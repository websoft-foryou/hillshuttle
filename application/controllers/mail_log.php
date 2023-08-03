<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_log extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    if($this->session->userdata('sess_type')==2) show_404();
                     $this->load->model('mail_log_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Mail Log');
            
            if($reset=='reset') {
                
                $this->session->unset_userdata('mail_searchtxt');
            
                $this->session->unset_userdata('mail_searchfld');
                
                redirect('mail_log');
                
            }
            else if($this->uri->total_segments()==1) {
                
                $this->session->unset_userdata('mail_searchtxt');
            
                $this->session->unset_userdata('mail_searchfld');
                
            }
            
            $search_post = $this->input->post('search_txt');
            
            $search_fldpost = $this->input->post('search_fld');
            
            if($search_post!='') {
            
                $search_sess = array('mail_searchtxt'=>$search_post,'mail_searchfld'=>$search_fldpost);
                
                $this->session->set_userdata($search_sess);
                
            }
            
            $search = $this->session->userdata('mail_searchtxt');
            
            $search_fld = $this->session->userdata('mail_searchfld');
            
            // paging config
                $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? 'id' : $order_field;
                
		$order_by = ($order_by=='')? 'DESC' : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/mail_log/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
            
            if($search!='' || $this->session->userdata('mail_searchtxt')) {
                
                $data['mail_data'] = $this->mail_log_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->mail_log_model->getNumRows($search,$search_fld);
                
            }
            
           else { 
               
                $data['mail_data'] = $this->mail_log_model->getTempdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 

                $paging_config['total_rows'] = $this->mail_log_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
           
            $this->load->view('header_tpl',$title);
                
            $this->load->view('mail_log_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */