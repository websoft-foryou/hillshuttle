<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('flight_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Flight');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('flight_searchtxt');
            
                $this->session->unset_userdata('flight_searchfld');
                
                redirect('flight');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('flight_searchtxt');
            
                $this->session->unset_userdata('flight_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post) {
            
                $search_sess = array('flight_searchtxt'=>$search_post,'flight_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('flight_searchtxt');
            
            $search_fld = $this->session->userdata('flight_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? 'id' : $order_field;
                
		$order_by = ($order_by=='')? 'ASC' : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/flight/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('flight_searchtxt')) {
                
                $data['users_data'] = $this->flight_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->flight_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['users_data'] = $this->flight_model->getFlightdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->flight_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('flight_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
                
            $title = array('title'=>'Add Flight');
            
            $data = $this->input->post('flight');
            
            $init = new stdClass;
            
            $init->id = "";
            $init->airline = "";
            $init->terminal = "";
            $init->direction = "";
            $init->terminal = "";
            $init->A_time = array('0'=>'','1'=>'','2'=>'','3'=>'','4'=>'','5'=>'','6'=>'');
            $user_data['sub_row'] = $init;  
        
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['created_date'] = $today_date;
                
                $data['updated_date'] = $today_date;
                
                $data['new_flight'] = $this->flight_model->addFlight();
                
                redirect('flight');
                
            }
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_flight_tpl',$user_data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function edit($id) {
            
                $title = array('title'=>'Edit Flight');
            
                $data = $this->input->post('flight');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');

                    $data['updated_date'] = $today_date;

                    $data['edit_flight'] = $this->flight_model->editFlight();

                    redirect('flight');

                }   
                
                $user_data['flight_row'] = $this->flight_model->getEditRows($id,0,1,0,0);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_flight_tpl',$user_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        function delete($id) {
            
            $this->flight_model->delete($id);
            
            redirect('flight');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */