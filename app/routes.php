<?php

$route[] = ['/', 'HomeController@index'];

$route[] = ['/user/create', 'UserController@create'];
$route[] = ['/user/store', 'UserController@store'];
$route[] = ['/login', 'UserController@login'];
$route[] = ['/login/auth', 'UserController@auth'];
$route[] = ['/logout', 'UserController@logout'];

$route[] = ['/home', 'HomeController@index', 'auth'];

return $route;
