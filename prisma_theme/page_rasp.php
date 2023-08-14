<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" align="center">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>" style="margin-top: 20px;">
		<p style="color: #707070; font-weight: bold;"><?php the_title(); ?></p>
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