<?php

/**
 * Load Frontend functions
 */
require get_template_directory() . '/inc/theme/frontend.php';

/**
 * Load Backend functions
 */
require get_template_directory() . '/inc/theme/backend.php';

global $DbBackend, $DbFrontEnd;

$DbBackend =  new DbBackend();
$DbFrontEnd = new DbFrontEnd();