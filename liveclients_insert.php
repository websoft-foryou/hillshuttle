<?php include 'db_connect.php';include 'hscommon/hsdb.php';hs_open();		$row1 = hs_read_rows_sql("SELECT * from suburb order by suburb");               echo '<pre>';            print_r($row1); /*                $k = 1;foreach($row1 as $row) {  //  echo $k."-".$row->cfirstname.' '.$row->csurname;    $sub = hs_read_rows_sql("select * from suburb where suburb like '".$row->csuburb."'");    if(count($sub)!=0) {     //   echo $k."-".$sub[0]->suburb;      //  echo '<br/>';        $suburb = $sub[0]->suburb;        $query = "insert into clients (first_name,last_name,gender,dob,address1,address2,suburb,state,phone,mobile,email,password,cli_type,created_by,created_date,updated_by,updated_date) values ('".mysql_real_escape_string($row->cfirstname)."','".mysql_real_escape_string($row->csurname)."','','','".mysql_real_escape_string($row->caddress)."','','".mysql_real_escape_string($suburb)."',0,'".mysql_real_escape_string($row->cphone)."','".mysql_real_escape_string($row->cmobile)."','".mysql_real_escape_string($row->cemail)."','".mysql_real_escape_string($row->cmd5password)."','1','','".mysql_real_escape_string($row->ccreated)."','','')";        mysql_query($query);        $k++;            }                } */                ?>