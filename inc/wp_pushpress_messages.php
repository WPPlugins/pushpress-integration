<?php

class Wp_Pushpress_Messages{
	
	private static $messages;
	public static $leadSubmitSuccess = false;
	public static function init(){
		self::$messages = array();
	}

	public static function get_messages(){
		$messages = self::$messages;

		if( !empty( $messages ) ):
		?>

			<div class="<?php echo $messages['class'];?>">
	        	<p><?php echo $messages['msg']; ?></p>
	    	</div>
    	<?php
    	endif;
	}

	public static function set_messages( $messages = array( ) ){
		if( is_array($messages) ){
			self::$messages = $messages;
		}
	}
}

Wp_Pushpress_Messages::init();