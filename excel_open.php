<?php

 $filename = $_GET['filename'];

 $mode = $_GET['mode'];
 
if($mode=='driver') $path = "excel_file/$filename";

if($mode=='daysheet') $path = "daysheet_excel/$filename";

$type = $_GET['type'];

if($type=='excel') {
// fix for IE catching or PHP bug issue
header("Pragma: public");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

header("Content-Disposition: attachment; filename=".$filename.";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($path));

/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='".$filename.");
header('Cache-Control: max-age=0');*/
}

if($type=='pdf') {

    header('Content-type: application/pdf');
    // It will be called downloaded.pdf
    header("Content-Disposition: attachment; filename=".$filename.";");
    
}

@readfile($path);

?>