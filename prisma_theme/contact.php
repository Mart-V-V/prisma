<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(5) ) : ?>     
<?php wp_list_categories('title_li=<h2>Categories</h2>'); ?>
<li><h2>Archives</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
</li>
<?php wp_list_bookmarks(); ?>
<?php endif; ?>
