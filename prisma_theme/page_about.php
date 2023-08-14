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

<div class="block2">
	<h2>Почему мы</h2>
	
	<div class="plus-items">
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/home.png" />
				</div>
				<b>Место</b>Новое здание, экологичные материалы, просторные комнаты, многофункциональное пространство. То, где мы занимаемся – тоже элемент нашего развития.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/books.png" />
				</div>
				<b>Программы</b>У нас нет курсов «чтобы были», всё направлено на решение той или иной задачи, приобретение конкретных навыков. А ещё мы за комплексность и единую систему.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/security-camera.png" />
				</div>
				<b>Безопасность</b>Здесь без компромиссов: охраняемая территория, видеонаблюдение, пропускная система.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/family.png" />
				</div>
				<b>Курсы для всех возрастов</b>Мы&nbsp;хотим, чтобы интересно и полезно было детям любого возраста, а также их родителям.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/mother.png" />
				</div>
				<b>Комфорт</b>Мы подумали о каждом: у нас есть кофе и книги, комната мамы и малыша,  парковка, тёплый пол, домик под потолком и многое другое.			</div>
				
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