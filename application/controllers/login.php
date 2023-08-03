<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if($this->authentication->is_logged_in()) { redirect('users'); }
                    
                     $this->load->model('login_model');

               }
       
	public function index()
	{
            $title = array('title'=>'Login');
            
            $logindata = $this->input->post('loginfo');
            
            if(!empty($logindata)) {
            
                $login_val = $this->login_model->authenticateUser($logindata);
                
                if(count($login_val)>0) {
                    
                    // session create
                    $sess_data = array('sess_username'=>$login_val[0]->username,'sess_userid'=>$login_val[0]->id,'sess_fname'=>$login_val[0]->first_name,'sess_lname'=>$login_val[0]->last_name,'sess_type'=>$login_val[0]->type);
                    
                    $this->session->set_userdata($sess_data);
                            
                    if($this->session->userdata('sess_type')==1) redirect('booking');
                    else redirect('booking');
                    
                }
                
                else {
                    $title = array('title'=>'Login','logerror'=>'Invalid Username / Password');
                    
                }
                
            }
            
            $this->load->view('login_header_tpl',$title);
                
            $this->load->view('login_tpl');
                
            $this->load->view('footer_tpl');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */