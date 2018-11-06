<?php

$router->get('/', function () use ($router) {
    return '进阶科技';
});
// MakController
$router->get('export', 'MakeController@export');
$router->get('get_vip', 'MakeController@get_vip');

// --post--
$router->post('get_rand', 'MakeController@get_rand');

// TaoBaoController
$router->get('get_top_api', 'TaoBaoController@get_info');


$router->get('test', 'TaoBaoController@test');

// test
//$router->get('login', 'Login\LoginController@index');

//  LoginController
$router->group(['middleware' => 'old'], function ($router){
    $router->get('login', 'Login\LoginController@index');
});
