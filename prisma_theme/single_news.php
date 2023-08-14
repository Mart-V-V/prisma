<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" align="left">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="news-detail" id="post-<?php the_ID(); ?>">
				<span class="news-date-time"><?php the_date(); ?></span>
				<h3><?php the_title(); ?></h3>
				<div><?php the_content(); ?></div>
				<!--<?php the_post_thumbnail(); ?>-->
		</div>


<?php endwhile; else: ?>
<br>
<p>К сожалению страница не найдена</p>
<p><a href="/">Вернуться на главную</a></p>

<?php endif; ?>

		</div>
	</article>

<?php get_footer(); ?>