<?php

$user="abhishek";

#$destDir="/home/$user/rtactive";
$destDir="/var/www/html/torrents/active";
$srcDir="./uploads";

$downloadFileName=array();
$downloadFileName[0]="temp.torrent";

extract($_POST);

foreach ($downloadFileName as $file) {
	if (file_exists($destDir)) {
	  if (is_dir($destDir)) {
	    if (is_writable($destDir)) {
	      if ($handle = opendir($srcDir)) {
	          if (is_file($srcDir . '/' . $file)) {
	            rename($srcDir . '/' . $file, $destDir . '/' . $file);
	        	echo "<h1> Moved $file successfully</h1>";
	        }
	        closedir($handle);
	      } else {
	        echo "$srcDir could not be opened.\n";
	      }
	    } else {
	      echo "$destDir is not writable!\n";
	    }
	  } else {
	    echo "$destDir is not a directory!\n";
	  }
	} else {
	  echo "$destDir does not exist\n";
	}
}

?>