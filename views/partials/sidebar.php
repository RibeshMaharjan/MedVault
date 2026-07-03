<?php
/**
 * Unified sidebar for both pharmacy and admin shells.
 * Expects $navItems (array of ['label','href','icon','match']), $productLabel,
 * $productSubtitle, $userName, $userEmail, $userInitials, $currentPage, $logoutUrl.
 */
$cp = $currentPage ?? '';
?>
<aside class="app-sidebar">
    <div class="app-sidebar__header">
        <div class="app-sidebar__logo"><?= lucide('pill', 'icon-5') ?></div>
        <div class="app-sidebar__brand">
            <p class="app-sidebar__product"><?= htmlspecialchars($productLabel, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="app-sidebar__subtitle"><?= htmlspecialchars($productSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>
    <div class="app-sidebar__content">
        <p class="app-sidebar__group-label">Workspace</p>
        <ul class="app-sidebar__nav">
            <?php foreach ($navItems as $item): ?>
                <?php $isActive = $item['match'] !== '' && strpos($cp, $item['match']) === 0; ?>
                <li>
                    <a class="app-sidebar__link" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>" data-active="<?= $isActive ? 'true' : 'false' ?>">
                        <?= lucide($item['icon'], 'icon-4') ?>
                        <span class="app-sidebar__label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="app-sidebar__footer">
        <div class="app-sidebar__avatar"><?= htmlspecialchars($userInitials, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="app-sidebar__user-info">
            <p class="app-sidebar__user-name"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="app-sidebar__user-email"><?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <a class="app-sidebar__logout" href="<?= htmlspecialchars($logoutUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Sign out">
            <?= lucide('log-out', 'icon-4') ?>
        </a>
    </div>
</aside>
<div class="app-sidebar-overlay" data-sidebar-overlay></div>
