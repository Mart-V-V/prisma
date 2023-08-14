<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper">

	<?php if (have_posts()) : ?>

		<h2>Результаты поиска</h2>


		<?php while (have_posts()) : the_post(); ?>

			<div class="post">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				<p>
					<?php the_content('Подробнее &rarr;'); ?>
				</p>

				<p class="postmetadata"><?php if (function_exists('the_tags')) { the_tags('Тэги: ', ', ', '<br/>'); } ?>Статья <?php the_category(', ') ?> <?php edit_post_link('Редактировать', ' | ', ''); ?> </p>
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

		</div>
	</article>

<?php get_footer(); ?>