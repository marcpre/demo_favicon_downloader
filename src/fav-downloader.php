<?php
require_once 'vendor/autoload.php';
// require 'FaviconDownloader.php';
use Vincepare\FaviconDownloader\FaviconDownloader;

// Find & download favicon
$favicon = new FaviconDownloader('http://stackoverflow.com/questions/19503326/bug-with-chrome-tabs-create-in-a-loop');

if (!$favicon->icoExists) {
    echo "No favicon for ".$favicon->url;
    // die(1);
}

echo "Favicon found : ".$favicon->icoUrl."\n";

// Saving favicon to file
$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'fav-'.$favicon->icoType;
file_put_contents($filename, $favicon->icoData);
echo "Saved to ".$filename."\n\n";

echo "Details :\n";
$favicon->debug();