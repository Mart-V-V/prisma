<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" style="margin-top: 20px;">

		<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
<div class="boxs post" id="post-<?php the_ID(); ?>"><div class="contents">
	<div class="article-item a1" id="bx_651765591_421">
		<span class="news_date"><?php the_date() ?></span>
		<a href="<?php the_permalink() ?>" class="img2"><?php echo get_the_post_thumbnail(); ?></a>
		<div class="info">
		<div class="news_block">
			<a href="<?php the_permalink() ?>" class="title" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<div class="desc"><?php the_excerpt(); ?></div>
			<a href="<?php the_permalink() ?>" class="link">читать дальше</a>
		</div>
		</div>
	</div>
</div></div>

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

		</div>
	</article>

<?php get_footer(); ?>