<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('UTC');

require 'class/Watimage.class.php';

/************************
 *** APPLY WATERMARKS ***
 ************************/
/**
$wm = new Watimage();
$wm->setImage(array('file' => 'test.png', 'quality' => 70)); // file to use and export quality
$wm->setWatermark(array('file' => 'watermark.png', 'position' => 'top right')); // watermark to use and it's position
$wm->applyWatermark(); // apply watermark to the canvas
if ( !$wm->generate('test1.png') ) {
    // handle errors...
    print_r($wm->errors);
}

/*********************
 *** RESIZE IMAGES ***
 *********************/

$wm = new Watimage('espadafor1.png');
// allowed types: resize, resizecrop, resizemin, crop and reduce
$wm->resize(array('type' => 'resizecrop', 'size' => array(160,70)));
if ( !$wm->generate('espadafor2.png') ) {
    // handle errors...
    print_r($wm->errors);
}
echo "<img src='espadafor1.png'/><img src='espadafor2.png'/>";

/*********************
 *** ROTATE IMAGES ***
 *********************/
/**
$wm = new Watimage('test.png');
$wm->rotate(90);
if ( !$wm->generate('test3.png') ) {
    // handle errors...
    print_r($wm->errors);
}

/**********************************
 *** EXPORTING TO OTHER FORMATS ***
 **********************************/
/**
$wm = new Watimage('test.png');
if ( !$wm->generate('test4.jpg', 'image/jpeg') ) {
    // handle errors...
    print_r($wm->errors);
}

/*******************
 *** FLIP IMAGES ***
 *******************/
/**
$wm = new Watimage('test.png');
$wm->flip('vertical'); // or "horizontal"
if ( !$wm->generate('test5.png') ) {
    // handle errors...
    print_r($wm->errors);
}


/***********************
 *** CROPPING IMAGES ***
 ***********************/
// Usefull for cropping plugins like https://github.com/tapmodo/Jcrop
/**
$wm = new Watimage('espadafor1.png');
$wm->crop(array( // values from the cropper
    'width' => 500, // the cropped width
    'height' => 500, // "     "	   height
    'x' => 50,
    'y' => 80
));
if ( !$wm->generate('espadafor2.png') ) {
    // handle errors...
    print_r($wm->errors);
}


/***************************
 *** EVERYTHING TOGETHER ***
 ***************************/
/**
$wm = new Watimage();

// Set the image
$wm->setImage('test.png'); // you can also set the quality with setImage, you only need to change it with an array: array('file' => 'test.png', 'quality' => 70)

// Set the export quality
$wm->setQuality(80);

// Set a watermark
$wm->setWatermark(array(
    'file' => 'watermark.png',  // the watermark file
    'position' => 'center center', // the watermark position works like CSS backgrounds positioning
    'margin' => array('x' => -20, 'y' => 10), // you can set some 'margins' to the watermark for better positioning
    'size' => 'full' // you can set the size of the watermark using a percentage or the word "full" for getting a full width/height watermark
));

// Resize the image
$wm->resize(array('type' => 'resize', 'size' => 400));

// Flip it
$wm->flip('horizontal');

// Now rotate it 30deg
$wm->rotate(30);

// It's time to apply the watermark
$wm->applyWatermark();

// Export the file
if ( !$wm->generate('test7.png') ) {
    // handle errors...
    print_r($wm->errors);
}

// END OF FILE
