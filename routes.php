<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\PharmacyMiddleware;
use App\Middleware\VerifiedPharmacyMiddleware;

$pharmacyAccess = [PharmacyMiddleware::class];
$verifiedPharmacyAccess = [PharmacyMiddleware::class, VerifiedPharmacyMiddleware::class];

// Auth
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Landing
$router->get('/', 'LandingController@index');

// Pharmacy - Dashboard
$router->get('/pharmacy/dashboard', 'Pharmacy\DashboardController@index', $verifiedPharmacyAccess);

// Pharmacy - Medicines
$router->get('/pharmacy/medicines', 'Pharmacy\MedicineController@index', $verifiedPharmacyAccess);
$router->get('/pharmacy/medicines/create', 'Pharmacy\MedicineController@create', $verifiedPharmacyAccess);
$router->post('/pharmacy/medicines', 'Pharmacy\MedicineController@store', $verifiedPharmacyAccess);
$router->post('/pharmacy/medicines/{id}', 'Pharmacy\MedicineController@update', $verifiedPharmacyAccess);
$router->post('/pharmacy/medicines/{id}/delete', 'Pharmacy\MedicineController@destroy', $verifiedPharmacyAccess);

// Pharmacy - Categories
$router->get('/pharmacy/categories', 'Pharmacy\CategoryController@index', $verifiedPharmacyAccess);
$router->post('/pharmacy/categories', 'Pharmacy\CategoryController@store', $verifiedPharmacyAccess);
$router->post('/pharmacy/categories/{id}', 'Pharmacy\CategoryController@update', $verifiedPharmacyAccess);
$router->post('/pharmacy/categories/{id}/delete', 'Pharmacy\CategoryController@destroy', $verifiedPharmacyAccess);

// Pharmacy - Orders
$router->get('/pharmacy/orders', 'Pharmacy\OrderController@index', $verifiedPharmacyAccess);
$router->get('/pharmacy/orders/create', 'Pharmacy\OrderController@create', $verifiedPharmacyAccess);
$router->post('/pharmacy/orders', 'Pharmacy\OrderController@store', $verifiedPharmacyAccess);
$router->post('/pharmacy/orders/{id}', 'Pharmacy\OrderController@update', $verifiedPharmacyAccess);
$router->post('/pharmacy/orders/{id}/delete', 'Pharmacy\OrderController@destroy', $verifiedPharmacyAccess);

// Pharmacy - Sales
$router->get('/pharmacy/sales', 'Pharmacy\SalesController@index', $verifiedPharmacyAccess);
$router->get('/pharmacy/sales/create', 'Pharmacy\SalesController@create', $verifiedPharmacyAccess);
$router->post('/pharmacy/sales', 'Pharmacy\SalesController@store', $verifiedPharmacyAccess);
$router->post('/pharmacy/sales/{id}', 'Pharmacy\SalesController@update', $verifiedPharmacyAccess);
$router->post('/pharmacy/sales/{id}/delete', 'Pharmacy\SalesController@destroy', $verifiedPharmacyAccess);

// Pharmacy - Analytics
$router->get('/pharmacy/analytics/sales', 'Pharmacy\AnalyticsController@sales', $verifiedPharmacyAccess);
$router->get('/pharmacy/analytics/orders', 'Pharmacy\AnalyticsController@orders', $verifiedPharmacyAccess);

// API - Pharmacy AJAX
$router->post('/api/pharmacy/search-medicine', 'Pharmacy\AjaxController@searchMedicine', $verifiedPharmacyAccess);
$router->post('/api/pharmacy/medicine-row', 'Pharmacy\AjaxController@getMedicineRow', $verifiedPharmacyAccess);
$router->get('/api/pharmacy/sales-data', 'Pharmacy\AjaxController@getSalesData', $verifiedPharmacyAccess);
$router->get('/api/pharmacy/order-data', 'Pharmacy\AjaxController@getOrderData', $verifiedPharmacyAccess);
$router->get('/api/pharmacy/inventory-levels', 'Pharmacy\AjaxController@getInventoryLevels', $verifiedPharmacyAccess);

// Pharmacy - Profile
$router->get('/pharmacy/profile', 'Pharmacy\ProfileController@edit', $pharmacyAccess);
$router->post('/pharmacy/profile', 'Pharmacy\ProfileController@update', $pharmacyAccess);
$router->post('/pharmacy/profile/verify', 'Pharmacy\ProfileController@requestVerification', $pharmacyAccess);
$router->get('/pharmacy/profile/document', 'Pharmacy\ProfileController@document', $pharmacyAccess);

// Admin - Dashboard
$router->get('/admin/dashboard', 'Admin\DashboardController@index', [AdminMiddleware::class]);

// Admin - Admins
$router->get('/admin/admins', 'Admin\AdminController@index', [AdminMiddleware::class]);
$router->post('/admin/admins', 'Admin\AdminController@store', [AdminMiddleware::class]);

// Admin - Pharmacies
$router->get('/admin/pharmacies', 'Admin\PharmacyController@index', [AdminMiddleware::class]);
$router->post('/admin/pharmacies', 'Admin\PharmacyController@store', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/delete', 'Admin\PharmacyController@destroy', [AdminMiddleware::class]);
$router->get('/admin/pharmacies/verify', 'Admin\PharmacyController@verify', [AdminMiddleware::class]);
$router->get('/admin/pharmacies/{id}', 'Admin\PharmacyController@show', [AdminMiddleware::class]);
$router->get('/admin/pharmacies/{id}/document', 'Admin\PharmacyController@document', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/approve', 'Admin\PharmacyController@approve', [AdminMiddleware::class]);
$router->post('/admin/pharmacies/{id}/reject', 'Admin\PharmacyController@reject', [AdminMiddleware::class]);
