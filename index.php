<?php

// define important constants
define('CONFIG_PATH', dirname(__FILE__) . '/config');
define('THEME_PATH', dirname(__FILE__) . '/theme');

// load in our libraries
foreach (glob('lib/*.php') as $filename) {
  include_once($filename);
}

// load our configuration settings
Config::load(CONFIG_PATH);

// load our functions
foreach (glob('functions/*.php') as $filename) {
  include_once($filename);
}

// load our theme's functions
include(THEME_PATH . '/functions.php');

// route to our file
$router = new AltoRouter();
$router->setBasePath('');

include('routes.php');

/* Match the current request */
$match = $router->match();

if ($match && is_callable($match['target'])) {
  call_user_func_array($match['target'], $match['params']);
}
else if ($match && is_string($match['target'])) {
  include(THEME_PATH . '/' . ltrim($match['target'], '/'));
}
else {
  header("HTTP/1.0 404 Not Found");
  include(THEME_PATH . '404.php');
}
