<?php
require_once 'vendor/autoload.php';
use Vincepare\FaviconDownloader\FaviconDownloader;

// print output buffer to file: https://stackoverflow.com/questions/16225437/printing-php-script-output-to-file
ob_start();

$fh = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR . '0_link_list.txt','r');
while ($line = fgets($fh)) {

    // based on https://stackoverflow.com/questions/7478250/how-do-i-eliminate-line-break-from-fgets-function-in-php
    $line=trim($line);

    // beautify url
    $line = preg_replace("~^(https?://)?~i", "http://", $line); //replace http or https
    $line = str_replace("www.","",$line); // replace "www"

    //if the url has not http:// add it
    /*
    if(preg_match("@^http://@i",$line))
        $line = preg_replace("@(http://)+@i",'http://',$line);
    else
        $line = 'http://'.$line;
     */   
    // Make link nice
    // remove whitespace and new line
    //$line = trim(preg_replace('/\s+/', ' ', $line));

    // get favicon
    echo 'Get favicon from link: '. $line . "\n";
    $favicon = new FaviconDownloader($line);
    
    if (!$favicon->icoExists) {
        echo "\n\n";
        echo "##############################################";
        echo "\n ERROR: No favicon for " . $favicon->url . "\n";
        echo "##############################################";
        echo "\n\n";
        // var_dump($favicon);
    }
    
    // get name of url
    $parts = parse_url($line);
    $path_parts = explode('.', isset($parts['host'])?$parts['host']:$parts['path']);

    echo 'Filename: fav-'. $path_parts[0] .'.png' . "\n";
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'fav-'. $path_parts[0] . '.png';
    file_put_contents($filename, $favicon->icoData);
    echo "Saved to ".$filename."\n";
}

fclose($fh);

//  Return the contents of the output buffer
$htmlStr = ob_get_contents();
// Clean (erase) the output buffer and turn off output buffering
ob_end_clean(); 
// Write final string to file
file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR . '0_OUTPUT_SCRIPTS.txt', $htmlStr);
