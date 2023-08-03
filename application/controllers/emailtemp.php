<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailtemp extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('emailtemp_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Email template');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('email_searchtxt');
            
                $this->session->unset_userdata('email_searchfld');
                
                redirect('emailtemp');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('email_searchtxt');
            
                $this->session->unset_userdata('email_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post) {
            
                $search_sess = array('email_searchtxt'=>$search_post,'email_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('email_searchtxt');
            
            $search_fld = $this->session->userdata('email_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? 'id' : $order_field;
                
		$order_by = ($order_by=='')? 'ASC' : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/emailtemp/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('email_searchtxt')) {
                
                $data['users_data'] = $this->emailtemp_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->emailtemp_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['users_data'] = $this->emailtemp_model->getTempdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->emailtemp_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('emailtemp_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

/*	function add()
	{
             
            $title = array('title'=>'Add Email template');
            
            //Ckeditor's configuration
            $this->load->helper('url'); //You should autoload this one ;)
            $this->load->helper('ckeditor');
            
            $ckeditor = array(
                //ID of the textarea that will be replaced
                'id'    =>   'etemp',  // Must match the textarea's id
                'path'  =>   'application/plugins/ckeditor',  // Path to the ckeditor folder relative to index.php
                //Optionnal values
                'config' => array(
                    'toolbar'   =>   "Full",     //Using the Full toolbar
                    'width'     =>   "600px",    //Setting a custom width
                    'height'    =>   '350px',    //Setting a custom height
                ),
                //Replacing styles from the "Styles tool"
                'styles' => array(
                    //Creating a new style named "style 1"
                    'style 1' => array (
                        'name'      =>   'Blue Title',
                        'element'   =>   'h2',
                        'styles' => array(
                            'color'         =>   'Blue',
                            'font-weight'       =>   'bold'
                        )
                    ),
                    //Creating a new style named "style 2"
                    'style 2' => array (
                        'name'      =>   'Red Title',
                        'element'   =>   'h2',
                        'styles' => array(
                            'color'         =>   'Red',
                            'font-weight'       =>   'bold',
                            'text-decoration'   =>   'underline'
                        )
                    )
                ) 
            );
            //Ckeditor's configuration end
            
            $data = $this->input->post('userinfo');
            
            $user_data['user_row'][] = array('id'=>'',
                                            'type'=>'',
                                            'direction'=>'',
                                            'subject'=>'',
                                            'email'=>'',
                                            'content'=>''
                                           );
            
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['content'] = $_POST['etemp'];
                
                $data['created_by'] = $this->session->userdata('sess_username');
                
                $data['created_date'] = $today_date;
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $data['new_user'] = $this->emailtemp_model->addTemp($data);
                
                redirect('emailtemp');
                
            }
            
            $user_data['view_ckeditor'] =  display_ckeditor($ckeditor);
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_emailtemp_tpl',$user_data);
                
            $this->load->view('footer_tpl');
            
        } */
        
        function edit($id) {
            
                $title = array('title'=>'Edit email template');
            
            //Ckeditor's configuration
            $this->load->helper('url'); //You should autoload this one ;)
            $this->load->helper('ckeditor');
            
            $ckeditor = array(
                //ID of the textarea that will be replaced
                'id'    =>   'etemp',  // Must match the textarea's id
                'path'  =>   'application/plugins/ckeditor',  // Path to the ckeditor folder relative to index.php
                //Optionnal values
                'config' => array(
                    'toolbar'   =>   "Full",     //Using the Full toolbar
                    'width'     =>   "600px",    //Setting a custom width
                    'height'    =>   '350px',    //Setting a custom height
                ),
                //Replacing styles from the "Styles tool"
                'styles' => array(
                    //Creating a new style named "style 1"
                    'style 1' => array (
                        'name'      =>   'Blue Title',
                        'element'   =>   'h2',
                        'styles' => array(
                            'color'         =>   'Blue',
                            'font-weight'       =>   'bold'
                        )
                    ),
                    //Creating a new style named "style 2"
                    'style 2' => array (
                        'name'      =>   'Red Title',
                        'element'   =>   'h2',
                        'styles' => array(
                            'color'         =>   'Red',
                            'font-weight'       =>   'bold',
                            'text-decoration'   =>   'underline'
                        )
                    )
                ) 
            );
            //Ckeditor's configuration end
                
                $data = $this->input->post('userinfo');
                
                $update_id = $this->input->post('user_id');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');
                    
                    $data['content'] = $_POST['etemp'];

                    $data['updated_by'] = $this->session->userdata('sess_username');
                    
                    $data['updated_date'] = $today_date;

                    $data['edit_user'] = $this->emailtemp_model->editTemp($data,$update_id);

                    redirect('emailtemp');

                }   
                
                $user_data['user_row'] = $this->emailtemp_model->getTempdata($id,0,1,0,0);
                
                $user_data['view_ckeditor'] =  display_ckeditor($ckeditor);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_emailtemp_tpl',$user_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        function delete($id) {
            
            $this->emailtemp_model->delete($id);
            
            redirect('emailtemp');
        }
        
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */