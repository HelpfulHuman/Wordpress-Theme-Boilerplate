<?php

class Config {

  /**
   * The configuration values
   *
   * @var array
   */
  protected static $config = [];

  /**
   * Load in all of the config files from the specified folder.
   *
   * @param  string $dir
   */
  public static function load($dir)
  {
    // find all of the files
    foreach(glob($dir . '/*.php') as $file) {
      // get the base file name to generate the key
      $key = basename($file, '.php');
      // include the values and add them to the key
      static::$config[$key] = include($file);
    }
  }

  /**
   * Loads the requested config (if it exists) and returns
   * the value, otherwise the given default will be returned.
   *
   * @param  string $key
   * @param  mixed $default
   * @return mixed
   */
  public static function get($key, $default = null)
  {
    // break the key into multiple indexes
    $key = explode('.', $key);

    return self::getValue($key, static::$config, $default);
  }

  /**
   * Returns true if the value exists.
   *
   * @return bool
   */
  public static function has($key)
  {
    return (bool) static::get($key, false);
  }

  /**
   * Returns the entire $config array.
   *
   * @return array
   */
  public static function all()
  {
    return static::$config;
  }

  /**
   * Navigate through a config array looking for a particular index.
   *
   * @param  array $index
   * @param  array $value
   * @param  mixed $default
   * @return mixed
   */
  private static function getValue($index, $value, $default)
  {
    if (is_array($index) && count($index)) {
      $current_index = array_shift($index);
    }

    if (
        is_array($index) &&
        count($index) &&
        is_array($value[$current_index]) &&
        count($value[$current_index])
      ) {
      return self::getValue($index, $value[$current_index], $default);
    }

    return (
      array_key_exists($current_index, $value) ?
      $value[$current_index] : $default
    );
  }
}

/**
 * Helper function for calling Config::get().
 *
 * @param  string $key
 * @param  mixed $default
 * @return mixed
 */
function config($key, $default = null)
{
  return Config::get($key, $default);
}
