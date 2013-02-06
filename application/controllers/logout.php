<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

   public function __construct()
   {
		parent::__construct();
   }

	public function index()
	{
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('header_action');
		$this->session->unset_userdata('selected_country');

		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */