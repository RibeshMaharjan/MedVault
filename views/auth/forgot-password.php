<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/login/password-reset.css">
    <title>Forgot Password - MedVault</title>
</head>
<body>
    <div class="toast-container"><?php alertMessage(); ?></div>
    <main class="auth-card">
        <h1>Forgot password?</h1>
        <p>Enter your registered email address. We will send you a secure link to choose a new password.</p>
        <form action="/forgot-password" method="POST">
            <?= csrf_field() ?>
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" autocomplete="email" required autofocus>
            <button type="submit">Send reset link</button>
        </form>
        <a class="back-link" href="/login">Back to sign in</a>
    </main>
</body>
</html>
