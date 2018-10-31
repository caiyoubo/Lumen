<?php

$router->get('/', function () use ($router) {
    return '进阶科技';
});
// MakController
$router->get('index', 'MakeController@index');
$router->get('export', 'MakeController@export');
// --post--
$router->post('get_rand', 'MakeController@get_rand');
$router->post('get_info', 'MakeController@get_info');
$router->post('set_share', 'MakeController@set_share');
$router->post('set_tel', 'MakeController@set_tel');

// TaoBaoController
$router->get('get_top_api', 'TaoBaoController@get_info');
$router->post('get_word', 'TaoBaoController@get_word');
// --post--
$router->post('set_word', 'TaoBaoController@set_word');

// VipApiController
$router->post('get_follow_api', 'VipApiController@get_follow_api');
$router->post('get_add_cart', 'VipApiController@get_add_cart');
// --post--
$router->post('get_luck', 'VipApiController@get_info');
$router->post('get_vip', 'VipApiController@get_vip');

$router->get('test', 'TaoBaoController@test');
