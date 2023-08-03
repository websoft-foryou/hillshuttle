<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driverreport extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    
                     $this->load->model('driverreport_model');
                     
                     $this->load->model('booking_model');
                     
                     $this->load->model('common_model');

               }
    
	public function index()
	{
            $this->load->helper('form');
            
            $title = array('title'=>'Driver Report');
            
            $searchval = array('driver'=>'','terminal'=>'','suburb'=>'','suburbval'=>'','direction'=>'','drivassign'=>'','alldrivers'=>'','alldriversval'=>'','fdate'=>'','todate'=>'','fdbdate'=>'','todbdate'=>'');
            
            $this->session->unset_userdata($searchval);
            
            $data['result_data'] = $this->driverreport_model->emptyData();
            
            $data['getdriverval'] = $this->booking_model->getDriverdata();
            
            $data['page_links'] = '';
            
            $data['export_data'] = '';
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('driverreport_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

        function search() {
            
            $this->load->helper('form');
            
            $title = array('title'=>'Driver Report');
            
            $data['result_data'] = $this->driverreport_model->search();
            
            //$data['export_data'] = $this->driverreport_model->getNumRows();
            
            $data['getdriverval'] = $this->booking_model->getDriverdata();
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('driverreport_tpl',$data);
                
            $this->load->view('footer_tpl');
            
          //  print_r($data[0]['id']); exit;
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */