<?php

// Usage: create_icons.php <file>

// Validate argv
if ($argc > 1) {
    $filename = $argv[1];
    if (strpos($filename, 'png') === false) {
        exit("Usage: create_icons.php <png file>\n");
    }
} else {
    exit("Usage: create_icons.php <png file>\n");
}


// Get filename and initialize
$basename = basename($filename, '.png');
$src_image = imagecreatefrompng($filename);
list($src_w, $src_h) = getimagesize($filename);


// List of sizes to produce
$dst_sizes = [58, 80, 87, 120, 180];


// Loop
foreach ($dst_sizes as $ds) {
    resize($basename, $src_image, $src_w, $src_h, $ds);
}


// Using GD imagecopyresize
function resize ($basename, $src_image, $src_w, $src_h, $dst_size) {
    // Create image
    $dst_image = @imagecreatetruecolor($dst_size, $dst_size)
        or die('Cannot Initialize new GD image stream');

    // Resize
    imagecopyresized($dst_image, $src_image, 0, 0, 0, 0, $dst_size, $dst_size, $src_w, $src_h);

    // Output
    header('Content-Type: image/png');
    imagepng($dst_image, $basename.'-'.$dst_size.'.png');
}

?>