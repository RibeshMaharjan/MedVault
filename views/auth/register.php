<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/tokens.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <title>Create pharmacy account · MedVault</title>
</head>
<body>
    <div class="toast-container">
        <?php alertMessage(); ?>
    </div>

    <div class="auth-shell">
        <div class="auth-shell__form-col">
            <div class="auth-shell__form">
                <a href="/" class="auth-shell__logo">
                    <div class="app-sidebar__logo" style="width:2.25rem;height:2.25rem;"><?= lucide('pill', 'icon-5') ?></div>
                    <span style="font-size:1.125rem;font-weight:600;letter-spacing:-0.01em;">MedVault</span>
                </a>
                <h1 class="auth-shell__title">Create your pharmacy account</h1>
                <p class="auth-shell__subtitle">Start managing inventory in minutes. You can complete verification later.</p>

                <form action="/register" method="POST">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label class="label" for="name">Your name</label>
                        <input class="input" id="name" name="name" type="text" required placeholder="Jane Doe">
                    </div>
                    <div class="field">
                        <label class="label" for="email">Work email</label>
                        <input class="input" id="email" name="email" type="email" required placeholder="you@pharmacy.com">
                    </div>
                    <div class="field">
                        <label class="label" for="password">Password</label>
                        <input class="input" id="password" name="password" type="password" required minlength="8" placeholder="At least 8 characters">
                    </div>
                    <div class="field">
                        <label class="label" for="repassword">Confirm password</label>
                        <input class="input" id="repassword" name="repassword" type="password" required minlength="8" placeholder="Re-enter your password">
                    </div>
                    <button type="submit" class="btn btn--primary" style="width:100%;">Create account</button>
                    <p class="text-xs text-muted" style="text-align:center;margin-top:0.75rem;">By continuing you agree to the MedVault terms.</p>
                </form>

                <p class="auth-shell__foot">Already registered? <a href="/login">Sign in</a></p>
            </div>
        </div>
        <div class="auth-shell__panel">
            <div>
                <blockquote class="auth-shell__quote">
                    "MedVault cut our restocking meetings from an hour to ten minutes. The counter staff love how quiet it is."
                    <cite>— Priya N., pharmacy owner</cite>
                </blockquote>
            </div>
        </div>
    </div>

    <script src="/assets/js/ui.js" defer></script>
</body>
</html>
