<?php
/*
Plugin Name: Custom Scroll Back to Top
Description: Custom Scroll Back to Top allows you to scroll back up to the top of a website page by clicking your customized icon or text link.
Version: 1.0
Author: Jan Michael Cheng
Author URI: http://www.trusted-freelancer.com
License: GPL
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
?>
<?php
	function wptf_csbtt_enqueue_scripts() 
	{
		// color picker
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_script( 'wptf-csbtt-handler', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'wp-color-picker', 'jquery' ), false, true );
		
		// media module
		wp_enqueue_media();
	}
	add_action( 'admin_enqueue_scripts', 'wptf_csbtt_enqueue_scripts' );
	
	
	function wptf_csbtt_view_head()
	{
		wp_enqueue_script('jquery');
	}
	add_action( 'wp_head', 'wptf_csbtt_view_head', 1);
	
	
	function wptf_csbtt_view() 
	{
		$s_csbtt_option = get_option( 's_csbtt_option' );
		$o_csbtt_option = json_decode($s_csbtt_option);

		$s_opt_wptf_csbtt_type = $o_csbtt_option->s_opt_wptf_csbtt_type;
		$s_txt_wptf_csbtt_icon_url = $o_csbtt_option->s_txt_wptf_csbtt_icon_url;
		$s_opt_wptf_csbtt_text = $o_csbtt_option->s_opt_wptf_csbtt_text;
		$s_opt_wptf_csbtt_font_color = $o_csbtt_option->s_opt_wptf_csbtt_font_color;
		$s_opt_wptf_csbtt_font_family = $o_csbtt_option->s_opt_wptf_csbtt_font_family;
		$s_opt_wptf_csbtt_font_size = $o_csbtt_option->s_opt_wptf_csbtt_font_size;
		$s_opt_wptf_csbtt_page_positioning = strtolower($o_csbtt_option->s_opt_wptf_csbtt_page_positioning);
		$s_opt_wptf_csbtt_iconntext_positioning = strtolower($o_csbtt_option->s_opt_wptf_csbtt_iconntext_positioning);

		/* decide s_opt_wptf_csbtt_page_positioning */
		if( isset($s_opt_wptf_csbtt_page_positioning) && !empty($s_opt_wptf_csbtt_page_positioning) )
		{
			if( $s_opt_wptf_csbtt_page_positioning == 'bottom-right' )
			{
				$s_opt_wptf_csbtt_page_positioning = 'is-bottom-right';
			}
			elseif( $s_opt_wptf_csbtt_page_positioning == 'bottom-left' )
			{
				$s_opt_wptf_csbtt_page_positioning = 'is-bottom-left';
			}
			elseif( $s_opt_wptf_csbtt_page_positioning == 'top-right' )
			{
				$s_opt_wptf_csbtt_page_positioning = 'is-top-right';
			}
			elseif( $s_opt_wptf_csbtt_page_positioning == 'top-left' )
			{
				$s_opt_wptf_csbtt_page_positioning = 'is-top-left';
			}
		}
		else
		{
			$s_opt_wptf_csbtt_page_positioning = 'is-bottom-right';
		}
		
		/* decide s_opt_wptf_csbtt_iconntext_positioning */
		if( isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning) )
		{
			if( $s_opt_wptf_csbtt_iconntext_positioning == 'icoleft-txtright' )
			{
				$s_opt_wptf_csbtt_iconntext_positioning = 'is-icoleft-txtright';
			}
			elseif( $s_opt_wptf_csbtt_iconntext_positioning == 'icoright-txtleft' )
			{
				$s_opt_wptf_csbtt_iconntext_positioning = 'is-icoright-txtleft';
			}
			elseif( $s_opt_wptf_csbtt_iconntext_positioning == 'icotop-txtbottom' )
			{
				$s_opt_wptf_csbtt_iconntext_positioning = 'is-icotop-txtbottom';
			}
			elseif( $s_opt_wptf_csbtt_iconntext_positioning == 'icobottom-txttop' )
			{
				$s_opt_wptf_csbtt_iconntext_positioning = 'is-icobottom-txttop';
			}
		}
		else
		{
			$s_opt_wptf_csbtt_iconntext_positioning = 'is-icoleft-txtright';
		}
		?>
		
		<!-- wptf-custom-scroll-back-to-top-start -->
		<div class="wptf wptf-csbtt is-display-none">
			<style>
				/* module */
				.wptf.wptf-csbtt {
				}
				.wptf.wptf-csbtt .wptf-csbtt-body {
					position: fixed;
					z-index: 100;
					margin: 20px;
					text-align: center;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body .wptf-csbtt-body-link {
					display: block;
					text-decoration: none;
					<?php if( isset($s_opt_wptf_csbtt_font_family) && !empty($s_opt_wptf_csbtt_font_family) ): ?>
					font-family: <?php echo $s_opt_wptf_csbtt_font_family; ?>;
					<?php endif; ?>
					<?php if( isset($s_opt_wptf_csbtt_font_size) && !empty($s_opt_wptf_csbtt_font_size) ): ?>
					font-size: <?php echo $s_opt_wptf_csbtt_font_size; ?>;
					<?php endif; ?>
					<?php if( isset($s_opt_wptf_csbtt_font_color) && !empty($s_opt_wptf_csbtt_font_color) ): ?>
					color: <?php echo $s_opt_wptf_csbtt_font_color; ?>;
					<?php endif; ?>
					
				}
				.wptf.wptf-csbtt .wptf-csbtt-body .wptf-csbtt-body-link .wptf-csbtt-body-icon-holder img {
					max-width: 50px;
					max-height: 50px;
				}

				/* state */
				.wptf.wptf-csbtt.is-display-none {
					display: none;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body.is-bottom-right {
					bottom: 0px;
					right: 0px;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body.is-bottom-left {
					bottom: 0px;
					left: 0px;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body.is-top-right {
					top: 0px;
					right: 0px;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body.is-top-left {
					top: 0px;
					left: 0px;
				}
				.wptf.wptf-csbtt .wptf-csbtt-body.is-icoleft-txtright .wptf-csbtt-body-link .wptf-csbtt-body-icon-holder, 
				.wptf.wptf-csbtt .wptf-csbtt-body.is-icoleft-txtright .wptf-csbtt-body-link .wptf-csbtt-body-note, 
				.wptf.wptf-csbtt .wptf-csbtt-body.is-icoright-txtleft .wptf-csbtt-body-link .wptf-csbtt-body-icon-holder, 
				.wptf.wptf-csbtt .wptf-csbtt-body.is-icoright-txtleft .wptf-csbtt-body-link .wptf-csbtt-body-note {
					display: inline-block;
					vertical-align: middle;
				}
			</style>
			
			<div class="wptf-csbtt-body <?php if(isset($s_opt_wptf_csbtt_page_positioning) && !empty($s_opt_wptf_csbtt_page_positioning)){ echo $s_opt_wptf_csbtt_page_positioning; } ?> <?php if(isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning)){ echo $s_opt_wptf_csbtt_iconntext_positioning; } ?> ">
				<a href="#" class="wptf-csbtt-body-link wptf-csbtt-body-link-up">
					<?php 
						if( 
							isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning) && $s_opt_wptf_csbtt_iconntext_positioning == 'is-icobottom-txttop' ||
							isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning) && $s_opt_wptf_csbtt_iconntext_positioning == 'is-icoright-txtleft' 
						): 
					?>
						<?php if( isset($s_opt_wptf_csbtt_text) && !empty($s_opt_wptf_csbtt_text) ): ?>
						<div class="wptf-csbtt-body-note">
							<?php echo $s_opt_wptf_csbtt_text; ?>
						</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( isset($s_txt_wptf_csbtt_icon_url) && !empty($s_txt_wptf_csbtt_icon_url) ): ?>
					<div class="wptf-csbtt-body-icon-holder">
						<img src="<?php echo $s_txt_wptf_csbtt_icon_url; ?>" />
					</div>
					<?php endif; ?>
					
					<?php 
						if( 
							isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning) && $s_opt_wptf_csbtt_iconntext_positioning == 'is-icotop-txtbottom' ||
							isset($s_opt_wptf_csbtt_iconntext_positioning) && !empty($s_opt_wptf_csbtt_iconntext_positioning) && $s_opt_wptf_csbtt_iconntext_positioning == 'is-icoleft-txtright' 
						): 
					?>
						<?php if( isset($s_opt_wptf_csbtt_text) && !empty($s_opt_wptf_csbtt_text) ): ?>
						<div class="wptf-csbtt-body-note">
							<?php echo $s_opt_wptf_csbtt_text; ?>
						</div>
						<?php endif; ?>
					<?php endif; ?>

				</a>
			</div>
			<script>
				jQuery('document').ready(function($){
					$(window).scroll(function(){
						o_scroll = $(window).scrollTop();
						var o_site_csbtt = $('.wptf.wptf-csbtt');
						if(o_scroll >= 100)
						{
							o_site_csbtt.removeClass('is-display-none');
						}
						else
						{
							if( !o_site_csbtt.hasClass('is-display-none') )
							{
								o_site_csbtt.addClass('is-display-none');
							}
						}
					});
					
					$('.wptf-csbtt-body-link-up').on('click', function(o_event){
						o_event.preventDefault();
						$('html, body').animate({scrollTop:0}, 'fast');
					});
				});
			</script>
		</div>
		<!-- wptf-custom-scroll-back-to-top-end -->
		<?php
	}
	add_action( 'wp_footer', 'wptf_csbtt_view');
	
	
	class wptf_csbtt
	{
		public function __construct()
		{
			add_action('admin_menu', array( &$this, 'wptf_csbtt_menu' ));
			
		}

		public function wptf_csbtt_menu() {
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			add_options_page('WPTF - Custom Scroll Back to Top - Panel', 'WPTF - Custom Scroll Back to Top', 'manage_options', 'wptf-csbtt-panel', array(&$this, 'wptf_csbtt_panel'));
		}
		
		function wptf_csbtt_panel() 
		{
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			
			global $current_user;
			$b_success = false;
			$b_error = false;
			
			if( isset($_POST) && !empty($_POST) )
			{
				$s_wptf_csbtt_nonce = $_POST['txt_wptf_csbtt_nonce'];
				if (!wp_verify_nonce($s_wptf_csbtt_nonce, 's_wptf_csbtt_nonce'))
				{
					echo "<div id=\"message\" class=\"updated fade\"><p>Security Check - If you receive this in error, log out and back in to WordPress</p></div>";
					die();
				}
				
				if( isset($_POST['btn_disable']) && !empty($_POST['btn_disable']) )
				{
					$s_csbtt_option = '';
				}
				else
				{
					$s_opt_wptf_csbtt_type = ( ( isset($_POST['opt_wptf_csbtt_type']) && !empty($_POST['opt_wptf_csbtt_type']) && $_POST['opt_wptf_csbtt_type'] != '-' ) ? $_POST['opt_wptf_csbtt_type'] : '' );
					$s_txt_wptf_csbtt_icon_url = ( ( isset($_POST['txt_wptf_csbtt_icon_url']) && !empty($_POST['txt_wptf_csbtt_icon_url']) && $_POST['txt_wptf_csbtt_icon_url'] != '-' ) ? $_POST['txt_wptf_csbtt_icon_url'] : '' );
					$s_opt_wptf_csbtt_text = ( ( isset($_POST['opt_wptf_csbtt_text']) && !empty($_POST['opt_wptf_csbtt_text']) && $_POST['opt_wptf_csbtt_text'] != '-' ) ? $_POST['opt_wptf_csbtt_text'] : '' );
					$s_opt_wptf_csbtt_font_color = ( ( isset($_POST['opt_wptf_csbtt_font_color']) && !empty($_POST['opt_wptf_csbtt_font_color']) && $_POST['opt_wptf_csbtt_font_color'] != '-' ) ? $_POST['opt_wptf_csbtt_font_color'] : '' );
					$s_opt_wptf_csbtt_font_family = ( ( isset($_POST['opt_wptf_csbtt_font_family']) && !empty($_POST['opt_wptf_csbtt_font_family']) && $_POST['opt_wptf_csbtt_font_family'] != '-' ) ? $_POST['opt_wptf_csbtt_font_family'] : '' );
					$s_opt_wptf_csbtt_font_size = ( ( isset($_POST['opt_wptf_csbtt_font_size']) && !empty($_POST['opt_wptf_csbtt_font_size']) && $_POST['opt_wptf_csbtt_font_size'] != '-' ) ? $_POST['opt_wptf_csbtt_font_size'] : '' );
					$s_opt_wptf_csbtt_page_positioning = ( ( isset($_POST['opt_wptf_csbtt_page_positioning']) && !empty($_POST['opt_wptf_csbtt_page_positioning']) && $_POST['opt_wptf_csbtt_page_positioning'] != '-' ) ? $_POST['opt_wptf_csbtt_page_positioning'] : '' );
					$s_opt_wptf_csbtt_iconntext_positioning = ( ( isset($_POST['opt_wptf_csbtt_iconntext_positioning']) && !empty($_POST['opt_wptf_csbtt_iconntext_positioning']) && $_POST['opt_wptf_csbtt_iconntext_positioning'] != '-' ) ? $_POST['opt_wptf_csbtt_iconntext_positioning'] : '' );
					
					$a_array = array(
						"s_opt_wptf_csbtt_type"=>$s_opt_wptf_csbtt_type, 
						"s_txt_wptf_csbtt_icon_url"=>$s_txt_wptf_csbtt_icon_url, 
						"s_opt_wptf_csbtt_text"=>$s_opt_wptf_csbtt_text, 
						"s_opt_wptf_csbtt_font_color"=>$s_opt_wptf_csbtt_font_color, 
						"s_opt_wptf_csbtt_font_family"=>$s_opt_wptf_csbtt_font_family, 
						"s_opt_wptf_csbtt_font_size"=>$s_opt_wptf_csbtt_font_size, 
						"s_opt_wptf_csbtt_page_positioning"=>$s_opt_wptf_csbtt_page_positioning, 
						"s_opt_wptf_csbtt_iconntext_positioning"=>$s_opt_wptf_csbtt_iconntext_positioning
					);
					$s_csbtt_option = json_encode($a_array);
				}

				update_option( 's_csbtt_option', $s_csbtt_option );
				$b_success = true;
			}

			/* get current values for form */
			$s_csbtt_option = get_option( 's_csbtt_option' );
			$o_csbtt_option = json_decode($s_csbtt_option);
			$s_opt_wptf_csbtt_type = $o_csbtt_option->s_opt_wptf_csbtt_type;
			$s_txt_wptf_csbtt_icon_url = $o_csbtt_option->s_txt_wptf_csbtt_icon_url;
			$s_opt_wptf_csbtt_text = $o_csbtt_option->s_opt_wptf_csbtt_text;
			$s_opt_wptf_csbtt_font_color = $o_csbtt_option->s_opt_wptf_csbtt_font_color;
			$s_opt_wptf_csbtt_font_family = $o_csbtt_option->s_opt_wptf_csbtt_font_family;
			$s_opt_wptf_csbtt_font_size = $o_csbtt_option->s_opt_wptf_csbtt_font_size;
			$s_opt_wptf_csbtt_page_positioning = strtolower($o_csbtt_option->s_opt_wptf_csbtt_page_positioning);
			$s_opt_wptf_csbtt_iconntext_positioning = strtolower($o_csbtt_option->s_opt_wptf_csbtt_iconntext_positioning);

			?>

			<style>
				.section {
					margin: 10px;
					padding: 20px;
					background: white;
				}
				.section h2 {
					background: #32373c;
					color: white;
					padding: 10px;
				}
				input[name='txt_wptf_csbtt_icon_url'] {
					width: 100%;
				}
				.wptf-csbtt-notice {
					margin: 10px 10px 10px;
				}
				.wptf-csbtt-notice .wptf-csbtt-notice-success{
					padding: 5px;
					color: #3c763d;
					background-color: #dff0d8;
					border-color: #3c763d;
				}
				.wptf-csbtt-notice .wptf-csbtt-notice-normal{
					padding: 5px;
					color: #31708f;
					background-color: #d9edf7;
					border-color: #31708f;
				}
				.wptf-csbtt-notice .wptf-csbtt-notice-error{
					padding: 5px;
					color: #a94442;
					background-color: #f2dede;
					border-color: #a94442;
				}
				.wptf-csbtt-notice p {}
				.wptf_csbtt-list-icon-predefined {}
				.wptf_csbtt-list-icon-predefined:after {
					/*
					*/
					content: " ";
					display: block;
					clear: both;
				}
				.wptf_csbtt-list-icon-predefined li{
					float: left;
					margin-right: 20px;
				}
			</style>
			
			<div class="wptf-csbtt-notice">
				<?php
					if( isset($b_success) && !empty($b_success) && $b_success == true ):
				?>
				<div class="wptf-csbtt-notice-success">
					<p>
						<strong>Success</strong>
					</p>
				</div>
				<?php
					endif;
				?>
				<?php
					if( isset($b_error) && !empty($b_error) && $b_error == true ):
				?>
				<div class="wptf-csbtt-notice-error">
					<p>
						<strong>Error</strong>
					</p>
				</div>
				<?php
					endif;
				?>
			</div>
			
			
			<div>
				<form id="frm_wptf_csbtt" name="frm_wptf_csbtt" method="post" >
					<h1>
						Custom Scroll Back to Top
					</h1>
					<hr/>
					<section class="section ">
						<h2>
							Predefined or Custom Icon
						</h2>
						<ul>
							<li>
								<input type="radio" id="opt_wptf_csbtt_type_3" name="opt_wptf_csbtt_type" value="no-icon" <?php if( $s_opt_wptf_csbtt_type == 'no-icon' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_type_3">
									<strong>No Icon</strong>
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_type_1" name="opt_wptf_csbtt_type" value="predefined" <?php if( $s_opt_wptf_csbtt_type == 'predefined' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_type_1">
									<strong>Predefined</strong> - Choose from our very own icons.
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_type_2" name="opt_wptf_csbtt_type" value="custom" <?php if( $s_opt_wptf_csbtt_type == 'custom' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_type_2">
									<strong>Custom</strong> - Choose icon from your library.
								</label> 
							</li>
						</ul>
						<div>
							<div id="" class="div_icon_options" value="predefined" <?php if( $s_opt_wptf_csbtt_type == 'predefined' ) { echo 'style="display: block"'; } else { echo 'style="display: none"'; } ?> >
								<h3>Predefined</h3>
								<ul class="wptf_csbtt-list-icon-predefined">
									<li>
										<input type="radio" id="opt_wptf_csbtt_icon_url_1" name="opt_wptf_csbtt_icon_url" value="<?php echo plugin_dir_url( __FILE__ ); ?>images/predifiend-btn-1.png" />
										<label for="opt_wptf_csbtt_icon_url_1">
											<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/predifiend-btn-1.png" />
										</label>
									</li>
									<li>
										<input type="radio" id="opt_wptf_csbtt_icon_url_2" name="opt_wptf_csbtt_icon_url" value="<?php echo plugin_dir_url( __FILE__ ); ?>images/predifiend-btn-2.png" />
										<label for="opt_wptf_csbtt_icon_url_2">
											<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/predifiend-btn-2.png" />
										</label>
									</li>
									<li>
										<input type="radio" id="opt_wptf_csbtt_icon_url_3" name="opt_wptf_csbtt_icon_url" value="<?php echo plugin_dir_url( __FILE__ ); ?>images/predifiend-btn-3.png" />
										<label for="opt_wptf_csbtt_icon_url_3">
											<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/predifiend-btn-3.png" />
										</label>
									</li>
									<li>
										<input type="radio" id="opt_wptf_csbtt_icon_url_4" name="opt_wptf_csbtt_icon_url" value="<?php echo plugin_dir_url( __FILE__ ); ?>images/predifiend-btn-4.png" />
										<label for="opt_wptf_csbtt_icon_url_4">
											<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/predifiend-btn-4.png" />
										</label>
									</li>
									<li>
										<input type="radio" id="opt_wptf_csbtt_icon_url_5" name="opt_wptf_csbtt_icon_url" value="<?php echo plugin_dir_url( __FILE__ ); ?>images/predifiend-btn-5.png" />
										<label for="opt_wptf_csbtt_icon_url_5">
											<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/predifiend-btn-5.png" />
										</label>
									</li>
								</ul>
							</div>
							<div id="" class="div_icon_options" value="custom"  <?php if( $s_opt_wptf_csbtt_type == 'custom' ) { echo 'style="display: block"'; } else { echo 'style="display: none"'; } ?>>
								<h3>Custom</h3>
								<button class="btn_media">Select Icon</button>
							</div>
							<div>
								<h3>Selected Icon URL</h3>
								<input type="text" name="txt_wptf_csbtt_icon_url" id="txt_wptf_csbtt_icon_url" readonly="readonly" placeholder="Choose from the Custom or Predefined Buttons" value="<?php if( isset($s_txt_wptf_csbtt_icon_url) && !empty($s_txt_wptf_csbtt_icon_url) ) { echo $s_txt_wptf_csbtt_icon_url; } ?>" />
							</div>
						</div>
					</section>
					<section class="section ">
						<h2>
							Text Control
						</h2>
						<p>
							Text to Show:<br/>
							<input type="text" name="opt_wptf_csbtt_text" value="<?php if( isset($s_opt_wptf_csbtt_text) && !empty($s_opt_wptf_csbtt_text) ) { echo $s_opt_wptf_csbtt_text; } ?>" /> <- Leave blank if not needed.
						</p>
						<p>
							Text Color:<br/> 
							<input type="text" value="<?php if( isset($s_opt_wptf_csbtt_font_color) && !empty($s_opt_wptf_csbtt_font_color) ) { echo $s_opt_wptf_csbtt_font_color; } ?>" name="opt_wptf_csbtt_font_color" class="opt_wptf_csbtt_font_color" data-default-color="#000000" placeholder="#000000" />
						</p>
						<p>
							Font Family:<br/>
							<select id="opt_wptf_csbtt_font_family" name="opt_wptf_csbtt_font_family">
								<option value="-"></option>
								<option value="inherit" <?php if( $s_opt_wptf_csbtt_font_family == 'inherit' ) { echo 'selected="selected"'; } ?>>Inherit</option>
								<option value="arial" <?php if( $s_opt_wptf_csbtt_font_family == 'arial' ) { echo 'selected="selected"'; } ?> >Arial</option>
								<option value="times-new-roman" <?php if( $s_opt_wptf_csbtt_font_family == 'times-new-roman' ) { echo 'selected="selected"'; } ?> >Times New Roman</option>
								<option value="verdana" <?php if( $s_opt_wptf_csbtt_font_family == 'verdana' ) { echo 'selected="selected"'; } ?> >Verdana</option>
							</select>
						</p>
						<p>
							Font Size:<br/>
							<select id="opt_wptf_csbtt_font_size" name="opt_wptf_csbtt_font_size">
								<option value="-"></option>
								<option value="inherit" <?php if( $s_opt_wptf_csbtt_font_size == 'inherit' ) { echo 'selected="selected"'; } ?>>Inherit</option>
								<option value="12px" <?php if( $s_opt_wptf_csbtt_font_size == '12px' ) { echo 'selected="selected"'; } ?> >12px</option>
								<option value="14px" <?php if( $s_opt_wptf_csbtt_font_size == '14px' ) { echo 'selected="selected"'; } ?> >14px</option>
								<option value="16px" <?php if( $s_opt_wptf_csbtt_font_size == '16px' ) { echo 'selected="selected"'; } ?> >16px</option>
								<option value="18px" <?php if( $s_opt_wptf_csbtt_font_size == '18px' ) { echo 'selected="selected"'; } ?> >18px</option>
							</select>
						</p>
					</section>
					<section class="section ">
						<h2>
							Page Positioning
						</h2>
						<ul>
							<li>
								<input type="radio" id="opt_wptf_csbtt_page_positioning_1" name="opt_wptf_csbtt_page_positioning" value="bottom-right" <?php if( $s_opt_wptf_csbtt_page_positioning == 'bottom-right' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_page_positioning_1">
									Bottom Right
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_page_positioning_2" name="opt_wptf_csbtt_page_positioning" value="bottom-left" <?php if( $s_opt_wptf_csbtt_page_positioning == 'bottom-left' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_page_positioning_2">
									Bottom Left
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_page_positioning_3" name="opt_wptf_csbtt_page_positioning" value="top-right" <?php if( $s_opt_wptf_csbtt_page_positioning == 'top-right' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_page_positioning_3">
									Top Right
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_page_positioning_4" name="opt_wptf_csbtt_page_positioning" value="top-left" <?php if( $s_opt_wptf_csbtt_page_positioning == 'top-left' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_page_positioning_4">
									Top Left
								</label>
							</li>
						</ul>
					</section>
					<section class="section ">
						<h2>
							Icon and Text Positioning
						</h2>
						<ul>
							<li>
								<input type="radio" id="opt_wptf_csbtt_iconntext_positioning_1" name="opt_wptf_csbtt_iconntext_positioning" value="icoleft-txtright" <?php if( $s_opt_wptf_csbtt_iconntext_positioning == 'icoleft-txtright' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_iconntext_positioning_1">
									Icon Left, Text Right
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_iconntext_positioning_2" name="opt_wptf_csbtt_iconntext_positioning" value="icoright-txtleft" <?php if( $s_opt_wptf_csbtt_iconntext_positioning == 'icoright-txtleft' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_iconntext_positioning_2">
									Icon Right, Text Left
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_iconntext_positioning_3" name="opt_wptf_csbtt_iconntext_positioning" value="icotop-txtbottom" <?php if( $s_opt_wptf_csbtt_iconntext_positioning == 'icotop-txtbottom' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_iconntext_positioning_3">
									Icon Top, Text Bottom
								</label>
							</li>
							<li>
								<input type="radio" id="opt_wptf_csbtt_iconntext_positioning_4" name="opt_wptf_csbtt_iconntext_positioning" value="icobottom-txttop" <?php if( $s_opt_wptf_csbtt_iconntext_positioning == 'icobottom-txttop' ) { echo 'checked="checked"'; } ?> /> 
								<label for="opt_wptf_csbtt_iconntext_positioning_4">
									Icon Bottom, Text Top
								</label>
							</li>
						</ul>
					</section>
					<section class="section ">
						<h2>
							Plugin Controls
						</h2>
						<input type="hidden" name="txt_wptf_csbtt_nonce" value="<?php echo wp_create_nonce('s_wptf_csbtt_nonce'); ?>" />
						<input class="button button-large" type="submit" name="btn_disable" value="Disable" /> or
						<input class="button button-primary button-large" type="submit" name="btn_save" value="Save Settings" /> 
					</section>
				</form>
			</div>
			<?php
		}
	}
	if( class_exists( 'wptf_csbtt' ) ) 
	{
		$o_wptf_csbtt = new wptf_csbtt;
	}
	
?>