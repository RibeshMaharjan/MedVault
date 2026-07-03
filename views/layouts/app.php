<?php
/**
 * Unified app shell layout for pharmacy + admin roles (replaces layouts/pharmacy.php and layouts/admin.php).
 * Role-derived nav/product/user config lives here so controllers don't need changes beyond
 * passing 'currentPage' (already the existing convention).
 */
$role = $session->role();
$user = $session->user() ?? [];
$userName = $user['name'] ?? '';
$userEmail = $user['email'] ?? '';

if ($role === 'admin') {
    $productLabel = 'MedVault';
    $productSubtitle = 'Platform admin';
    $navItems = [
        ['label' => 'Dashboard', 'href' => '/admin/dashboard', 'icon' => 'layout-dashboard', 'match' => 'dashboard'],
        ['label' => 'Pharmacies', 'href' => '/admin/pharmacies', 'icon' => 'building-2', 'match' => 'pharmacy'],
        ['label' => 'Verification', 'href' => '/admin/pharmacies/verify', 'icon' => 'shield-check', 'match' => 'verify'],
        ['label' => 'Admins', 'href' => '/admin/admins', 'icon' => 'users', 'match' => 'admin-'],
        ['label' => 'Settings', 'href' => '/admin/settings', 'icon' => 'settings', 'match' => 'settings'],
    ];
} else {
    $productLabel = 'MedVault';
    $productSubtitle = $userName !== '' ? $userName : 'Pharmacy';
    $navItems = [
        ['label' => 'Dashboard', 'href' => '/pharmacy/dashboard', 'icon' => 'layout-dashboard', 'match' => 'dashboard'],
        ['label' => 'Medicines', 'href' => '/pharmacy/medicines', 'icon' => 'package', 'match' => 'medicine'],
        ['label' => 'Categories', 'href' => '/pharmacy/categories', 'icon' => 'folder-tree', 'match' => 'category'],
        ['label' => 'Orders', 'href' => '/pharmacy/orders', 'icon' => 'shopping-cart', 'match' => 'order'],
        ['label' => 'Sales', 'href' => '/pharmacy/sales', 'icon' => 'trending-up', 'match' => 'sales'],
        ['label' => 'Analytics · Sales', 'href' => '/pharmacy/analytics/sales', 'icon' => 'bar-chart-3', 'match' => 'analysis-sales'],
        ['label' => 'Analytics · Orders', 'href' => '/pharmacy/analytics/orders', 'icon' => 'pie-chart', 'match' => 'analysis-order'],
        ['label' => 'Profile', 'href' => '/pharmacy/profile', 'icon' => 'user', 'match' => 'profile'],
    ];
}

$userInitials = initialsOf($userName !== '' ? $userName : 'U');
$logoutUrl = '/logout';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/tokens.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <title>MedVault</title>
</head>
<body>
    <div class="toast-container">
        <?php alertMessage(); ?>
    </div>

    <div class="app-shell" data-collapsed="false" data-mobile-open="false">
        <?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>
        <div class="app-main">
            <?php include dirname(__DIR__) . '/partials/header.php'; ?>
            <main class="app-content">
                <?= $content ?>
            </main>
        </div>
    </div>

    <script>
        window.csrfToken = '<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>';
    </script>
    <script src="/assets/js/ui.js" defer></script>
</body>
</html>
