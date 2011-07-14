<h3>Minerva Blog Plugin</h3>
<?php echo $this->minervaMenu->render_menu('blog_menu', 'minerva_blog'); ?>
<p>
	This is a simple blog plugin for Minerva. It changes the schema of the base Page model to add new fields useful for blogging.
</p>
<h4>About This Page</h4>
<p>
	This is Minerva Blog's default static home page. To change this template, edit the file
	<code><?php echo realpath(LITHIUM_APP_PATH . '/libraries/minerva_blog/views/pages/static/home.html.php'); ?></code>.
</p>
<p>
	Note that this page does not pull any of its data from the database. It is simply a template file that gets rednered.
</p>