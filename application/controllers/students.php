<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->model('students_model');
		$this->load->model('fields_model');

		// Check if user is Logged In - Else redirect to login page
		if(!$this->user_status->is_signed_in()){
			redirect('login/index/1', 'refresh');
		}

	}

	public function index()
	{
		$this->load->view("template/header");
		$this->load->view("students_index");
		$this->load->view("template/footer");
	}

	public function students_list()
	{
		// Load the success or error values(if any)
		if($this->session->userdata('students_upload_errors')){
			$data['errors'] = $this->session->userdata('students_upload_errors');

			$newdata = array( 'students_upload_errors'  => "" );

			$this->session->set_userdata($newdata);
		}

		if($this->session->userdata('students_upload_success')){
			$data['success'] = $this->session->userdata('students_upload_success');

			$newdata = array( 'students_upload_success'  => "" );

			$this->session->set_userdata($newdata);
		}

		$data['students'] = $this->students_model->getStudentsList();
		$data['fields'] = $this->fields_model->getFieldsList('active');

		$this->load->view("template/header");
		$this->load->view("students_list", $data);
		$this->load->view("template/footer");
	}

	public function manage_students($id = false)
	{
		$data['student'] = array();

		// Load the error values(if any) while managing a student
		if($this->session->userdata('students_upload_errors')){
			$data['errors'] = $this->session->userdata('students_upload_errors');

			$newdata = array( 'students_upload_errors'  => "" );

			$this->session->set_userdata($newdata);
		}

		if ($id) {
			$data['student'] = $this->students_model->getStudent($id);
		}

		$data['fields'] = $this->fields_model->getFieldsList('active');
		// echo "<pre>"; print_r($data['student']); print_r($data['fields']); echo "</pre>"; exit();

		$this->load->view("template/header");
		$this->load->view("students_manage", $data);
		$this->load->view("template/footer");
	}

	public function student_change_status($value='')
	{
		echo $this->students_model->student_change_status();
	}

	public function manage_students_action($type = "add")
	{
		if ($type == "edit") {
			$student_id = $this->input->post('student_id');
		}

		$student_details = $this->students_model->manage_student($type);

		if (is_bool($student_details)) {
			$success = "Student updated succesfully";

			$newdata = array( 'students_upload_success'  => $success );

			$this->session->set_userdata($newdata);

			redirect('students/students_list', 'refresh');
		}
		if( is_string($student_details) ) {
			$errors = "Student Add / Edit Failed for the following reasons:<br />" . $student_details;

			$newdata = array( 'students_upload_errors'  => $errors );

			$this->session->set_userdata($newdata);

			if($type == "add"){
				redirect('students/manage_students');
			} else if($type == "edit"){
				redirect('students/manage_students/' . $student_id);
			}

		} else if (is_array($student_details)) {
			$success = "Student added succesfully";

			$newdata = array( 'students_upload_success'  => $success );

			$this->session->set_userdata($newdata);

			redirect('students/students_list', 'refresh');
		}
	}

}

/* End of file students.php */
/* Location: ./application/controllers/students.php */