<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" style="margin-top: 20px;">

		<?php if (have_posts()) : ?>


		<?php while (have_posts()) : the_post(); ?>

			<div class="comment-item" id="post-<?php the_ID(); ?>">
				<div class="author"><span><?php the_title(); ?></span></div>
				<div class="text"><?php the_content(); ?></div>
			</div>

		<?php endwhile; ?>

			<div class="navigation">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
		
		        <div class="alignleft"><?php next_posts_link('&larr; Предыдущие') ?></div>
		        <div class="alignright"><?php previous_posts_link('Следующие &rarr;') ?></div>
		        <?php } ?>
			</div>

	<?php else : ?>

<br>
<p>К сожалению страница не найдена</p>
<p><a href="/">Вернуться на главную</a></p>

	<?php endif; ?>

<div class="question-block">
	<div class="wrapper" align="center">
		<div class="question-form2" align="left">
			<h2>Оставить отзыв</h2>
			<?php echo do_shortcode("[contact-form-7 id=152]"); ?>				
		</div>
	</div>
</div>

		</div>
	</article>

<?php get_footer(); ?>