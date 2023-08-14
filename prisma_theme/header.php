<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name="keywords" content="" />
<meta name="description" content="" />

<title><?php wp_title('&laquo;', true, 'right'); ?></title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php bloginfo( 'template_url' ); ?>/img/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/script.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<?php wp_head(); ?>

</head>
<body>
<div class="full-page">
<div class="full-page_2">
    <div class="header">
        <div class="header_left"><a href="/"><img src="<?php bloginfo( 'template_url' ); ?>/img/logo_1.png"></a></div>
        <div class="header_right">
            <div class="header_menu-top">
                <div class="btn_grad mobile-burger"><span></span></div>
				<?php wp_nav_menu('menu=top_menu_1'); ?>
                <div class="mobile">
                    <div class="btn_grad mobile-burger"><span></span></div>
                    <a href="/" class="logo"><img src="<?php bloginfo( 'template_url' ); ?>/img/logo_1.png"></a>
                    <?php include(TEMPLATEPATH."/mob_menu.php");?>
                    <div class="soc_ico">
                        <a href=""><img src="<?php bloginfo( 'template_url' ); ?>/img/whats.png"></a>
                        <a href=""><img src="<?php bloginfo( 'template_url' ); ?>/img/teleg.png"></a>
                        <a href=""><img src="<?php bloginfo( 'template_url' ); ?>/img/vk.png"></a>
                        <a href=""><img src="<?php bloginfo( 'template_url' ); ?>/img/yout.png"></a>
                    </div>
                    <a href="tel:+79955002442" class="mob_phone">+7 (995) 500-24-42</a>
                    <a href="" class="btn_grad">Заказать звонок</a>
                </div>
            </div>
            <div class="header_contact">
                <div>
                    <a href="tel:+79955002442">+7 (995) 500-24-42</a>
                </div>
                <div>
                    <a href=""><img src="<?php bloginfo( 'template_url' ); ?>/img/whats.png"></a>
                    <a href="" class="btn_grad">Заказать звонок</a>
                </div>
            </div>
        </div>
    </div>

