<?php get_header(); ?>
		<div class="banner" align="center">
<?php echo do_shortcode("[swiper-js-slider id=114]"); ?>
		</div>

	<article>
		<div class="cats">
			<span nowrap="" style="display: inline-block;"><a href="/services/?age=1" class="cat-item b1"><span class="b11"></span><b>от 7 мес до 3 лет</b><span class="b12"></span></a>&nbsp;<a href="/services/?age=2" class="cat-item b2"><span class="b21"></span><b>от 3 до 5 лет</b><span class="b22"></span></a></span>
			<span nowrap="" style="display: inline-block;"><a href="/services/?age=3" class="cat-item b3"><span class="b31"></span><b>От 5 до 7 лет</b><span class="b32"></span></a>&nbsp;<a href="/services/?age=4" class="cat-item b4"><span class="b41"></span><b>От 7 до 17 лет</b><span class="b42"></span></a></span>
		</div>
		<div class="wrapper">

        <?php if (have_posts()) : ?>
        
<style>
.eduFormSelect {
  display:block;
  width:80%;
  float:left;
  margin: 30px 0;
  padding 20px 0;
  border:1px solid #000;
}
.formBegin {
  width:100%;
  float:left;
}
.getAge {
  width:250px;
  float:left;
}
.weekDays-selector {
  width:500px;
  float:left;
}
.formButton {
  width:100px;
  float:left;
}
.weekDays-selector input {
  display: none!important;
}

.weekDays-selector input[type=checkbox] + label {
  display: inline-block;
  border-radius: 6px;
  background: #dddddd;
  height: 40px;
  width: 30px;
  margin-right: 3px;
  line-height: 40px;
  text-align: center;
  cursor: pointer;
}

.weekDays-selector input[type=checkbox]:checked + label {
  background: #2AD705;
  color: #ffffff;
}
</style>
<div class="eduFormSelect">
<h1>Подобрать занятия</h1>
<div class="formBegin">
    <form method='get' action="/timetable/">
    <div class="getAge"><label for="age">Возраст<input type="text" id="age" name="age" value="1" /></label></div>
    <div class="weekDays-selector">
        <input type="checkbox" id="Mon" name="Mon" class="weekday" /><label for="Mon">Пн</label>
        <input type="checkbox" id="Tue" name="Tue" class="weekday" /><label for="Tue">Вт</label>
        <input type="checkbox" id="Wed" name="Wed" class="weekday" /><label for="Wed">Ср</label>
        <input type="checkbox" id="Thu" name="Thu" class="weekday" /><label for="Thu">Чт</label>
        <input type="checkbox" id="Fri" name="Fri" class="weekday" /><label for="Fri">Пт</label>
        <input type="checkbox" id="Sat" name="Sat" class="weekday" /><label for="Sat">Сб</label>
        <input type="checkbox" id="Sun" name="Sun" class="weekday" /><label for="Sun">Вс</label>
    </div>
    <div class="formButton"><input type="submit" class="button" value="Подобрать"  /></div>
    </form>
</div>
</div>
<?php
    // меню в виде категорий
    $for_first_page = wp_nav_menu( [
        'menu'            => 'for_first_page',
        'echo'            => false,
        'depth'           => 1,
    ] );
    
    // темплейт для подмены верстки меню
    $template = '<div class="boxs post"><div class="contents"><div class="article-item_2"><a href="%permalink%" class="img_2">%image%</a>
<div class="info_2"><a href="%permalink%" class="title_2" >%title%</a>
<div class="ln_2"><a href="%permalink%" class="link_2">Подробнее</a></div></div></div></div></div>';
  
    // разбираем меню на строки
    $lines_array = array_filter(explode("\n", $for_first_page));
    $lines = '';
    foreach ($lines_array as $key => $line) {
        preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $line, $href);
        
        $permalink = $href[2][0];
        $tax_slug  = trim(basename($permalink));
        $id        = term_exists($tax_slug);
        
        if ( $id ) {
            $line = $template;
            $taxonomy = get_term( $id );
            $img = (strpos(get_taxonomy_image( $id ), 'http') !== false) ? get_taxonomy_image( $id, true ) : '';
           
            $line = str_replace('%permalink%', $permalink, $line);
            $line = str_replace('%title%', $taxonomy->name, $line);
            $line = str_replace('%image%', $img, $line);
            
            $lines .= $line."\n";
        }
    }
    print_r($lines);

?>
</div>
<div class="wrapper">
         <?php query_posts(array(
         'post_type' => 'news',
         'post_status' => 'publish',
         'posts_per_page' => 8, ));
         ?>

         <?php while (have_posts()) : the_post(); ?>

<div class="boxs post" id="post-<?php the_ID(); ?>"><div class="contents">
	<div class="article-item a1" id="bx_651765591_421">
        <?php if (empty(get_post_meta(get_the_ID(), 'news_no_date', true))) { ?>
            <span class="news_date"><?php echo get_the_date(); ?></span>
        <?php } ?>
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
		
