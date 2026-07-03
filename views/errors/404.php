<?php http_response_code(404); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page not found · MedVault</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/tokens.css">
    <link rel="stylesheet" href="/assets/css/components.css">
</head>
<body>
    <div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:0 1rem;">
        <div style="max-width:28rem;text-align:center;">
            <p class="text-xs font-semibold text-primary" style="text-transform:uppercase;letter-spacing:0.08em;">Error 404</p>
            <h1 style="margin-top:0.75rem;font-size:2.25rem;font-weight:600;letter-spacing:-0.02em;">Page not found</h1>
            <p class="text-muted text-sm" style="margin-top:0.5rem;">The page you're looking for doesn't exist or has been moved.</p>
            <div style="margin-top:1.5rem;display:flex;justify-content:center;gap:0.5rem;">
                <a href="/" class="btn btn--primary">Return home</a>
                <a href="/login" class="btn btn--outline">Sign in</a>
            </div>
        </div>
    </div>
</body>
</html>
