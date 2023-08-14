<?php
/*
Template Name: Категории занятий
Template Post Type: page
*/
?>
<?php include(TEMPLATEPATH."/header_2.php"); ?>

	<article>
		<div class="wrapper" align="center">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
    // меню в виде категорий
    $for_first_page = wp_nav_menu( [
        'menu'            => 'for_servises_page',
        'echo'            => false,
        'depth'           => 1,
    ] );
    
    
    // real-illumination.ru/
    
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
                
                
				<?php //the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('до' => '<p><strong>Страница:</strong> ', 'после' => '</p>', 'next_or_number' => 'number')); ?>
				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</p>
		</div>
		<?php endwhile; endif; ?>

		</div>
	</article>
<?php get_footer(); ?>
