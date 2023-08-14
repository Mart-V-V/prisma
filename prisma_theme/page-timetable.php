<?php
/*
Template Name: Расписание занятий
Template Post Type: page
*/
?>
<?php include(TEMPLATEPATH."/header_2.php"); ?>

	<article>
		<div class="wrapper" align="center">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>" style="margin-top: 20px;">
		<p style="color: #707070; font-weight: bold;"><?php the_title(); ?></p>
        <p>

<?php 

global $wpdb;


// получаем переменные для анализа
$need_age = ( int ) (isset($_REQUEST['age'])) ? urldecode($_REQUEST['age']) : 0;
$need_day['Mon'] = (isset($_REQUEST['Mon'])) ? 1 : null;
$need_day['Tue'] = (isset($_REQUEST['Tue'])) ? 1 : null;
$need_day['Wed'] = (isset($_REQUEST['Wed'])) ? 1 : null;
$need_day['Thu'] = (isset($_REQUEST['Thu'])) ? 1 : null;
$need_day['Fri'] = (isset($_REQUEST['Fri'])) ? 1 : null;
$need_day['Sat'] = (isset($_REQUEST['Sat'])) ? 1 : null;
$need_day['Sun'] = (isset($_REQUEST['Sun'])) ? 1 : null;
$need_day = array_filter($need_day);


// формируем первичный запрос к базе данных
$main_sql = "
    SELECT wp_posts.ID, wp_posts.post_title, wp_terms.term_id, wp_posts.post_name as url, wp_terms.name as edu_type, 
        max(case when (wp_postmeta.meta_key='Mon') then wp_postmeta.meta_value else 0 end) as 'Mon', 
        max(case when (wp_postmeta.meta_key='Tue') then wp_postmeta.meta_value else 0 end) as 'Tue', 
        max(case when (wp_postmeta.meta_key='Wed') then wp_postmeta.meta_value else 0 end) as 'Wed', 
        max(case when (wp_postmeta.meta_key='Thu') then wp_postmeta.meta_value else 0 end) as 'Thu', 
        max(case when (wp_postmeta.meta_key='Fri') then wp_postmeta.meta_value else 0 end) as 'Fri', 
        max(case when (wp_postmeta.meta_key='Sat') then wp_postmeta.meta_value else 0 end) as 'Sat', 
        max(case when (wp_postmeta.meta_key='Sun') then wp_postmeta.meta_value else 0 end) as 'Sun', 
        max(case when (wp_postmeta.meta_key='AgeFrom') then wp_postmeta.meta_value else 0 end) as 'GlobalAgeFrom', 
        max(case when (wp_postmeta.meta_key='AgeTo') then wp_postmeta.meta_value else 0 end) as 'GlobalAgeTo', 
        max(case when (wp_postmeta.meta_key='JSONgroup') then wp_postmeta.meta_value else NULL end) as 'JSONgroup'
    FROM wp_posts 
    LEFT JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
    LEFT JOIN wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id
    LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
    LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
    WHERE wp_posts.post_type = 'services' 
        AND wp_posts.post_status = 'publish' 
        AND wp_term_taxonomy.taxonomy = 's_type'
    GROUP BY wp_posts.ID
";


// корректируем запрос, если есть выборки (возраст, дни недели)
if ( !empty($need_age) && !empty($need_day) ) {
    $new_sql = "SELECT * FROM (%main_sql%) AS total
        WHERE (".$need_age." >= GlobalAgeFrom AND ".$need_age." <= GlobalAgeTo) AND (";
    foreach($need_day as $day => $val){
        $new_sql .= $day . " = 1 OR ";
    }
    $new_sql .= ")";
    $main_sql = str_replace('%main_sql%', $main_sql, $new_sql);
    $main_sql = str_replace(' OR )', ')', $main_sql);
}elseif( !empty($need_age) ){
    $new_sql = "SELECT * FROM (%main_sql%) AS total
        WHERE ".$need_age." >= GlobalAgeFrom AND ".$need_age." <= GlobalAgeTo
    ";
    $main_sql = str_replace('%main_sql%', $main_sql, $new_sql);
}elseif( !empty($need_day) ){
    $new_sql = "SELECT * FROM (%main_sql%) AS total
        WHERE (";
    foreach($need_day as $day => $val){
        $new_sql .= $day . " = 1 OR ";
    }
    $new_sql .= ")";
    $main_sql = str_replace('%main_sql%', $main_sql, $new_sql);
    $main_sql = str_replace(' OR )', ')', $main_sql);
}
$new_posts = $wpdb->get_results($main_sql);



// добавляем к списку выбранных ЗАНЯТИЙ данные конкретных ГРУПП из JSON
$groups_array = array();
foreach ($new_posts as $data) {
    $data = (array) $data;
    $g_array = json_decode($data['JSONgroup'], true, 512, JSON_UNESCAPED_UNICODE);
    $g_array = (is_array($g_array)) ? $g_array : array();
    unset($data['JSONgroup']);
    
    /*
    if (empty($g_array)) {
        $groups_array[$data['term_id']][$data['ID']] = $data;
        continue;
    }
    */
    foreach ($g_array as $key => $val) {
        $n_key = $data['ID'].md5($key);
        $s_type = $val['s_type'];
        $groups_array[$s_type][$n_key] = array_merge($data,$g_array[$key]);
    }
}

// удаляем из списка ГРУПП ненужные на основании запроса
$week = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
foreach ($groups_array as $key => $value) {
    $rowspan = count($value);
    foreach ($value as $k => $v) {
        // активна ли группа?
        if (empty($v['is_active'])){
            unset($groups_array[$key][$k]);
        }
        
        // идет набор?
        //if ($v['is_nabor']){
        //    unset($groups_array[$key][$k]);
        //}
        
        // проверка количества рабочих дней
        $work_days = 0;
        foreach($week as $d){
            $work_days = (!empty($v[$d])) ? $work_days+1 : $work_days;
        }
        if (empty($work_days)){
            unset($groups_array[$key][$k]);
        }
        
        // проверки выборки по возрасту
        if (!empty($need_day) || !empty($need_age)){
            if (!empty($need_age)){
                if ($need_age > $v['ageto'] || $need_age < $v['agefrom']){
                    unset($groups_array[$key][$k]);
                }
            }
            if (!empty($need_day)){
                $good = 0;
                foreach($need_day as $day => $val){
                    if (!empty($groups_array[$key][$k][$day])){
                        $good =  1;
                    }
                }
                if ($good == 0){
                    unset($groups_array[$key][$k]);
                }
            }
        }
    }
}

// формируем строку для вывода таблицы
$groups_array = array_filter($groups_array);
if (!empty ($groups_array)) {
    $line = '';
    $i = 0;
    foreach ($groups_array as $key => $value) {
        $rowspan = count($value);
        foreach ($value as $k => $v) {
            $line .= (($i % 2) == 0) ? '<tr>' : '<tr class="second">';
            if ( $rowspan > 0 ) {
                $line .= '<td class="red" rowspan="'.$rowspan.'">'.get_term_by('id', $v['s_type'], 's_type')->name.'</td>';
            }
            
            $ageTo = (!empty($v['ageto'])) ? $v['ageto'] : '...';
            $age = (!empty($v['agefrom'])) ? '<br>Возраст: '.$v['agefrom'].'-'.$ageTo : '';
            $GroupName = (!empty($v['name'])) ? '<br>'.$v['name'] : '';
            
            $line .= '<td><a href="/services/'.$v['url'].'/" target="_blank">'.$v['post_title'].$GroupName.$age.'</a></td>';
          
            if (!empty($v['is_nabor'])){
                $line .= '<td colspan="7">Идет набор в группу.</td>';
            } else {
                $line .= '<td>'.$v['Mon'].'</td>';
                $line .= '<td>'.$v['Tue'].'</td>';
                $line .= '<td>'.$v['Wed'].'</td>';
                $line .= '<td>'.$v['Thu'].'</td>';
                $line .= '<td>'.$v['Fri'].'</td>';
                $line .= '<td>'.$v['Sat'].'</td>';
                $line .= '<td>'.$v['Sun'].'</td>';
            }
            
            $line .= '<td>'.$v['monthlyprice'].'</td>';
            $line .= '<td>'.$v['singleprice'].'</td>';
            $rowspan = 0;
            $line .= '</tr>';
            $i++;
        }
    }
}


wp_reset_query();

?>
<style>
.timetable a {text-decoration:underline;}
.timetable a:hover {text-decoration:none;}
.second{background:#ebf6f8;}
.red{background:#d80b8c;color:#fff;}
</style>      



<?php if (!empty($line)) : ?>
<table class="timetable">
    <tr>
        <th class="red">Вид занятий</th>
        <th class="red">Группы</th>
        <th class="red">Понедельник</th>
        <th class="red">Вторник</th>
        <th class="red">Среда</th>
        <th class="red">Четверг</th>
        <th class="red">Пятница</th>
        <th class="red">Суббота</th>
        <th class="red">Воскресенье</th>
        <th class="red" colspan="2">Стоимость</th>
    </tr>
    <?php echo $line; ?>
    <tr>
        <td class="red" colspan="11">Так же различные тематические мастер классы для детей и взрослых!</td>
    </tr>
</table>
<?php else: ?>
<p>К сожалению по вашему запросу ничего не найдено!</p>   
<?php endif; ?>               
				<?php //the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('до' => '<p><strong>Страница:</strong> ', 'после' => '</p>', 'next_or_number' => 'number')); ?>
				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</p>
		</div>
		<?php endwhile; endif; ?>

		</div>
	</article>
<?php get_footer(); ?>
