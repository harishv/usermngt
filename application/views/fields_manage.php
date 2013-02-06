<script type="text/javascript" src="<?php echo base_url("js"); ?>/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url("js"); ?>/bootstrap-datepicker.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/bootstrap-datepicker.css" />

<script type="text/javascript">
$(document).ready(function() {

	$('#field_form').validate({
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
		$set = (isset($field) && is_array($field) && count($field)>0) ? true : false;

		$user_info = $this->session->userdata('user');
		?>

		<fieldset>
			<legend><?php echo ($set)? "Update Field" : "Add Field"; ?>

			<p class="pull-right">
				<?php echo anchor("fields/fields_list", "<i class='icon-arrow-left icon-white'></i> Back To List", array("class" => "btn btn-info")); ?>
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
				$attributes = array ("class" => "form-horizontal", "id" => "field_form", "name" => "field_form");
				$action = "fields/manage_fields_action";

				if ($set) {
					$action .= "/edit";
				}

				echo form_open($action, $attributes);

				if ($set) { ?>
					<input type="hidden" id="field_id" name="field_id" value="<?php echo $field['field_id']; ?>" />
				<?php } ?>

			<div class="control-group">
				<label class="control-label" for="field_desc">Field Description :</label>
				<div class="controls">
					<input type="text" class="required input-xlarge" id="field_desc" name="field_desc"
						placeholder="Field Description" value="<?php echo ($set) ? $field['description']:'';?>"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="field_type">Field Type :</label>
				<div class="controls">
					<select class="required input-xlarge" id="field_type" name="field_type">
						<option value="">:: Select One ::</option>
						<?php
						foreach ($field_types as $type) {
							$selected = '';
							if ($set && $type['id'] == $field['field_type_id']) {
								$selected = 'selected="selected"';
							}
							?>
							<option <?php echo $selected; ?> value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
						<?php }
						?>
					</select>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="field_mandatory">Mandatory :</label>
				<div class="controls">
					<select class="required input-xlarge" id="field_mandatory" name="field_mandatory">
						<option value="">:: Select One ::</option>
						<option <?php echo ($set && $field['mandatory'] == 1) ? 'selected="selected"' : ''; ?> value="1">Yes, this is mandatory</option>
						<option <?php echo ($set && $field['mandatory'] == 0) ? 'selected="selected"' : ''; ?> value="0">No, this is not mandatory</option>
					</select>
				</div>
			</div>

			<div class="form-actions">
				<button class="btn btn-primary" type="submit"><?php if(!$set)echo "Add New";else echo "Update";?></button>
				<button class="btn" type="reset">Cancel</button>
			</div>

			<?php
			echo form_close();
			?>

		</fieldset>
	</div>


</div>