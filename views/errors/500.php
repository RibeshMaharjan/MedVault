<?php http_response_code(500); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Something went wrong · MedVault</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/tokens.css">
    <link rel="stylesheet" href="/assets/css/components.css">
</head>
<body>
    <div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:0 1rem;">
        <div style="max-width:28rem;text-align:center;">
            <p class="text-xs font-semibold text-destructive" style="text-transform:uppercase;letter-spacing:0.08em;">Error 500</p>
            <h1 style="margin-top:0.75rem;font-size:2.25rem;font-weight:600;letter-spacing:-0.02em;">Something went wrong</h1>
            <p class="text-muted text-sm" style="margin-top:0.5rem;">An unexpected error interrupted this request. You can try again or head back home.</p>
            <div style="margin-top:1.5rem;display:flex;justify-content:center;gap:0.5rem;">
                <a href="/" class="btn btn--primary">Go home</a>
                <a href="/login" class="btn btn--outline">Sign in</a>
            </div>
        </div>
    </div>
</body>
</html>
