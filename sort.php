<?php 
$friends_text = get_field('home_friends_list', $page_id); 

$alphabet_ukr = array('а', 'б', 'в', 'г', 'ґ', 'д', 'е', 'є', 'ж', 'з', 'и', 'і', 'ї', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я');
$names_sort = sortNames($friends_text, $alphabet_ukr);

$names_sort_notempty = array();
foreach ($names_sort as $key_s => $value_s) {
	if(!empty($value_s)){
		array_push($names_sort_notempty, $key_s);
	}
}

$names_nav_chunk = array_chunk($names_sort_notempty, 5);
$names_nav = array();

foreach ($names_nav_chunk as $key_ch => $value_ch) {
	$key_names_arr = $value_ch[0] . '-' . $value_ch[count($value_ch) - 1];
	$names_nav[$key_names_arr] = $value_ch;
}


function sortNames($names, $alphabet){
  $names_tr = trim(preg_replace('/;\s+/', ';', $names));
  // echo $names_tr;
  $names_sp = explode(";", $names_tr);
  sort($names_sp);

  $result_arr = array();

  foreach ($alphabet as $key_a => $value_a) {
    $push_arr = array();
    
    foreach ($names_sp as $key_sp => $value_sp) {
      $first = mb_strtolower(mb_substr($value_sp, 0, 1));
      if($value_a == $first){
        array_push($push_arr, $value_sp);
      }
    }
    $result_arr[$value_a] = $push_arr;
  }

  return $result_arr;
}

?>
<div class="container">
	<div class="main-title" data-animation="fadeInUp">
		<h2><?php echo get_field('home_friends_title', $page_id); ?></h2>
	</div>

	<div class="friends-cont">
		<div class="friends-nav">
			<?php $nav_count = 0; ?>
			<?php foreach ($names_nav as $key_n => $value_n) { ?>
			<p <?php if($nav_count == 0){echo 'class="active"';} ?>><?php echo $key_n; ?></p>
			<?php $nav_count++; } ?>
		</div>
		<div class="friends-slides">
			<?php 
			$slide_count = 0;
			foreach ($names_nav as $key_nav => $value_nav) {
				?>
				<div class="friends-slide <?php if($slide_count == 0){echo 'active';} ?>">
					<?php
					foreach ($value_nav as $k_n => $v_n) {
						foreach ($names_sort as $key_sort => $value_sort) {
							if($v_n == $key_sort){
								?>
								<div class="letter-block">
									<p class="letter"><?php echo $key_sort; ?></p>
									<?php
									foreach ($value_sort as $k_sort => $v_sort) {
										?>
										<p><?php echo $v_sort; ?></p>
										<?php 
									}
									?>
								</div>
								<?php
							}
						}
					}
					?>
				</div>
				<?php
				$slide_count++; }
				?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>