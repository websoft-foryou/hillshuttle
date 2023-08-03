<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
                    if(!$this->authentication->is_logged_in()) {redirect('login');}
                    
                     $this->load->model('booking_model');
                     
                     $this->load->model('common_model');

               }
    
	public function index($order_field='',$order_by='',$offset=0,$reset='')
	{
            $title = array('title'=>'Booking');
            
		if($reset=='reset') {
            
                    $this->session->unset_userdata('book_searchtxt');
            
                    $this->session->unset_userdata('book_searchfld');
                    
                    redirect('booking');
                }
              /*  else if($this->uri->total_segments()==1) {

                    $this->session->unset_userdata('searchtxt');

                    $this->session->unset_userdata('searchfld');

                } */
                
                $search_post = $this->input->post('search_txt');
                
                $search_fldpost = $this->input->post('search_fld');

                if($search_post) {

                    $search_sess = array('book_searchtxt'=>$search_post,'book_searchfld'=>$search_fldpost);

                    $this->session->set_userdata($search_sess);

                }

                $search = $this->session->userdata('book_searchtxt');

                $search_fld = $this->session->userdata('book_searchfld');
                
            // paging config
            $paging_config = $this->config->item('paging_config'); 

                $default_paging_filed_config = $this->config->item('default_order_field');
                
		$order_field = 'id';
                
		$order_by = ($order_by=='')? $default_paging_filed_config['orderby_fld_val'] : $order_by;
                
		$this->load->library('pagination');

		$paging_config['base_url'] = site_url()."/booking/index/$order_field/$order_by";
                
		$paging_config['uri_segment'] = $default_paging_filed_config['uri_segment_val'];
                
		$data['uri_offset'] = $offset;
                
		$data['uri_orderby'] = $order_by;
                
		$data['uri_orderfield'] = $order_field;
            // end paging config
                
                
            
            
            
            if($search!='' || $this->session->userdata('book_searchtxt')) {
                
                $data['book_data'] = $this->booking_model->getFilterdata($search,$search_fld,$offset,$paging_config['per_page'],$order_field,$order_by);
                
                $paging_config['total_rows'] = $this->booking_model->getNumRows($search,$search_fld);
              //  echo 'count'.$paging_config['total_rows']; 
            }
            
           else { 
               
               $data['book_data'] = $this->booking_model->getBookingdata(0,$offset,$paging_config['per_page'],$order_field,$order_by); 
               
               $paging_config['total_rows'] = $this->booking_model->getNumRows(0,0);
               //echo 'count'.$paging_config['total_rows']; 
               }
            
               // paging library
		$this->pagination->initialize($paging_config);

		$data['page_links']=$this->pagination->create_links();
                // end pagination library
               
                // delete multipickup address if not save or update
                //$current_updateid = $this->session->userdata('currentupdateid');                
               // $this->booking_model->autoPickup($current_updateid);
                
            $this->load->view('header_tpl',$title);
                
            $this->load->view('booking_tpl',$data);
                
            $this->load->view('footer_tpl');
            
	}

	function add()
	{
              
            $this->load->helper('form');
            // mail config
                $this->load->library('email');
                
                $cus_config = $this->config->item('customize_email_config');

                $this->email->initialize($cus_config);
            // mail config end
            
            $title = array('title'=>'Add Booking');
            
            //$data = $this->input->post('bookinfo');
            $data = $_POST;
            
          //  $moredata = $this->input->post('morebookinfo');
            
            $book_data['getdriverval'] = $this->booking_model->getDriverdata();
            
            //print_r($data); exit;
            $book_data['book_row'][] = array('id'=>'',
                                            'client'=>'',
                                            'type'=>'',
                                            'dep_address1'=>'',
                                            'dep_address2'=>'',
                                            'dep_suburb'=>'',
                                            'dep_phone'=>'',
                                            'dep_mobile'=>'',
                                            'dep_drop_address1'=>'',
                                            'dep_drop_address2'=>'',
                                            'dep_drop_suburb'=>'',
                                            'dep_drop_phone'=>'',
                                            'dep_drop_mobile'=>'',
                                            'dep_date'=>'',
                                            'dep_flight'=>'',
                                            'dep_airline'=>'',
                                            'dep_origin'=>'',
                                            'dep_terminal'=>'',
                                            'dep_ourtime'=>'',
                                            'dep_yourtime'=>'',
                                            'dep_time'=>'',
                                            'dep_pickuptime'=>'',
                                            'dep_bus'=>'',
                                            'dep_passengers'=>'',
                                            'dep_babyseats'=>'',
                                            'dep_estfare'=>'',
                                            'dep_driver'=>'',
                                            'dep_comments'=>'',
                                            'dep_destination'=>'',
                                            'arr_suburb'=>'',
                                            'arr_address1'=>'',
                                            'arr_address2'=>'',
                                            'arr_phone'=>'',
                                            'arr_mobile'=>'',
                                            'arr_drop_suburb'=>'',
                                            'arr_drop_address1'=>'',
                                            'arr_drop_address2'=>'',
                                            'arr_drop_phone'=>'',
                                            'arr_drop_mobile'=>'',
                                            'arr_date'=>'',
                                            'arr_flight'=>'',
                                            'arr_airline'=>'',
                                            'arr_origin'=>'',
                                            'arr_terminal'=>'',
                                            'arr_ourtime'=>'',
                                            'arr_yourtime'=>'',
                                            'arr_time'=>'',
                                            'arr_pickuptime'=>'',
                                            'arr_bus'=>'',
                                            'arr_passengers'=>'',
                                            'arr_babyseats'=>'',
                                            'arr_estfare'=>'',
                                            'arr_driver'=>'',
                                            'arr_comments'=>'',
                                            'arr_destination'=>'',
                                            'total'=>'',
                                            'payment_method'=>'',
                                            'first_name'=>'',
                                            'last_name'=>'',
                                           );
            
            if(!empty ($data)) {
                
                $today_date = date('Y-m-d H:i:s');
                
                $data['created_date'] = $today_date;
                
                $data['updated_date'] = $today_date;
                
                $data['new_book'] = $this->booking_model->addBooking();
                
                redirect('booking');
                
            }
            else {
                $book_data['empty_book'] = $this->booking_model->addEmptybook();
               
            }
            
            // more booking add
          /*  if(!empty ($moredata)) {
                
                $data['more_book'] = $this->booking_model->addmoreBooking($moredata,$data);
                
              //  redirect('booking');
            } */
            // more booking end
            
            $book_data['getpickup'] = array();
            
            $book_data['getdropoff'] = array();
            
            $this->load->view('header_tpl',$title);
                
            $this->load->view('new_booking_tpl',$book_data);
                
            $this->load->view('footer_tpl');
            
        }
        
        function edit($id) {
            
                $this->load->helper('form');
                
            // mail config
                $this->load->library('email');
                
                $cus_config = $this->config->item('customize_email_config');

                $this->email->initialize($cus_config);
            // mail config end
                
                $title = array('title'=>'Edit Booking');
            
                $data = $_POST;
                
                $update_id = $this->input->post('book_id');
                
                if(!empty ($data)) {

                    $today_date = date('Y-m-d H:i:s');

                    $data['updated_date'] = $today_date;

                    $data['edit_book'] = $this->booking_model->editBooking($update_id);

                    redirect('booking');

                }   
                
                $book_data['getdriverval'] = $this->booking_model->getDriverdata();
                
                $book_data['book_row'] = $this->booking_model->getBookingdata($id,0,1,0,0);
                
                $book_data['getpickup'] = $this->common_model->showPickup($id,'dep');
                
                $book_data['getdropoff'] = $this->common_model->showPickup($id,'arr');
                
            //    $current_book_session = array('currentupdateid'=>$id);
              //  $this->session->set_userdata($current_book_session);
                
                $this->load->view('header_tpl',$title);
                
                $this->load->view('new_booking_tpl',$book_data);
                
                $this->load->view('footer_tpl');
                
                
        }
        
        function delete($id) {
            
            $this->booking_model->delete($id);
            
            redirect('booking');
        }

        function cancel($book) {
            
            $this->booking_model->delPickup($book);
            
            redirect('booking');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */