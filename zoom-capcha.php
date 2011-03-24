<?php
/*
Plugin Name: DZS Comments Capcha Plugin
Plugin URI: http://digitalzoomstudio.net/
Description: Creates a capcha box in the comments to prevent unwanted spam.
Version: 1.1
Author: Digital Zoom Studio
Author URI: http://digitalzoomstudio.net/
*/

//Plugin Path
$WPZpath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

add_action('init', 'wpz_init');
add_action('wp_footer','wpz_footer');

add_action('wp_ajax_capcha_ajax', 'wpz_capcha_ajax');



add_action('comment_form', 'zs01_comment_form', 1);
function zs01_comment_form(){
    ?>

<div class="capcha-div"><img src=""/><br><input type="text" class="capcha-text" name="dzs_capcha_text"></input></div>
<input type="hidden" class="capcha-text-nr" name="dzs_capcha_nr"></input>
<script>
jQuery(document).ready(function(){

var randomNr = parseInt(Math.random()*4);
var auxsrc="<?php global $WPZpath; echo $WPZpath; ?>img/"+randomNr+".jpg";
jQuery('.capcha-div img').attr('src', auxsrc);
jQuery('.capcha-text-nr').val(randomNr);
})
</script>
<?php
}


  $capchaId = get_option("wpz_capchaid");
  if($capchaId=='')
  $capchaId="submit";
  
function wpz_capcha_ajax() {
	global $wpdb; // this is how you get access to the database

	$capchaId = $_POST['capchaId'];
      update_option("wpz_capchaid",$capchaId);
        echo $capchaId;

	die();
}

function wpz_init(){
wp_enqueue_script( 'jquery');

$arr = array(0 => "8906", 1 => "45723", 2 => "1764", 3 => "9407");
if(isset($_POST['dzs_capcha_text'])){
    if($arr[$_POST['dzs_capcha_nr']] == $_POST['dzs_capcha_text']){

    }
    else
        wp_die('revise capcha value');
}
}

?>