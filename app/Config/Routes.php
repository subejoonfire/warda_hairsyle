<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home routes
$routes->get('/', 'Home::index');
$routes->get('hairstyles', 'Home::hairstyles');
$routes->get('test-login', function() {
    return view('test_login');
});

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
    $routes->get('get-chats', 'Home::getChats');
});

// Admin routes (require admin role)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Hairstyles management
    $routes->get('hairstyles', 'Admin::hairstyles');
    $routes->get('hairstyles/create', 'Admin::createHairstyle');
    $routes->post('hairstyles/create', 'Admin::createHairstyle');
    $routes->get('hairstyles/edit/(:num)', 'Admin::editHairstyle/$1');
    $routes->post('hairstyles/edit/(:num)', 'Admin::editHairstyle/$1');
    $routes->get('hairstyles/delete/(:num)', 'Admin::deleteHairstyle/$1');
    
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
});
