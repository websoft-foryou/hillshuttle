<?php
class Suburb_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getSuburbdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from suburb order by suburb limit ".$offset.",".$limit."");
                    return $rows;
	}
        
        function getNumRows($txt,$fld) {
            
         //   $txt = ucfirst($txt);
            if($fld!='suburb' && $txt!='') $where = "WHERE ".$fld."='".$txt."'";
            else if($fld=='suburb' && $txt!='') $where = "WHERE ".$fld." like '".$txt."'";
            else $where = "WHERE 1=1";
            
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from suburb ".$where." order by suburb");
                    return count($rows);
            
        }
        
        function getEditRows($id) {

                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from suburb WHERE id='".$id."'");
                    return $rows;
            
        }

	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{

          //  $txt = ucfirst($txt);
            if($fld!='suburb' && $txt!='') $where = "WHERE ".$fld."='".$txt."'";
            else if($fld=='suburb' && $txt!='') $where = "WHERE ".$fld." like '".$txt."%'";
            else $where = "WHERE 1=1";
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT * from suburb ".$where);
            return $rows;
	}
        
        function addSuburb()
        {
            
	$row = null;

	$row->suburb = $_POST['suburb'];

	$row->postcode = $_POST['postcode'];

	$row->A_fee[0] = $_POST['f0'];

	$row->A_fee[1] = $_POST['f1'];

	$row->A_fee[2] = $_POST['f2'];

	$row->A_fee[3] = $_POST['f3'];

	$row->A_fee[4] = $_POST['f4'];

	$row->A_fee[5] = $_POST['f5'];

	$row->A_fee[6] = $_POST['f6'];

	$row->A_fee[7] = $_POST['f7'];

	$row->A_fee[8] = $_POST['f8'];

	$row->A_fee[9] = $_POST['f9'];

	$row->A_fee[10] = $_POST['f10'];

        $this->hsdb->hs_open();
        $insert_row = $this->hsdb->hs_insert_row('suburb',$row);
            
        }
        
        function editSuburb($id)
        {
          // echo '<pre>';
	$row = null;

	$row->suburb = $_POST['suburb'];

	$row->postcode = $_POST['postcode'];

	$row->A_fee[0] = $_POST['f0'];

	$row->A_fee[1] = $_POST['f1'];

	$row->A_fee[2] = $_POST['f2'];

	$row->A_fee[3] = $_POST['f3'];

	$row->A_fee[4] = $_POST['f4'];

	$row->A_fee[5] = $_POST['f5'];

	$row->A_fee[6] = $_POST['f6'];

	$row->A_fee[7] = $_POST['f7'];

	$row->A_fee[8] = $_POST['f8'];

	$row->A_fee[9] = $_POST['f9'];

	$row->A_fee[10] = $_POST['f10'];
        
        $row->id = $id;
          
        $this->hsdb->hs_open();
        $this->hsdb->hs_write_row('suburb',$row);
        
        }
        
        function delete($id) {
            
                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("DELETE from suburb WHERE id='".$id."'");
            
        }
        
}
?>