<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\PharmacyMiddleware;

// Auth
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Landing
$router->get('/', 'LandingController@index');

// Pharmacy - Dashboard
$router->get('/pharmacy/dashboard', 'Pharmacy\DashboardController@index', [PharmacyMiddleware::class]);

// Pharmacy - Medicines
$router->get('/pharmacy/medicines', 'Pharmacy\MedicineController@index', [PharmacyMiddleware::class]);
$router->get('/pharmacy/medicines/create', 'Pharmacy\MedicineController@create', [PharmacyMiddleware::class]);
$router->post('/pharmacy/medicines', 'Pharmacy\MedicineController@store', [PharmacyMiddleware::class]);
$router->post('/pharmacy/medicines/{id}', 'Pharmacy\MedicineController@update', [PharmacyMiddleware::class]);
$router->post('/pharmacy/medicines/{id}/delete', 'Pharmacy\MedicineController@destroy', [PharmacyMiddleware::class]);

// Pharmacy - Categories
$router->get('/pharmacy/categories', 'Pharmacy\CategoryController@index', [PharmacyMiddleware::class]);
$router->post('/pharmacy/categories', 'Pharmacy\CategoryController@store', [PharmacyMiddleware::class]);
$router->post('/pharmacy/categories/{id}', 'Pharmacy\CategoryController@update', [PharmacyMiddleware::class]);
$router->post('/pharmacy/categories/{id}/delete', 'Pharmacy\CategoryController@destroy', [PharmacyMiddleware::class]);

// Pharmacy - Orders
$router->get('/pharmacy/orders', 'Pharmacy\OrderController@index', [PharmacyMiddleware::class]);
$router->get('/pharmacy/orders/create', 'Pharmacy\OrderController@create', [PharmacyMiddleware::class]);
$router->post('/pharmacy/orders', 'Pharmacy\OrderController@store', [PharmacyMiddleware::class]);
$router->post('/pharmacy/orders/{id}', 'Pharmacy\OrderController@update', [PharmacyMiddleware::class]);
$router->post('/pharmacy/orders/{id}/delete', 'Pharmacy\OrderController@destroy', [PharmacyMiddleware::class]);

// Pharmacy - Sales
$router->get('/pharmacy/sales', 'Pharmacy\SalesController@index', [PharmacyMiddleware::class]);
$router->get('/pharmacy/sales/create', 'Pharmacy\SalesController@create', [PharmacyMiddleware::class]);
$router->post('/pharmacy/sales', 'Pharmacy\SalesController@store', [PharmacyMiddleware::class]);
$router->post('/pharmacy/sales/{id}', 'Pharmacy\SalesController@update', [PharmacyMiddleware::class]);
$router->post('/pharmacy/sales/{id}/delete', 'Pharmacy\SalesController@destroy', [PharmacyMiddleware::class]);

// Pharmacy - Analytics
$router->get('/pharmacy/analytics/sales', 'Pharmacy\AnalyticsController@sales', [PharmacyMiddleware::class]);
$router->get('/pharmacy/analytics/orders', 'Pharmacy\AnalyticsController@orders', [PharmacyMiddleware::class]);

// API - Pharmacy AJAX
$router->post('/api/pharmacy/search-medicine', 'Pharmacy\AjaxController@searchMedicine', [PharmacyMiddleware::class]);
$router->post('/api/pharmacy/medicine-row', 'Pharmacy\AjaxController@getMedicineRow', [PharmacyMiddleware::class]);
$router->get('/api/pharmacy/sales-data', 'Pharmacy\AjaxController@getSalesData', [PharmacyMiddleware::class]);
$router->get('/api/pharmacy/order-data', 'Pharmacy\AjaxController@getOrderData', [PharmacyMiddleware::class]);
$router->get('/api/pharmacy/inventory-levels', 'Pharmacy\AjaxController@getInventoryLevels', [PharmacyMiddleware::class]);

// Pharmacy - Profile
$router->get('/pharmacy/profile', 'Pharmacy\ProfileController@edit', [PharmacyMiddleware::class]);
$router->post('/pharmacy/profile', 'Pharmacy\ProfileController@update', [PharmacyMiddleware::class]);
$router->post('/pharmacy/profile/verify', 'Pharmacy\ProfileController@requestVerification', [PharmacyMiddleware::class]);

// Admin - Dashboard
$router->get('/admin/dashboard', 'Admin\DashboardController@index', [AdminMiddleware::class]);

// Admin - Admins
$router->get('/admin/admins', 'Admin\AdminController@index', [AdminMiddleware::class]);
$router->get('/admin/admins/create', 'Admin\AdminController@create', [AdminMiddleware::class]);
$router->post('/admin/admins', 'Admin\AdminController@store', [AdminMiddleware::class]);

// Admin - Pharmacies
$router->get('/admin/pharmacies', 'Admin\PharmacyController@index', [AdminMiddleware::class]);
$router->get('/admin/pharmacies/create', 'Admin\PharmacyController@create', [AdminMiddleware::class]);
$router->post('/admin/pharmacies', 'Admin\PharmacyController@store', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/delete', 'Admin\PharmacyController@destroy', [AdminMiddleware::class]);
$router->get('/admin/pharmacies/verify', 'Admin\PharmacyController@verify', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/approve', 'Admin\PharmacyController@approve', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/reject', 'Admin\PharmacyController@reject', [AdminMiddleware::class]);

// Admin - Settings
$router->get('/admin/settings', 'Admin\SettingController@index', [AdminMiddleware::class]);
$router->post('/admin/settings', 'Admin\SettingController@update', [AdminMiddleware::class]);

// Admin - Export
$router->get('/admin/export/orders', 'Admin\ExportController@orders', [AdminMiddleware::class]);
