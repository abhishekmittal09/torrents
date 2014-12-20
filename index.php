<!DOCTYPE html>
<html>
<body>

<form action="./uploadFile.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>

<h1> Pending Torrents </h1>

<form action="./moveFile.php" method="post">

<?php


	
	//prints all file names
	$log_directory="./uploads";

	$scanDir = scandir($log_directory);

	foreach ($scanDir as $file) {
		if(is_dir($log_directory."/".$file));
		else
	    	echo $file."<input type='checkbox' name='downloadFileName[]' value='".$file."'><br>";
	}

?>

<input type="submit" value="submit">
</form>

<h1> Active Torrents </h1>

<?php

	//prints all file names
	$log_directory="./active";

	foreach(glob($log_directory.'/*') as $file) {
	    echo $file."<br>";
	}

?>

<h1>Start Torrent Daemon</h1>

<form action="./startDaemon.php" method="POST">
	<input type="submit" value="Start"><br>
</form>

</body>
</html>