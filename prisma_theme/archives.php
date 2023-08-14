<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper">

		<h2>Архив за месяц:</h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		
		<h2>Архив:</h2>
			<ul>
				 <?php wp_list_categories(); ?>
			</ul>
			
		</div>
	</article>

<?php get_footer(); ?>