<?php
	require_once './includes/bootstrap.inc';        // Instanciate Drupal
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
   
   /* General Rules:
    *
    * File ID ($_GET['fids']) - Can be given as a single file, or a sequence like "29-38-89-22", where each File ID is separated by a "-".  
    *             
    * If a File ID sequence is given, the playlist will play in the order of the sequence.
    *
    */

   // Function for formating our array elements.
   function fid_format(&$item){$item = 'f.fid='.$item;}	
	
	// Returns the file extension given a file path.									
   function get_file_ext($filepath){ return strtolower(substr($filepath, strrpos($filepath, '.') + 1)); }
   
   // Returns the base file name given a file path.  
   function filename($filepath){ return basename($filepath, "." . get_file_ext($filepath)); }  
   
   $contents = '';                                                                  // To store the contents of the XML lists.
   $fid_array = array();   
   $fids = array();
   if(isset($_GET['fids']) && !preg_match("/[^0-9\-]/", $_GET['fids'])) {           // If they pass only one File ID, then this means they only want to play one file
      $clean_fids = preg_replace("/[^0-9\-]/", "", $_GET['fids']);                  // Clean the argument...
      $fids = explode("-", $clean_fids);                                            // A sequence can also be given : example "23-53" plays fid 23 and fid 53 sequencially.
      array_walk($fids, create_function('&$n', '$n = trim($n);'));    					// Trim all the elements
      $fid_array = $fids;
      if(is_array($fid_array)) {
      	array_walk($fid_array, 'fid_format');    												// Format all the elements
      }
      else {
      	$fid_array = 'f.fid='. $fid_array;
      }
   }
      
   // TO-DO:  Commercial manager plugs in here... future enhancments
   
   $fid_query = ($fid_array) ? 'AND (' . implode(' OR ', $fid_array) . ')' : '';
   $query = "SELECT n.type, f.fid, f.filename, f.filepath FROM {flashvideo} fv LEFT JOIN {files} f ON fv.fid = f.fid LEFT JOIN {node} n ON n.nid = f.nid WHERE (f.filemime='flv-application/octet-stream') AND (fv.status=3) $fid_query";
   $result = db_query($query);
   $all_files = array();
   while($file = db_fetch_object($result)) {                                         // Walk through all the files
   	$all_files[] = $file;
   }     
	
   // We need to construct a files list based off of the order of the $fids array.
   $files = array();
   if($fids) {
     foreach($fids as $fid) {
        foreach($all_files as $file) {
           if(trim($fid) == $file->fid) {
              $files[] = $file;
              continue 2;                   // Continue with the $fids iteration (That's what the 2 does...)
           }  
        }  
     }
   }
   else {      
     $files = $all_files;                  
   } 

   if($files) {
   	$played_intro = false;
   	foreach($files as $file) {  
   		// Play the intro video.
   		$output_dir = variable_get('flashvideo_' . $file->type .'_outputdir', '') . '/';    // The output directory
   		$output_dir = ($output_dir == '/') ? '' : $output_dir;
	
   		if(!$played_intro && (($intro_video = variable_get('flashvideo_' . $file->type .'_intro', '')) != '') ) {
           	$intro_path = check_url(file_create_url($output_dir . $intro_video));
           	$contents .= '<track><title>Intro</title><location>' . $intro_path . '</location><album>commercial</album></track>';
   			$played_intro = true;
   		}
   		
   		$filepath = check_url(file_create_url($output_dir . basename($file->filepath)));
   		
         $contents .= '<track>';
         $contents .= '<title>' . $file->filename . '</title>';
         $contents .= '<location>' . $filepath . '</location>';
         $contents .= '</track>';
      }
   }
    
   if($contents != '') {
      $xml = '<playlist version="1" xmlns="http://xspf.org/ns/0/"><trackList>';        // Start off the XML file contents
      $xml .= $contents;                                                               // Fill in all the rest.
      $xml .= '</trackList></playlist>';                                               // Finish off the XML file contents
      echo $xml;
   }
?>