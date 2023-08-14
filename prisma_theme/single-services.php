<?php include(TEMPLATEPATH."/header_2.php");?>

	<article>
		<div class="wrapper" align="left">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
    // функция для вывода таблицы групп, если они есть
    function show_groups() {
        $empty_msg = '<p>У занятия нет групп для отображения.</p>';
        $json = get_post_meta(get_the_ID(), 'JSONgroup', true);
        $groups = json_decode($json);
        if (!is_object($g_array)) {
        //    return null;
        }
        if (empty($groups)){
            return $empty_msg;
        }
        $table_line = '';
        $i=0;
        foreach ($groups as $group) {
            if (!($group->is_active)){
                continue;
            }
            $table_line .= (($i % 2) == 0) ? '<tr>' : '<tr class="second">';
            $table_line .= '<td>'
                . '<b>' . $group->name . '</b><br>'
                . $group->description . '<br>'
                . ( ($group->is_nabor) ? 'Сейчас идёт набор!' : 'Набора нет!' ) . '<br>'
                . 'Возраст: от ' . $group->agefrom . ' до ' . $group->ageto .'<br>'
                . 'Локация: <a href="/services/place/' . get_term_by('id', $group->location, 's_place')->slug . '/">' . get_term_by('id', $group->location, 's_place')->name . '</a><br>'
                . 'Тип группы: ' . get_term_by('id', $group->s_type, 's_type')->name . '</a><br>'
            .'</td>';
            
            $table_line .= '<td>'. $group->Mon .'</td>';
            $table_line .= '<td>'. $group->Tue .'</td>';
            $table_line .= '<td>'. $group->Wed .'</td>';
            $table_line .= '<td>'. $group->Thu .'</td>';
            $table_line .= '<td>'. $group->Fri .'</td>';
            $table_line .= '<td>'. $group->Sat .'</td>';
            $table_line .= '<td>'. $group->Sun .'</td>';
            
            $table_line .= '<td>'. $group->monthlyprice .'</td>';
            $table_line .= '<td>'. $group->singleprice .'</td>';
            
            //is_nabor
            $table_line .= '</tr>';
            $i++;
        }
        
        if (empty($table_line)){
            return $empty_msg;
        }
        
        $table_line = '<table class="timetable">
        <tr>
            <th class="red">Название</th>
            
            <th class="red">Понедельник</th>
            <th class="red">Вторник</th>
            <th class="red">Среда</th>
            <th class="red">Четверг</th>
            <th class="red">Пятница</th>
            <th class="red">Суббота</th>
            <th class="red">Воскресенье</th>
            
            <th class="red">Цена за месяц</th>
            <th class="red">Цена занятия</th>
        </tr>'.$table_line.'</table>';
        
        return $table_line;
    }
    ?>
		<div class="service-info" id="post-<?php the_ID(); ?>" style="padding-left: 10px; margin-top: 40px;">
				<h2 class="h2"><?php the_title(); ?></h2>
				<div class="article-detail"><?php the_content(); ?><?php echo show_groups(); ?></div>
		</div>


<?php endwhile; else: ?>
<br>
<p>К сожалению страница не найдена</p>
<p><a href="/">Вернуться на главную</a></p>

<?php endif; ?> 

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
