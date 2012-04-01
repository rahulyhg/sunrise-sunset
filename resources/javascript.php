<?php $directory_resources = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));?>
<link rel="stylesheet" href="<?=$directory_resources?>colorpicker/css/colorpicker.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="<?=$directory_resources?>colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=$directory_resources?>colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=$directory_resources?>colorpicker/js/utils.js"></script>
<script type="text/javascript">
	var aff_code = '';
	$(document).ready(function(){
		aff_code = $('#bga_oh_api_key');
		$('#bga_border_color').keyup(function(){
			$('#bga_colorSelector1 div').css('backgroundColor', '#' + $(this).val());
		})
		$('#bga_background_color').keyup(function(){
			$('#bga_colorSelector2 div').css('backgroundColor', '#' + $(this).val());
		})
		$('#bga_link_color').keyup(function(){
			$('#bga_colorSelector3 div').css('backgroundColor', '#' + $(this).val());
		})
		$('#bga_text_color').keyup(function(){
			$('#bga_colorSelector4 div').css('backgroundColor', '#' + $(this).val());
		})
		$('#bga_url_color').keyup(function(){
			$('#bga_colorSelector5 div').css('backgroundColor', '#' + $(this).val());
		})
		$('#bga_colorSelector5').ColorPicker({
			color: '#<?=$values->bga_url_color?>',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#bga_colorSelector5 div').css('backgroundColor', '#' + hex);
				$('#bga_url_color').val(hex);
			},
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).ColorPickerHide();
			}
		});
		$('#bga_colorSelector4').ColorPicker({
			color: '#<?=$values->bga_text_color?>',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#bga_colorSelector4 div').css('backgroundColor', '#' + hex);
				$('#bga_text_color').val(hex);
			},
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).ColorPickerHide();
			}
		});
		$('#bga_colorSelector3').ColorPicker({
			color: '#<?=$values->bga_link_color?>',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#bga_colorSelector3 div').css('backgroundColor', '#' + hex);
				$('#bga_link_color').val(hex);
			},
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).ColorPickerHide();
			}
		});
		$('#bga_colorSelector2').ColorPicker({
			color: '#<?=$values->bga_background_color?>',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#bga_colorSelector2 div').css('backgroundColor', '#' + hex);
				$('#bga_background_color').val(hex);
			},
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).ColorPickerHide();
			}
		});
		$('#bga_colorSelector1').ColorPicker({
			color: '#<?=$values->bga_border_color?>',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#bga_colorSelector1 div').css('backgroundColor', '#' + hex);
				$('#bga_border_color').val(hex);
			},
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).ColorPickerHide();
			}
		});
		
		$('#bga_form_save2, #bga_form_save1, #bga_form_save3').click(function() {
			saveAll();
		  	return false;
		});
		$('#bga_reset_colors').click(function(){
			var colors = {};
			$.data(colors,'bga_border_color','FFFFFF')
			$.data(colors,'bga_background_color','FFFFFF')
			$.data(colors,'bga_link_color','0000FF')
			$.data(colors,'bga_text_color','000000')
			$.data(colors,'bga_url_color','008000')
			$.each($.data(colors), function(k,v){
				$('#'+k).val(v);	
			});
			$('#bga_border_color, #bga_background_color, #bga_link_color, #bga_text_color, #bga_url_color, ').keyup();		
		});
		$('#oh_show').click(function(){
			$(this).hide();
			$('#bga_oh').show();
			$('#oh_hide').show();
		});
		$('#oh_hide').click(function(){
			$(this).hide();
			$('#bga_oh').hide();
			$('#oh_show').show();
		});
		$('#ads_show').click(function(){
			$(this).hide();
			$('#bga_ads').show();
			$('#ads_hide').show();
		});
		$('#ads_hide').click(function(){
			$(this).hide();
			$('#bga_ads').hide();
			$('#ads_show').show();
		});
		$('.bga_checkbox').change(function(){
			verifyCheckboxes();
		});
		verifyCheckboxes();
		$('#bga_language').change(function(){
			$.post("/wp-content/plugins/best-google-adsense/ajax.php",{
			action: 'change_language',
			bga_language: $('#bga_language').val()
			} ,
			function(data){
				if(data.STATUS == 'ok')
					location.href = window.location.pathname+'?page=Best-Google-Adsense';
				else
					alert('<?=$trans['0066']?>');
			 }		
		, "json");	
		});
	});
	function saveAll(){
		//buttons and loaders
		btn = $('#bga_form_save1, #bga_form_save2, #bga_form_save3');
		loader = $('#bga_form_save1_loader, #bga_form_save2_loader, #bga_form_save3_loader');
		btn.hide();
		loader.show();
		
		
		//General Settings Adsense
		$.post("/wp-content/plugins/best-google-adsense/ajax.php",{
			action: 'save_bga_ads_general_settings',
			bga_ads_id: $('#bga_ads_id').val(),
			bga_ads_chanel: $('#bga_ads_chanel').val()
			} ,
			function(data){
				if(data.STATUS != 'ok'){
					if(data.ERROR_MESSAGE=='wrong_api_key')
						alert('<?=$trans['0064']?>');
					else
						alert('<?=$trans['0066']?>');
				}
				btn.show();
				loader.hide();
			 }		
		, "json");
		
		
		//Print Settings
		values_s = $('#bga_form_print_settings').serialize();
		$.post("/wp-content/plugins/best-google-adsense/ajax.php",{
			action: 'save_bga_print_settings',
			values: values_s
			} ,
			function(data){
				if(data.STATUS != 'ok'){
					alert('<?=$trans['0066']?>');
				}
			 }		
		, "json");
		
	}
	
	function verifyCheckboxes(){
		flag=0;
		$(".bga_checkbox").each(function(){
			temp = $(this).attr('checked');
			if	(temp==true)
				flag=1;
		});
		if (flag==0)
			$('#bga_label_ai_468_60').attr('checked', 'true');
	}	
</script>
