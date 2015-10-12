<?php

function get_header($name = null) {
  $filename = ($name ? 'header-' . $name : 'header');
  include(THEME_PATH . '/' . $filename . '.php');
}

function get_footer($name = null) {
  $filename = ($name ? 'footer-' . $name : 'footer');
  include(THEME_PATH . '/' . $filename . '.php');
}
