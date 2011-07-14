<div class="grid_16">
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
        Being a static page, it has its own static layout. To change that layout, edit the file
        <code><?php echo realpath(LITHIUM_APP_PATH . '/libraries/minerva_blog/views/layouts/static/default.html.php'); ?></code>.
    </p>
    <p>
        Static layout templates are always set to use a "default.html.php" layout template and if the plugin does not include one, it will default back to Minerva's static layout (default.html.php) and if that didn't exist, it would use Minerva's normal default.html.php layout template.
    </p>
    <p>
        Note that this page does not pull any of its data from the database. It is simply a template file that gets rendered. If you would prefer to set this URL to be an index listing of blog entries, then change the routes.php file under the minerva_blog library's config directory.
    </p>
</div>