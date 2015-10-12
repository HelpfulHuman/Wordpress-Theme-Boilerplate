<?php

function get_bloginfo($key = 'name')
{
  return config('bloginfo.' . $key);
}

function bloginfo($key = 'name')
{
  echo get_bloginfo($key);
}

function get_theme_root_uri()
{
  return config('bloginfo.template_url');
}

function get_template_directory()
{
  return config('bloginfo.template_directory');
}

function get_template_directory_uri()
{
  return config('bloginfo.template_url');
}
