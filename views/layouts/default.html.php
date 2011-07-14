<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->html->charset();?>
	<title>Minerva > <?php echo $this->title(); ?></title>
	<?php //echo $this->html->style(array('debug', 'lithium')); ?>	
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?php	// Flip between "960" and "grid" style sheets for fluid vs. fixed 960gs
		echo $this->html->style(array('/minerva/css/reset', '/minerva/css/text', '/minerva/css/960', '/minerva/css/layout', '/minerva/css/nav', '/minerva/css/jquery/themes/smoothness/jquery-ui-1.8.6.custom.css'), array('inline' => false));	
		echo '<!--[if IE 6]>'.$this->html->style('/minerva/css/ie6').'<![endif]-->';
		echo '<!--[if IE 7]>'.$this->html->style('/minerva/css/ie').'<![endif]-->';
		echo $this->html->script(array('/minerva/js/jquery/jquery-1.4.4.min.js', '/minerva/js/jquery/jquery-ui-1.8.6.custom.min.js', '/minerva/js/jquery-fluid16.js'), array('inline' => false));
	?>
		
	<?php
		echo $this->scripts();
		echo $this->styles();
	?>
</head>
<body>
	<div class="container_16">
		<div class="grid_16" id="admin_header">
			<h1 id="branding">
				<a href="/minerva">Minerva</a>
			</h1>
		</div>
		<div class="clear" style="height: 10px;"></div>
		
		<?php echo $this->content(); ?>		
		
		<div class="clear"></div>
		<div class="grid_16">
			Powered by <?php echo $this->html->link('Lithium', 'http://li3.rad-dev.org'); ?>.
		</div>
	</div>
	<?=$this->minervaHtml->flash(); ?>
	<!-- layout template: /blog/views/layouts/default.html.php -->
</body>
</html>