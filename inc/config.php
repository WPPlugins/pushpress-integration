<?php

if ( PUSHPRESS_DEV ){
	define('PUSHPRESS_HOST', 'http://api.pushpressdev.com');
	define('PUSHPRESS_CPANEL', 'http://{subdomain}.pushpressdev.com/');
	define('PUSHPRESS_CLIENT', 'http://{subdomain}.members.pushpressdev.com/');
	define('PUSHPRESS_DEV_NOTIFICATION', "Development Mode");
}else{
	define('PUSHPRESS_HOST', 'http://api.pushpress.com');
	define('PUSHPRESS_CPANEL', 'http://{subdomain}.pushpress.com/');
	define('PUSHPRESS_CLIENT', 'http://{subdomain}.members.pushpress.com/');
}