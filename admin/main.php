<?php

$pagesID = get_option('wp-pushpress-page-id');
if( isset($_POST['save_pushpress_apikey_nonce']) && wp_verify_nonce($_POST['save_pushpress_apikey_nonce'], 'save_pushpress_apikey') ) {
	$arrayArgs = array( 'products' => 'product-enabled', 'plans' => 'plan-enabled','schedule' => 'schedule-enabled', 'workouts' => 'workout-enabled', 'leads' => 'lead-enabled' );
	
	if ( isset($_POST['btnIntegration']) ){
		
		foreach ($arrayArgs as $key => $arrayArg) {
			
			// feature check box available
			if ( isset($_POST[ $arrayArg ]) && sanitize_text_field( $_POST[ $arrayArg ] ) == 'yes' ){
				//enable feature option
				update_option( 'wp-pushpress-feature-' . $arrayArg, 'yes' );
				//update post 
				$post = array(
						'ID' => $pagesID[$key],
						'post_status' => 'publish'
					);
				wp_update_post( $post );
			}else{
				//disable feature option
				update_option( 'wp-pushpress-feature-' . $arrayArg, 'no' );
				//update post 
				$post = array(
						'ID' => $pagesID[$key],
						'post_status' => 'private'
					);
				wp_update_post( $post );
			}
		}
	}
}

$pushpress_apikey = get_option('wp-pushpress-integration-key');
$recaptcha_sitekey = get_option('wp-pushpress-recaptcha-sitekey');
$recaptcha_secretkey = get_option('wp-pushpress-recaptcha-secretkey');

$scheduleEnabled = get_option('wp-pushpress-feature-schedule-enabled');
$workoutEnabled = get_option('wp-pushpress-feature-workout-enabled');
$planEnabled = get_option('wp-pushpress-feature-plan-enabled');
$productEnabled = get_option('wp-pushpress-feature-product-enabled');
$leadEnabled = get_option('wp-pushpress-feature-lead-enabled');

$linkTo = str_replace('{subdomain}', $this->subdomain, PUSHPRESS_CPANEL);
?>

<div class="pushpress-wrap">
	<div class="header">
		<div class="dashboard-title"><h1>PushPress: Website</h1></div>
		
		<div class="logo">
			<img src="<?php echo PUSHPRESS_URL . '/images/img_logo.png';?>" alt="pushpress logo">
		</div>
		<div class="clear"></div>
	</div>
	<div class="container">
		<h2 class="nav-tab-wrapper">
			<a href="#account" aria-controls="account-container" class="nav-tab">Account Settings</a>
			<?php if( $this->check_API_key ):?>

				<a href="#website-integrations" aria-controls="website-integrations-container" class="nav-tab">Website Integrations</a>
				<a href="#help" aria-controls="help-container" class="nav-tab">Help</a>
			<?php endif;?>

		</h2>
		<?php Wp_Pushpress_Messages::get_messages();?>

		<form method="post">
			<div class="tab-pane" id="account-container">
				<p class="integration-desc">
					You need a PushPress Membership Management account to activate this plug-in. 
					If you don’t already have one you can sign-up for one <a href="https://www.pushpress.com">here</a>.
				</p>
				<div class="input-group-integration">
					<?php wp_nonce_field( 'save_pushpress_apikey', 'save_pushpress_apikey_nonce' );?>
					<label for="pushpress_apikey">Your PushPress Integration Code</label>
					<div class="form-group">
						<input type="text" id="pushpress_apikey" name="pushpress_apikey" value="<?php echo $pushpress_apikey;?>" placeholder="( 20 characters )">						
					</div>
					<p class="integration-link">
						<a href="https://pushpress.zendesk.com/hc/en-us/articles/205016859-Integration-code" target="_blank">Where do I get the intergation get from ?</a>
					</p>
					<label for="recaptcha_sitekey">reCAPTCHA Site Key</label>
					<div class="form-group">
						<input type="text" id="recaptcha_sitekey" name="recaptcha_sitekey" value="<?php echo $recaptcha_sitekey;?>" placeholder="( 40 characters )">
					</div>
					<label for="recaptcha_sitekey">reCAPTCHA Secret Key</label>
					<div class="form-group">
						<input type="text" id="recaptcha_secretkey" name="recaptcha_secretkey" value="<?php echo $recaptcha_secretkey;?>" placeholder="( 40 characters )">
					</div>
					<p class="integration-link">
						<a href="https://pushpress.zendesk.com/hc/en-us/articles/205698775-reCAPTCHA-Keys" target="_blank">Where do I get this code from ?</a>
					</p>
					<div class="form-group">
						<button type="submit" name="btnAccount">Save</button>
					</div>
				</div>
				
			</div>

			<?php if( $this->check_API_key ):?>
			<div class="tab-pane" id="website-integrations-container">
				<ul>
					<li>
						<div class="integrations-header">
							<div class="integrations-icon">
								<img src="<?php echo PUSHPRESS_URL . '/images/icon_schedule.png';?>" />
								<h2>Schedule</h2>
							</div>
						</div>
						<div class="integrations-check">
						<?php if ($scheduleEnabled == 'yes'): ?>

							<span class="integration-status">Active</span>
						<?php else:?>

							<span class="integration-status disabled">Disabled</span>
						<?php endif;?>

							<span class="inputCheck">
								<input type="checkbox" class="js-switch" name="schedule-enabled" value="yes" <?php checked($scheduleEnabled, 'yes');?> />
							</span>
							<div class="clear"></div>
							<p class="integrations-p-container">
								This will create a page on your website
								displaying your current Schedule of Classes,
								Events and Courses.
							</p>
						</div>
						<div class="integrations-edit">
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo $linkTo;?>calendar" target="_blank">Edit Schedule in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo get_edit_post_link($pagesID['schedule']);?>" target="_blank">Edit Page in WordPress</a>
							</p>
							<p>
								<i class="pp-icons-view"></i><a href="<?php echo get_permalink($pagesID['schedule']);?>" target="_blank">View Page</a>
							</p>
						</div>
						<div class="integrations-footer">The content data of your Schedule is managed through
							your PushPress Control Panel.</div>
					</li>
					<li>
						<div class="integrations-header">
							<div class="integrations-icon">
								<img src="<?php echo PUSHPRESS_URL . '/images/icon_workouts.png';?>" />
								<h2>Workouts</h2>
							</div>
						</div>
						<div class="integrations-check">
						<?php if ($workoutEnabled == 'yes'): ?>

							<span class="integration-status">Active</span>
						<?php else:?>

							<span class="integration-status disabled">Disabled</span>
						<?php endif;?>

							<span class="inputCheck">
								<input type="checkbox" class="js-switch" name="workout-enabled" value="yes" <?php checked($workoutEnabled, 'yes');?> />
							</span>
							<div class="clear"></div>
							<p class="integrations-p-container">This will create a page on your website
								displaying all workouts for the day. Viewers will
								be able to see Workout of the Day and all
								previous workouts posted.</p>
						</div>
						<div class="integrations-edit">
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo $linkTo;?>workouts" target="_blank">Edit Workouts in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo get_edit_post_link($pagesID['workouts']);?>" target="_blank">Edit Page in WordPress</a>
							</p>
							<p>
								<i class="pp-icons-view"></i><a href="<?php echo get_permalink($pagesID['workouts']);?>" target="_blank">View Page</a>
							</p>
						</div>
						<div class="integrations-footer">The content data of Workouts is managed through your
							PushPress Control Panel.</div>
					</li>
					<li>
						<div class="integrations-header">
							<div class="integrations-icon">
								<img src="<?php echo PUSHPRESS_URL . '/images/icon_plans.png';?>" />
								<h2>Plans, Courses, Events</h2>
							</div>
						</div>
						<div class="integrations-check">
						<?php if ($planEnabled == 'yes'): ?>

							<span class="integration-status">Active</span>
						<?php else:?>

							<span class="integration-status disabled">Disabled</span>
						<?php endif;?>
							<span class="inputCheck">
								<input type="checkbox" class="js-switch" name="plan-enabled" value="yes" <?php checked($planEnabled, 'yes');?> />
							</span>
							<div class="clear"></div>
							<p class="integrations-p-container">This will create a page on your website with links
								to purchase Plans, Courses, Events and Puncards.<p>
						</div>
						<div class="integrations-edit">
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo $linkTo;?>plans" target="_blank">Edit Plans in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"><a href="<?php echo $linkTo;?>calendar" target="_blank"></i>Edit Courses and Events in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo get_edit_post_link($pagesID['plans']);?>" target="_blank">Edit Page in WordPress</a>
							</p>
							<p>
								<i class="pp-icons-view"></i><a href="<?php echo get_permalink($pagesID['plans']);?>" target="_blank">View Page</a>
							</p>
						</div>
						<div class="integrations-footer">The content data of your Plans, Courses & Events is managed through
							your PushPress Control Panel.</div>
					</li>
					<li>
						<div class="integrations-header">
							<div class="integrations-icon">
								<img src="<?php echo PUSHPRESS_URL . '/images/icon_products.png';?>" />
								<h2>Products</h2>
							</div>
						</div>
						<div class="integrations-check">
						<?php if ($productEnabled == 'yes'): ?>

							<span class="integration-status">Active</span>
						<?php else:?>

							<span class="integration-status disabled">Disabled</span>
						<?php endif;?>

							<span class="inputCheck">
								<input type="checkbox" class="js-switch" name="product-enabled" value="yes" <?php checked($productEnabled, 'yes');?> />
							</span>
							<div class="clear"></div>
							<p class="integrations-p-container">
								This will create a page on your website
								displaying links to purchase products you have
								for sale. You can control which products display
								on this list on an individual item basis from the
								product detail page in your PushPress Control Panel.
							</p>
						</div>
						<div class="integrations-edit">
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo $linkTo;?>products" target="_blank">Edit Products in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo get_edit_post_link($pagesID['products']);?>" target="_blank">Edit Page in WordPress</a>
							</p>
							<p>
								<i class="pp-icons-view"></i><a href="<?php echo get_permalink($pagesID['products']);?>" target="_blank">View Page</a>
							</p>
						</div>
						<div class="integrations-footer">The content data of your Products is managed through your Pushpress Control Panel.</div>
					</li>
					<li>
						<div class="integrations-header">
							<div class="integrations-icon">
								<img src="<?php echo PUSHPRESS_URL . '/images/icon_leads.png';?>" />
								<h2>Lead Capture Form</h2>
							</div>
						</div>
						<div class="integrations-check">
						<?php if ($leadEnabled == 'yes'): ?>

							<span class="integration-status">Active</span>
						<?php else:?>

							<span class="integration-status disabled">Disabled</span>
						<?php endif;?>
							<span class="inputCheck">
								<input type="checkbox" class="js-switch" name="lead-enabled" value="yes" <?php checked($leadEnabled, 'yes');?> />
							</span>
							<div class="clear"></div>
							<p class="integrations-p-container">This will create a page on your website with a
								form to collect information on potential new members.</p>
						</div>
							
						<div class="integrations-edit">
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo $linkTo;?>settings/leads" target="_blank">Edit Lead Capture Form in PushPress</a>
							</p>
							<p>
								<i class="pp-icons-edit"></i><a href="<?php echo get_edit_post_link($pagesID['leads']);?>" target="_blank">Edit Page in WordPress</a>
							</p>
							<p>
								<i class="pp-icons-view"></i><a href="<?php echo get_permalink($pagesID['leads']);?>" target="_blank">View Page</a>
							</p>
						</div>
						<div class="integrations-footer">The form settings for Lead Capture is managed through your Pushpress Control Panel.</div>
					</li>
				</ul>
			</div>

			<div class="tab-pane" id="help-container">
				<h2>About PushPress</h2>
				<p class="about-pushpress">
					PushPress provides robust, simple, and elegant recurring billing and membership 
					management solutions. Services the niche industry of fitness and health providers. 
					Our focus is on simplicity and ease of use. Visit <a href="https://pushpress.com/">www.pushpress.com</a> to learn more.
				</p>

				<h2>What this Plugin Does</h2>
				<p class="plugin">
					A simple way to integrate data from your PushPress membership management solution into your Wordpress website.
				</p>
				<ul class="ul-plugin">
					<li>Show your Class Schedule. Link to reserving spot in class.</li>
					<li>Display your scheduled Workout Of the Day</li>
					<li>Display your upcomming events and link to page for ticket purchase.</li>
					<li>Display Membership Plan and Courses options with links to sign up.</li>
					<li>Show a list of Products for sale via your website with link to purchase.</li>
					<li>Creates a page with a Lead Capture form on it which funnels signups into the PushPress Lead management section.</li>
				</ul>
				<p class="plugin-footer">
					By activating each section it will create a new page on your Wordpress site. Each page has a shortcode which pulls in the relevant data.
				</p>

				<h2>How to use shortcodes</h2>
				<p>
					What are shortcodes? More info on <a href="https://en.support.wordpress.com/shortcodes/">general shortcode overview here</a>.
				</p>
				<p>	
					<strong>Examples:</strong><br />
					<span>[wp-pushpress-plans]</span> would/display return all plans.<br />
					<span>[wp-pushpress-plans id=xyz]</span> would return/display a single plan.<br />
					<span>[wp-pushpress-products category=xyz]</span> would/display return all products in a category. Etc.
				</p>
				<p>
					<strong>Generate a Shortcode:</strong>
				</p>
				<p>
					<select class="section-shortcode" name="slSection">
						<option value="">- Select Section -</option>
						<option value="plans">Plans</option>
						<option value="events">Events</option>
						<option value="products">Products</option>
					</select>
					<span class="spinner"></span>
				</p>
				<p>
					<select class="genarete-code" name="slCode">
						<option>- Genarate Code -</option>
					</select>
				</p>
				<p>
					<label for="shortcode_output">Copy and Paste Shortcode below in to your Wordpress page.</label>
					<input name="shortcode_output" id="shortcode_output" value="" placeholder="Shortcode output" />
				</p>
				<h2>Support</h2>
				<p>Email <a href="mailto:support@pushpress.com">support@pushpress.com</a> for additional help/issues.</p>
			</div>
		<?php endif;?>
		</form>
	</div>
	<?php if( PUSHPRESS_DEV ):?>

	<div class="footer"><?php echo PUSHPRESS_DEV_NOTIFICATION;?></div>
	<?php endif;?>

</div>
<script type="text/javascript">
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

	elems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

	jQuery(document).ready(function($) {
		$('.js-switch').on('change', function(){
			var btnName = $(this).attr('name');
			var data = {
				'action': 'pushpress_ajax'
			};
			data[ btnName ] = 'no';
			if ( $(this).prop( "checked" ) ){
				data[ btnName ] = 'yes';
			}
			var me  = this;
			$.post(ajaxurl, data, function(response) {
				if ( response.result != 0){
					var $textStatus = $(me).closest('.integrations-check').find('.integration-status');
					if ( response.status == 'yes' ){
						$textStatus.text('Active');
						$textStatus.removeClass('disabled');
					}else{
						$textStatus.text('Disabled');
						$textStatus.addClass('disabled');
					}
				}
			}, 'json');

		});

		function remove_option(options){
			//var first = $(options + ":first").first();
			$(options).each(function(){
				//if( $(this).val() != first.val() ){
					$(this).remove();
				//}
			});
		}

		var section_shortcode = '.pushpress-wrap .container #help-container p .section-shortcode';
		var genarete_code = '.pushpress-wrap .container #help-container p .genarete-code';
		var loader_img = '.pushpress-wrap .container #help-container p .spinner';

		function hide_code(){
			if( $( section_shortcode ).val() == "" ){
				$( genarete_code ).css({
					'display':'none'
				});
			}else{
				$( genarete_code ).css({
					'display':'block'
				});
			}
		}

		hide_code();

		$( section_shortcode ).on( 'change', function(){
			var btnName = $(this).attr('name');
			var data = {
				'action': 'pushpress_ajax_section'
			};
			data[ btnName ] = $(this).val();
			var me  = this;

			$( genarete_code ).attr( 'disabled', 'disabled' );
			remove_option( genarete_code + ' option' );
			$( loader_img ).css( {'display':'inline-block'} );
			$.post(ajaxurl, data, function(response) {
				if ( response.result != 0 ){
					var value = "";
					var text = "";

					switch ( $(me).val() ) {
						case 'plans':
							text = "- Select Plan -";
							break;
						
						case 'events':
							text = "- Select Event -";
							break;

						case 'products':
							text = "- Select Product -";
							break;
					}
					$( genarete_code ).append( new Option( text, value ) );

					var n = response.length;
					for( i = 0; i < n; i++ ){
						$( genarete_code ).append( new Option( response[i].name, response[i].id  ) );
					}
				}
				$( genarete_code ).removeAttr( 'disabled' );
				$( loader_img ).removeAttr( 'style' );
				hide_code();
			}, 'json');
			
		} );

		$( genarete_code ).on( 'change', function(){
			var $section = $( section_shortcode );

			var $input = $( '.pushpress-wrap .container #help-container p #shortcode_output');
					
			var id = $( this ).val();

			switch ( $section.val() ) {
				case 'plans':

					$input.val( '[wp-pushpress-plans id="' + id + '"]' );

					break;
				
				case 'events':

					$input.val( '[wp-pushpress-plans id="' + id + '"]' );

					break;
				case 'products':
					
					$input.val( '[wp-pushpress-products category="' + id + '"]' );

					break;
			}
			$input.select();
			
		} );

	});
</script>