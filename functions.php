<?php

require_once( dirname( __FILE__) . '/classes/admin/ProductsUpdater.php');

require_once( dirname( __FILE__) . '/classes/constants/Constants.php');
require_once( dirname( __FILE__) . '/classes/apis/ProductApi.php');
require_once( dirname( __FILE__) . '/classes/enqueue/Enqueue.php');
require_once( dirname( __FILE__) . '/classes/images/ImageAttributes.php');
require_once( dirname( __FILE__) . '/classes/menus/Menus.php');
require_once( dirname( __FILE__) . '/classes/post-types/Product.php');
require_once( dirname( __FILE__) . '/classes/relevannsi/RelevannsiSqliteCompatibility.php');

// Add theme support for Featured Images
add_theme_support('post-thumbnails', array(
    'post',
    'page',
    'product',
    ));


