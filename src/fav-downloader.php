<?php
require_once 'vendor/autoload.php';
use Vincepare\FaviconDownloader\FaviconDownloader;

$fh = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR . 'link_list.txt','r');
while ($line = fgets($fh)) {

    //if the url has not http:// add it
    if(preg_match("@^http://@i",$line))
        $line = preg_replace("@(http://)+@i",'http://',$line);
    else
        $line = 'http://'.$line;
        
    // Make link nice
    // remove whitespace and new line
    $line = trim(preg_replace('/\s+/', ' ', $line));

    $favicon = new FaviconDownloader($line);
    
    if (!$favicon->icoExists) {
        echo "No favicon for ".$favicon->url;
        var_dump($favicon);
    }
    
    // get name of url
    $parts = parse_url($line);
    $path_parts = explode('.', isset($parts['host'])?$parts['host']:$parts['path']);

    echo 'Filename: fav-'. $path_parts[0] .'.ico' . "\n";
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'fav-'. $path_parts[0] . '.ico';
    file_put_contents($filename, $favicon->icoData);
    echo "Saved to ".$filename."\n\n";
}

fclose($fh);
