<!-- start left column -->
<div class="grid_4">	
	<div class="box">
		<h2>Menu</h2>
		<div class="block">
			<?php echo $this->minervaMenu->render(array('library' => 'blog', 'template' => 'blog_menu')); ?>
			<p>This menu is being rendered from app/libraries/blog/views/menus/static</p>
		</div>
	</div>
</div>
<!-- end left column -->

<div class="grid_8">
    <h2 id="page-heading">Blog Entry</h2>
<!-- start main content area -->
    
<br />
<p>The template being rendered is from /libraries/blog/views/pages/read.html.php
<br />
<h1><?=$document->title; ?></h1>
<p>
Created: <?=$document->created; ?> (modified: <?=$document->modified; ?>)<br /><br />
<?=$document->body; ?>
</p>
<?=$document->image; ?>

<!-- end main content area -->
</div>

<!-- right column -->
<div class="grid_4">
	<div class="box">		
	</div>
</div>
<div class="clear"></div>
<!-- end right column -->
