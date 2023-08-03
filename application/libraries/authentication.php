<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication
{
      
    function __construct()
    {        
        $this->obj = & get_instance();
        
    }
    function is_logged_in()
	{
		if($this->obj->session) {
			//If user has valid session, and such is logged in
			
			if ($this->obj->session->userdata('sess_userid'))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}

		}
		else
		{
			return FALSE;
		}
	} 	
	function logout()
	{		
		$this->obj->session->sess_destroy();		
		redirect('login');
	}
    
}

?>