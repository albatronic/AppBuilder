<?php

/**
 * Clase para tratamiento de imágenes.
 *
 * Permite recortar imágenes sin cambiar su proporcionaliadad
 *
 * Ej. de uso:
 *
 * $myThumb = new Gd();
 * $myThumb->load('pathToSourceImage');
 * $myThumb->crop(50,50,'right');
 * $myThumb->save('pathToTargetImage');
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 29-sep-2012 12:46:13
 */
class Gd
{
    public $image;
    public $type;
    public $width;
    public $height;

    /**
     * Carga la imagen y lee su tipo, anchura y altura
     *
     * @param string $imagePath path completo de la imagen
     */
    public function loadImage($imagePath)
    {
        //---Tomar las dimensiones de la imagen
        $info = getimagesize($imagePath);

        $this->width = $info[0];
        $this->height = $info[1];
        $this->type = $info[2];

        //---Dependiendo del tipo de imagen crear una nueva imagen
        switch ($this->type) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($imagePath);
                break;
        }
    }

    /**
     * Guarda la imagen en el path indicado en $name
     *
     * @param  string  $name    Path de la imagen destino
     * @param  integer $quality Calidad de la imagen destino (0 a 100)
     * @return boolean TRUE si éxito al guardar
     */
    public function save($name, $quality = 75)
    {
        $ok = FALSE;

        //---Guardar la imagen en el tipo de archivo correcto
        switch ($this->type) {
            case IMAGETYPE_JPEG:
                $ok = imagejpeg($this->image, $name, $quality);
                break;
            case IMAGETYPE_GIF:
                $ok = imagegif($this->image, $name);
                break;
            case IMAGETYPE_PNG:
                $pngquality = floor(($quality - 10) / 10);
                $this->_preallocate_transparency();
                $ok = imagepng($this->image, $name, $pngquality);
                break;
        }

        return $ok;
    }

    /**
     * Usually when people use PNGs, it's because they need alpha channel
     * support (that means transparency kids). So here we jump through some
     * hoops to create a big transparent rectangle which the resampled image
     * will be copied on top of. This will prevent GD from using its default
     * background, which is black, and almost never correct. Why GD doesn't do
     * this automatically, is a good question.
     *
     * @param $w int width of target image
     * @param $h int height of target image
     * @return void
     */
    public function _preallocate_transparency()
    {
        if (!empty($this->type) && !empty($this->image) && ($this->type == IMAGETYPE_PNG)) {
            if (function_exists('imagecolorallocatealpha')) {
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                $transparent = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
                imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $transparent);
            }
        }
    }

    /**
     * Muestrar la imagen en el navegador sin salvarla previamente
     */
    public function show()
    {
        //---Mostrar la imagen dependiendo del tipo de archivo
        switch ($this->type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image);
                break;
        }
    }

    /**
     * Redimensiona la imagen en ancho o alto manteniendo sus proporciones
     * El nuevo tamaño será el indicado en $value
     *
     * @param int    $value El tamaño destino de la propiedad $prop
     * @param string $prop  La propiedad a redimensionar ( width ó height )
     */
    public function resize($value, $prop)
    {
        //---Determinar la propiedad a redimensionar y la propiedad opuesta
        $prop_value = ($prop == 'width') ? $this->width : $this->height;
        $prop_versus = ($prop == 'width') ? $this->height : $this->width;

        //---Determinar el valor opuesto a la propiedad a redimensionar
        $pcent = $value / $prop_value;
        $value_versus = $prop_versus * $pcent;

        //---Crear la imagen dependiendo de la propiedad a variar
        $image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);
        // Fill the image with transparent color
        imagesavealpha($image, true);
        $color = imagecolorallocatealpha($image, 255,255,255, 127);
        imagefill($image, 0, 0, $color);
        //---Hacer una copia de la imagen dependiendo de la propiedad a variar
        switch ($prop) {

            case 'width':
                imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
                break;

            case 'height':
                imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
                break;
        }

        //---Actualizar la imagen y sus dimensiones
        //$info = getimagesize($name);

        $this->width = imagesx($image);
        $this->height = imagesy($image);
        $this->image = $image;
    }

    /**
     * Crea un thumbnail de la imagen con las medidas especificadas y manteniendo
     * las proporciones visuales de la imagen intactas.
     *
     * $pos puede tomar los valors "left", "top", "right", "bottom" o "center"
     *
     * @param int    $cwidth  Anchura del thumbnail
     * @param int    $cheight Altura del thumbnail
     * @param string $pos     Posición desde donde extraer el thumbnail. Defecto 'center'
     */
    public function crop($cwidth, $cheight, $pos = 'center')
    {
        //---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
        if ($cwidth > $cheight) {
            $this->resize($cwidth, 'width');
        } else {
            $this->resize($cheight, 'height');
        }

        //---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
        $image = imagecreatetruecolor($cwidth, $cheight);

        switch ($pos) {

            case 'center':
                imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
                break;

            case 'left':
                imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
                break;

            case 'right':
                imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
                break;

            case 'top':
                imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
                break;

            case 'bottom':
                imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
                break;
        }

        $this->image = $image;
    }

}
