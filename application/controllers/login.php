<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->lang->load('general');
		//$this->load->library('user_status');
		$this->load->model('Login_Model');

		// Check if user is Logged In and redirect to index page
		if( $this->user_status->is_signed_in() ){
			redirect('home');
		}
	}

	public function index($error = 0) {
		$data = array();

		if ($error != 0) {
			$data["errors"] = $this->lang->line("login_form_access_err");
		}

		if ($this->session->userdata("errors")) {
			$data["errors"] = $this->session->userdata("errors");

			$newdata = array( 'errors'  => "" );

			$this->session->set_userdata($newdata);
		}

		$this->load->view("template/header");
		$this->load->view("login", $data);
		$this->load->view("template/footer");
	}

	public function check_user_login() {
		$user_access = $this->Login_Model->check_user_login();

		if (!$user_access) {

			$newdata = array( 'errors'  => "Invalid Login-ID or Password." );

			$this->session->set_userdata($newdata);

			redirect("login", "refresh");

		} else {
			$newdata = array( 'user'  => $user_access );

			$this->session->set_userdata($newdata);

			redirect("home", "refresh");

		}

	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */