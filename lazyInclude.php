<?php

//we need this, it does the actual including processing
require('lazyIncluder.php');
//and now we parse
startParsing('js');


/** Inserting these files first **/
//insertFiles(array('Class.js', 'Util.js'));

//potential bug: insertFiles first with duplicate names
//insertFolder('Framework/Util/')
//insertFoldersOf('Framework')


/** Framework Core **/
//insertFolder(array('Framework')); 
/** Application / Modules **/
//insertFolder(array('Application', 'Modules'), WITH_SUBFOLDERS);


echo implode("\n", $includes);

?>