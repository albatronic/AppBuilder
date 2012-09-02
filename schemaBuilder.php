<?php
if (file_exists("class/yaml/lib/sfYaml.php"))
    include "class/yaml/lib/sfYaml.php";
else
    die("NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML");

if (file_exists("class/schemaBuilder.class.php"))
    include "class/schemaBuilder.class.php";
else
    die("NO EXISTE LA CLASE schemaBuilder.class.php");

$mensaje = array();

if ($_POST['accion'] == 'BUILD') {

    if (!file_exists($_POST['fileName']))
        $mensaje[] = "El archivo no existe";

    $conection = array(
        'host' => $_POST['host'],
        'user' => $_POST['user'],
        'password' => $_POST['password'],
        'dataBase' => $_POST['dataBase'],
    );
    $sb = new schemaBuilder($conection);

    if ($sb->connect()) {

        $ok = TRUE;
        if ($_POST['newDataBase'] == 'on')
            $ok = $sb->createDataBase();

        if ($_POST['newUser'] == 'on')
            $ok = $sb->createUser();

        if ($ok) {
            $ok = $sb->buildSchema(sfYaml::load($_POST['fileName']));
            if (!$ok) $mensaje = $sb->getErrores();
        } else
            $mensaje[] = "No se pudo crear la base de datos y/o el usuario";
    } else
        $mensaje[]= "No se ha realizado la conexión";

}

function createDataBase() {

}

function createUser() {

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Schema Builder</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>

    <body>
        <form action="schemaBuilder.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr><td colspan="2" align="center">SCHEMA BUILDER</td></tr>
                <?php foreach ($mensaje as $texto) {?>
                <tr><td colspan="2"><b><?php echo $texto; ?></b></td></tr>
                <?php } ?>
                <tr><td>Server</td><td><input name="host" type="text" value="localhost"></td></tr>
                <tr><td>User</td><td><input name="user" type="text" value="root"></td></tr>
                <tr><td>Passw</td><td><input name="password" type="text" value="albatronic"></td></tr>
                <tr><td>Data Base</td><td><input name="dataBase" type="text" value=""></td></tr>
                <tr><td>YAML file</td><td><input name="fileName" type="text" size="50" value="/home/sergio/NetBeansProjects/cpanel/entities/schema.yml"></td></tr>
                <tr><td>New Data Base </td><td><input name="newDataBase" type="checkbox"></td></tr>
                <tr><td>New User</td><td><input name="newUser" type="checkbox"></td></tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="accion" value="BUILD" type="submit">&nbsp;
                        <input name="accion" value="CANCEL" type="submit">
                    </td>
                </tr>
            </table>
        </form>
    </body>
    <p>Crea la base de datos a partir de la definición del esquema en sintaxis YAML indicada en el archivo</p>
</html>