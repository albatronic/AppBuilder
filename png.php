
<html>
    <body>
        <?php
        include 'class/Gd.class.php';

        $imagenOrigen = "prueba.jpg";

        $origen = imagecreatefromjpeg($imagenOrigen);
        $info = getimagesize($imagenOrigen);
        $width = $info[0];
        $height = $info[1];

        $ratioAnchura = 150/$width;
        $nuevaAnchura = $width * $ratioAnchura;
        $nuevaAltura = $height * $ratioAnchura;
        echo $nuevaAnchura," ",$nuevaAltura;
        $imagenResized = imagecreatetruecolor($nuevaAnchura, $nuevaAltura);
        imagecopyresized($imagenResized, $origen, 0,0,0,0, $nuevaAnchura, $nuevaAltura, $width, $height);
        imagejpeg($imagenResized, "pruebaRR.jpg");
        echo "<img src='pruebaRR.jpg'/>";

        $image = imagecreatetruecolor(150, 150);
        // Fill the image with transparent color
        //imagesavealpha($image, true);
        $color = imagecolorallocatealpha($image, 255, 255, 0, 127);
        imagefill($image, 0, 0, $color);
        imagecopyresampled($image, $imagenResized, abs(150-$nuevaAnchura)/2, abs(150-$nuevaAltura)/2, 0, 0, $nuevaAnchura, $nuevaAltura, $nuevaAnchura, $nuevaAltura);

        imagejpeg($image, "pruebaxx.jpg");
        echo "<img src='pruebaxx.jpg'/>";
        exit;

        function crearPngTransparante()
        {
            // Set the image
            $img = imagecreatetruecolor(100, 100);
            imagesavealpha($img, true);

            // Fill the image with transparent color
            $color = imagecolorallocatealpha($img, 0x00, 0x00, 0x00, 127);
            imagefill($img, 0, 0, $color);

            // Save the image to file.png
            $ok = imagepng($img, "file.png");
            echo "---{$ok}---";

            // Destroy image
            imagedestroy($img);
        }

        $img = new Gd();
        $img->loadImage("prueba.jpg");
        $img->crop(150, 150);
        $img->save("prueba150150.jpg");
        $img = new Gd();
        $img->loadImage("prueba.jpg");
        $img->crop(220, 172);
        $img->save("prueba220172.jpg");
        exit;
        $image = imagecreatetruecolor(150, 150);
        // Fill the image with transparent color
        imagesavealpha($image, true);
        $color = imagecolorallocatealpha($image, 0x00, 0x00, 0x00, 127);
        imagefill($image, 0, 0, $color);

        $imagen = 'sergio.png';

        $info = getimagesize($imagen);
        print_r($info);
        $width = $info[0];
        $height = $info[1];
        $type = $info[2];

// Cargar una imagen png con canales alfa
        $png = imagecreatefrompng($imagen);

// Desactivar la mezcla alfa y establecer la bandera alfa
        if (function_exists('imagecolorallocatealpha')) {
            imagealphablending($png, false);
            imagesavealpha($png, true);
            $transparent = imagecolorallocatealpha($png, 0x00, 0x00, 0x00, 127);
            imagefilledrectangle($png, 0, 0, $width, $height, $transparent);
        } else
            "NO EXISTE LA FUNCION";

// Impirmir la imagen al navegador
//        header('Content-Type: image/png');

        $ok = imagepng($png, "sergio1.png");

        if ($ok)
            echo "imagen salvada {$ok}";
        else
            echo "error al salvar {$ok}"
            ?>

    </body>
</html>
