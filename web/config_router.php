<?php 
$config_router = array(
    // router
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' =>array(
        // 'api2/:table' => array('Api2/Index/index'),
        'api2/index/index/:table/[:id\d]' => array('Api2/Index/index'),
        'api/brand'                       => array('Api/Brand/index'),

        // 'home/cart/user/[:username]/[:cart_key]' => array('Cart/user'),
        'home/checkout/:cart_tag'         => array('Checkout/index'),
        'home/brand/:brandname'           => array('Brand/index')
    )
);