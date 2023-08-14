<!--div class="left_block">
	<a href="#" class="mrow"><img src="/wp-content/themes/prisma_theme/img/menu_list/burger.png">Меню</a>
	<table cellpadding="0" cellspacing="0" class="menu-list">
		<tr>
			<td><a href="/services/onlayn-kursy/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/1.png" align="absmiddle"></a><a href="/services/onlayn-kursy/">Онлайн курсы</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/podgotovka-k-shkole/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/2.png" align="absmiddle"></a><a href="/services/podgotovka-k-shkole/">Подготовка к школе</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/holidays/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/3.png" align="absmiddle"></a><a href="/services/holidays/">Каникулы</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/robototekhnika/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/4.png" align="absmiddle"></a><a href="/services/robototekhnika/">Робототехника</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/tekhnicheskie-inzhenernye-it/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/5.png" align="absmiddle"></a><a href="/services/tekhnicheskie-inzhenernye-it/">Инженерные и IT</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/zanyatiya-dlya-shkolnikov/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/6.png" align="absmiddle"></a><a href="/services/zanyatiya-dlya-shkolnikov/">Клуб дневного пребывания</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/mini-sad/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/7.png" align="absmiddle"></a><a href="/services/mini-sad/">Мини-сад</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/prazdnik-v-prizme/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/8.png" align="absmiddle"></a><a href="/services/prazdnik-v-prizme/">Праздник в Призме</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/rannee-razvitie/" class="img"><img src="/wp-content/themes/prisma_theme//img/menu_list/9.png" align="absmiddle"></a><a href="/services/rannee-razvitie/">Раннее развитие</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/creative/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/10.png" align="absmiddle"></a><a href="/services/creative/">Творческие занятия </a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/izuchenie-yazykov/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/11.png" align="absmiddle"></a><a href="/services/izuchenie-yazykov/">Языковые группы</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/studiya-spektr/" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/12.png" align="absmiddle"></a><a href="/services/studiya-spektr/">Индивидуально</a>
			</td>
		</tr>
		<tr>
			<td><a href="/services/?age=5" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/13.png" align="absmiddle"></a><a href="/services/?age=5">Родительский клуб</a>
			</td>
		</tr>
	</table>
</div-->


<?php
    // вывод меню слева
    $menu = wp_nav_menu([
        'theme_location' => '',
        'menu' => 'left_menu',
        'container' => 'div',
        'container_class' => 'left_block',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => false,
        'fallback_cb' => 'wp_page_menu',
        'before' => '<tr><td><a href="%href%" class="img"><img src="/wp-content/themes/prisma_theme/img/menu_list/%img_id%.png" align="absmiddle"></a>',
        'after' => '</td><tr>',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<a href="#" class="mrow"><img src="/wp-content/themes/prisma_theme/img/menu_list/burger.png">Меню</a>
        <table cellpadding="0" cellspacing="0" class="menu-list">%3$s</table>',
        'depth' => 1,
        'walker' => '',
    ]);

$menu = preg_replace('/<li(.*)><tr><td>/', '<tr><td>', $menu);
$menu = str_replace('</li></td><tr>', '</td><tr>', $menu);
$lines_array = array_filter(explode("\n", $menu));
$i = 1;

foreach ($lines_array as $key => $line) {
    if ($i > 13) {
        $i = 1;
    }

    preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $line, $href);
    $line = ($href[2][1]) ? str_replace('%href%', $href[2][1], $line) : $line;
    $lines_array[$key] = trim(str_replace('%img_id%', (string) $i, $line));
    if (strripos($line, '%img_id%') === false) {
        continue;
    }
    $i++;
}

// print_r($lines_array); exit;
print_r(implode($lines_array));
?>
