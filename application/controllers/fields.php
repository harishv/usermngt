<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->model('fields_model');

		// Check if user is Logged In - Else redirect to login page
		if(!$this->user_status->is_signed_in()){
			redirect('login/index/1', 'refresh');
		}

	}

	public function index()
	{
		$this->load->view("template/header");
		$this->load->view("fields_index");
		$this->load->view("template/footer");
	}

	public function fields_list ()
	{
		// Load the success or error values(if any)
		if($this->session->userdata('fields_upload_errors')){
			$data['errors'] = $this->session->userdata('fields_upload_errors');

			$newdata = array( 'fields_upload_errors'  => "" );

			$this->session->set_userdata($newdata);
		}

		if($this->session->userdata('fields_upload_success')){
			$data['success'] = $this->session->userdata('fields_upload_success');

			$newdata = array( 'fields_upload_success'  => "" );

			$this->session->set_userdata($newdata);
		}

		$data['fields'] = $this->fields_model->getFieldsList();

		$this->load->view("template/header");
		$this->load->view("fields_list", $data);
		$this->load->view("template/footer");
	}

	public function manage_fields($id = false)
	{
		$data['field'] = array();

		// Load the error values(if any) while managing a field
		if($this->session->userdata('fields_upload_errors')){
			$data['errors'] = $this->session->userdata('fields_upload_errors');

			$newdata = array( 'fields_upload_errors'  => "" );

			$this->session->set_userdata($newdata);
		}

		if ($id) {
			$data['field'] = $this->fields_model->getField($id);
		}

		$data['field_types'] = $this->fields_model->getFieldsTypeList();

		$this->load->view("template/header");
		$this->load->view("fields_manage", $data);
		$this->load->view("template/footer");
	}

	public function field_change_status($value='')
	{
		echo $this->fields_model->field_change_status();
	}

	public function manage_fields_action($type = "add")
	{
		if ($type == "edit") {
			$field_id = $this->input->post('field_id');
		}

		$field_details = $this->fields_model->manage_field($type);

		if (is_bool($field_details)) {
			$success = "Field updated succesfully";

			$newdata = array( 'fields_upload_success'  => $success );

			$this->session->set_userdata($newdata);

			redirect('fields/fields_list', 'refresh');
		}
		if( is_string($field_details) ) {
			$errors = "Field Add / Edit Failed for the following reasons:<br />" . $field_details;

			$newdata = array( 'fields_upload_errors'  => $errors );

			$this->session->set_userdata($newdata);

			if($type == "add"){
				redirect('fields/manage_fields');
			} else if($type == "edit"){
				redirect('fields/manage_fields/' . $field_id);
			}

		} else if (is_array($field_details)) {
			$success = "Field added succesfully";

			$newdata = array( 'fields_upload_success'  => $success );

			$this->session->set_userdata($newdata);

			redirect('fields/fields_list', 'refresh');
		}
	}

}

/* End of file fields.php */
/* Location: ./application/controllers/fields.php */