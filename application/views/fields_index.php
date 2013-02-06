<div class="row">
	<header id="overview" class="jumbotron subhead">
		<h1><?php echo $this->lang->line("fields_index_title"); ?></h1>
		<hr />
		<p class="lead"><?php echo $this->lang->line("fields_index_desc"); ?></p>
	</header>
</div>
<div class="row jumbotron">
	<?php echo anchor("fields/fields_list", $this->lang->line("fields_index_list"), array("class" => "btn btn-large btn-success span3 btn-span3")); ?>
	<?php echo anchor("fields/manage_fields", $this->lang->line("fields_index_add_new"), array("class" => "btn btn-large btn-primary span3 btn-span3")); ?>
</div>