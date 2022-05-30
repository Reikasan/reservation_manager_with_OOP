<?php
defined('DS')? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Applications'.DS.'MAMP'.DS.'htdocs'.DS.'reservation_manager');
defined('CLASSES_PASS') ? null : define('CLASSES_PASS', SITE_ROOT.DS.'classes'); 
defined('INCLUDES_PASS') ? null : define('INCLUDES_PASS', SITE_ROOT.DS.'includes');

require_once(INCLUDES_PASS.DS."functions.php");
require_once(CLASSES_PASS.DS."config.php");
require_once(CLASSES_PASS.DS."database.php");
require_once(CLASSES_PASS.DS."db_object.php");
require_once(CLASSES_PASS.DS."reservation.php");
require_once(CLASSES_PASS.DS."session.php");
require_once(CLASSES_PASS.DS."paginate.php");
require_once(CLASSES_PASS.DS."status.php");
require_once(CLASSES_PASS.DS."user.php");
require_once(CLASSES_PASS.DS."token.php");
require_once(CLASSES_PASS.DS."category.php");
require_once(CLASSES_PASS.DS."filter.php");
require_once(CLASSES_PASS.DS."calendar.php");

?>