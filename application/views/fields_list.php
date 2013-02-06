<script type="text/javascript">

	$(document).ready(function() {
		$('#fields_list').dataTable({
			"sDom": "<'row'<'span8'l><'span4'f>r>t<'row'<'span6'i><'span6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			}
		});
	});

	function change_status (field_id, del_status) {
		var status, data;

		if (del_status) {
			$('.status_text_' + field_id).html('<span class="label label-important"><i class="icon-remove icon-white"></i> Deleted</span>');
			$('.del_btn_' + field_id).html('');
			status = 2;
		} else {
			$('#onandoff_' + field_id).toggleClass('active_on');

			if ($('#onandoff_' + field_id).hasClass('active_on')) {
				status = 1;
			} else{
				status = 0;
			}
		}

		data = {'field_id' : field_id, 'status' : status};

		$.ajax({
			data: data,
			type: 'POST',
			url: '<?php echo base_url() . "/fields/field_change_status"; ?>',
			success: function(responseTxt){
							console.log(responseTxt);
							if (responseTxt != 1) {
								$('#onandoff_' + field_id).toggleClass('active_on');
							} else {
								var success_msg = '<div class="span6 alert alert-success"><a class="close" data-dismiss="alert">&times;</a><h4 class="alert-heading">Success!</h4>Status Changed Successfully.</div>';
								$("#success_message").html(success_msg);
							}
					 }
		});

		return false;
	}

	function delete_field (field_id,status) {

		if ($('#onandoff_' + field_id).hasClass('active_on')) {

				alert("Please Inactive your field first, to Delete it.");
				return false;

		}else{
			var choice = confirm('Are you sure.\nYou want to Delete field.?');

			if (choice) {
				change_status(field_id, true);
			}
			return false;
		}

	}

</script>
<div class="container inner-page-content">

	<ul class="pager">
		<li class="next">
			<?php echo anchor("fields", '<i class="icon-arrow-left"></i> Back'); ?>
		</li>
	</ul>

	<div class="row">
		<div class="span12">
			<div class="alert alert-info">
				<h3>Fields List</h3>
			</div>
		</div>
	</div>

	<div class="clear"></div>

	<div class="row">
		<div class="span12">

			<div class="row" style="padding-bottom: 20px;">
				<div id="success_message" class="container">
					<?php if (isset($success)) { ?>
					<div class="span6 alert alert-success">
						<a class="close" data-dismiss="alert">&times;</a>
						<h4 class="alert-heading">
						<?php echo $this->lang->line("success"); ?>
						</h4>
						<?php echo $success; ?>
					</div>
					<?php } ?>
				</div>

				<div id="errors_message" class="container">
					<?php if (isset($errors)) { ?>
					<div class="span6 alert alert-error">
						<a class="close" data-dismiss="alert">&times;</a>
						<h4 class="alert-heading">
						<?php echo $this->lang->line("error"); ?>
						</h4>
						<?php echo $errors; ?>
					</div>
					<?php } ?>
				</div>

				<div class="pull-right">
					<?php echo anchor("fields/manage_fields", '<i class="icon-plus icon-white"></i> '.'<b>Add New</b>', array ("class" => "btn btn-small btn-inverse")); ?>
				</div>
			</div>

			<?php
			if (isset($fields) && count($fields) > 0) {

				$tableCount = 1;

				?>
			<table id="fields_list" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Description</th>
						<th>Field Type</th>
						<th>Mandotary</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($fields as $field) { ?>
					<tr>
						<td><?php echo $tableCount; ?></td>
						<td><?php echo strip_slashes($field["description"]); ?></td>
						<td><?php echo $field["field_type_name"]; ?></td>
						<td><?php echo ($field["mandatory"] == '1') ? 'Mandatory' : 'Optional'; ?></td>
						<td>
							<div class="status_text_<?php echo $field["field_id"]; ?>">
								<?php if ($field["status"] != 2){ ?>
									<div class="status-switch" id="onandoff_<?php echo $field["field_id"]; ?>" onclick="return change_status(<?php echo $field["field_id"]; ?>)"></div>
									<?php if ($field["status"] == 1){ ?>
										<script type="text/javascript">
											$('#onandoff_<?php echo $field["field_id"]; ?>').addClass('active_on');
										</script>
									<?php } ?>
								<?php } else { ?>
									<span class="label label-important"><i class="icon-remove icon-white"></i> Deleted</span>
								<?php } ?>
							</div>
						</td>
						<td>
							<?php echo anchor("fields/manage_fields/" . $field["field_id"], '<i class="icon-edit icon-white"></i> <b>Edit</b>', array ("class" => "btn btn-mini btn-success")); ?>
							<span class="del_btn_<?php echo $field["field_id"]; ?>">
								<?php if ($field["status"] != 2) { ?>
								<a href="#" class="btn btn-mini btn-danger" onclick="return delete_field('<?php echo $field['field_id']; ?>','<?php echo $field["status"]; ?>')"><i class="icon-trash icon-white"></i> <b>Delete</b></a>
								<?php } ?>
							</span>
						</td>
					</tr>
					<?php
					$tableCount++;
				} ?>
				</tbody>
			</table>
			<?php } else { ?>
			<p>
			<?php echo $this->lang->line("no_data"); ?>
			</p>
			<?php } ?>

			</div>
		</div>
	</div>

<script type="text/javascript" src="<?php echo base_url("js"); ?>/jquery.dataTables.js"></script>

<script type="text/javascript" src="<?php echo base_url("js"); ?>/dt-bootstrap.js"></script>
