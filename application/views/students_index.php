<div class="row">
	<header id="overview" class="jumbotron subhead">
		<h1><?php echo $this->lang->line("students_index_title"); ?></h1>
		<hr />
		<p class="lead"><?php echo $this->lang->line("students_index_desc"); ?></p>
	</header>
</div>
<div class="row jumbotron">
	<?php echo anchor("students/students_list", $this->lang->line("students_index_list"), array("class" => "btn btn-large btn-warning span3 btn-span3")); ?>
	<?php echo anchor("students/manage_students", $this->lang->line("students_index_add_new"), array("class" => "btn btn-large btn-info span3 btn-span3")); ?>
</div>