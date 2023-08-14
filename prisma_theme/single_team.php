<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" align="left">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="service-info" id="post-<?php the_ID(); ?>" style="padding-left: 10px; display: inline-block;">
				<h2 class="h2"><?php the_title(); ?></h2>
				<div class="article-detail"><span class="detail_picture"><?php echo the_post_thumbnail(); ?></span><?php the_content(); ?></div>
		</div>
	<div class="clear"></div>
<p align="center"><a class="link" href="/?cat=11">К СПИСКУ</a></p>

<?php endwhile; else: ?>
<br>
<p>К сожалению страница не найдена</p>
<p><a href="/">Вернуться на главную</a></p>

<?php endif; ?>

		</div>
	</article>

<?php get_footer(); ?>