<script type="text/javascript" src="<?php echo base_url("js"); ?>/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url("js"); ?>/bootstrap-datepicker.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/bootstrap-datepicker.css" />

<script type="text/javascript">
$(document).ready(function() {

	$('#student_form').validate({
		ignore: 'input[type=hidden]',
		errorClass: 'error',
		validClass: 'success',
		errorElement: 'span',
		highlight: function(element, errorClass, validClass) {
			if (element.type === 'radio') this.findByName(element.name).closest('div.control-group').removeClass(validClass).addClass(errorClass);
			else if ($(element).parent('div').parent('div').hasClass('control-group')) $(element).parent('div').parent('div').removeClass(validClass).addClass(errorClass);
			else $(element).parent('div').parent('div').parent('div').removeClass(validClass).addClass(errorClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			if (element.type === 'radio') this.findByName(element.name).closest('div.control-group').removeClass(errorClass).addClass(validClass);
			else {
				if ($(element).parent('div').parent('div').hasClass('control-group')) $(element).parent('div').parent('div').removeClass(errorClass).addClass(validClass);
				else $(element).parent('div').parent('div').parent('div').removeClass(errorClass).addClass(validClass);
				$(element).next('span.help-inline').text('');
			}
		},
		errorPlacement: function(error, element) {
			var isInputAppend = $(element).parent('div.input-append').length > 0;
			var isRadio = $(element).attr('type') === 'radio';
			if (isRadio) {
				afterElement = $(element).closest('div.controls').children('label').filter(':last');
				error.insertAfter(afterElement);
			} else if (isInputAppend) {
				appendElement = $(element).next('span.add-on');
				error.insertAfter(appendElement);
			} else error.insertAfter(element);
		}
	});

});
</script>

<div class="row">
	<div class="span12">
		<?php
		$set = (isset($student) && is_array($student) && count($student)>0) ? true : false;

		$user_info = $this->session->userdata('user');
		?>

		<studentset>
			<legend><?php echo ($set)? "Update Student" : "Add Student"; ?>

			<p class="pull-right">
				<?php echo anchor("students/students_list", "<i class='icon-arrow-left icon-white'></i> Back To List", array("class" => "btn btn-info")); ?>
			</p>
			</legend>

			<?php if (isset($errors)) { ?>
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert">&times;</a>
					<h4 class="alert-heading">
						<?php echo $this->lang->line("error"); ?>
					</h4>
					<?php echo $errors; ?>
				</div>
			<?php } ?>

			<?php
				$attributes = array ("class" => "form-horizontal", "id" => "student_form", "name" => "student_form");
				$action = "students/manage_students_action";

				if ($set) {
					$action .= "/edit";
				}

				echo form_open($action, $attributes);

				if ($set) { ?>
					<input type="hidden" id="student_id" name="student_id" value="<?php echo $student['0']['user_id']; ?>" />
					<input type="hidden" id="student_status" name="student_status" value="<?php echo $student['0']['status']; ?>" />
				<?php } ?>

				<?php
					foreach ($fields as $field) {
						$field_type = $this->fields_model->getFieldsTypeList($field['field_type_id']);
						$field_type = strtolower($field_type['name']);
					?>
					<div class="control-group">
						<label class="control-label" for="student_<?php echo $field['field_id']; ?>">Student <?php echo $field['description']; ?> :</label>
						<div class="controls">
							<?php
								$data_value = '';
								$data_id = '';
								if ($set) {
									foreach ($student as $entry) {
										if ($entry['field_id'] == $field['field_id']) {
											$data_value = $entry['value'];
											$data_id = $entry['id'];
										}
									}
								}
							?>
							<input type="text" class="<?php echo ($field['mandatory'] == '1') ? 'required ' : ''; echo ($field['field_type_id'] == '1') ? 'number ' : ''; echo ($field['field_type_id'] == '3') ? 'date ' : ''; ?>input-xlarge" id="student_<?php echo $field['field_id']; ?>" name="student_<?php echo $field['field_id']; ?>"
								placeholder="Student <?php echo $field['description']; ?>" value="<?php echo $data_value;?>"/>
							<?php if ($set) { ?>
								<input type="hidden" name="student_<?php echo $field['field_id']; ?>_id" value="<?php echo $data_id; ?>">
							<?php } ?>
						</div>
					</div>
				<?php }
				?>

			<div class="form-actions">
				<button class="btn btn-primary" type="submit"><?php if(!$set)echo "Add New";else echo "Update";?></button>
				<button class="btn" type="reset">Cancel</button>
			</div>

			<?php
			echo form_close();
			?>

		</studentset>
	</div>


</div>