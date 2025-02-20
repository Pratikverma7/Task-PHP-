<?php
$csvFile = 'task2.csv';
$data = array_map('str_getcsv', file($csvFile));


$headers = array_shift($data);
$x_values = [];
$y_values = [];

foreach ($data as $row) {
    if (isset($row[0], $row[1]) && is_numeric($row[0]) && is_numeric($row[1])) {
        $x_values[] = (float)$row[0];
        $y_values[] = (float)$row[1];
    }
}


$width = 500;
$height = 200;
$image = imagecreatetruecolor($width, $height);
$background = imagecolorallocate($image, 255, 255, 255);
$dotColor = imagecolorallocate($image, 0, 0, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, $width, $height, $background);


$minX = min($x_values);
$maxX = max($x_values);
$minY = min($y_values);
$maxY = max($y_values);

foreach ($x_values as $index => $x) {
    $scaledX = ($x - $minX) / ($maxX - $minX) * ($width - 40) + 20;
    $scaledY = $height - (($y_values[$index] - $minY) / ($maxY - $minY) * ($height - 40) + 20);
    imagesetpixel($image, (int)$scaledX, (int)$scaledY, $dotColor);
}


header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>