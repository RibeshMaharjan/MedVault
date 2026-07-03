<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedVault — Pharmacy inventory &amp; sales management</title>
    <meta name="description" content="MedVault is the modern operations platform for independent pharmacies — inventory, purchase orders, sales, and analytics in one place.">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/tokens.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <style>
        .landing-hero { position: relative; overflow: hidden; }
        .landing-hero__bg {
            position: absolute; inset: 0; z-index: -1; opacity: 0.7;
            background: radial-gradient(60% 60% at 50% 0%, var(--accent) 0%, transparent 70%);
        }
        .landing-nav { position: sticky; top: 0; z-index: 30; border-bottom: 1px solid color-mix(in oklab, var(--border) 60%, transparent); background: color-mix(in oklab, var(--background) 80%, transparent); backdrop-filter: blur(8px); }
        .landing-nav__inner, .landing-section { max-width: 72rem; margin-inline: auto; padding-inline: 1rem; }
        @media (min-width: 768px) { .landing-nav__inner, .landing-section { padding-inline: 1.5rem; } }
        .landing-nav__inner { height: 4rem; display: flex; align-items: center; justify-content: space-between; }
        .landing-brand { display: flex; align-items: center; gap: 0.5rem; }
        .landing-brand__logo { display: grid; place-items: center; width: 2.25rem; height: 2.25rem; border-radius: var(--radius-lg); background: var(--primary); color: var(--primary-foreground); }
        .landing-brand__name { font-size: 1.125rem; font-weight: 600; letter-spacing: -0.01em; }
        .landing-hero__content { padding-block: 4rem; }
        @media (min-width: 768px) { .landing-hero__content { padding-top: 6rem; padding-bottom: 6rem; } }
        .landing-hero__inner { max-width: 48rem; margin-inline: auto; text-align: center; }
        .landing-badge { display: inline-flex; align-items: center; gap: 0.5rem; border-radius: 9999px; border: 1px solid var(--border); background: var(--card); padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; color: var(--muted-foreground); }
        .landing-h1 { margin-top: 1.25rem; font-size: 2.25rem; font-weight: 600; letter-spacing: -0.02em; color: var(--foreground); }
        @media (min-width: 768px) { .landing-h1 { font-size: 3.75rem; } }
        .landing-h1 span { color: var(--primary); }
        .landing-lede { margin: 1.25rem auto 0; max-width: 42rem; font-size: 1rem; color: var(--muted-foreground); }
        @media (min-width: 768px) { .landing-lede { font-size: 1.125rem; } }
        .landing-cta-row { margin-top: 2rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 0.75rem; }
        .landing-fine { margin-top: 1rem; font-size: 0.75rem; color: var(--muted-foreground); }
        .feature-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; padding-bottom: 5rem; }
        @media (min-width: 768px) { .feature-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .feature-card { border-radius: var(--radius-2xl); border: 1px solid var(--border); background: var(--card); padding: 1.5rem; }
        .feature-card__icon { display: grid; place-items: center; width: 2.5rem; height: 2.5rem; border-radius: var(--radius-lg); background: color-mix(in oklab, var(--primary) 10%, transparent); color: var(--primary); }
        .feature-card__title { margin-top: 1rem; font-size: 1rem; font-weight: 600; }
        .feature-card__body { margin-top: 0.25rem; font-size: 0.875rem; color: var(--muted-foreground); }
        .cta-band { border-radius: var(--radius-2xl); border: 1px solid var(--border); background: linear-gradient(to bottom right, color-mix(in oklab, var(--primary) 10%, transparent), var(--card), color-mix(in oklab, var(--accent) 40%, transparent)); padding: 2rem; margin-bottom: 5rem; }
        @media (min-width: 768px) { .cta-band { padding: 3rem; } }
        .cta-band__grid { display: grid; gap: 1.5rem; align-items: center; }
        @media (min-width: 768px) { .cta-band__grid { grid-template-columns: 1fr auto; } }
        .cta-band__title { font-size: 1.5rem; font-weight: 600; letter-spacing: -0.01em; }
        @media (min-width: 768px) { .cta-band__title { font-size: 1.875rem; } }
        .cta-band__list { margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground); list-style: none; padding: 0; }
        .cta-band__list li { display: flex; align-items: center; gap: 0.5rem; }
        .cta-band__actions { display: flex; flex-direction: column; gap: 0.5rem; }
        @media (min-width: 768px) { .cta-band__actions { min-width: 220px; } }
        .landing-footer { border-top: 1px solid var(--border); padding-block: 2rem; }
        .landing-footer__inner { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; font-size: 0.75rem; color: var(--muted-foreground); }
    </style>
</head>
<body>
    <header class="landing-nav">
        <div class="landing-nav__inner">
            <div class="landing-brand">
                <div class="landing-brand__logo"><?= lucide('pill', 'icon-5') ?></div>
                <span class="landing-brand__name">MedVault</span>
            </div>
            <nav style="display:flex;align-items:center;gap:0.5rem;">
                <a href="/login" class="btn btn--ghost btn--sm">Sign in</a>
                <a href="/register" class="btn btn--primary btn--sm">Start free</a>
            </nav>
        </div>
    </header>

    <section class="landing-hero">
        <div class="landing-hero__bg"></div>
        <div class="landing-section landing-hero__content">
            <div class="landing-hero__inner">
                <span class="landing-badge">
                    <?= lucide('shield-check', 'icon-4') ?>
                    Built for independent pharmacies
                </span>
                <h1 class="landing-h1">Run your pharmacy on <span>one calm dashboard.</span></h1>
                <p class="landing-lede">Track every medicine, purchase order, and sale — with analytics that keep shelves stocked and expiries under control. MedVault is the quiet operations layer behind well-run pharmacies.</p>
                <div class="landing-cta-row">
                    <a href="/register" class="btn btn--primary btn--lg">Create pharmacy account <?= lucide('arrow-right', 'icon-4') ?></a>
                    <a href="/login" class="btn btn--outline btn--lg">Sign in</a>
                </div>
                <p class="landing-fine">No credit card required · 14-day trial</p>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-card__icon"><?= lucide('package', 'icon-5') ?></div>
                <h3 class="feature-card__title">Inventory that stays honest</h3>
                <p class="feature-card__body">Real stock levels, low-stock alerts, expiry tracking, and category organization built for medicines.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon"><?= lucide('shopping-cart', 'icon-5') ?></div>
                <h3 class="feature-card__title">Orders in, sales out</h3>
                <p class="feature-card__body">Search a medicine, drop it into the cart, and MedVault handles totals, status, and stock movement.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon"><?= lucide('bar-chart-3', 'icon-5') ?></div>
                <h3 class="feature-card__title">Analytics you'll actually open</h3>
                <p class="feature-card__body">Revenue trends, top movers, and order status at a glance — so restocking decisions take seconds.</p>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="cta-band">
            <div class="cta-band__grid">
                <div>
                    <h2 class="cta-band__title">Ready to trade spreadsheets for MedVault?</h2>
                    <ul class="cta-band__list">
                        <li><?= lucide('circle-check', 'icon-4') ?> Verified pharmacy accounts</li>
                        <li><?= lucide('circle-check', 'icon-4') ?> Role-based access for staff &amp; admins</li>
                        <li><?= lucide('circle-check', 'icon-4') ?> Works on tablets at the counter</li>
                    </ul>
                </div>
                <div class="cta-band__actions">
                    <a href="/register" class="btn btn--primary btn--lg" style="width:100%;">Get started</a>
                    <a href="/login" class="btn btn--outline btn--lg" style="width:100%;">I already have an account</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="landing-footer">
        <div class="landing-section landing-footer__inner">
            <p>&copy; <?= date('Y') ?> MedVault. All rights reserved.</p>
            <p>hello@medvault.io &middot; +1 (415) 555-0100</p>
        </div>
    </footer>
</body>
</html>
