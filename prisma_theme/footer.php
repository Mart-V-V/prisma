	<footer>
	<div class="fbg">

			<div class="foot_1"><?php include(TEMPLATEPATH."/counter.php");?><div class="mob2"><?php include(TEMPLATEPATH."/contact.php");?></div></div>
			<div class="foot_2"><?php include(TEMPLATEPATH."/foot_1.php");?></div>

		<div class="foot_3"><?php include(TEMPLATEPATH."/foot_2.php");?></div>
		<div class="foot_4"><div class="mob"><?php include(TEMPLATEPATH."/contact.php");?></div></div>
	</div>
	</footer>

<?php wp_footer(); ?>


<div class="carOverlay_black" id="ban">
<table class="car_all_bg" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tr valign="top">
            <td class="td_car" valign="middle" align="center">
<a class="closed" onclick="banner(0);"><img src="/images/closed.png" alt="" width="20" height="20" /></a>
<div class="callme">
<?php echo do_shortcode("[contact-form-7 id=142]"); ?>
</div>
            </td>
        </tr>
</table>
</div>

</body>
</html>