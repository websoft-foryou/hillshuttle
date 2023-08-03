<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('user_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Users');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('user_searchtxt');
            
                $this->session->unset_userdata('user_searchfld');
                
                redirect('users');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('user_searchtxt');
            
                $this->session->unset_userdata('user_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post) {
            
                $search_sess = array('user_searchtxt'=>$search_post,'user_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('user_searchtxt');
            
            $search_fld = $this->session->userdata('user_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? 'id' : $order_field;
                
		$order_by = ($order_by=='')? 'ASC' : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/users/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('user_searchtxt')) {
                
                $data['users_data'] = $this->user_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->user_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['users_data'] = $this->user_model->getUsersdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->user_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('users_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
                
            $title = array('title'=>'Add User');
            
            $data = $this->input->post('userinfo');
            
            $user_data['user_row'][] = array('id'=>'',
                                            'first_name'=>'',
                                            'last_name'=>'',
                                            'username'=>'',
                                            'password'=>'',
                                            'type'=>'',
                                            'status'=>''
                                           );
            
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['created_by'] = $this->session->userdata('sess_username');
                
                $data['created_date'] = $today_date;
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $data['new_user'] = $this->user_model->addUser($data);
                
                redirect('users');
                
            }
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_user_tpl',$user_data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function edit($id) {
            
                $title = array('title'=>'Edit User');
            
                $data = $this->input->post('userinfo');
                
                $update_id = $this->input->post('user_id');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');

                    $data['updated_by'] = $this->session->userdata('sess_username');
                    
                    $data['updated_date'] = $today_date;

                    $data['edit_user'] = $this->user_model->editUser($data,$update_id);

                    redirect('users');

                }   
                
                $user_data['user_row'] = $this->user_model->getUsersdata($id,0,1,0,0);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_user_tpl',$user_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        function delete($id) {
            
            $this->user_model->delete($id);
            
            redirect('users');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */