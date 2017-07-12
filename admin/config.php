<?php

?>

<div class="pushpress-wrap">
	<div class="header">
		<div class="dashboard-title"><h1>PushPress: Config</h1></div>
		
		<div class="logo">
			<img src="<?php echo PUSHPRESS_URL . '/images/img_logo.png';?>" alt="pushpress logo">
		</div>
		<div class="clear"></div>
	</div>
	<div class="container">
		
		<?php Wp_Pushpress_Messages::get_messages();?>

		<!-- 
			save this to plugin settings.
			on config/setup pull from settings and set to constant PUSHPRESS_URL
		-->		
		<input type="text" name="api_url" value="<?php echo PUSHPRESS_HOST;?>" />

	</div>
	
</div>