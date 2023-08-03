<?php

include 'hsdb.php';

hs_open();


//$maintainence_password = 'w'; 

$shortform = true;

//require  "cms/cms.php";



if (isset($_POST['fee']))

{

	$bk = $_POST['bktype']; // book type
        
        $s0 = $_POST['s0']; // suburb

	$s1 = $_POST['s1']; // suburb

	

	$p0 = $_POST['p0']; // pax

	$b0 = $_POST['b0']; // baby seat

	$a0 = $_POST['a0']; // arrival

	

	$p1 = $_POST['p1']; // pax

	$b1 = $_POST['b1']; // baby seat

	$a1 = $_POST['a1']; // arrival

	$dhours = $_POST['dhours']; // dep pick hours
        $ahours = $_POST['ahours']; // arr pick hours
        $amin = $_POST['amin']; // arr pick min
		
		//$dmin = $_POST['dmin']; // arr pick min Acorr
		
		
		$dhoursval = 0;
        $ahoursval = 0;
		
			

        // dep pickup time
        //if($dhours!=0 && $dhours<5) $dhoursval = '20';
        //else if($dhours==5) $dhoursval = '10';
        
		// dep pickup time ACorr
        if($dhours!=0 && $dhours<4) $dhoursval = '100';
        else if($dhours==4) $dhoursval = '20';
		else if($dhours==5) $dhoursval = '20';
		//else if($dmin ==15) $dhoursval = '99';
		
        // arr pickup time
        if($ahours==19) $ahoursval = '20';
        else if($ahours==20) $ahoursval = '50';
        else if($ahours==21 || ($ahours==22)) $ahoursval = '100'; //Assigned $50 fee for 22:00 and 23:00 Arrivals ACorr
//	if ($b == '1')

//		sleep(5);



	$row0 = null;

	if ($s0)

		$row0 = hs_read_row_sql("select * from suburb where suburb like '{$s0}'");

	

	$row1 = null;

	if ($s1)

		$row1 = hs_read_row_sql("select * from suburb where suburb like '{$s1}'");
//echo "select * from suburb where suburb = '{$s1}'";
	//print_r($row0); exit;

	$fee0 = '';

	$fee1 = '';

		

	if ($row0)

	{
            
		$fee0 = 0;

		if ($p0)

			$fee0 += $row0->A_fee[$p0-1];

		$fee0 += $b0 * 5; // Cost per Departure babyseat

		

	}

	

	if ($row1)

	{
            
		$fee1 = 0;

		if ($p1)

			$fee1 = $row1->A_fee[$p1-1];
			
			$fee1 += $b1 * 5; //Added line to calculate baby seat costs for Arrivals ACorr

		if($bk == 1) { // book type Airport
               
                    if ($a1 == '1') $fee1 += 0;  // Cost per Airport Arrival for parking Office side ACorr changed from 10 to 0

                }	

	}

		$fee0 = $fee0+$dhoursval;	
        $fee1 = $fee1+$ahoursval;
                
		$fee = $fee0 + $fee1;

			

	echo "{";

	echo "fee:'\${$fee}.00',fee0:'\${$fee0}.00',fee1:'\${$fee1}.00'";

	echo "}";



}

if (isset($_POST['efee']))

{

	 $s = $_POST['s0']; // suburb

	

	 $p0 = $_POST['p0']; // pax

	 $a0 = $_POST['a0']; // arrival

	

	

//	if ($b == '1')

//		sleep(5);

	$row = hs_read_row_sql("select * from suburb where suburb like '{$s}'");

	

	

	if ($row)

	{

		$fee = $row->A_fee[$p0-1];

		if ($a0 == 'true')

			$fee += 0;		//Arrivl fee for FARE ENQUIRIES page 

			

			

		echo "{";

		echo "fee:'\${$fee}.00'";

		echo "}";

	}

	else

	{

		echo "{";

		echo "fee:'Not found'";

		echo "}";

	}

}

if (isset($_GET['weather']))

{

	include 'weather.php';

	$location = $_GET['weather'];

	$id = $_GET['id'];

	$id++;

	$row = get_weather($location);

	if ($row)

	{

		write_weather_details($row);

	}

	else

	{

	}

}



if (isset($_POST['flight']))

{

//sleep(10);

	$flight = $_POST['flight'];

	$dir = $_POST['dir'];

	$row = hs_read_row_sql("SELECT * from flight where id = '{$flight}'");
//print_r($row->direction); exit;
	if ($row && $row->direction != $dir)

	{

		preg_match('/([A-Za-z]*)/',$flight,$matches);

		$airline = '';

		$fdir = $row->direction;

		if ($matches[0])

		{

			$row = hs_read_row_sql("SELECT id, airline from flight where id LIKE '{$matches[0]}%' limit 1");

			if ($row)

			{

				preg_match('/([A-Za-z]*)/',$row->id,$matches_id);

				if ($matches[0] == $matches_id[0])

					$airline = $row->airline;

			}

		}

		

		echo "{";

		echo "flight:'{$_POST['flight']}',";

		echo "airline:'{$airline}',";

		echo "terminal:'',";

		echo "direction:'',";

		echo "dest:'<span class=ferror>";

		if ($fdir == 'A')

			//echo "This is an Arrival flight";
                    echo '';

		else

			//echo "This is an Departure flight";
                    echo '';

		echo "</span>',";

		echo "time:''";

		echo '}';

	}

	else if ($row)

	{

		echo "{";

		echo "flight:'$row->id',";

		echo "airline:'$row->airline',";

		echo "terminal:'$row->terminal',";

		echo "direction:'$row->direction',";

		echo "dest:'<span>$row->dest0";

		if ($row->dest1)

			echo ", $row->dest1";

		echo "</span>',";

		echo "dest0:'$row->dest0',";

		echo "dest1:'$row->dest1',";

		

		$datesplit = explode('/',$_POST['date']);

		if (count($datesplit) == 3)

		{

			$da = getdate(strtotime("$datesplit[2]/$datesplit[1]/$datesplit[0]"));

//			z($da);

				

			$day = $da['wday'];

			if (isset($row->A_time[$day]))

				$time = $row->A_time[$day];
                            

			else

				$time = '';

				

			if (!$time)

				$time = "Not found";

		}

		else

			$time = 'Date not specified';



		

		echo "time:'$time'";

		

		

		echo '}';

	}

	else

	{

		preg_match('/([A-Za-z]*)/',$flight,$matches);

		$airline = '';

		if ($matches[0])

		{

			$row = hs_read_row_sql("SELECT id, airline from flight where id LIKE '{$matches[0]}%' limit 1");

			if ($row)

			{

				preg_match('/([A-Za-z]*)/',$row->id,$matches_id);

				if ($matches[0] == $matches_id[0])

					$airline = $row->airline;

			}

		}

		

		echo "{";

		echo "flight:'{$_POST['flight']}',";

		echo "airline:'{$airline}',";

		echo "terminal:'',";

		echo "direction:'',";

		//echo "dest:'<span class=ferror>Flight not found</span>',";
                echo "dest:'',";

		echo "time:''";

		echo '}';

	}

}	



if (isset($_GET['email']))

{

	$email = $_GET['email'];

	

	$row = hs_read_row_sql("SELECT * from client where email = '{$email}'");

	

	if ($row)

	{

		echo '{';

		echo "email:'$row->email',";

		echo "firstname:'$row->firstname',";

		echo "surname:'$row->surname'";

		echo '}';

	}

	else

		echo "{}";



}



if (isset($_POST['suburb']))

{

	$suburb = $_POST['suburb'];
        $dir = $_POST['dir'];
	if($dir==1) $direct = 1;
        else $direct = 0;

	$rows = hs_read_rows_sql("SELECT * from suburb order by suburb");

	

	if ($rows)

	{
                $subval = '';
		foreach ($rows as $row) {

			//echo "<tr><td>$row->suburb</td></tr>";

                        //echo "</table>\"}";
                 $subval.= ",".$row->suburb;
                    
                }
                echo $subval;
	}

	else {

                 echo '<ul>';
                    echo '<li>No record found</li>';
                 echo '</ul>'; 

        }

}

// website  calculation
if (isset($_POST['webfee']))

{

	$s0 = $_POST['s0']; // suburb

	$s1 = $_POST['s1']; // suburb

	

	$p0 = $_POST['p0']; // pax

	$b0 = $_POST['b0']; // baby seat

	$a0 = $_POST['a0']; // arrival

	

	$p1 = $_POST['p1']; // pax

	$b1 = $_POST['b1']; // baby seat

	$a1 = $_POST['a1']; // arrival
        
        $bktype = $_POST['bktype']; // book type

//	if ($b == '1')

//		sleep(5);

        // pickup time calculate
            // dep pickup time
        $dhours = 0;
        $ahours = 0;
        $amin = 0;
        $dhoursval = 0;
        $ahoursval = 0;
        
        $arrpicktime = '';
        
        $arr_flag = '';
       
        // for AirPort
      if($bktype==1 || $bktype==0)  { 
          
        $depterminal = $_POST['depterm'];
        
        $arrterminal = $_POST['arrterm'];
        
        $depourtime = $_POST['deptime'];
        
        $arrourtime = $_POST['arrtime'];
        
        if(($depterminal!='' && $depourtime!='')) {
            
            // dep pickup time
            if($depterminal=='Int') $dhours = date('H:i', strtotime($depourtime.' - 4 hours') );
            else if($depterminal=='Dom') $dhours = date('H:i', strtotime($depourtime.' - 3 hours') );

            // dep est fare calculation
            //if($dhours!=0 && $dhours<5) $dhoursval = '20';
            //else if($dhours==5) $dhoursval = '10';
			
			// dep pickup time ACorr
        	if($dhours!=0 && $dhours<4) $dhoursval = '40';
        	else if($dhours==4) $dhoursval = '20';
			else if($dhours==5) $dhoursval = '20';

        }
        
        if(($arrterminal!='' && $arrourtime!='')) {
            
            // arr pickup time
            if($arrterminal=='Int') $arrpicktime = date('H:i', strtotime($arrourtime.' + 30 minutes') );
            else if($arrterminal=='Dom') $arrpicktime = $arrourtime;

            $arrxp = explode(':', $arrpicktime);
            $ahours = $arrxp[0];
            $amin = $arrxp[1];
            
            // arr est fare calcultaion
            if($ahours==19) $ahoursval = '20';
            else if($ahours==20) $ahoursval = '30';
            //else if($ahours==21 || ($ahours==22 && $amin<06)) $ahoursval = '50';
			else if($ahours==21 || ($ahours==22)) $ahoursval = '50'; //Assigned $50 fee for 22:00 and 23:00 Arrivals ACorr
            
            // arrival pickup time above 21:35
            if(($ahours==21 && $amin>35) || ($ahours>21)) {
                
                $arr_flag = '1';
            }
            else $arr_flag = '';
            
        }
        
      }
      else {
          
        $arrpicktime = ''  ;
        
        $depourtime = $_POST['deptime'];
        
        $arrourtime = $_POST['arrtime'];
        
        if($depourtime!='') {
            
            // dep pickup time
            $dhours = date('H:i', strtotime($depourtime.' - 2 hours') );

            // dep est fare calculation
            //if($dhours!=0 && $dhours<5) $dhoursval = '20';
            //else if($dhours==5) $dhoursval = '10';
			
			// dep pickup time ACorr
        	if($dhours!=0 && $dhours<4) $dhoursval = '30';
			//if(($dhours!=0 && $dhours<4 && $arrterminal=='Int'))$dhoursval = '50';
			//else if(($dhours!=0 && $dhours<4 && $arrterminal=='Dom'))$dhoursval = '20';
       		else if($dhours==4 || $dhours==5) $dhoursval = '20';
			//else if($dhours==5) $dhoursval = '20';

        }

        if($arrourtime!='') {
            
            // arr pickup time
           $arrpicktime = $arrourtime;

            $arrxp = explode(':', $arrpicktime);
            $ahours = $arrxp[0];
            $amin = $arrxp[1];
            
            // arr est fare calcultaion
            if($ahours==19) $ahoursval = '20';
            else if($ahours==20) $ahoursval = '30';
            else if($ahours==21 || ($ahours==22 && $amin<06)) $ahoursval = '50';
            
            // arrival pickup time above 21:35
            if(($ahours==21 && $amin>35) || ($ahours>21)) {
                
                $arr_flag = '1';
            }
            else $arr_flag = '';
            
        }
          
      }
      
	$row0 = null;

	if ($s0)

		$row0 = hs_read_row_sql("select * from suburb where suburb like '{$s0}'");

	

	$row1 = null;

	if ($s1)

		$row1 = hs_read_row_sql("select * from suburb where suburb like '{$s1}'");
//echo "select * from suburb where suburb = '{$s1}'";
	//print_r($row0); exit;

	$fee0 = '';

	$fee1 = '';

		

	if ($row0)

	{
            
		$fee0 = 0;

		if ($p0)

			$fee0 += $row0->A_fee[$p0-1];

		$fee0 += $b0 * 5;

		

	}

	

	if ($row1)

	{
            
		$fee1 = 0;

		if ($p1)

			$fee1 += $row1->A_fee[$p1-1];
			$fee1 += $b1 * 5; //Added line to calculate baby seat costs for Arrivals ACorr

		if($bktype==1) {
                
                    if ($a1 == '1') $fee1 += 0;  // Cost per Airport Arrival for parking Customer Side ACorr changed from 10 to 0 

                }
	}

		$fee0 = $fee0+$dhoursval;	
        $fee1 = $fee1+$ahoursval;
                
		$fee = $fee0 + $fee1;

			

	echo "{";

	echo "fee:'\${$fee}.00',fee0:'\${$fee0}.00',fee1:'\${$fee1}.00',arrflag:'$arr_flag'";

	echo "}";



}

if (isset($_POST['websuburb']))

{

	//$suburb = $_POST['websuburb'];

	$rows = hs_read_rows_sql("SELECT * from suburb order by suburb");

	

	if ($rows)

	{
                $subval = '';
		foreach ($rows as $row) {

			//echo "<tr><td>$row->suburb</td></tr>";

                        //echo "</table>\"}";
                 $subval.= ",".$row->suburb;
                    
                }
               echo $subval;
	}

	else {

                 echo '<ul>';
                    echo '<li>No record found</li>';
                 echo '</ul>'; 

        }

}

if (isset($_POST['departuredate']) && $_POST['departuredate']=='newbook') {
    
    $todaydate = date('Y-m-d');
    $todaydate = strtotime($todaydate);
    
    $depdate = '';
    
    if(isset($_POST['depdate']) && $_POST['depdate']!='') { $depdate = $_POST['depdate'];
                $exp_date = explode('/',$depdate);
                
                $depdate = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
                $depdate = strtotime($depdate);
    }
    
   // echo $todaydate.",".$depdate; exit;
    $dflag = true;  
    
    if($_POST['mode']=='online') { if($todaydate < $depdate) $dflag = true; else $dflag = false; }
    else { if($todaydate <= $depdate) $dflag = true; else $dflag = false; }
    
    echo $dflag;
}

if (isset($_POST['arrivaldate']) && $_POST['arrivaldate']=='newbook') {
    
    $todaydate = date('Y-m-d');
    $todaydate = strtotime($todaydate);
    
    $arrdate = '';
    
    if(isset($_POST['arrdate']) && $_POST['arrdate']!='') { $arrdate = $_POST['arrdate'];
                $exp_date = explode('/',$arrdate);
                
                $arrdate = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
                $arrdate = strtotime($arrdate);
    }
    
    $aflag = true;  
    
    if($_POST['mode']=='online') { if($todaydate < $arrdate) $aflag = true; else $aflag = false; }
    else { if($todaydate <= $arrdate) $aflag = true; else $aflag = false; }
    
    echo $aflag;
}

// website  calculation end

// more booking
if (isset($_POST['moresuburb']))

{

	$suburb = $_POST['moresuburb'];
        $dir = $_POST['dir'];
        $mid = $_POST['auto'];
        
	if($dir==1) $direct = 1;
        else $direct = 0;

	$rows = hs_read_rows_sql("SELECT * from suburb where suburb like '{$suburb}%' order by suburb");

	

	if ($rows)

	{

		foreach ($rows as $row) {

			//echo "<tr><td>$row->suburb</td></tr>";

                        //echo "</table>\"}";
                 echo '<ul>';
                    echo '<li onClick="fillmoreSuburb(\''.$row->suburb.'\',\''.$direct.'\',\''.$mid.'\');">'.$row->suburb.'</li>';
                 echo '</ul>'; 
                    
                }
	}

	else {

                 echo '<ul>';
                    echo '<li>No record found</li>';
                 echo '</ul>'; 

        }

}

// popup suburb
if (isset($_POST['popsuburb']))

{

	$suburb = $_POST['popsuburb'];

	$rows = hs_read_rows_sql("SELECT * from suburb order by suburb");

	

	if ($rows)

	{
            $subval = '';
		foreach ($rows as $row) {

			//echo "<tr><td>$row->suburb</td></tr>";

                        //echo "</table>\"}";
                    $subval.= ",".$row->suburb;
                }
                echo $subval;
	}

	else {

                 echo '<ul>';
                    echo '<li>No record found</li>';
                 echo '</ul>'; 

        }

} // more booking end

// suburb validate for App suburb add
if(isset($_POST['suburbval'])) {
    $subval = $_POST['queryString'];
    $exsubval = $_POST['exsuburb'];
    
    if($exsubval!='') $rows = hs_read_row_sql("select * from suburb where suburb!='".$exsubval."' and suburb like '{$subval}'");
    else $rows = hs_read_row_sql("select * from suburb where suburb like '{$subval}'");
    
    if($rows) $suburb = $rows->suburb;
    else $suburb = '0';
    
    echo $suburb;
}

// suburb validate for Client in App
if(isset($_POST['clisuburbval'])) {
    $subval = $_POST['queryString'];
    
    $rows = hs_read_row_sql("select * from suburb where suburb like '{$subval}'");
    
    if($rows) $suburb = $rows->suburb;
    else $suburb = '0';
    
    echo $suburb;
}

// flight validate for App flight add
if(isset($_POST['flightval'])) {
    $flval = $_POST['queryString'];
    $exflval = $_POST['exflight'];
    
    if($exflval!='') $rows = hs_read_row_sql("select * from flight where id!='".$exflval."' and id like '{$flval}'");
    else $rows = hs_read_row_sql("select * from flight where id like '{$flval}'");
    
    if($rows) $fl = $rows->id;
    else $fl = '0';
    
    echo $fl;
}

// web suburb page
if(isset($_POST['suburbpage'])) {
    
    $rows = hs_read_rows_sql("select * from suburb order by suburb asc");
    
    echo json_encode($rows);
}



?>