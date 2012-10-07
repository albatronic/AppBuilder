<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('class/Thumbnails.class.php');
$mythumb = new Thumbnails();

$imagen = "DSC00805.JPG";

$mythumb->loadImage($imagen);
$mythumb->crop(50,50,'left');
$mythumb->save("sergioL.jpg");

$mythumb->loadImage($imagen);
$mythumb->crop(50,50,'right');
$mythumb->save("sergioR.jpg");

$mythumb->loadImage($imagen);
$mythumb->crop(50,50,'top');
$mythumb->save("sergioT.jpg");

$mythumb->loadImage($imagen);
$mythumb->crop(50,50,'bottom');
$mythumb->save("sergioB.jpg");

$mythumb->loadImage($imagen);
$mythumb->crop(50,50,'center');
$mythumb->save("sergioC.jpg");

header('Content-Type: image/jpeg');
$mythumb->loadImage($imagen);
$mythumb->show();



?>