<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/login/password-reset.css">
    <title>Reset Password - MedVault</title>
</head>
<body>
    <div class="toast-container"><?php alertMessage(); ?></div>
    <main class="auth-card">
        <?php if ($valid): ?>
            <h1>Choose a new password</h1>
            <p>Use at least eight characters with uppercase, lowercase, and a number.</p>
            <form action="/reset-password" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
                <label for="password">New password</label>
                <div class="password-wrapper">
                    <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required autofocus>
                    <i class="fa-regular fa-eye toggle-password"></i>
                </div>
                <label for="password_confirmation">Confirm new password</label>
                <div class="password-wrapper">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required>
                    <i class="fa-regular fa-eye toggle-password"></i>
                </div>
                <button type="submit">Reset password</button>
            </form>
        <?php else: ?>
            <h1>Link unavailable</h1>
            <p class="error">This password reset link is invalid, expired, or has already been used.</p>
            <a class="back-link" href="/forgot-password">Request a new reset link</a>
        <?php endif; ?>
        <a class="back-link" href="/login">Back to sign in</a>
    </main>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                var wrapper = this.closest('.password-wrapper');
                var input = wrapper.querySelector('input');
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    </script>
</body>
</html>
