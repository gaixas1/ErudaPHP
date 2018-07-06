<?php
if (defined ( 'SWIFT_REQUIRED_LOADED' )) {
	return;
}

define ( 'SWIFT_REQUIRED_LOADED', true );

require dirname ( __FILE__ ) . '/classes/Swift.php';

if (! function_exists ( '_swiftmailer_init' )) {
	function _swiftmailer_init() {
		require dirname ( __FILE__ ) . '/swift_init.php';
	}
}

Swift::registerAutoload ( '_swiftmailer_init' );
