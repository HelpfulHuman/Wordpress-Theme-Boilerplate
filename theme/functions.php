<?php

/**
 * Returns the full URL for the given theme asset.
 *
 * @param  string $filepath
 * @return string
 */
function get_asset($filepath)
{
  return get_theme_root_uri() . '/' . ltrim($filepath);
}

/**
 * Prints the full URL for the given theme asset.
 *
 * @param  string $filepath
 */
function asset($filepath)
{
  echo get_asset($filepath);
}
