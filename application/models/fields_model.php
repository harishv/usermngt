<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields_Model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

	}

	public function getFieldsList($type = 'all')
	{
		// $this->db->select('*');
		// $this->db->from('standard_user_fields');
		// if ($type == 'active') {
		// 	$this->db->where('status', '1');
		// }

		// $result = $this->db->get();

		$query = "SELECT standard_user_fields.*, field_types.name as field_type_name FROM standard_user_fields LEFT JOIN field_types ON standard_user_fields.field_type_id = field_types.id";

		if($type == "active") {
			$query .= " AND standard_user_fields.status = '1'";
		}

		$result = $this->db->query("SELECT standard_user_fields.*, field_types.name as field_type_name FROM standard_user_fields LEFT JOIN field_types ON standard_user_fields.field_type_id = field_types.id");

		// echo $this->db->last_query(); exit;

		if ($result->num_rows() == 0) {
			return false;
		} else {
			return $result->result_array();
		}

		return false;
	}

	public function getFieldsTypeList($id = false)
	{
		$this->db->select('*');
		$this->db->from('field_types');
		if ($id) {
			$this->db->where('id', $id);
		}

		$result = $this->db->get();

		if ($result->num_rows() == 0) {
			return false;
		} else {
			if ($id) {
				return $result->row_array();
			}
			return $result->result_array();
		}

		return false;
	}

	function field_change_status()
	{
		$field_id = trim($this->input->post("field_id"));
		$status_id = trim($this->input->post("status"));

		$update_data = array ('status' => $status_id);

		if ($this->db->update('standard_user_fields', $update_data, array('field_id' => $field_id))) {
			return true;
		}

		return false;
	}

	public function getField($id = 0)
	{
		if ($id == 0) {
			return false;
		}

		$this->db->select('*');
		$this->db->from('standard_user_fields');
		$this->db->where('field_id', $id);

		$result = $this->db->get();

		if ($result->num_rows() == 0) {
			return false;
		} else {
			return $result->row_array();
		}

		return false;
	}

	function manage_field($type)
	{
		extract($this->input->post());

		$errors = "";

		$errors .= (isset($field_desc) && trim($field_desc) == "") ? "Field's Description shouldn't be empty<br />" : "";
		$errors .= (!isset($field_type) || ((isset($prod_cat_choice) && (trim($prod_cat_choice) == "")))) ? "Please select a Field's Type choice<br />" : "";
		$errors .= (!isset($field_mandatory) || ((isset($field_mandatory) && trim($field_mandatory) == ""))) ? "Field's Mandatory choice should be selected<br />" : "";

		if(trim($errors) == "") {

			$field_info = array (	'description' => $field_desc,
									'field_type_id' => intval($field_type),
									'mandatory' => $field_mandatory);

			if($type == "add"){

				$field_info['status'] = 0;

				$this->db->insert('standard_user_fields', $field_info);

			} else if ($type == "edit"){

				$this->db->where('field_id', intval($field_id));
				$this->db->update('standard_user_fields', $field_info);

			}

			$affected_rows = $this->db->affected_rows();

			if($affected_rows > 0){

				if($type == "add"){
					return $field_info;
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
