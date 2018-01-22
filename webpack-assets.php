<?php
/**
 * Plugin Name: Webpack Assets
 * Plugin URI: http://github.com/castiron/wp-webpack-assets
 * Description: Use assets from webpack php manifest in WordPress Templates. Requires: https://www.npmjs.com/package/webpack-php-manifest
 * Version: 1.0.0
 * Author: Cast Iron Coding
 * Author URI: http://castironcoding.com
 * License: MIT
 */

defined('ABSPATH') or die("Direct access to this plugin is not allowed.");

use CIC\WebpackAssets\Plugin;
require_once('WebpackAssets.php');

function webpackAsset($type, $options = array()) {
  // File type is required
  if (!$type) {
    return false;
  }

  // Instantiate class
  $assets = new WebpackAssets($options);
  echo $assets->outputAssets($type);
}
