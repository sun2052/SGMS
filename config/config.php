<?php

// decide how to show errors
define('DEVELOPMENT_ENVIRONMENT', true);

// configuration for connecting database
define('DB_HOST', '127.0.0.1:3306');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sgms');

// privilege
define('ADMIN', 1);
define('STUDENT', 2);

//used for absolute path
define('WEB_DOMAIN', 'http://127.0.0.1:8888');

//with trailing slash pls
define('WEB_FOLDER', '/SGMS/');

//default route
$default['controller'] = 'site';
$default['action'] = 'index';
