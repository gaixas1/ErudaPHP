<?php
if (defined ( 'SWIFT_INIT_LOADED' )) {
	return;
}

define ( 'SWIFT_INIT_LOADED', true );

require dirname ( __FILE__ ) . '/dependency_maps/cache_deps.php';
require dirname ( __FILE__ ) . '/dependency_maps/mime_deps.php';
require dirname ( __FILE__ ) . '/dependency_maps/message_deps.php';
require dirname ( __FILE__ ) . '/dependency_maps/transport_deps.php';

require dirname ( __FILE__ ) . '/preferences.php';
