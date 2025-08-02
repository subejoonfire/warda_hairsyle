<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home routes
$routes->get('/', 'Home::index');
$routes->get('hairstyles', 'Home::hairstyles');

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('verify/(:num)', 'Auth::verify/$1');
    $routes->post('verify/(:num)', 'Auth::verify/$1');
    $routes->post('resend-verification/(:num)', 'Auth::resendVerification/$1');
    $routes->get('logout', 'Auth::logout');
});

// Customer routes (require login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('booking', 'Home::booking');
    $routes->post('booking', 'Home::createBooking');
    $routes->get('profile', 'Home::profile');
    $routes->post('profile', 'Home::profile');
    $routes->get('chat', 'Home::chat');
    $routes->post('send-message', 'Home::sendMessage');
    $routes->get('send-quick-message/(:num)', 'Home::sendQuickMessage/$1');
    $routes->get('get-chats', 'Home::getChats');
});

// Admin routes (require admin role)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Bookings management
    $routes->get('bookings', 'Admin::bookings');
    $routes->get('bookings/(:num)', 'Admin::bookingDetail/$1');
    $routes->post('update-booking-status', 'Admin::updateBookingStatus');
    
    // Customers management
    $routes->get('customers', 'Admin::customers');
    
    // Chat management
    $routes->get('chats', 'Admin::chats');
    $routes->post('send-admin-message', 'Admin::sendAdminMessage');
    $routes->get('get-customer-chats/(:num)', 'Admin::getCustomerChats/$1');
    
    // Quick Messages management
    $routes->get('quick-messages', 'Admin\QuickMessageController::index');
    $routes->get('quick-messages/create', 'Admin\QuickMessageController::create');
    $routes->post('quick-messages/create', 'Admin\QuickMessageController::create');
    $routes->get('quick-messages/edit/(:num)', 'Admin\QuickMessageController::edit/$1');
    $routes->post('quick-messages/edit/(:num)', 'Admin\QuickMessageController::edit/$1');
    $routes->get('quick-messages/delete/(:num)', 'Admin\QuickMessageController::delete/$1');
    $routes->post('quick-messages/toggle-status/(:num)', 'Admin\QuickMessageController::toggleStatus/$1');
    $routes->get('quick-messages/preview/(:num)', 'Admin\QuickMessageController::preview/$1');
    $routes->post('quick-messages/test-response', 'Admin\QuickMessageController::testResponse');
    $routes->get('quick-messages/response-sources', 'Admin\QuickMessageController::getResponseSources');

    // Hairstyles management (using HairstyleController)
    $routes->get('hairstyles', 'Admin\HairstyleController::index');
    $routes->get('hairstyles/create', 'Admin\HairstyleController::create');
    $routes->post('hairstyles/create', 'Admin\HairstyleController::create');
    $routes->get('hairstyles/edit/(:num)', 'Admin\HairstyleController::edit/$1');
    $routes->post('hairstyles/edit/(:num)', 'Admin\HairstyleController::edit/$1');
    $routes->get('hairstyles/delete/(:num)', 'Admin\HairstyleController::delete/$1');
    $routes->post('hairstyles/toggle-status/(:num)', 'Admin\HairstyleController::toggleStatus/$1');
    $routes->get('hairstyles/view/(:num)', 'Admin\HairstyleController::view/$1');
    $routes->get('hairstyles/categories', 'Admin\HairstyleController::categories');
    $routes->get('hairstyles/categories/create', 'Admin\HairstyleController::createCategory');
    $routes->post('hairstyles/categories/create', 'Admin\HairstyleController::createCategory');
    $routes->get('hairstyles/categories/edit/(:num)', 'Admin\HairstyleController::editCategory/$1');
    $routes->post('hairstyles/categories/edit/(:num)', 'Admin\HairstyleController::editCategory/$1');
    $routes->get('hairstyles/categories/delete/(:num)', 'Admin\HairstyleController::deleteCategory/$1');
    
    // Admin Management
    $routes->get('admins', 'Admin\AdminController::index');
    $routes->get('admins/create', 'Admin\AdminController::create');
    $routes->post('admins/store', 'Admin\AdminController::store');
    $routes->get('admins/edit/(:num)', 'Admin\AdminController::edit/$1');
    $routes->post('admins/update/(:num)', 'Admin\AdminController::update/$1');
    $routes->post('admins/delete/(:num)', 'Admin\AdminController::delete/$1');
    $routes->post('admins/toggle-status/(:num)', 'Admin\AdminController::toggleStatus/$1');
    $routes->get('admins/view/(:num)', 'Admin\AdminController::view/$1');
});
