<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 23.06.14
 * Time: 16:11
 */


// now try it
require_once('get_browser.php');
$ua=getBrowser();
$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on the " .$ua['platform'] . " platform with OS ".." reports: <br />" . $ua['userAgent'];
print_r($yourbrowser);

?>