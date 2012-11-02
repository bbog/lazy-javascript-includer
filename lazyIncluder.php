<?php

define('WITH_SUBFOLDERS', TRUE);

/**
 * JSFile object
 */
Class JSFile {

	//Constructs a new JSFile based on the file's path
	function __construct ($file_string) {
		
		//we save the path
		$this->path = $file_string;

		/**
		 * this array will store the folder structure of the file
		 * folders[0] will be the root of the file
		 *
		 * Ex. for folder/subfolder1/subfolder2/file.js
		 * folders[0] = 'folder';
		 * folders[1] = 'subfolder1';
		 * folders[2] = 'subfolder2';
		 */
		$this->folders = array();

		//breaking apart the path
		$file_parts = explode('/', $file_string);
		
		//we don't need to parse all the parts, the last one will be the filename and not a folder, therefore we decrease the length with 1
		$len = count($file_parts) - 1;
		for($i = 0; $i < $len; $i++) {
			$this->folders[$i] = $file_parts[$i];
		}

		//setting the filename
		$this->filename = $file_parts[$len];
	}

	function __toString () {
		return $this->path;
	}

};



function find_all_files($dir) 
 { 
     $root = scandir($dir); 
     foreach($root as $value) 
     { 
         if($value === '.' || $value === '..') {continue;} 
         if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
         foreach(find_all_files("$dir/$value") as $value) 
         { 
             $result[]=$value; 
         } 
     } 
     return $result; 
 } 



function insertFolder($folders_array, $with_subfolders=FALSE) {
	global $files;
	global $includes;

	$len = count($folders_array);


	//cleaning array
	$toRemove = array();

	foreach($files as $file) {
		$ok = 1;

		//if the file is in the correct path (folder/subfolders), than ok will remain 1
		for ($i = 1; $i <= $len; $i++) {
			if ($len >= $i) {
				//we need to check if we have a root folder file too, and we're not dealing with something in a subfolder
				if (isset($file->folders[$i]) && $file->folders[$i] == $folders_array[$i-1]) {
					if (!$with_subfolders) {
						if (count($file->folders) == $len+1) {

						} else {
							$ok = 0;
						}
					}
				} else {
					$ok = 0;
				}
			} else {
				$ok = 0;
			}
		}

		if ($ok) {

			//adding files
			$includes[] = '<script src="' . $file->path . '"></script>';
			//marking them for deletion
			$toRemove[] = $file; 
		}

	}
	//removing the already found files
	$files = array_diff($files, $toRemove);

}



function insertFiles($files_array) {

 	global $includes;
 	global $files;

	$toRemove = array();

	foreach($files as $file) {

		if (in_array($file->filename, $files_array)) {
			$includes[] = '<script src="' . $file->path . '"></script>';
			$toRemove[] = $file;
		}

	}
	//removing the already found files
	$files = array_diff($files, $toRemove);


 }

function startParsing($dir) {

	global $includes, $files;

	//parsing the files
	foreach(find_all_files($dir) as $file) {
	 	if(substr($file, -3) == '.js') {
	 		//echo $file . '<br/>';
	 		$files[] = new JSFile($file);
	 	}
	 }
}


//we will put the files that need to be included here
$includes = array();
$files = array();



?>