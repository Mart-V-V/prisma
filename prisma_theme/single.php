		<?php if (in_category(1)) : ?>
			<?php include(TEMPLATEPATH."/single_news.php");?>
		<?php  elseif( in_category(10) ) : ?>	
			<?php include(TEMPLATEPATH."/single_services.php");?>
		<?php  elseif( in_category(11) ) : ?>	
			<?php include(TEMPLATEPATH."/single_team.php");?>
		<?php  elseif( is_category(12) ) : ?>	
			<?php include(TEMPLATEPATH."/single_news.php");?>
		<?php  elseif( is_category(13) ) : ?>	
			<?php include(TEMPLATEPATH."/single_news.php");?>
		<?php  elseif( is_category(14) ) : ?>	
			<?php include(TEMPLATEPATH."/single_news.php");?>
		<?php endif; ?>