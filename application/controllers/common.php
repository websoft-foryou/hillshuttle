<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    $this->load->model('common_model');
                    $this->load->model('daysheet_model');
                    $this->load->model('booking_model');
               }
       
	public function index()
	{
            $this->load->helper('form');
            
            $book_data['book_row'][] = array('id'=>'',
                                            'client'=>'',
                                            'type'=>'',
                                            'dep_address1'=>'',
                                            'dep_address2'=>'',
                                            'dep_suburb'=>'',
                                            'dep_phone'=>'',
                                            'dep_mobile'=>'',
                                            'dep_date'=>'',
                                            'dep_flight'=>'',
                                            'dep_airline'=>'',
                                            'dep_origin'=>'',
                                            'dep_terminal'=>'',
                                            'dep_ourtime'=>'',
                                            'dep_yourtime'=>'',
                                            'dep_time'=>'',
                                            'dep_pickuptime'=>'',
                                            'dep_bus'=>'',
                                            'dep_passengers'=>'',
                                            'dep_babyseats'=>'',
                                            'dep_estfare'=>'',
                                            'dep_driver'=>'',
                                            'dep_comments'=>'',
                                            'arr_suburb'=>'',
                                            'arr_address1'=>'',
                                            'arr_address2'=>'',
                                            'arr_phone'=>'',
                                            'arr_mobile'=>'',
                                            'arr_date'=>'',
                                            'arr_flight'=>'',
                                            'arr_airline'=>'',
                                            'arr_origin'=>'',
                                            'arr_terminal'=>'',
                                            'arr_ourtime'=>'',
                                            'arr_yourtime'=>'',
                                            'arr_time'=>'',
                                            'arr_pickuptime'=>'',
                                            'arr_bus'=>'',
                                            'arr_passengers'=>'',
                                            'arr_babyseats'=>'',
                                            'arr_estfare'=>'',
                                            'arr_driver'=>'',
                                            'arr_comments'=>'',
                                            'total'=>'',
                                            'payment_method'=>'',
                                            'first_name'=>'',
                                            'last_name'=>'',
                                           );
            
            $book_data['getdriverval'] = $this->booking_model->getDriverdata();
            
            $book_data['formval'] = $_POST['frmval'];
            
            $book_data['type'] = $_POST['type'];
            
            $book_data['mid'] = $_POST['auto'];
            
            $this->load->view('common_tpl',$book_data);
	}
        
        function mail() {
            
            $val = $_POST['mail'];
            $ccid = $_POST['ccid'];
            
            $data = $this->common_model->mailValidate($val,$ccid);
            
            echo $data;
        }
        
        function client() {
            
            $val = $_POST['queryString'];
            
            $data = $this->common_model->clientAutosuggest($val);
            
            echo $data;
        }

        function clientgrid() {
            
            $val = $_POST['queryString'];
            
            $auto_id = $_POST['auto'];
            
            $data = $this->common_model->clientAutosuggestgrid($val,$auto_id);
            
            echo $data;
        }

        function drivergrid() {
            
            $val = $_POST['queryString'];
            
            $auto_id = $_POST['auto'];
            
            $data = $this->common_model->driverAutosuggestgrid($val,$auto_id);
            
            echo $data;
        }
        
        function clidetails() {
            
            $val = $_POST['client'];
            
            $data = $this->common_model->clientDetails($val);
            
            echo $data;
        }

        function driver() {
            
            $val = $_POST['queryString'];
            
            $data = $this->common_model->driverAutosuggest($val);
            
            echo $data;
        }

        function daysheet() {
            
            $this->load->helper('form');
            
            $depdir = $_POST['depdir'];
            $arrdir = $_POST['arrdir'];
            
            $depdri = $_POST['depdri'];
            $arrdri = $_POST['arrdri'];
            
            $uid = $_POST['uid'];
            
            $sdate = $_POST['sdate'];
            
            $type = $_POST['type'];
            
            $data = $this->common_model->daysheetSave($depdir,$arrdir,$depdri,$arrdri,$uid,$sdate,$type);
            
            echo $data;
        }
        
        function alldrivers() {
             
           echo $data = $this->booking_model->getAlldriver();
        }
        
        function clidel() {
            $clival = $_POST['clival'];
            echo $data = $this->common_model->getClidel($clival);
        }
        
        // popup pickup address save
        function savepickup() {
            
          $book_type = $_POST['btype'];
          $pdestination = $_POST['dest'];
          
          $data = $this->common_model->savePickup();
          
          $popdata['pickup'] = $this->common_model->showPickup($data,'dep',$book_type,$pdestination);
          
          $this->load->view('popup_pickup_tpl',$popdata);
        }

        function savedropoff() {
            
          $book_type = $_POST['btype'];
          $pdestination = $_POST['dest'];
            
          $data = $this->common_model->savePickup();
          
          $dropdata['dropoff'] = $this->common_model->showPickup($data,'arr',$book_type,$pdestination);
          
          $this->load->view('popup_dropoff_tpl',$dropdata);
        }
        
        function delpickup() {
            $aid = $_POST['id'];
            $bid = $_POST['book'];
            $dir = $_POST['dir'];
            $type = $_POST['type'];
            $destination = $_POST['dest'];
            
          $data = $this->common_model->delPickup($aid,$dir,$type,$destination);
          
          $popdata['pickup'] = $this->common_model->showPickup($bid,$dir,$type,$destination);
          
          $this->load->view('popup_pickup_tpl',$popdata);
        }

        function popclient() {
            
            $val = $_POST['queryString'];
            
            $data = $this->common_model->popupClient($val);
            
            echo $data;
        }
        
        function clientval() {
            $fval = $_POST['fval'];
            $lval = $_POST['lval'];
            $ccid = $_POST['ccid'];
            $add = $_POST['add'];
            $mail = $_POST['mail'];
            $suburb = $_POST['suburb'];
            
            $data = $this->common_model->clientValidate($fval,$lval,$ccid,$add,$mail,$suburb);
            
            echo $data;
            
        }
        
        function userduplicate() {
            $fval = $_POST['fval'];
            $lval = $_POST['lval'];
            $ccid = $_POST['ccid'];
            
            $data = $this->common_model->userValidate($fval,$lval,$ccid);
            
            echo $data;
            
        }

        function driverduplicate() {
            $fval = $_POST['fval'];
            $lval = $_POST['lval'];
            $ccid = $_POST['ccid'];
            
            $data = $this->common_model->driverValidate($fval,$lval,$ccid);
            
            echo $data;
            
        }

        function dsviewcomment() {
            $aid = $_POST['aid'];
            $dir = $_POST['dir'];
            $flag = $_POST['flag'];
            $mid = $_POST['mid'];
            
            $data = $this->common_model->getComments($aid,$dir,$flag,$mid);
            
            echo $data;
        }

        function dssavecomment() {
            $cmd = $_POST['cmd'];
            $auto = $_POST['cmauto'];
            $dir = $_POST['dir'];
            $flag = $_POST['cmtflag'];
            $mid = $_POST['mid'];
            
            $data = $this->common_model->savedsComments($cmd,$auto,$dir,$flag,$mid);
            
            echo $data;
        }

        function cliname() {
            $cid = $_POST['cid'];
            
            $data = $this->common_model->getClientname($cid);
            
            echo $data;
        }

        function autoclientval() {
            $cval = $_POST['queryString'];
            $csub = substr($_POST['suburb'],0,-1);
            
            $data = $this->common_model->clientLogid($cval,$csub);
            
            echo $data;
        }

        function cancelbook() {
            $bookid = $_POST['cid'];
            $canval = $_POST['pdir'];
            $dir = $_POST['dir'];
            $hcval = $_POST['cval'];
            $cmail = $_POST['cmail'];
            $mode = $_POST['mode'];
            
            $data = $this->common_model->cancelBook($bookid,$canval,$dir,$hcval,$cmail,$mode);
            
            echo $data;
        }
        
        function daysheetpopup() {
            
            $book = @explode(',',$_POST['ids']);
            $book_data['bookids'] = @array_unique($book);

            
            $this->load->view('daysheet_mailconfirm_tpl',$book_data);
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */