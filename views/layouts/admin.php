<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet" href="/assets/css/new-sidebar.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin-verify.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px; }
        .toast { margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); animation: slideIn 0.5s ease-in-out; background-color: white; border-left: 4px solid #198754; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>
    <title>Admin Dashboard - MedVault</title>
</head>
<body>
    <div class="toast-container">
        <?php alertMessage(); ?>
    </div>
    <div class="main-container">
        <?php include dirname(__DIR__) . '/partials/admin-sidebar.php'; ?>
        <div class="mobile-topbar d-md-none">
            <button class="btn open-btn" type="button" aria-label="Open navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <span class="mobile-brand">MedVault</span>
        </div>
        <div class="sidebar-backdrop"></div>
        <div class="container-fluid mv-content">
            <?= $content ?>
        </div>
    </div>
    <script src="/assets/js/app.js"></script>
    <script>
        window.csrfToken = '<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>';
        $.ajaxPrefilter(function(options) {
            const method = (options.type || options.method || 'GET').toUpperCase();
            if (method !== 'POST') return;
            if (typeof options.data === 'string') {
                options.data += (options.data ? '&' : '') + '_csrf_token=' + encodeURIComponent(window.csrfToken);
            } else {
                options.data = Object.assign({}, options.data || {}, { _csrf_token: window.csrfToken });
            }
        });
        $(document).ready(function() {
            setTimeout(function() { $('.toast').fadeOut('slow'); }, 5000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.querySelector('.open-btn');
            const closeBtn = document.querySelector('.close-btn');
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.querySelector('.sidebar-backdrop');
            if (openBtn) openBtn.addEventListener('click', () => sidebar.classList.add('active'));
            if (openBtn) openBtn.addEventListener('click', () => backdrop.classList.add('active'));
            if (closeBtn) closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('active');
                backdrop.classList.remove('active');
            });
            if (backdrop) backdrop.addEventListener('click', () => {
                sidebar.classList.remove('active');
                backdrop.classList.remove('active');
            });
        });
    </script>
</body>
</html>
