<?php
/**
 * GENERAR EL CODIGO DEL FORMULARIO DE MANTENIMIENTO DE UNA TABLA
 * LO DEVUELVE CON EL METODO GET
 *
 * SE GENERAN DOS ARCHIVOS. UNO PARA EL CODIGO PHP (form.php) Y OTRO CON EL CODIGO
 * HTML DE PRESENTACIÓN DE LOS DATOS (template.php)
 *
 * EL CODIGO DE LOS DOS ARCHIVOS SE ALMACENA EN EL ARRAY 'formulario', QUE ES
 * EL QUE SE DEVUELVE CON EL MÉTODO GET.
 *
 * NECESITA APOYARSE EN LA CLASE 'TableDescriptor'
 *
 * LOS LITERALES DE LAS ETIQUETAS DE LOS CAMPOS A EDITAR SE MUESTRAN
 * EN BASE A $_SECCION['TEXTOS'] PARA PERMITIR EL MULTIIDIOMA.
 *
 * @author Sergio Perez
 * @copyright Informatica ALBATRONIC, SL 22.10.2010
 * @version 1.0
*/

class FormBuilderSymfony
{
  private $form;
  private $template;
  private $formulario=array();
  private $table_descriptor;

  public function __construct($bundle,$table)
  {
    $this->table_descriptor = new TableDescriptor(DB_BASE,$table);
    $this->Load();
  }

  private function Load()
  {
    $buf  = "<?php\n";
    $buf .= "/**\n";
    $buf .= "* Form for " . DB_BASE . "." . $this->table_descriptor->getTable() . "\n";
    $buf .= "* @author: Sergio Perez\n* @copyright: INFORMATICA ALBATRONIC SL ".date('d.m.Y H:i:s')."\n";
    $buf .= "*/\n\n";

    $buf .= "namespace ".$bundle."\Form;\n\n";
    $buf .= "use Symfony\Component\Form\AbstractType;\n";
    $buf .= "use Symfony\Component\Form\FromBuilder;\n\n";

    $buf .= "class ".$this->table_descriptor->getTable()." extends AbstractType\n";
    $buf .= "{\n";
    $buf .= "\tpublic function buildForm(FormBuilder \$builder, array \$options)\n";


    foreach($this->table_descriptor->getColumns() as $column)
    {
      $column_name = str_replace('-','_',$column['Field']);
      if( $column['Field'] != $this->table_descriptor->getPrimaryKey() )
      {
	if($column['Referenced_schema']!='') //El campo es un ID de referencia a otra tabla. Se muestra una lista desplegable
            {
                $bdReferencia=$column['Referenced_schema'];
                $tablaReferencia=$column['Referenced_table'];
                $columnaReferencia=$column['Referenced_column'];
                $objetosInstanciados[]="\$ref".$tablaReferencia;
                //Crea el desplegable de la tabla referenciada por esta columna IDxxx
                $temp .= "<div><?php \$ref".$tablaReferencia."=new ".$tablaReferencia."(); \$ref".$tablaReferencia."->desplegable('".$column_name."','',\$dat->get".$column_name."());?></div>\n";
            } else {
		switch ($column['Type']){
			case 'datetime':
				$clase="LiteralFechaHora";
				$maxlong=19;
				$temp .="<div><input name=\"".$column_name."\" type=\"text\" class=\"".$clase."\" value=\"<?php \$fec=new fechas(\$dat->get".$column_name."());echo \$fec->getddmmaaaa(); unset(\$fec);?>\" maxlength=\"".$maxlong."\"></div>\n";
				break;
				
			case 'date':
				$clase="CampoFecha";
				$maxlong=10;
				$temp .="<div><input name=\"".$column_name."\" type=\"text\" class=\"".$clase."\" value=\"<?php \$fec=new fechas(\$dat->get".$column_name."());echo \$fec->getddmmaaaa(); unset(\$fec);?>\" maxlength=\"".$maxlong."\"></div>\n";
				break;
				
			case 'varchar':
			case 'char':
				if($column['Length']>=30) $clase="CampoTextoLargo";
				else $clase="CampoTextoCorto";
				$maxlong=$column['Length'];
				$temp .="<div><input name=\"".$column_name."\" type=\"text\" class=\"".$clase."\" value=\"<?php echo \$dat->get".$column_name."();?>\" maxlength=\"".$maxlong."\"></div>\n";
				break;
				
			case 'bigint':
			case 'int':
			case 'tinyint':
			case 'decimal':
				if($column['Length']>=8) $clase="CampoImporte";
				else $clase="CampoUnidades";
				$maxlong=$column['Length'];
				$temp .="<div><input name=\"".$column_name."\" type=\"text\" class=\"".$clase."\" value=\"<?php echo \$dat->get".$column_name."();?>\" maxlength=\"".$maxlong."\"></div>\n";
				break;
			
			case 'text':
				$clase="TextArea"; //hay que convertir el input en un textarea;
				$temp .="<div><textarea name=\"".$column_name."\" class=\"".$clase."\"><?php echo \$dat->get".$column_name."();?></textarea></div>\n";
				break;
			
			case 'enum': //Desplegable de array
                                //Los valores posibles vienen como un string, cada uno entre comillas simples
                                //y separados por comas. EL string lo convierto a un array para luego tratarlo
                                $valores='';
                                $aux=array();
                                $aux=split(",", $column['Values']);

                                foreach ($aux as $value) {
                                    if($valores!='') $valores.=",";
                                    $valores.="$value=>$value";
                                }
				$temp .="<div><?php desplegableArray('".$column_name."',array(".$valores."),\$dat->get".$column_name."());?></div>\n";
				break;
							
			default: $clase="";
		} // end switch
		} // end del else
	  } // end if
    } // end foreach
	

    $buf .= "// END form {$this->table_descriptor->getTable()}\n?>";
    $this->form = $buf;

    $this->formulario['form']=$this->form;
  }

  /**
   * Devuelve el código html con el formulario de mantenimiento
   * @return text
   */
  public function Get()
  {
      return $this->formulario;
  }
}

?>