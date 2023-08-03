<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

        public function __construct()
               {
                    parent::__construct();
                    // Your own constructor code
                    
               }
       
	public function index()
	{
            $this->authentication->logout();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */