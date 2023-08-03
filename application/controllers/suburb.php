<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suburb extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('suburb_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Suburb');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('sub_searchtxt');
            
                $this->session->unset_userdata('sub_searchfld');
                
                redirect('suburb');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('sub_searchtxt');
            
                $this->session->unset_userdata('sub_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post) {
            
                $search_sess = array('sub_searchtxt'=>$search_post,'sub_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('sub_searchtxt');
            
            $search_fld = $this->session->userdata('sub_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? 'id' : $order_field;
                
		$order_by = ($order_by=='')? 'ASC' : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/suburb/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('sub_searchtxt')) {
                
                $data['users_data'] = $this->suburb_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->suburb_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['users_data'] = $this->suburb_model->getSuburbdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->suburb_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('suburb_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
                
            $title = array('title'=>'Add Suburb');
            
            $data = $this->input->post('suburb');
            
            $init = new stdClass;
            
            $init->id = "";
            $init->postcode = "";
            $init->suburb = "";
            $init->A_fee = array('0'=>'','1'=>'','2'=>'','3'=>'','4'=>'','5'=>'','6'=>'','7'=>'','8'=>'','9'=>'','10'=>'',);
            $user_data['sub_row'] = $init;  
        
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['created_date'] = $today_date;
                
                $data['updated_date'] = $today_date;
                
                $data['new_suburb'] = $this->suburb_model->addSuburb();
                
                redirect('suburb');
                
            }
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_suburb_tpl',$user_data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function edit($id) {
            
                $title = array('title'=>'Edit Suburb');
            
                $data = $this->input->post('suburb');
                
                $update_id = $this->input->post('suburb_id');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');

                    $data['updated_date'] = $today_date;

                    $data['edit_suburb'] = $this->suburb_model->editSuburb($update_id);

                    redirect('suburb');

                }   
                
                $user_data['suburb_row'] = $this->suburb_model->getEditRows($id,0,1,0,0);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_suburb_tpl',$user_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        function delete($id) {
            
            $this->suburb_model->delete($id);
            
            redirect('suburb');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */