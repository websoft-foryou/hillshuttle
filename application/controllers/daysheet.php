<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daysheet extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    
                     $this->load->model('daysheet_model');
                     
                     $this->load->model('booking_model');
                     
                     $this->load->model('common_model');

               }
    
	/* public function index()
	{
            $title = array('title'=>'Daysheet');
            
            $searchval = array('fdate'=>'','todate'=>'','fdbdate'=>'','todbdate'=>'');
            
            $this->session->unset_userdata($searchval);
            
            $data['result_data'] = $this->daysheet_model->emptyData();
           
            $data['page_links'] = '';
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('daysheet_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	} */
        function index() {
            
            $this->load->helper('form');
            
            $title = array('title'=>'Daysheet');
            
            $searchval = array('fdate'=>'','todate'=>'','fdbdate'=>'','todbdate'=>'','showdate'=>'');
            
            $this->session->unset_userdata($searchval);
            
            $data['result_data'] = $this->daysheet_model->search();
           
            $data['getdriverval'] = $this->daysheet_model->daysheetDriverdata();
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('daysheet_tpl',$data);
                
            $this->load->view('footer_tpl');
            
        }

        function search() {
            
            $this->load->helper('form');
            
            $title = array('title'=>'Daysheet');
            
            $data['result_data'] = $this->daysheet_model->search();
           
            $data['getdriverval'] = $this->daysheet_model->daysheetDriverdata();
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('daysheet_tpl',$data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function save($id) {
            
            $title = array('title'=>'Daysheet');
            
            $data['result_data'] = $this->daysheet_model->save($id);
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('daysheet_tpl',$data);
                
            $this->load->view('footer_tpl');
            
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */