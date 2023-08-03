<?php







function get_booking($b = null, $today = null,$c = null)

{

	

		

	$q = "select *, client.id as cid, booking.id as bid

		from booking inner join client on (booking.cid = client.id) ";

/*	

		booking.id as bid,

		client.id as cid,

		client.email,

		client.firstname,

		client.surname,

		client.phone,

		client.mobile,

		booking.flight,

		booking.airline,

		booking.flightnotfound,

		booking.direction,

		booking.terminal,

		booking.date,

		booking.time,

		booking.ftime,

		booking.fprimary,

		booking.freturn,

		client.address,

		client.suburb,

		booking.baddress,

		booking.bsuburb

		from booking inner join client on (booking.client = client.id) ";

*/		

		

	if ($b)

	{

		$q .= "where booking.id = '{$b}'";

		$row = hs_read_row_sql($q);

		return $row;

	}	

	else if ($c)

	{

		$q .= "where cid = '{$c}' order by bdate desc, bstime desc ";

		return hs_read_rows_sql($q);

	}	

	else

	{

//		$q .= "where bdate >= '{$today}'";

		$q .= " order by bdate, bstime ";

		return hs_read_rows_sql($q);

	}

}





function buildbookingrow(&$row)

{

	$row->id = 0;

	$row->cid = 0;

	$row->btype = $_SESSION['btype'];

	$row->bsuburb = $_SESSION['crow']->csuburb;

	$row->baddress = $_SESSION['crow']->caddress;

	$row->bphone = $_SESSION['crow']->cphone;

	$row->bmobile .= $_SESSION['crow']->cmobile;

	$row->bflight = '';

	$row->bairline = '';

	$row->bterminal = '';

	$row->bdest = '';

//	$row->bdirection = '';

	$row->bdeparture = 0;

	$row->barrival = 0;

	$row->bdate = 0;

	$row->bftime = '';

	$row->btime = '';

	$row->bpax = 1;

	$row->bbaby = 0;

	$row->bcomments = '';

	$row->bfare = 0;

	$row->bcreated = time();

	$row->downloaded = 0;

	

	$srow = hs_read_row_sql("select * from suburb where suburb = '{$row->bsuburb}'");

	if ($srow)

	{

		$row->bfare = $srow->A_fee[0];

	}

}













function passengerdet($row,$cerror,$displayonly = true)

{

	

	if ($displayonly)

	{

		$ro = ' readonly ';

	}

	else

	{

		$ro = '';

	}

	

//	$row = hs_read_row('client',$id);



	if (isset($_SESSION['confirmmsg']))

	{

		echo "<strong>{$_SESSION['confirmmsg']}</strong>\r\n";

		unset($_SESSION['confirmmsg']);

	}



	$err = ' class=f_input_error';



	

	

//	groupbox('Passenger Details');

	echo "<h3>Passenger Details</h3>\r\n";

	

	if ($cerror)

	{

		echo "<p class = form_input_error>Some required fields have not been completed or have been completed incorrectly.<br>\r\n";

		foreach($cerror as $e)

		{

			if ($e)

				echo "Passenger " . $e . "<br>\r\n";

		}

		echo "</p>\r\n";

		

	}

	

	

	

	echo "<table class=booking>\r\n";

	

	echo "<thead>\r\n";

	

	echo "<tr><th></th><td class=passenger>";

	echo "<div style='background: #fd8 url(images/otl.gif) no-repeat;'>";

	echo "<div style='background: transparent url(images/otr.gif) no-repeat top right;'>";

	echo "&nbsp;";

	echo "</div></div>\r\n";

	echo "</td></tr>\r\n";

	$o = fixout($row->cemail);

	$e = isset($cerror->cemail) ? $err: '';

	echo "<tr><th style='width: 8em;'>Email</th><td class=passenger><input $ro style='width: 20em;' type=text name=email id=email value='{$o}' {$e}></td></tr>\r\n";

	echo "</thead>\r\n";

	echo "<tbody id=passengerbody>\r\n";

	

 	$o = fixout($row->cfirstname);

	$e = isset($cerror->cfirstname) ? $err: '';

	echo "<tr><th>First name</th><td class=passenger><input $ro style='width: 12em;' type=text name=firstname id=firstname value='{$o}' {$e}></td></tr>\r\n";

	

	$o = fixout($row->csurname);

	$e = isset($cerror->csurname) ? $err: '';

	echo "<tr><th>Surname</th><td class=passenger><input $ro style='width: 12em;' type=text name=surname id=surname value='{$o}' {$e}></td></tr>\r\n";

	

	$o = fixout($row->csuburb);

	$e = isset($cerror->csuburb) ? $err: '';

	echo "<tr>";

	echo "<th>Suburb</th><td class=passenger>

	<input $ro style='width: 10em;' type=text  name=suburb id=suburb value='{$o}' {$e}>

	<img id=suburbloader src='loader.gif' style='visibility: hidden'>

	<span id=suburberror class=error></span><br>

	<div id=suburblist class=suburblist>

	</div>

	</td>\r\n";

	echo "<td class=additional rowspan=4>Your Passenger address and phone details will be used in any new bookings.</td>\r\n";

	echo "</tr>\r\n";

	

	$o = fixout($row->caddress);

	$e = isset($cerror->caddress) ? $err: '';

	echo "<tr><th>Street Address</th><td class=passenger><input $ro style='width: 20em;' type=text name=address id=address value='{$o}' {$e}></td></tr>\r\n";

	

	//echo "<tr><th>Postcode</th><td><input $ro type=text name=postcode id=postcode></td></tr>\r\n";

	$o = fixout($row->cphone);

	$e = isset($cerror->cphone) ? $err: '';

	echo "<tr><th>Phone</th><td class=passenger><input $ro type=text name=phone id=phone value='{$o}' {$e}></td></tr>\r\n";

	$o = fixout($row->cmobile);

	$e = isset($cerror->cmobile) ? $err: '';

	echo "<tr><th>Mobile</th><td class=passenger><input $ro type=text name=mobile id=mobile value='{$o}' {$e}></td></tr>\r\n";

	

	if ($displayonly)

	{

		echo "<tr><th></th><td class=passenger>";

		echo "<input type=submit name=updateclient value = 'Update passenger details'>\r\n";

		echo "<input $ro type=submit name=logout value=Logout>\r\n";

		echo "</td>";

		echo "<td class=additional>You may wish to update your passenger details before starting a new booking.</td>\r\n";

	}

	else

	{	

		echo "<tr><th></th><td class=passenger>";

		echo "<input type=submit name=saveclient value = 'Save'>";

		echo "<input type=submit name=cancelclient value = 'Cancel'>";

		echo "</td>\r\n";

	}

	echo "</tr>\r\n";

	

	echo "<tr><th></th><td class=passenger>";

	echo "<div style='background: #fd8 url(images/obl.gif) no-repeat;'>";

	echo "<div style='background: transparent url(images/obr.gif) no-repeat top right;'>";

	echo "&nbsp;";

	echo "</div></div>\r\n";

	echo "</td></tr>\r\n";

	

	echo "</tbody>\r\n";

	

	echo "</table>\r\n";



	

	

	

//	egroupbox();

	

}









function bookingdet($crow,$drow,$arow,$derror,$aerror)

{

	$btype = '';

	$err = ' class=f_input_error';

	$o = '';

//	groupbox('Travel Details');

	echo "<h3>Travel Details. ";

	

	echo "</h3>\r\n";

	

	if ($derror || $aerror)

	{

		echo "<p class = form_input_error>Some required fields have not been completed or have been completed incorrectly.<br>\r\n";

		if ($derror)

		{

			foreach($derror as $e)

			{

				if ($e)

					echo "Departure " . $e . "<br>\r\n";

			}

		}

		if ($aerror)

		{

			foreach($aerror as $e)

			{

				if ($e)

					echo "Arrival " . $e . "<br>\r\n";

			}

		}

		echo "</p>\r\n";

		

	}

	

	echo "<table class=booking>\r\n";

	

	echo "<tr>\r\n";

	echo "<th style='width: 8em;'></th>\r\n";

	

	if ($drow)

	{

		echo "<th style='text-align: center;' class=departure>";

		echo "<div style='background: #cfc url(images/gtl.gif) no-repeat;'>";

		echo "<div style='background: transparent url(images/gtr.gif) no-repeat top right;'>";

		echo "<div style='padding-top: 6px;'>";

		$btype = $drow->btype;

		if ($btype == 'AP')

			echo "Airport ";

		if ($btype == 'DH')

			echo "Darling Harbour ";

		if ($btype == 'CQ')

			echo "Circular Quay ";

		if ($btype == 'CS')

			echo "Central Station ";

		echo "Departure</div>";

		echo "</div>";

		echo "</div>";

		echo "</th>\r\n";

	}

	

	if ($arow)

	{

		echo "<th style='text-align: center;' class=departure>";

		echo "<div style='background: #ccf url(images/btl.gif) no-repeat;'>";

		echo "<div style='background: transparent url(images/btr.gif) no-repeat top right;'>";

		echo "<div style='padding-top: 6px;'>";

		$btype = $arow->btype;

		if ($btype == 'AP')

			echo "Airport ";

		if ($btype == 'DH')

			echo "Darling Harbour ";

		if ($btype == 'CQ')

			echo "Circular Quay ";

		if ($btype == 'CS')

			echo "Central Station ";

		echo "Arrival</div>";

		echo "</div>";

		echo "</div>";

		echo "</tr>\r\n";

	}

	

	echo "<tr>\r\n";

	echo "<th></th>\r\n";

	if ($drow)

		echo "<td class=departure style='padding-bottom: .4em;'><div style='text-align: center;'>Complete this section for your<br> departure dropoff</div></td>\r\n";

	if ($arow)

	{

		echo "<td class=arrival><div style='text-align: center;'>Complete this section for your<br> arrival pickup</div></td>\r\n";

		echo "<td class=additional>There is a $5 parking surcharge for arrivals</td>\r\n";

	}

	

		

		

	echo "</tr>\r\n";



	if ($drow && $drow->id || $arow && $arow->id)

	{

		echo "<tr><th>Booking Number</th>\r\n";

		if ($drow)

		{

			echo "<td class=departure><div>\r\n";

			if ($drow->id)

				echo "<span>{$drow->cid}-{$drow->id}</span>";

			echo "</div></td>\r\n";

		}

		if ($arow)

		{

			echo "<td class=arrival><span>\r\n";

			if ($arow->id)

				echo "<span>{$arow->cid}-{$arow->id}</span>";

			echo "</span></td>\r\n</tr>\r\n";

		}

	}

	

	

	echo "<tr><th>Suburb</th>\r\n";

	

	if ($drow)

	{

		$o = fixout($drow->bsuburb);

		$e = isset($derror->bsuburb) ? $err: '';

		echo "<td class=departure>

		<input style='width: 10em;' type=text name=bsuburb[0] id=suburb0 value='{$o}' {$e}>

		<img id=suburbloader0 src='loader.gif' style='visibility: hidden'>

		<span id=suburberror0 class=error></span><br>

		<div id=suburblist0  class=suburblist>

		</div>

		</td>\r\n";

	}

	if ($arow)

	{

		$o = fixout($arow->bsuburb);

		$e = isset($aerror->bsuburb) ? $err: '';

		echo "<td class=arrival>

		<input style='width: 10em;' type=text name=bsuburb[1] id=suburb1 value='{$o}' {$e}>

		<img id=suburbloader1 src='loader.gif' style='visibility: hidden'>

		<span id=suburberror1 class=error></span><br>

		<div id=suburblist1  class=suburblist>

		</div>

		</td>\r\n";

	}

	echo "<td class=additional rowspan=4>You may change your travel pickup/dropoff address and phone details

		if for this booking they are your to passenger details above.</td>\r\n";

	echo "</tr>\r\n";

	

	

	

	echo "<tr><th>Street Address</th>\r\n";

	if ($drow)

	{

		$o = fixout($drow->baddress);

		$e = isset($derror->baddress) ? $err: '';

		echo "<td class=departure><input style='width: 16em;' type=text name=baddress[0] id=address0 value='{$o}' {$e}></td>\r\n";

	}

	if ($arow)

	{

		$o = fixout($arow->baddress);

		$e = isset($aerror->baddress) ? $err: '';

		echo "<td class=arrival><input style='width: 16em;' type=text name=baddress[1] id=address1 value='{$o}' {$e}></td>\r\n";

	}

	echo "</tr>\r\n";

	

	

	echo "<tr><th>Phone</th>\r\n";

	if ($drow)

	{

		$o = fixout($drow->bphone);

		$e = isset($derror->bphone) ? $err: '';

		echo "<td class=departure><input type=text name=bphone[0] id=phone0 value='{$o}' {$e}></td>\r\n";

	}

	if ($arow)

	{

		$o = fixout($arow->bphone);

		$e = isset($aerror->bphone) ? $err: '';

		echo "<td class=arrival><input type=text name=bphone[1] id=phone1 value='{$o}' {$e}></td>\r\n";

	}

	echo "</tr>\r\n";

	

	

	echo "<tr><th>Mobile</th>\r\n";

	if ($drow)

	{

		$o = fixout($drow->bmobile);

		$e = isset($derror->bmobile) ? $err: '';

		echo "<td class=departure><input type=text name=bmobile[0] id=mobile0 value='{$o}' {$e}></td>\r\n";

	}

	if ($arow)

	{

		$o = fixout($arow->bmobile);

		$e = isset($aerror->bmobile) ? $err: '';

		echo "<td class=arrival><input type=text name=bmobile[1] id=mobile1 value='{$o}' {$e}></td>\r\n";

	}

	echo "</tr>\r\n";

	

	

	if ($btype == 'AP')

	{

	

		echo "<tr><th>Flight number</th>\r\n";

		if ($drow)

		{

			$o = fixout($drow->bflight);

			$e = isset($derror->bflight) ? $err: '';

			echo "<td class=departure><input type=text name=flight[0] id=flight0 value='{$o}' onkeyup='getFlight(0);' {$e}><img id=flightloader0 src='loader.gif' style='visibility: hidden'></td>\r\n";

		}

		if ($arow)

		{

			$o = fixout($arow->bflight);

			$e = isset($aerror->bflight) ? $err: '';

			echo "<td class=arrival><input type=text name=flight[1] id=flight1 value='{$o}' onkeyup='getFlight(1);' {$e}><img id=flightloader1 src='loader.gif' style='visibility: hidden'></td>\r\n";

		}

		

		echo "<td class=additional rowspan=3>When you enter a valid Flight Number some of the fields below may be filled in for you.</td>\r\n";

		echo "</tr>\r\n";

		

		

		

		echo "<tr><th>Origin/Dest</th>\r\n";

		if ($drow)

		{

			$o = '';

			if ($drow)

			{ 

				if ($drow->bdest)

					$o = "<span>" . fixout($drow->bdest) . "</span>";

				else

					$o = "<span class=ferror>Flight not found</span>";

			}

			echo "<td id='dest0' class=departure>$o</td>\r\n";

		}

		if ($arow)

		{

			$o = '';

			if ($arow)

			{ 

				if ($arow->bdest)

					$o = "<span>" . fixout($arow->bdest) . "</span>";

				else

					$o = "<span class=ferror>Flight not found</span>";

			}

			echo "<td id='dest1' class=arrival>$o</td>\r\n";

		}

		

		echo "</tr>\r\n";

		

		

		

		

		echo "<tr><th>Airline</th>\r\n";

		if ($drow)

		{

			$o = fixout($drow->bairline);

			$e = isset($derror->bairline) ? $err: '';

			echo "<td class=departure><input type=text name=airline[0] id=airline0 value='{$o}' {$e}></td>\r\n";

		}

		if ($arow)

		{

			$o = fixout($arow->bairline);

			$e = isset($aerror->bairline) ? $err: '';

			echo "<td class=arrival><input type=text name=airline[1] id=airline1 value='{$o}' {$e}></td>\r\n";

		}

		echo "</tr>\r\n";

		

		

		

		

		echo "<tr><th>Terminal</th>\r\n";

		

		if ($drow)

		{

			echo "<td class=departure><label><input type=radio name=terminal[0] value=D id=domestic0";

			if ($drow && $drow->bterminal == 'D')

				echo " checked";

			echo ">Domestic</label><label><input type=radio name=terminal[0] value=I id=international0";

			if ($drow && $drow->bterminal == 'I')

				echo " checked";

			echo ">International</label></td>\r\n";

		}

		

		if ($arow)

		{

			echo "<td class=arrival><label><input type=radio name=terminal[1] value=D id=domestic1";

			if ($arow->bterminal == 'D')

				echo " checked";

			echo ">Domestic</label><label><input type=radio name=terminal[1] value=I id=international1";

			if ($arow->bterminal == 'I')

				echo " checked";

			echo ">International</label></td>\r\n";

		}

		

		echo "</tr>\r\n";

		

		

		

/*		

		echo "<tr><th>Flight Type</th>\r\n";

		

		if ($drow)

		{

			echo "<td class=departure><label><input type=radio name=direction[0] value=A id=arrival0";

			

			if ($drow->bdirection =='A')

				echo " checked";

				

			echo ">Arrival</label><label><input type=radio name=direction[0] value=D id=departure0";

			

			if ($drow->bdirection =='D')

				echo " checked";

				

			echo ">Departurel</label></td>\r\n";

		}

		if ($arow)

		{	

			echo "<td class=arrival><label><input type=radio name=direction[1] value=A id=arrival1";

			

			if ($arow->bdirection =='A')

				echo " checked";

				

			echo ">Arrival</label><label><input type=radio name=direction[1] value=D id=departure1";

			

			if ($arow->bdirection =='D')

				echo " checked";

				

			echo ">Departure</label></td>\r\n";

		}

		

		echo "<td class=additional>There is a $5 parking fee for arrivals</td>\r\n";

		echo "</tr>\r\n";

		

*/		

		

	}		

	

	if ($btype == 'AP')

		echo "<tr><th>Flight Date</th>\r\n";

	else

		echo "<tr><th>Date</th>\r\n";

	

	if ($drow)

	{

		echo "<td class=departure>\r\n";

		$o = '';

		$e = isset($derror->bdate) ? $err: '';

		if ($drow->bdate)

		{

			$rdate = new DateTime('@' . $drow->bdate);

			$o = $rdate->format("d/m/Y");

	 	}

		echo "<input type=text name=date[0] id=date0 readonly onclick='cal0.select(this)' value='{$o}' {$e}>";

		echo "<br><div ID='divdate0' style='position:absolute;visibility:hidden;background-color:white;layer-background-color:white;'></div>";

		echo "</td>\r\n";

	}

	if ($arow)

	{		

		echo "<td class=arrival>\r\n";

		$o = '';

		$e = isset($aerror->bdate) ? $err: '';

		if ($arow->bdate)

		{

			$bdate = new DateTime('@' . $arow->bdate);

			$o = $bdate->format("d/m/Y");

	 	}

		echo "<input type=text name=date[1] id=date1 readonly onclick='cal1.select(this)' value='{$o}' {$e}>";

		echo "<br><div id='divdate1' style='position:absolute;visibility:hidden;background-color:white;layer-background-color:white;'></div>";

		echo "</td>\r\n";

	}

	

	echo "</tr>\r\n";

	

	

	

	

	if ($btype == 'AP')

	{

		echo "<tr><th>Our Flight Time</th>\r\n";

		

		if ($drow)

		

		{

			$o = $drow->bftime;

			echo "<td class=departure> <input type=text readonly name=ftime[0] id=ftime0 value='{$o}'></td>";

		}

		if ($arow)

		{	

			$o = $arow->bftime;

			echo "<td class=arrival> <input type=text readonly name=ftime[1] id=ftime1 value='{$o}'></td>";

		}

		

	

		

		echo "</tr>\r\n";

	}	

	

		

	if ($btype == 'AP')

		echo "<tr><th>Your Flight Time</th>\r\n";

	else

		echo "<tr><th>Time</th>\r\n";



	if ($drow)

	{	

		$o = $drow->btime ? $drow->btime : '';

		$e = isset($derror->btime) ? $err: '';

		echo "<td class=departure> <input type=text name=time[0] id=time0 value='{$o}' {$e}></td>";

	}

	if ($arow)

	{	

		$o = $arow->btime ? $arow->btime : '';

		$e = isset($aerror->btime) ? $err: '';

		echo "<td class=arrival> <input type=text name=time[1] id=time1 value='{$o}' {$e}></td>";

	}

	

	if ($btype == 'AP')

	{

		echo "<td class=additional>You may enter the flight time on your ticket if it differs from our flight time stored in our database</td>\r\n";

	}

	

	echo "</tr>\r\n";



	

		

	echo "<tr><th>Passengers</th>\r\n";

	

	if ($drow)

	{

		$s1 = '';

		$s2 = '';

		$s3 = '';

		$s4 = '';

		$s5 = '';

		$s6 = '';

		$s7 = '';

		$s8 = '';

		$s9 = '';

		$s10 = '';

		$s11 = '';

		if ($drow->bpax == 1) $s1 = ' selected';

		if ($drow->bpax == 2) $s2 = ' selected';

		if ($drow->bpax == 3) $s3 = ' selected';

		if ($drow->bpax == 4) $s4 = ' selected';

		if ($drow->bpax == 5) $s5 = ' selected';

		if ($drow->bpax == 6) $s6 = ' selected';

		if ($drow->bpax == 7) $s7 = ' selected';

		if ($drow->bpax == 8) $s8 = ' selected';

		if ($drow->bpax == 9) $s9 = ' selected';

		if ($drow->bpax == 10) $s10 = ' selected';

		if ($drow->bpax == 11) $s11 = ' selected';

		echo "<td class=departure>\r\n";

		echo "<select name='pax[0]' id='pax0' onchange='getFee();'>\r\n";

		echo "

		<option value='1'{$s1}>1</option>

		<option value='2'{$s2}>2</option>

		<option value='3'{$s3}>3</option>

		<option value='4'{$s4}>4</option>

		<option value='5'{$s5}>5</option>

		<option value='6'{$s6}>6</option>

		<option value='7'{$s7}>7</option>

		<option value='8'{$s8}>8</option>

		<option value='9'{$s9}>9</option>

		<option value='10'{$s10}>10</option>

		<option value='11'{$s11}>Charter</option>";

		echo "</select>\r\n";

		echo"</td>\r\n";

	}

	

	if ($arow)

	{	

		$s1 = '';

		$s2 = '';

		$s3 = '';

		$s4 = '';

		$s5 = '';

		$s6 = '';

		$s7 = '';

		$s8 = '';

		$s9 = '';

		$s10 = '';

		$s11 = '';

		if ($arow->bpax == 1) $s1 = ' selected';

		if ($arow->bpax == 2) $s2 = ' selected';

		if ($arow->bpax == 3) $s3 = ' selected';

		if ($arow->bpax == 4) $s4 = ' selected';

		if ($arow->bpax == 5) $s5 = ' selected';

		if ($arow->bpax == 6) $s6 = ' selected';

		if ($arow->bpax == 7) $s7 = ' selected';

		if ($arow->bpax == 8) $s8 = ' selected';

		if ($arow->bpax == 9) $s9 = ' selected';

		if ($arow->bpax == 10) $s10 = ' selected';

		if ($arow->bpax == 11) $s11 = ' selected';

		echo "<td class=arrival>\r\n";

		echo "<select name='pax[1]' id='pax1' onchange='getFee();'>\r\n";

		echo "

		<option value='1'{$s1}>1</option>

		<option value='2'{$s2}>2</option>

		<option value='3'{$s3}>3</option>

		<option value='4'{$s4}>4</option>

		<option value='5'{$s5}>5</option>

		<option value='6'{$s6}>6</option>

		<option value='7'{$s7}>7</option>

		<option value='8'{$s8}>8</option>

		<option value='9'{$s9}>9</option>

		<option value='10'{$s10}>10</option>

		<option value='11'{$s11}>Charter</option>";

		echo "</select>\r\n";

		echo"</td>\r\n";

	}

	

	echo "</tr>\r\n";

	

	

	

	echo "<tr><th>Baby Seats</th>\r\n";



	if ($drow)

	{	

		$s0 = '';

		$s1 = '';

		$s2 = '';

		if ($drow->bbaby == 0) $s0 = ' selected';

		if ($drow->bbaby == 1) $s1 = ' selected';

		if ($drow->bbaby == 2) $s2 = ' selected';

		echo "<td class=departure>\r\n";

		echo "<select name='baby[0]' id='baby0' onchange='getFee();'>\r\n";

		echo "

		<option value='0'{$s0}>None</option>

		<option value='1'{$s1}>1</option>

		<option value='2'{$s2}>2</option>";

		echo "</select>\r\n";

		echo "</td>\r\n";

	}

	if ($arow)

	{	

		$s0 = '';

		$s1 = '';

		$s2 = '';

		if ($arow->bbaby == 0) $s0 = ' selected';

		if ($arow->bbaby == 1) $s1 = ' selected';

		if ($arow->bbaby == 2) $s2 = ' selected';

		echo "<td class=arrival>\r\n";

		echo "<select name='baby[1]' id='baby1' onchange='getFee();'>\r\n";

		echo "

		<option value='0'{$s0}>None</option>

		<option value='1'{$s1}>1</option>

		<option value='2'{$s2}>2</option>";

		echo "</select>\r\n";

		echo "</td>\r\n";

	}

	

	echo "</tr>\r\n";

	

	

	

	

	echo "<tr><th>Comments</th>\r\n";

	

	if ($drow)

	{		

		echo "<td class=departure><textarea style='width: 18em; height: 6em;' name=comments[0]>\r\n";

		echo fixout($drow->bcomments);

		echo "</textarea></td>\r\n";

	}

	if ($arow)

	{

		echo "<td class=arrival><textarea style='width: 18em; height: 6em;' name=comments[1]>\r\n";

		echo fixout($arow->bcomments);

		echo "</textarea></td>\r\n";

	}

	

	echo "<td class=additional>Enter any additional comments you may wish to clarify your booking.</td>\r\n";

	

	echo "</tr>\r\n";



	

		

	echo "<tr><th>Estimated Fare</th>\r\n";



	$totalfare = 0;

	

	if ($drow)

	{	

		echo "<td class=departure>";

		echo "<div style='background: #cfc url(images/gbl.gif) no-repeat bottom left;'>";

		echo "<div style='background: transparent url(images/gbr.gif) no-repeat bottom right;'>";

		echo "<div style='padding-bottom: 10px;'><input type=text name=fee[0] id=fee0 value='\${$drow->bfare}' readonly><img id=feeloader0 src='loader.gif' style='visibility: hidden'></div>";

		$totalfare += $drow->bfare;

		echo "</div>";

		echo "</div>";

		echo "</td>\r\n";

	}

	if ($arow)

	{	

		echo "<td class=arrival>";

		echo "<div style='background: #ccf url(images/bbl.gif) no-repeat bottom left;'>";

		echo "<div style='background: transparent url(images/bbr.gif) no-repeat bottom right;'>";

		echo "<div style='padding-bottom: 10px;'><input type=text name=fee[1] id=fee1 value='\${$arow->bfare}' readonly><img id=feeloader1 src='loader.gif' style='visibility: hidden'></div>";

		$totalfare += $arow->bfare;

		echo "</div>";

		echo "</div>";

		echo "</td>\r\n";

	}

	

	

	echo "</tr>\r\n";

	

	

	echo "</table>\r\n";

//	egroupbox();

	

	

	echo "<h3>Fare Details</h3>\r\n";

	

//	groupbox('Fare Details');

	

	echo "<table class=booking>\r\n";

	

	echo "<tr><th style='width: 8em;'>Total Estimated Fare</th>\r\n";

	echo "<td><input type=text name=fee id=fee readonly value='\${$totalfare}'><img id=feeloader src='loader.gif' style='visibility: hidden'></td>\r\n";

	echo "<td>Note: there may be additional charges for early and late transfers and for excess luggage. 

		Refer to our <a href='services.tos.html'>Terms of Service</a> for details.

		If you are unsure of any of these additional charges or if you require any further information then please contact us at the phone number at the top 

		of the page.

		</td>\r\n";

	echo "</tr>\r\n";

	

	

	echo "</table>\r\n";

//	egroupbox();



}





function getbooking($dir)

{

	$row = null;

	$row->id = $_SESSION['bid'][$dir];

	$row->cid = $_SESSION['thisclient'];

	$row->btype = $_SESSION['btype'];

	

	$row->btime = sanitize($_POST['time'][$dir]);

	

	$ft = '';

	

	if ($_SESSION['btype'] == 'AP')

	{

		$row->bflight = sanitize($_POST['flight'][$dir]);

	

		$frow = hs_read_row_sql("select dest0, dest1 from flight where id = '{$row->bflight}'");

	

		if ($frow)

		{

			$row->bdest = $frow->dest0;

			if ($frow->dest1)

				$row->bdest .= ', ' . $frow->dest1;

		}

		else

			$row->bdest = '';

		

		

		$row->bairline = sanitize($_POST['airline'][$dir]);

		if (isset($_POST['terminal'][$dir]))

			$row->bterminal = sanitize($_POST['terminal'][$dir]);

		else 

			$row->bterminal = '';

		$row->bftime = sanitize($_POST['ftime'][$dir]);

		$ft = $row->bftime;

		

	}

	

	

	

	if ($dir == 0)

		$row->bdirection = 'D';

	else

		$row->bdirection = 'A';

	

	$row->bdate = 0;

	$date = new DateTime("@0");

	$sdate = explode('/',sanitize($_POST['date'][$dir]));

	if (isset($sdate[2]))

	{

		$date->setDate($sdate[2],$sdate[1],$sdate[0]);

		$row->bdate = $date->format("U");

	}



	$row->btime = sanitize($_POST['time'][$dir]);

	if ($row->btime)

		$ft = $row->btime;



			

	$t = 0;	

	if (preg_match('/^([0-9]*):([0-9]*)(am|pm)$/',$ft,$m))

	{

		$t = 0;

		if ($m[3] == 'pm' && $m[1] != '12')

			$t += 12*60*60;

		$t += $m[1] * 60 * 60;

		$t += $m[2] * 60;

		

	}

	

	$row->bstime = $t;

		



	$row->bsuburb = sanitize($_POST['bsuburb'][$dir]);

	$row->baddress = sanitize($_POST['baddress'][$dir]);

	$row->bphone = sanitize($_POST['bphone'][$dir]);

	$row->bmobile = sanitize($_POST['bmobile'][$dir]);

	$row->bpax = sanitize($_POST['pax'][$dir]);

	$row->bbaby = sanitize($_POST['baby'][$dir]);

	$row->bcomments = sanitize($_POST['comments'][$dir]);

//	z($_POST['comments']);

//	z($row->bcomments);

	

	$srow = hs_read_row_sql("select * from suburb where suburb = '{$row->bsuburb}'");

	

	

	if ($srow)

	{

		$row->bfare = $srow->A_fee[$row->bpax-1];

		if ($row->bdirection  == 'A')

			$row->bfare += 5;

	}

	else

	{

		$row->bfare = 'Not found';

	}

	

	

	return $row;

}





function validatebooking($row,&$erow,&$wrow)

{

	

	if (!$row->bsuburb)

		$erow->bsuburb = 0;

	else

	{

		$s = hs_read_row_sql("select suburb from suburb where suburb = '{$row->bsuburb}'");

		if (!$s)

			$wrow->bsuburb = "suburb $row->bsuburb not found";

	}

		

	if (!$row->baddress)

		$erow->baddress = 0;

		

	if (!$row->bphone && !$row->bmobile)

	{

		$erow->bphone = 0;

		$erow->bmobile = 0;

	}

		

		

	if (!$row->bdate)

		$erow->bdate = 0;

		



	if ($row->btype == 'AP')

	{

	

		if (!$row->bflight)

			$erow->bflight = 0;

			

		if (!$row->bairline)

			$wrow->bairline = 0;

			

		if (!$row->bftime && !$row->btime)

			$erow->btime = 0;

	}

	else

	{

		if (!$row->btime)

			$erow->btime = 0;

	}

		

	

		

	if ($row->btime)

	{

		$e = "time $row->btime invalid format. Should be of the form, for example, 9:30am or 4:20pm";

		if (preg_match('/^([0-9]*):([0-9]*)(am|pm)$/',$row->btime,$m))

		{

			if ($m[1] < 1)

				$vrow ->btime = $e;

			if ($m[1] > 12)

				$vrow ->btime = $e;

				

			if ($m[2] < 0)

				$vrow ->btime = $e;

			if ($m[2] > 59)

				$vrow ->btime = $e;

		}

		else

			$erow->btime = $e;

	}

}







?>



