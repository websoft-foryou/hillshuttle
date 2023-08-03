<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drivers extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('driver_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Drivers');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('driv_searchtxt');
            
                $this->session->unset_userdata('driv_searchfld');
                
                redirect('drivers');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('driv_searchtxt');
            
                $this->session->unset_userdata('driv_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post) {
            
                $search_sess = array('driv_searchtxt'=>$search_post,'driv_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('driv_searchtxt');
            
            $search_fld = $this->session->userdata('driv_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? $default_paging_filed_config['def_order_fld'] : $order_field;
                
		$order_by = ($order_by=='')? $default_paging_filed_config['orderby_fld_val'] : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/drivers/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('driv_searchtxt')) {
                
                $data['drivers_data'] = $this->driver_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->driver_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['drivers_data'] = $this->driver_model->getDriversdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->driver_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('drivers_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
                
            $title = array('title'=>'Add Driver');
            
            $data = $this->input->post('driverinfo');
            
            $driver_data['driver_row'][] = array('id'=>'',
                                            'first_name'=>'',
                                            'last_name'=>'',
                                            'gender'=>'',
                                            'dob'=>'',
                                            'street'=>'',
                                            'suburb'=>'',
                                            'state'=>'',
                                            'phone'=>'',
                                            'mobile'=>'',
                                            'email'=>'',
                                            'comments'=>'',
                                            'status'=>''
                                           );
            
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['created_by'] = $this->session->userdata('sess_username');
                
                $data['created_date'] = $today_date;
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $data['new_driver'] = $this->driver_model->addDriver($data);
                
                redirect('drivers');
                
            }
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_driver_tpl',$driver_data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function edit($id) {
            
                $title = array('title'=>'Edit Driver');
            
                $data = $this->input->post('driverinfo');
                
                $update_id = $this->input->post('driver_id');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');

                    $data['updated_by'] = $this->session->userdata('sess_username');
                    
                    $data['updated_date'] = $today_date;

                    $data['edit_driver'] = $this->driver_model->editDriver($data,$update_id);

                    redirect('drivers');

                }   
                
                $driver_data['driver_row'] = $this->driver_model->getDriversdata($id,0,1,0,0);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_driver_tpl',$driver_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        function delete($id) {
            
            $this->driver_model->delete($id);
            
            redirect('drivers');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */