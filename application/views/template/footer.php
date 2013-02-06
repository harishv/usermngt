<!--Body content - Ends-->
<?php /* ?>
</div>
</div>
</div>
<?php */ ?>
</div>
<div class="footer">
	<div class="pull-right back-to-top"> <i class="icon-upload"></i>
		Back to top
	</div>
	<!-- <p class="pull-right">
		<a href="#">Back to top</a>
	</p> -->
	<p>
	<?php echo $this->lang->line("footer_product_desc"); ?>
	</p>
	<p>
	<?php echo $this->lang->line("footer_follow_us"); ?>
	<?php echo anchor(TWITTER_URL, img(array('src' => '/img/twitter-32.png', 'title' => $this->lang->line("twitter"))), array ("target" => "_blank")); ?>
	<?php echo anchor(FACEBOOK_URL, img(array('src' => '/img/facebook-32.png', 'title' => $this->lang->line("facebook"))), array ("target" => "_blank")); ?>
	<?php echo anchor(LINKEDIN_URL, img(array('src' => '/img/linkedin-32.png', 'title' => $this->lang->line("linkedin"))), array ("target" => "_blank")); ?>
		<br />
		<?php echo $this->lang->line("footer_maintained_by");?>
		<?php echo anchor(CONTACT_US, "Gouthami Reddy", array ("target" => "_blank")); ?>.
	</p>
</div>

</div>
<!-- End of Main-Container -->
<script type="text/javascript" src="<?php echo base_url("js"); ?>/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url("js"); ?>/prettify.js"></script>
<script type="text/javascript" src="<?php echo base_url("js"); ?>/docs.js"></script>

</body>
</html>
