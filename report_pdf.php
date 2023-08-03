<?php   
include 'db_connect.php';

    $cisess_cookie = $_COOKIE['ci_session'];
     $cisess_cookie = stripslashes($cisess_cookie);
     $cisess_cookie = unserialize($cisess_cookie);
     $cisess_session_id = $cisess_cookie['session_id'];
    $cisess_query = "SELECT user_data FROM ci_sessions WHERE session_id = '$cisess_session_id'";

     $cisess_result = mysql_query($cisess_query);
     if (!$cisess_result) {
       die("Invalid Query");
     }
     $cisess_row = mysql_fetch_assoc($cisess_result);
     $cisess_data = unserialize($cisess_row['user_data']);


include("filepdf/fpdf.php");
require('filepdf/mc_table.php');

$pdf=new PDF_MC_Table('L','mm','A4');
//Column titles
$pdf->SetFont('Arial','B',7);

//$pdf->SetFont('Arial','',6);
//$pdf->TableData();
/*
$pdf->Output('invoice.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="invoice.pdf"');
// The PDF source is in original.pdf
readfile('invoice.pdf');
 */

    function getClient($val) {

        $qry = 'select first_name,last_name from clients where id='.$val;
        $result = mysql_query($qry);
        $row = mysql_fetch_array($result);
        return $row['first_name']." ".$row['last_name'];
    }

    function getDriver($val) {

        $qry = 'select first_name,last_name from drivers where id='.$val;
        $result = mysql_query($qry);
        $row = mysql_fetch_array($result);
        return $row['first_name']." ".$row['last_name'];
    }

    $data = $_POST['dataval'];
    
            $pdf->AddPage();
           // $pdf->FancyTable($header);
    
    
 if(count($data)>0) {
     
     for($i=0;$i<count($data);$i++) {
 
            
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(182,231,249);
                $pdf->SetLineWidth(.2);
                $pdf->SetFont('Arial','B',8);
                
            
             
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(182,231,249);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','B',8);    
  /*  $pdf->Cell(15,3,$pickuptime,1,0,'T',true);
    $pdf->Cell(20,3,$pickup_address,1,0,'T',true);
    $pdf->Cell(30,3,$drop_address,1,0,'T',true);
    $pdf->Cell(10,3,$pax,1,0,'T',true);
    $pdf->Cell(10,3,$data[$i]->total,1,0,'T',true);
    $pdf->Cell(13,3,$ftime,1,0,'T',true);
    $pdf->Cell(30,3,$cliname,1,0,'T',true);
    $pdf->Cell(10,3,$dphone,1,0,'T',true);
    $pdf->Cell(30,3,$drivname,1,0,'T',true);
    $pdf->Cell(30,3,$dcomm,1,0,'T',true);
    $pdf->Ln();     */
    
                        $res_suburb = '';
                        
                        $deppickup_address = '';
                        
                        $depdrop_address = '';
                        
                        $pickuptime = '';
                        
                        $pax = '';
                        
                        $ftime = '';
                        
                        $dcomm = '';
                        
                        $dphone = '';
                        
                        $directions = '';
                        
                        $amount = '';
                        
                        $client = '';
                        
                        $mobile = '';
                        
                        $driver = '';
                        
                        $depres_suburb = '';
                        
                        $directions = $data[$i]['direction'];
    
               if((($directions=='both' || $directions=='departure') &&  $cisess_data['direction']=='both') || (($directions=='departure' || $directions=='both') && $cisess_data['direction']=='departure')) {
                   
                   if(($cisess_data['terminal']==$data[$i]['dep_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['dep_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['dep_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['dep_date']>=$cisess_data['fdbdate'] && $data[$i]['dep_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {
                   
                            if($data[$i]['dep_suburb']) $depres_suburb = ','.$data[$i]['dep_suburb'];
                            
                            if($data[$i]['dep_street']) $deppickup_address = $data[$i]['dep_street']."".$depres_suburb;
                        
                            else $deppickup_address = $data[$i]['dep_suburb'];
                        
                            $depdrop_address = $data[$i]['dep_terminal'];
                        
                            if($data[$i]['dep_date']!='' && $data[$i]['dep_date']!='0000-00-00') $depdate = date('d/m/Y',strtotime($data[$i]['dep_date']));
                            else $depdate = '';
    
                            if($data[$i]['dep_pickuptime']!=':') $pickuptime = $data[$i]['dep_pickuptime'];
                            $pax = $data[$i]['dep_passengers'];
                            $amount = $data[$i]['dep_estfare'];
                            $ftime = $data[$i]['dep_ourtime'];
                            $client = getClient($data[$i]['client']);
                            if($data[$i]['dep_mobile']!='0') $mobile = $data[$i]['dep_mobile'];
                            $driver = getDriver($data[$i]['dep_driver']);
                            $dcomm = $data[$i]['dep_comments'];
                            
                    $pdf->SetWidths(array(20,20,20,35,40,15,15,15,30,15,30,30));
                    $pdf->Row(array($depdate,'Departure',$pickuptime,$deppickup_address,$depdrop_address,$pax,$amount,$ftime,$client,$mobile,$driver,$dcomm));    
               }
     }
               if((($directions=='both' || $directions=='arrival') && $cisess_data['direction']=='both') || (($directions=='arrival' || $directions=='both') && $cisess_data['direction']=='arrival')) {
                   
                   if(($cisess_data['terminal']==$data[$i]['arr_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['arr_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['arr_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['arr_date']>=$cisess_data['fdbdate'] && $data[$i]['arr_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {
                   
                            if($data[$i]['arr_suburb']) $res_suburb = ','.$data[$i]['arr_suburb'];
                            
                            if($data[$i]['arr_street']) $drop_address = $data[$i]['arr_street']."".$res_suburb;
                        
                            else $drop_address = $data[$i]['arr_suburb'];
                        
                            $pickup_address = $data[$i]['arr_flight'];
                        
                            if($data[$i]['arr_date']!='' && $data[$i]['arr_date']!='0000-00-00') $arrdate = date('d/m/Y',strtotime($data[$i]['arr_date']));
                            else $arrdate = '';

                            if($data[$i]['arr_pickuptime']!=':') $pickuptime = $data[$i]['arr_pickuptime'];
                            $pax = $data[$i]['arr_passengers'];
                            $amount = $data[$i]['arr_estfare'];
                            $ftime = $data[$i]['arr_ourtime'];
                            $client = getClient($data[$i]['client']);
                            if($data[$i]['arr_mobile']!='0') $mobile = $data[$i]['arr_mobile'];
                            $driver = getDriver($data[$i]['arr_driver']);
                            $dcomm = $data[$i]['arr_comments'];
                            
                    $pdf->SetWidths(array(20,20,20,35,40,15,15,15,30,15,30,30));
                    $pdf->Row(array($arrdate,'Arrival',$pickuptime,$pickup_address,$drop_address,$pax,$amount,$ftime,$client,$mobile,$driver,$dcomm));    
               } 
        }
     }
}


$filename  = "report_".strtotime("now").".pdf";
$path = "excel_file/".$filename;

$pdf->Output($path);

echo $filename;
?>

