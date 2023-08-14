<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" align="left">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="service-info" id="post-<?php the_ID(); ?>" style="padding-left: 10px; margin-top: 40px;">
				<h2 class="h2"><?php the_title(); ?></h2>
				<div class="article-detail"><?php the_content(); ?></div>
		</div>


<?php endwhile; else: ?>
<br>
<p>К сожалению страница не найдена</p>
<p><a href="/">Вернуться на главную</a></p>

<?php endif; ?>


<div class="question-block3">
	<div class="wrapper" align="center">
		<div class="question-form" align="left">
			<h2>Цена</h2>
			<?php echo do_shortcode("[contact-form-7 id=153]"); ?>				
		</div>
	</div>
</div> 

<div class="question-block">
	<div class="wrapper" align="center">
		<div class="question-form" align="left">
			<h2>Задать вопрос</h2>
			<?php echo do_shortcode("[contact-form-7 id=143]"); ?>				
		</div>
	</div>
</div> 

		</div>
	</article>

<?php get_footer(); ?>