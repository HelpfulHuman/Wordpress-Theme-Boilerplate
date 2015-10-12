<?php

function get_field($key)
{
  return config('acf.fields.' . $key);
}

function the_field($key)
{
  echo get_field($key);
}
