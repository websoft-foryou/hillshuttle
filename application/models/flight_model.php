<?php
class Flight_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getFlightdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from flight order by id limit ".$offset.",".$limit."");
                    return $rows;
	}
        
        function getNumRows($txt,$fld) {
            
         //   $txt = ucfirst($txt);
            if($fld!='' && $txt!='') $where = "WHERE ".$fld." like '".$txt."%'";
            else $where = "WHERE 1=1";
            
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from flight ".$where." order by id");
                    return count($rows);
            
        }
        
        function getEditRows($id) {

                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from flight WHERE id='".$id."'");
                    return $rows;
            
        }

	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{

          //  $txt = ucfirst($txt);
            if($fld!='' && $txt!='') $where = "WHERE ".$fld." like '".$txt."%'";
            else $where = "WHERE 1=1";
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from flight ".$where." limit ".$offset.",".$limit);
            return $rows;
	}
        
        function addFlight()
        {
            
	$row = null;

	$row->id = $_POST['flight'];

	$row->airline = $_POST['airline'];

	$row->direction = $_POST['dir'];

	$row->terminal = $_POST['term'];

	$row->dest0 = $_POST['origin'];

	$row->A_time[0] = $_POST['sun'];
        
        $row->A_time[1] = $_POST['mon'];
        
        $row->A_time[2] = $_POST['tue'];
        
        $row->A_time[3] = $_POST['wed'];

	$row->A_time[4] = $_POST['thu'];

	$row->A_time[5] = $_POST['fri'];

	$row->A_time[6] = $_POST['sat'];


        $this->hsdb->hs_open();
        $insert_row = $this->hsdb->hs_insert_row('flight',$row);
            
        }
        
        function editFlight()
        {
          // echo '<pre>';
	$row = null;

	$row->id = $_POST['flight'];

	$row->airline = $_POST['airline'];

	$row->direction = $_POST['dir'];

	$row->terminal = $_POST['term'];

	$row->dest0 = $_POST['origin'];

	$row->A_time[0] = $_POST['sun'];
        
        $row->A_time[1] = $_POST['mon'];
        
        $row->A_time[2] = $_POST['tue'];
        
        $row->A_time[3] = $_POST['wed'];

	$row->A_time[4] = $_POST['thu'];

	$row->A_time[5] = $_POST['fri'];

	$row->A_time[6] = $_POST['sat'];
        
        $this->hsdb->hs_open();
        $this->hsdb->hs_write_row('flight',$row);
        
        }
        
        function delete($id) {
            
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("DELETE from flight WHERE id='".$id."'");
            
        }
        
}
?>