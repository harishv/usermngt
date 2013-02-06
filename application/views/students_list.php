<script type="text/javascript">

	$(document).ready(function() {
		$('#students_list').dataTable({
			"sDom": "<'row'<'span8'l><'span4'f>r>t<'row'<'span6'i><'span6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			}
		});
	});

	function change_status (student_id, del_status) {
		var status, data;

		if (del_status) {
			$('.status_text_' + student_id).html('<span class="label label-important"><i class="icon-remove icon-white"></i> Deleted</span>');
			$('.del_btn_' + student_id).html('');
			status = 2;
		} else {
			$('#onandoff_' + student_id).toggleClass('active_on');

			if ($('#onandoff_' + student_id).hasClass('active_on')) {
				status = 1;
			} else{
				status = 0;
			}
		}

		data = {'student_id' : student_id, 'status' : status};

		$.ajax({
			data: data,
			type: 'POST',
			url: '<?php echo base_url() . "/students/student_change_status"; ?>',
			success: function(responseTxt){
							console.log(responseTxt);
							if (responseTxt != 1) {
								$('#onandoff_' + student_id).toggleClass('active_on');
							} else {
								var success_msg = '<div class="span6 alert alert-success"><a class="close" data-dismiss="alert">&times;</a><h4 class="alert-heading">Success!</h4>Status Changed Successfully.</div>';
								$("#success_message").html(success_msg);
							}
					 }
		});

		return false;
	}

	function delete_student (student_id,status) {

		if ($('#onandoff_' + student_id).hasClass('active_on')) {

				alert("Please Inactive the student first, to Delete.");
				return false;

		}else{
			var choice = confirm('Are you sure.\nYou want to Delete student.?');

			if (choice) {
				change_status(student_id, true);
			}
			return false;
		}

	}

</script>
<div class="container inner-page-content">

	<ul class="pager">
		<li class="next">
			<?php echo anchor("students", '<i class="icon-arrow-left"></i> Back'); ?>
		</li>
	</ul>

	<div class="row">
		<div class="span12">
			<div class="alert alert-info">
				<h3>Students List</h3>
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
					<?php echo anchor("students/manage_students", '<i class="icon-plus icon-white"></i> '.'<b>Add New</b>', array ("class" => "btn btn-small btn-inverse")); ?>
				</div>
			</div>

			<?php
			if (isset($students) && count($students) > 0) {

				$tableCount = 1;

				?>
			<table id="students_list" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<?php
						foreach ($fields as $field) { ?>
						<th><?php echo $field['description']; ?></th>
						<?php }
						?>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($students as $student) { ?>
					<tr>
						<td><?php echo $tableCount; ?></td>
						<?php
							foreach ($fields as $field) { ?>
							<td>
								<?php
								foreach ($student as $entry) {
									if ($entry['field_id'] == $field['field_id']) {
										echo $entry['value'];
									} else {
										echo '';
									}
								}
								?>
							</td>
						<?php }
						?>
						<td>
							<div class="status_text_<?php echo $student["0"]["user_id"]; ?>">
								<?php if ($student["0"]["status"] != 2){ ?>
									<div class="status-switch" id="onandoff_<?php echo $student["0"]["user_id"]; ?>" onclick="return change_status(<?php echo $student["0"]["user_id"]; ?>)"></div>
									<?php if ($student["0"]["status"] == 1){ ?>
										<script type="text/javascript">
											$('#onandoff_<?php echo $student["0"]["user_id"]; ?>').addClass('active_on');
										</script>
									<?php } ?>
								<?php } else { ?>
									<span class="label label-important"><i class="icon-remove icon-white"></i> Deleted</span>
								<?php } ?>
							</div>
						</td>
						<td>
							<?php echo anchor("students/manage_students/" . $student["0"]["user_id"], '<i class="icon-edit icon-white"></i> <b>Edit</b>', array ("class" => "btn btn-mini btn-success")); ?>
							<span class="del_btn_<?php echo $student["0"]["user_id"]; ?>">
								<?php if ($student["0"]["status"] != 2) { ?>
								<a href="#" class="btn btn-mini btn-danger" onclick="return delete_student('<?php echo $student['0']['user_id']; ?>','<?php echo $student["0"]["status"]; ?>')"><i class="icon-trash icon-white"></i> <b>Delete</b></a>
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
