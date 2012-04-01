<div class="wrap">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) {return;}
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<h2><?php echo NAME; ?>  - <?php _e('Settings','best-google-adsense');?></h2>
	<div class="postbox-container" style="width:69%;">
		<div class="metabox-holder">	
			<div class="meta-box-sortables">
			
				<!--Google Adsense Configurations-->
				
				<div id="" class="postbox">
					<div class="handlediv" title="Click to toggle">
						<div class="submit" id="ads_hide">
							<br/>
						</div>
						<div class="submit" id="ads_show">
							<br/>
						</div>
					</div>
					<h3 class="hndle" style="cursor:default;"><span><?php _e( 'Google Adsense Settings' , 'best-google-adsense' );?></span></h3>
					<div class="inside" id="bga_ads">
						
						<div id="bga_ads_cp" class="gray_box">
							<h4><?php _e( 'Settings' , 'best-google-adsense' );?></h4>
							<div class="inside">
								<table cellspacing="0">
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Adsense ID' , 'best-google-adsense' );?></div>
											<?php if(!get_option('bga_ads_id')){ ?>
												<p class="explain alert rounded"><?php _e( 'To display ads from Google Adsense is required to enter your Adsense ID. Your ID can be found in your <a href="https://www.google.com/adsense">Adsense panel</a> on the "Home" tab and in the sidebar "Account Settings". Eg: pub-4268725654361605' , 'best-google-adsense' );?></p>
											<?php }else {?>
												<p class="explain"><?php _e( 'Adsense ID is the unique identifier of your account at Google Adsense.' , 'best-google-adsense' );?></p>
											<?php } ?>
										</td>
										<td valign="top">
											<input type="text" size="40" name="bga_ads_id" id="bga_ads_id" value="<?=get_option('bga_ads_id')?>"/>
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Custom Channels <span class="optional">(Optional)</span>' , 'best-google-adsense' );?></div>
											<p class="explain"><?php _e( 'Allows you to define groups of ads for better tracking.' , 'best-google-adsense' );?></p>
										</td>
										<td valign="top">
											<input type="text" size="40" name="bga_ads_chanel" id="bga_ads_chanel" value="<?=get_option('bga_ads_chanel')?>"/> 
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div style="text-align:right;margin-top:5px;">
							<span class="submit" id="bga_form_save1_loader" style="display:none">
								<img src="/wp-admin/images/wpspin_light.gif"> <?php _e( 'Wait' , 'best-google-adsense' );?>...
							</span>
							<input class="button-primary" id="bga_form_save1" type="button" value="<?php _e( 'Save Changes' , 'best-google-adsense' );?>" style="padding:1px 3px;"> 
						</div>
					</div>
				</div>	
				
				<!--Print Settings-->
				<div class="fb-like" data-href="http://wordpress.org/extend/plugins/best-google-adsense/" data-send="true" data-width="450" data-show-faces="true"></div>
				<div id="" class="postbox">
					<div class="handlediv" title="Click to toggle">
						<div class="submit" id="ads_hide">
							<br/>
						</div>
						<div class="submit" id="ads_show">
							<br/>
						</div>
					</div>
					<h3 class="hndle" style="cursor:default;"><span><?php _e( 'General Settings' , 'best-google-adsense' );?></span></h3>
					<div class="inside" id="bga_ads">
						
						<div id="bga_ads_cp" class="gray_box">
							<form name="bga_form_print_settings" id="bga_form_print_settings" method="" action="">
							<?php
								$values = json_decode(get_option('bga_print_settings'));
							?>
							<h4><?php _e( 'Display Configuration' , 'best-google-adsense' );?></h4>
							<div class="inside">
								<table cellspacing="0">
									<tr>
										<td width="50%"><div class="field_label"><?php _e( 'Border' , 'best-google-adsense' );?></div></td>
										<td>
											<select name="bga_corner" id="bga_corner">
												<option value="normal" <?php if($values->bga_corner=='normal')echo "selected='selected'";?>><?php _e( 'Normal' , 'best-google-adsense' );?></option>
												<option value="rounded" <?php if($values->bga_corner=='rounded')echo "selected='selected'";?>><?php _e( 'Rounded' , 'best-google-adsense' );?></option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td><div class="field_label"><?php _e( 'Ad size' , 'best-google-adsense' );?></div>
											<p class="explain">
												<?php _e( 'Choose more than one to display random. <br /> (Width x Height)' , 'best-google-adsense' );?>
											</p>
										</td>
										<td>
											<table>
												<tr>
													<td>
														<INPUT TYPE=CHECKBOX NAME="bga_c234x60" id="bga_label_ai_234_60" class='bga_checkbox' <?php if($values->bga_c234x60=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_234_60">234x60</label><BR>
														<INPUT TYPE=CHECKBOX NAME="bga_c468x60" id="bga_label_ai_468_60" class='bga_checkbox' <?php if($values->bga_c468x60=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_468_60">468x60</label><BR>												
														<INPUT TYPE=CHECKBOX NAME="bga_c728x90" id="bga_label_ai_728_90" class='bga_checkbox' <?php if($values->bga_c728x90=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_728_90">728x90</label><BR>
													</td>
													<td>
														<INPUT TYPE=CHECKBOX NAME="bga_c120x600" id="bga_label_ai_120_600" class='bga_checkbox' <?php if($values->bga_c120x600=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_120_600">120x600</label><BR>
														<INPUT TYPE=CHECKBOX NAME="bga_c160x600" id="bga_label_ai_160_600" class='bga_checkbox' <?php if($values->bga_c160x600=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_160_600">160x600</label><BR>
														<INPUT TYPE=CHECKBOX NAME="bga_c120x240" id="bga_label_ai_120_240" class='bga_checkbox' <?php if($values->bga_c120x240=='on')echo "checked='checked'"; ?>><label for="bga_label_ai_120_240">120x240</label><BR>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td><div class="field_label"><?php _e( 'Colors' , 'best-google-adsense' );?> <input class="button" type="button" value="Restaurar valores" id="bga_reset_colors" style="padding:1px 3px;"></div> 
											<p class="explain"></p>
											
										</td>
										<td >
											<table>
												<tr>
													<td><div class="field_label"><?php _e( 'Border color' , 'best-google-adsense' );?></div></td>
													<td>
														#<input type="text" name="bga_border_color" id="bga_border_color" size="6" value="<?=$values->bga_border_color?>"/></td><td><div class="colorSelector" id="bga_colorSelector1"><div style="background-color: #<?=$values->bga_border_color?>"></div></div></td>
												</tr>
												<tr>
													<td><div class="field_label"><?php _e( 'Background color' , 'best-google-adsense' );?></div></td>
													<td>#<input type="text" name="bga_background_color" id="bga_background_color" size="6" value="<?=$values->bga_background_color?>"/></td><td><div class="colorSelector" id="bga_colorSelector2"><div style="background-color: #<?=$values->bga_background_color?>"></div></div></td>
												</tr>
												<tr>
													<td><div class="field_label"><?php _e( 'Link color' , 'best-google-adsense' );?></div></td>
													<td>#<input type="text" name="bga_link_color" id="bga_link_color" size="6" value="<?=$values->bga_link_color?>"/></td><td><div class="colorSelector" id="bga_colorSelector3"><div style="background-color: #<?=$values->bga_link_color?>"></div></div></td>
												</tr>
												<tr>
													<td><div class="field_label"><?php _e( 'Text color' , 'best-google-adsense' );?></div></td>
													<td>#<input type="text" name="bga_text_color" id="bga_text_color" size="6" value="<?=$values->bga_text_color?>"/></td><td><div class="colorSelector" id="bga_colorSelector4"><div style="background-color: #<?=$values->bga_text_color?>"></div></div></td>
												</tr>
												<tr>
													<td><div class="field_label"><?php _e( 'Url color' , 'best-google-adsense' );?></div></td>
													<td>
														#<input type="text" name="bga_url_color" id="bga_url_color" size="6" value="<?=$values->bga_url_color?>"/></td><td><div class="colorSelector" id="bga_colorSelector5"><div style="background-color: #<?=$values->bga_url_color?>"></div></div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Number of ads per Page' , 'best-google-adsense' );?></div>
										</td>
										<td>
											<select name="ads_per_page" id="ads_per_page">
												<option value="0" <?php if($values->ads_per_page==0) echo "selected='selected'" ?>>0</option>
												<option value="1" <?php if($values->ads_per_page==1) echo "selected='selected'" ?>>1</option>
												<option value="2" <?php if($values->ads_per_page==2) echo "selected='selected'" ?>>2</option>
												<option value="3" <?php if($values->ads_per_page==3) echo "selected='selected'" ?>>3</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Number of ads per Post' , 'best-google-adsense' );?></div>
										</td>
										<td>
											<select name="ads_per_post" id="ads_per_post">
												<option value="0" <?php if($values->ads_per_page==0) echo "selected='selected'" ?>>0</option>
												<option value="1" <?php if($values->ads_per_page==1) echo "selected='selected'" ?>>1</option>
												<option value="2" <?php if($values->ads_per_page==2) echo "selected='selected'" ?>>2</option>
												<option value="3" <?php if($values->ads_per_page==3) echo "selected='selected'" ?>>3</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td valign="top">
											<div class="field_label"><?php _e( 'Ad type' , 'best-google-adsense' );?></div>
										</td>
										<td>
											<select name="ads_type_ads" id="ads_type_ads">
												<option value="text" <?php if($values->ads_type_ads=='text') echo "selected='selected'" ?>><?php _e( 'Text' , 'best-google-adsense' );?></option>
												<option value="image" <?php if($values->ads_type_ads=='image') echo "selected='selected'" ?>><?php _e( 'Image' , 'best-google-adsense' );?></option>
												<option value="text_image" <?php if($values->ads_type_ads=='text_image') echo "selected='selected'" ?>><?php _e( 'Text & Image' , 'best-google-adsense' );?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Ad Placement' , 'best-google-adsense' );?></div>
										</td>
										<td>
											<select name="ads_positioning" id="ads_positioning">
												<option value="center" <?php if($values->ads_positioning == 'center') echo "selected='selected'" ?>><?php _e( 'Center' , 'best-google-adsense' );?></option>
												<option value="left" <?php if($values->ads_positioning == 'left') echo "selected='selected'" ?>><?php _e( 'Left' , 'best-google-adsense' );?></option>
												<option value="right" <?php if($values->ads_positioning == 'right') echo "selected='selected'" ?>><?php _e( 'Right' , 'best-google-adsense' );?></option>
												<option value="top-center" <?php if($values->ads_positioning == 'top-center') echo "selected='selected'" ?>><?php _e( 'Top/Center' , 'best-google-adsense' );?></option>
												<option value="top-left" <?php if($values->ads_positioning == 'top-left') echo "selected='selected'" ?>><?php _e( 'Top/Left' , 'best-google-adsense' );?></option>
												<option value="top-right" <?php if($values->ads_positioning == 'top-right') echo "selected='selected'" ?>><?php _e( 'Top/Right' , 'best-google-adsense' );?></option>
												<option value="bottom-center" <?php if($values->ads_positioning == 'bottom-center') echo "selected='selected'" ?>><?php _e( 'Bottom/Center' , 'best-google-adsense' );?></option>
												<option value="bottom-left" <?php if($values->ads_positioning == 'bottom-left') echo "selected='selected'" ?>><?php _e( 'Bottom/Left' , 'best-google-adsense' );?></option>
												<option value="bottom-right" <?php if($values->ads_positioning == 'bottom-right') echo "selected='selected'" ?>><?php _e( 'Bottom/Right' , 'best-google-adsense' );?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Do not show ads on these Pages' , 'best-google-adsense' );?></div>
										</td>
										<td>
											<input type="checkbox" name="non_show_home" id="non_show_home" <?php if($values->non_show_home=='on')echo "checked='checked'"; ?>/> <?php _e( 'Home Page' , 'best-google-adsense' );?><br />
											<input type="checkbox" name="non_show_stats" id="non_show_stats" <?php if($values->non_show_stats=='on')echo "checked='checked'"; ?>/> <?php _e( 'Static Pages' , 'best-google-adsense' );?> <br />
											<input type="checkbox" name="non_show_posts" id="non_show_posts" <?php if($values->non_show_posts=='on')echo "checked='checked'"; ?>/> <?php _e( 'Posts Pages' , 'best-google-adsense' );?> <br />
											<input type="checkbox" name="non_show_categories" id="non_show_categories" <?php if($values->non_show_categories=='on')echo "checked='checked'"; ?>/> <?php _e( 'Category Pages' , 'best-google-adsense' );?> <br />
											<input type="checkbox" name="non_show_archive" id="non_show_archive" <?php if($values->non_show_archive=='on')echo "checked='checked'"; ?>/> <?php _e( 'Archive Pages' , 'best-google-adsense' );?> <br />
										</td>
									</tr>
									<tr>
										<td>
											<div class="field_label"><?php _e( 'Donation' , 'best-google-adsense' );?></div>
											<p class="explain"><?php _e( 'The default donation rate is 5%. To disable the donation system fill in 0%.' , 'best-google-adsense' );?></p>
										</td>
										<td valign="top">
											<input type="text" id="donation_percent" name="donation_percent" size="3" value="<?php echo $values->donation_percent;?>"/> %
										</td>
									</tr>
								</table>
							</div>
							</form>
						</div>
						<div style="text-align:right;padding:5px 3px 0px 0px;">
							<span class="submit" id="bga_form_save3_loader" style="display:none">
								<img src="/wp-admin/images/wpspin_light.gif"> <?php _e( 'Wait' , 'best-google-adsense' );?>...
							</span>
							<input class="button-primary" type="button" value="<?php _e( 'Save Changes' , 'best-google-adsense' );?>" id="bga_form_save3" style="padding:1px 3px;"> 
						</div>
					</div>
				</div>
				
			</div>
			<br/><br/><br/>
		</div>
	</div>
	<div class="postbox-container" style="width:30%;">
		<div class="metabox-holder">	
			<div class="meta-box-sortables">
			
				
			</div>
			<br/><br/><br/>
		</div>
	</div>
</div>

<style>
	h4 span{font-size:11px;font-weight:normal;margin-left:50px;cursor:pointer;}
	.success{display:none; padding:2px 5px;border:1px solid #72CB67;background:#DFFAD3}
	.suggest,.alert{display:none; padding:2px 5px;border:1px solid #FFEF3F;background:#FFFAC6;margin-top:3px;line-height:18px !important;}
	.save_inline_btn{display:none;}
	.link_button{font-size:11px;color:#888;text-decoration:underline;cursor:pointer; margin-left:10px;}
	#bga_oh, #bga_ads{padding:5px;}
	#oh_hide,#oh_show,#ads_hide,#ads_show{cursor:pointer;}
	.explain{font-weight: normal;	font-size: 11px;	line-height: 12px;	color:#777; padding-left:5px; display:block !important;}
	.optional{font-weight: normal;	font-size: 11px;	line-height: 12px;	color:#777; padding-left:5px;}
	.separator{border-bottom:1px solid #fff;}
	.gray_box{background:#f9f9f9;	padding-left:3px; -moz-border-radius: 5px;	-webkit-border-radius: 5px;}
	.gray_box h4{padding:3px;	text-shadow:0 1px 0 #FFFFFF;	color:#666;}
	.gray_box table{width:99%;	border-top:1px solid #fff;	margin-top:5px;	padding-top:5px;-moz-box-shadow: 0px -1px 0px #ddd;	-webkit-box-shadow: 0px -1px 0px #ddd;}
	.gray_box table th{text-align:left;color:#666;font-size:12px;padding-bottom:3px;}
	.gray_box table td{text-align:left;color:#666;font-size:12px;padding:5px;}
	.colorSelector{float:right;}
	.bga_oh_select_list{ margin:3px;color:blue;cursor:pointer;text-decoration:underline;}
	#bga_oh_add_city_list{display:none;}
	.success .message_header, .alert .message_header{ padding:5px;font-weight:bold;}
	input[type="text"]{background:#EBF1FF !important;border:#A4C6D3 2px solid !important;color:#555555 !important; font-size:11px !important;}
	.field_label{color:#bf3d11; font-size:11px; font-weight:normal;}
	.gray_box table tr:hover{background:#f3f3f3;}
	.gray_box table td{margin:0px !important;}
	.rounded{-moz-border-radius: 5px;-webkit-border-radius: 5px;}
</style>