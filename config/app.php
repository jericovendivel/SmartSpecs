<?php
// ============================================================
//  SmartSpecs — App Configuration
// ============================================================

define('APP_NAME',    'SmartSpecs');
define('APP_VERSION', '1.0.0');
define('APP_URL',     'http://localhost/smartspecs'); // Change to your domain

// Paths
define('ROOT_PATH',   dirname(__DIR__));
define('ASSETS_URL',  APP_URL . '/assets');
define('IMAGES_URL',  ASSETS_URL . '/images');

// Brands available
define('BRANDS', ['samsung', 'apple', 'xiaomi', 'google']);

// Phones per brand on grid
define('PHONES_PER_BRAND', 6);
