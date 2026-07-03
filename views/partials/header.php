<header class="app-header">
    <button type="button" class="app-header__trigger" data-sidebar-trigger aria-label="Toggle sidebar">
        <?= lucide('panel-left', 'icon-4') ?>
    </button>
    <div class="app-header__search input-search">
        <?= lucide('search', 'icon-4') ?>
        <input type="search" class="input" placeholder="Search..." aria-label="Search">
    </div>
    <div class="app-header__actions">
        <button type="button" class="btn btn--ghost btn--icon" aria-label="Notifications">
            <?= lucide('bell', 'icon-4') ?>
        </button>
        <button type="button" class="btn btn--ghost btn--icon" aria-label="Settings">
            <?= lucide('settings', 'icon-4') ?>
        </button>
    </div>
</header>
