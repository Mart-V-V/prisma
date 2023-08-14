		<?php if (is_category(1)) : ?>
			<?php include(TEMPLATEPATH."/archive_news.php");?>
		<?php  elseif( is_category(10) ) : ?>	
			<?php include(TEMPLATEPATH."/archive_services.php");?>
		<?php  elseif( is_category(11) ) : ?>	
			<?php include(TEMPLATEPATH."/archive_team.php");?>
		<?php  elseif( is_category(12) ) : ?>	
			<?php include(TEMPLATEPATH."/archive_discounts.php");?>
		<?php  elseif( is_category(13) ) : ?>	
			<?php include(TEMPLATEPATH."/archive_online.php");?>
		<?php  elseif( is_category(14) ) : ?>	
			<?php include(TEMPLATEPATH."/archive_reviews.php");?>
		<?php endif; ?>