<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper">

		<?php if (have_posts()) : ?>


		<?php while (have_posts()) : the_post(); ?>
<div class="boxs post" id="post-<?php the_ID(); ?>"><div class="contents">
	<div class="article-item_2" id="bx_651765591_421">
		<a href="<?php the_permalink() ?>" class="img_2"><?php echo get_the_post_thumbnail(); ?></a>
		<div class="info_2">
			<a href="<?php the_permalink() ?>" class="title_2" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<div class="age"><?php echo CFS()->get( 'age' );?></div>
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
<div class="block2">
	<h2>Для нас важно то же, что и для вас</h2>
	
	<div class="plus-items">
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/home.png" />
				</div>
				<b>Место</b>. Новое здание, экологичные материалы, просторные комнаты, многофункциональное пространство. То, где мы занимаемся – тоже элемент нашего развития.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/books.png" />
				</div>
				<b>Программы</b>. У нас нет курсов «чтобы были», всё направлено на решение той или иной задачи, приобретение конкретных навыков. А ещё мы за комплексность и единую систему.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/security-camera.png" />
				</div>
				<b>Безопасность</b>. Здесь без компромиссов: охраняемая территория, видеонаблюдение, пропускная система.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/family.png" />
				</div>
				<b>К</b><b>урсы для всех возрастов. </b>Мы&nbsp;хотим, чтобы интересно и полезно было детям любого возраста, а также их родителям.			</div>
								<div class="plus-item">
				<div class="img">
					<img src="<?php bloginfo( 'template_url' ); ?>/img/mother.png" />
				</div>
				<b>Комфорт</b>. Мы подумали о каждом: у нас есть кофе и книги, комната мамы и малыша,  парковка, тёплый пол, домик под потолком и многое другое.			</div>
				
	</div>
</div>
		</div>
	</article>

<?php get_footer(); ?>