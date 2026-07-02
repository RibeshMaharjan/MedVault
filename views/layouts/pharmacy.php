<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet" href="/assets/css/inventory/inventory.css">
    <link rel="stylesheet" href="/assets/css/inventory/category.css">
    <link rel="stylesheet" href="/assets/css/inventory/table.css">
    <link rel="stylesheet" href="/assets/css/editprofile.css">
    <link rel="stylesheet" href="/assets/css/medicine.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .alert-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 650px;
        }
        .alert {
            margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 320px;
            overflow-y: auto; background-color: white; z-index: 100;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .main-container { min-height: 100vh; display: block; }
        .container-fluid {
            margin-left: 320px; padding-bottom: 30px; min-height: 100vh;
            width: calc(100% - 320px); overflow-y: auto;
        }
        @media (max-width: 767px) {
            .sidebar { margin-left: -320px; transition: all 0.3s; }
            .sidebar.active { margin-left: 0; }
            .container-fluid { margin-left: 0; width: 100%; }
        }
        .toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px;
        }
        .toast {
            margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-in-out; background-color: white;
            border-left: 4px solid #198754;
        }
    </style>
    <title>MedVault</title>
</head>
<body>
    <div class="toast-container">
        <?php alertMessage(); ?>
    </div>

    <div class="main-container">
        <?php include dirname(__DIR__) . '/partials/pharmacy-sidebar.php'; ?>
        <div class="container-fluid p-5">
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
            setTimeout(function() { $('.alert').fadeOut('slow'); }, 5000);
            $('.alert').click(function() { $(this).fadeOut('slow'); });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.querySelector('.open-btn');
            const closeBtn = document.querySelector('.close-btn');
            const sidebar = document.querySelector('.sidebar');
            if (openBtn) openBtn.addEventListener('click', () => sidebar.classList.add('active'));
            if (closeBtn) closeBtn.addEventListener('click', () => sidebar.classList.remove('active'));
        });
    </script>
</body>
</html>
