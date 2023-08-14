		<?php if ( is_page('9') ) : ?>
			<?php include(TEMPLATEPATH."/page_about.php");?>
		<?php  elseif( is_page('139') ) : ?>
			<?php include(TEMPLATEPATH."/page_rasp.php");?>
		<?php  elseif( is_page('10') ) : ?>
			<?php include(TEMPLATEPATH."/page_cont.php");?>
		<?php  else : ?>	
			<?php include(TEMPLATEPATH."/page_all.php");?>
		<?php endif; ?>