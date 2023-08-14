<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>" style="margin-top: 40px;">
		<h2><?php the_title(); ?></h2>
			<p>
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('до' => '<p><strong>Страница:</strong> ', 'после' => '</p>', 'next_or_number' => 'number')); ?>
				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</p>
		</div>
		<?php endwhile; endif; ?>

		</div>
	</article>

<?php get_footer(); ?>