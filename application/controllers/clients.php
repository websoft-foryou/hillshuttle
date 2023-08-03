<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    
                     $this->load->model('client_model');
                     
                     $this->load->model('common_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Clients');
            
		if($reset=='reset') {
            
                    $this->session->unset_userdata('client_searchtxt');
            
                    $this->session->unset_userdata('client_searchfld');
                    
                    redirect('clients');
                }
                else if($this->uri->total_segments()==1) {

                    $this->session->unset_userdata('client_searchtxt');

                    $this->session->unset_userdata('client_searchfld');

                }
                
                $search_post = $this->input->post('search_txt');
                
                $search_fldpost = $this->input->post('search_fld');

                if($search_post) {

                    $search_sess = array('client_searchtxt'=>$search_post,'client_searchfld'=>$search_fldpost);

                    $this->session->set_userdata($search_sess);

                }

                $search = $this->session->userdata('client_searchtxt');

                $search_fld = $this->session->userdata('client_searchfld');
                
            // paging config
            $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = ($order_field=='')? $default_paging_filed_config['def_order_fld'] : $order_field;
                
		$order_by = ($order_by=='')? $default_paging_filed_config['orderby_fld_val'] : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/clients/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
                
            if($search!='' || $this->session->userdata('client_searchtxt')) {
                
                $data['clients_data'] = $this->client_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->client_model->getNumRows($search,$search_fld);
            }
            
           else { 
               
               $data['clients_data'] = $this->client_model->getClientsdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 
               
               $paging_config['total_rows'] = $this->client_model->getNumRows(0,0);
               
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
               
            $this->load->view('header_tpl',$title);
                
            $this->load->view('clients_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
                
            $title = array('title'=>'Add Client');
            
            if($_POST['mode']) $mode = $_POST['mode'];
            
            if($_POST['bktype']) $bktype = $_POST['bktype'];
            
            if($_POST['dir']) $redir = $_POST['dir'];
            
            $data = $this->input->post('clientinfo');
            //print_r($data); exit;
            if($redir=='client') { // from booking form
              
            $client_data['client_row'][] = array('id'=>'',
                                            'first_name'=>$_POST['fval'],
                                            'last_name'=>$_POST['lval'],
                                            'gender'=>$_POST['gendval'],
                                            'dob'=>'',
                                            'address1'=>$_POST['streetval'],
                                            'address2'=>$_POST['address2'],
                                            'suburb'=>$_POST['suburbval'],
                                            'state'=>'',
                                            'phone'=>$_POST['phoneval'],
                                            'mobile'=>$_POST['mobileval'],
                                            'email'=>$_POST['emailval'],
                                            'comments'=>$_POST['cmtval'],
                                            'bkform'=>$mode,
                                           );
                
            }
            else {
            $client_data['client_row'][] = array('id'=>'',
                                            'first_name'=>'',
                                            'last_name'=>'',
                                            'gender'=>'',
                                            'dob'=>'',
                                            'address1'=>'',
                                            'address2'=>'',
                                            'suburb'=>'',
                                            'state'=>'',
                                            'phone'=>'',
                                            'mobile'=>'',
                                            'email'=>'',
                                            'comments'=>'',
                                            'bkform'=>$mode,
                                           );
            }
            
            if(!empty ($data)) {
                
                $today_date = strtotime('Today');
                
                $data['first_name'] = ucfirst($data['first_name']);
                
                $data['last_name'] = ucfirst($data['last_name']);
                
                $data['created_by'] = $this->session->userdata('sess_username');
                
                $data['created_date'] = $today_date;
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $cli_id = $this->client_model->addClient($data);
                
                    // redirect to booking module
                    $rebkurl = 'booking/add/?cid='.$cli_id;
                    if($this->input->post('redirect')=='booking') redirect($rebkurl);
                    else redirect('clients');
            }
            
            if($bktype=='bkaddclient') { // from booking form
             
                $today_date = strtotime('Today');
                
                $data['first_name'] = ucfirst($_POST['fval']);
                
                $data['last_name'] = ucfirst($_POST['lval']);
                
                $data['address1'] = $_POST['streetval'];
                
                $data['address2'] = $_POST['address2'];
                
                $data['gender'] = $_POST['gendval'];
                
                $data['suburb'] = $_POST['suburbval'];
                
                $data['phone'] = $_POST['phoneval'];
                
                $data['mobile'] = $_POST['mobileval'];
                
                $data['email'] = $_POST['emailval'];
                
                $data['comments'] = $_POST['cmtval'];
                
                $data['created_by'] = $this->session->userdata('sess_username');
                
                $data['created_date'] = $today_date;
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $cli_id = $this->client_model->addClient($data);
                
                echo $cli_id;
                exit;
            }
            
            if(empty($mode)) $this->load->view('header_tpl',$title);
                
            $this->load->view('new_client_tpl',$client_data);
                
            if(empty($mode)) $this->load->view('footer_tpl');
            
        }
        
        function edit($id=0) {
            

                $title = array('title'=>'Edit Client');
            
                $data = $this->input->post('clientinfo');
                
                $update_id = $this->input->post('cli_id');
                
                $bktype = '';
                if(isset($_POST['bktype'])) $bktype = $_POST['bktype'];
                
                if(!empty ($data)) {

                    $today_date = strtotime('Today');

                    $data['first_name'] = ucfirst($data['first_name']);
                    $data['last_name'] = ucfirst($data['last_name']);
                    
                    $data['updated_by'] = $this->session->userdata('sess_username');
                    
                    $data['updated_date'] = $today_date;

                    $data['edit_client'] = $this->client_model->editClient($data,$update_id);

                    // redirect to booking module
                    $rebkurl = 'booking/add/?cid='.$update_id;
                    if($this->input->post('redirect')=='booking') redirect($rebkurl);
                    else redirect('clients');

                }   
                
            if($bktype=='bkaddclient') { // from booking form
             
                $today_date = strtotime('Today');
                
                $data['first_name'] = ucfirst($_POST['fval']);
                
                $data['last_name'] = ucfirst($_POST['lval']);
                
                $data['address1'] = $_POST['streetval'];
                
                $data['address2'] = $_POST['address2'];
                
                $data['gender'] = $_POST['gendval'];
                
                $data['suburb'] = $_POST['suburbval'];
                
                $data['phone'] = $_POST['phoneval'];
                
                $data['mobile'] = $_POST['mobileval'];
                
                $data['email'] = $_POST['emailval'];
                
                $data['comments'] = $_POST['cmtval'];
                
                $data['updated_by'] = $this->session->userdata('sess_username');
                
                $data['updated_date'] = $today_date;
                
                $update_id = $_POST['cid'];
                
                $data['edit_client'] = $this->client_model->editClient($data,$update_id);
                
                echo $update_id;
                exit;
            }
                
                $client_data['client_row'] = $this->client_model->getClientsdata($id,0,1,0,0);
                
                // Prior booking
                $client_data['prior_row'] = $this->client_model->getPriordata($id);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_client_tpl',$client_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        
        function delete($id) {
            
            $this->client_model->delete($id);
            
            redirect('clients');
        }
        
        function getclient() {
            
            $id = $_POST['id'];
            $client = $this->client_model->getClientsdata($id,0,1,0,0);
            
            echo '{';
            echo "fname:'".addslashes($client[0]['first_name'])."',";
            echo "lname:'".addslashes($client[0]['last_name'])."',";
            echo "gender:'".addslashes($client[0]['gender'])."',";
            echo "address1:'".addslashes($client[0]['address1'])."',";
            echo "address2:'". addslashes($client[0]['address2'])."',";
            echo "suburb:'".addslashes($client[0]['suburb'])."',";
            echo "phone:'".addslashes($client[0]['phone'])."',";
            echo "mobile:'".addslashes($client[0]['mobile'])."',";
            echo "email:'".addslashes($client[0]['email'])."',";
            echo "comments:'".addslashes($client[0]['comments'])."'";
            echo '}';
        }
        
        function check() {
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('check_client_tpl');
                
            $this->load->view('footer_tpl');
            
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */