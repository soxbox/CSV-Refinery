<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 11/28/2014
 * Time: 1:19 AM
 */

//sleep(60);
$myfile = fopen("C:\\xampp\\htdocs\\csvrefinery\\app\\custom\\newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);