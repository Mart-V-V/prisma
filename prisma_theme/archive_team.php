<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" style="margin-top: 40px;">

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2><?php single_cat_title(); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2><?php single_tag_title(); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2><?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2><?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2><?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2>Author</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2>Archive</h2>
 	  <?php } ?>


		<?php while (have_posts()) : the_post(); ?>
<div class="boxs post" id="post-<?php the_ID(); ?>"><div class="contents">
	<div class="article-item_2" id="bx_651765591_421">
		<a href="<?php the_permalink() ?>" class="img_2"><?php echo get_the_post_thumbnail(); ?></a>
		<div class="info_2">
			<a href="<?php the_permalink() ?>" class="title_2" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<div class="desc_2"><?php the_excerpt(); ?></div>
			<div class="ln_2"><a href="<?php the_permalink() ?>" class="link_2">Подробнее</a></div>
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