<?php

function hs_open()
{
	global $hsdatabase;
	$hsdatabase = new PDO('sqlite:hillshut.db');
}

function hs_checkError($where,$table,$query)
{	
	global $hsdatabase;
	$err = $hsdatabase->errorInfo();
	if ($err[0] != '00000')
	{
		hs_error($where . ': ' . $table,$query,$err[2]); 
		echo '<pre style="background-color: yellow;">';
		echo '<code>';
		echo $where . "\r\n";
		echo htmlspecialchars($query) . "\r\n";
		echo $$err[2] . "\r\n";
		echo '</code>';
		trace();
		echo '</pre>' . "\r\n";
	}
}
	
function hs_error($where,$query,$info)
{
	echo '<pre style="background-color: yellow;">';
	echo '<code>';
	echo $where . "\r\n";
	echo htmlspecialchars($query) . "\r\n";
	echo $info . "\r\n";
	echo '</code>';
	trace();
	echo '</pre>' . "\r\n";
	
	exit;
}



function hs_read_rows_sql($query)
{
	global $hsdatabase;
		
	$rows = null;
	
	$st = $hsdatabase->query($query);
	hs_checkError('hs read rows sql','',$query);

	if ($st)
	{
		while($row = $st->fetchObject())
		{
			forEach($row as $k => $v)
			{
				if (substr($k,0,2) == 'A_')
					$row->$k = unserialize($v);
			}
			$rows[] = $row;
		}
	}
	return $rows;
}


function hs_read_row_sql($query)
{		
	global $hsdatabase;
	$row = null;
	$st = $hsdatabase->query($query);
	hs_checkError('read rows sql','',$query);
	if ($st)
	{
		$row = $st->fetchObject();
		if ($row)
		{
			forEach($row as $k => $v)
			{
				if (substr($k,0,2) == 'A_')
					$row->$k = unserialize($v);
			}
		}
	}
	return $row;
}

function hs_read_row($db,$id)
{		
	global $hsdatabase;
	$query = "SELECT * FROM $db WHERE id = '$id'";
	$row = null;
	$st = $hsdatabase->query($query);
	hs_checkError('read rows sql','',$query);
	if ($st)
	{
		$row = $st->fetchObject();
		if ($row)
		{
			forEach($row as $k => $v)
			{
				if (substr($k,0,2) == 'A_')
					$row->$k = unserialize($v);
			}
		}
	}
	return $row;
}

function hs_write_row($table,&$row)
{
	global $hsdatabase;
	$query = "UPDATE $table SET ";
	$first = true;
	foreach($row as $k => $v)
	{
		if ($k == 'id')
			continue;
		if ($first)
			$first = false;
		else
			$query .= ", "; 
			
		if (substr($k,0,2) == 'A_')
			$query .= "$k = '" . str_replace("'","''",serialize($v)) . "'";
		else
			$query .= "$k = '" . str_replace("'","''",$v) . "'";
//		if ($j < count($ar))
//			$query .= ", "; 
	}
	$query .= " WHERE id = '" . $row->id . "';";
	$hsdatabase->exec($query); // or db_error('write row:' . $table,$query); 
	hs_checkError('write row',$table,$query);
}



function hs_insert_row($table,$row)
{
	global $hsdatabase;
	$query = "INSERT INTO $table ( ";
	$vals = "";
	$first = true;
	foreach($row as $k => $v)
	{
		if ($first)
			$first = false;
		else
		{
			$query .= ", ";
			$vals .= ", ";
		}
		$query .= $k;
		if (substr($k,0,2) == 'A_')
			$vals .= "'" . str_replace("'","''",serialize($v)) . "'";
		else
			$vals .= "'" . str_replace("'","''",$v) . "'";
//		$vals .= "'" . str_replace("'","''",$v) . "'";
	}
	$query .= ") VALUES (" . $vals . ")";
	$hsdatabase->query($query);
	hs_checkError('read roww',$table,$query);
	return $hsdatabase->lastInsertId();
}


function hs_sql($query)
{
	global $hsdatabase;
//	z($database);
	$st = $hsdatabase->query($query);
	hs_checkError('sql','',$query);
}




?>
