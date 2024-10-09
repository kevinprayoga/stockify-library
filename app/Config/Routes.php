<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'LandingPageController::login');
$routes->post('/login/save', 'LandingPageController::storeLogin');
$routes->get('/register', 'LandingPageController::register');
$routes->post('/register/save', 'LandingPageController::storeRegister');

$routes->group('', ['filter' => 'auth'], function($routes) {
  $routes->get('/', 'HomeController::index');

  $routes->group('booklist', function($routes) {
    $routes->get('/', 'BooklistController::index');
    $routes->get('addBooklist', 'BooklistController::addBooklist');
    $routes->post('storeBooklist', 'BooklistController::storeBooklist');
    $routes->get('(:segment)', 'BooklistController::detailBooklist/$1');
    $routes->get('(:segment)/edit', 'BooklistController::editBooklist/$1');
    $routes->post('delete/(:segment)', 'BooklistController::deleteBooklist/$1');
    $routes->get('download/(:any)', 'BooklistController::downloadFile/$1');
    $routes->post('update/(:segment)', 'BooklistController::updateBooklist/$1');
  });
  
  $routes->group('category', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'admin\CatController::index');
    $routes->post('add', 'admin\CatController::add');
    $routes->post('edit', 'admin\CatController::edit');
    $routes->post('delete', 'admin\CatController::delete');
  });

  $routes->get('/logout', 'LandingPageController::logout');
});
