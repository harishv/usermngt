<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_Model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

	}

	public function getStudentsList()
	{
		$user_ids = array();
		$students_list = array();

		$result = $this->db->query("SELECT DISTINCT `user_id` FROM `user_details`");

		if ($result->num_rows() == 0) {
			return false;
		} else {
			$user_ids = $result->result_array();
		}

		foreach ($user_ids as $user_id) {
			$this->db->select('*');
			$this->db->from('user_details');
			$this->db->where('user_id', $user_id['user_id']);

			$result = $this->db->get();

			if ($result->num_rows() > 0) {
				$students_list[$user_id['user_id']] = $result->result_array();
			}
		}

		return $students_list;
	}

	public function student_change_status()
	{
		$student_id = trim($this->input->post("student_id"));
		$status_id = trim($this->input->post("status"));

		$update_data = array ('status' => $status_id);

		if ($this->db->update('user_details', $update_data, array('user_id' => $student_id))) {
			return true;
		}

		return false;
	}

	public function getStudent($id = 0)
	{
		if ($id == 0) {
			return false;
		}

		$this->db->select('*');
		$this->db->from('user_details');
		$this->db->where('user_id', $id);

		$result = $this->db->get();

		if ($result->num_rows() == 0) {
			return false;
		} else {
			return $result->result_array();
		}

		return false;
	}

	function manage_student($type)
	{
		extract($this->input->post());

		$errors = "";

		$active_fields = $this->fields_model->getFieldsList('active');

		foreach ($active_fields as $field) {
			$field_name = "student_" . $field['field_id'];

			$errors .= (isset($$field_name) && trim($$field_name) == "") ? "Field's " . $field['description'] . " shouldn't be empty<br />" : "";
		}

		if(trim($errors) == "") {

			if ($type == "add") {
				$result_id = $this->db->query("SELECT MAX( DISTINCT (`user_id`) ) as user_id FROM `user_details`");

				if ($result_id->num_rows() > 0) {
					$user_id = $result_id->row_array();
					$user_id = intval($user_id['user_id']) + 1;
				} else {
					$user_id = 1;
				}

				$user_status = '0';
			} else if ($type == "edit"){
				$user_id = $student_id;
				$user_status = $student_status;
			}

			foreach ($active_fields as $field) {
				$student_info = array();
				$field_name = "student_" . $field['field_id'];
				$student_info['field_id'] = intval($field['field_id']);
				$student_info['value'] = (isset($$field_name)) ? $$field_name : '';
				$student_info['user_id'] = $user_id;
				$student_info['status'] = $user_status;

				if($type == "add") {
					$this->db->insert('user_details', $student_info);
				} else if ($type == "edit"){
					$record_id = $field_name . '_id';

					if($$record_id != null || $$record_id != '') {

						$this->db->where('id', intval($$record_id));
						$this->db->update('user_details', $student_info);
					} else {
						$this->db->insert('user_details', $student_info);
					}
				}

			}

			$affected_rows = $this->db->affected_rows();

			if($affected_rows > 0){

				if($type == "add"){
					return $student_info;
				} else if($type == "edit"){
					return true;
				}

			} else {

				$errors .= "Database insertion error<br />";

			}
		}

		return trim($errors);
	}
};


/* End of file fields_model.php */
/* Location: ./system/application/models/fields_model.php */
