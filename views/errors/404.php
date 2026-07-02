<?php http_response_code(404); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <div class="mx-auto" style="max-width: 560px;">
            <h1 class="h3 mb-3">Page Not Found</h1>
            <p class="text-muted mb-4">Requested page does not exist or is no longer available.</p>
            <a class="btn btn-primary" href="/login">Go to login</a>
        </div>
    </main>
</body>
</html>
