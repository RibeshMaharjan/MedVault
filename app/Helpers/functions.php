<?php

use App\Core\Security\Csrf;

function alertMessage(): void
{
    if (isset($_SESSION['status'])) {
        $variant = ($_SESSION['status_type'] ?? 'success') === 'error' ? 'error' : 'success';
        $icon = $variant === 'error'
            ? '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
            : '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';

        echo '
        <div class="toast toast--' . $variant . '" role="alert" aria-live="assertive" aria-atomic="true">
            <svg class="toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $icon . '</svg>
            <span class="toast__body">' . htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8') . '</span>
            <button type="button" class="toast__close" aria-label="Dismiss">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>';
        unset($_SESSION['status'], $_SESSION['status_type']);
    }
}

function initialsOf(string $name): string
{
    $parts = array_filter(preg_split('/\s+/', trim($name)));
    if (empty($parts)) {
        return '';
    }
    $first = mb_substr(reset($parts), 0, 1);
    $last = count($parts) > 1 ? mb_substr(end($parts), 0, 1) : '';
    return mb_strtoupper($first . $last);
}

function pageHeader(string $title, string $description = '', string $actionsHtml = ''): string
{
    $html = '<div class="page-header"><div><h1 class="page-header__title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h1>';
    if ($description !== '') {
        $html .= '<p class="page-header__description">' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    $html .= '</div>';
    if ($actionsHtml !== '') {
        $html .= '<div class="page-header__actions">' . $actionsHtml . '</div>';
    }
    $html .= '</div>';
    return $html;
}

function statCard(string $label, string $value, string $icon, string $tone = 'default', string $hint = ''): string
{
    $html = '<div class="card stat-card"><div class="stat-card__content">';
    $html .= '<div class="stat-card__icon stat-card__icon--' . htmlspecialchars($tone, ENT_QUOTES, 'UTF-8') . '">' . lucide($icon, 'icon-5') . '</div>';
    $html .= '<div class="stat-card__body">';
    $html .= '<p class="stat-card__label">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</p>';
    $html .= '<p class="stat-card__value">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</p>';
    if ($hint !== '') {
        $html .= '<p class="stat-card__hint">' . htmlspecialchars($hint, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    $html .= '</div></div></div>';
    return $html;
}

function statusBadge(string $status): string
{
    $key = strtolower($status);
    $known = ['pending', 'completed', 'cancelled', 'verified', 'unverified'];
    $modifier = in_array($key, $known, true) ? $key : 'default';
    return '<span class="status-badge status-badge--' . $modifier . '">' . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</span>';
}

function sortableTh(string $label, string $class = ''): string
{
    $classAttr = $class !== '' ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"' : '';
    return '<th data-sort' . $classAttr . '><button type="button">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . ' ' . lucide('arrow-up-down', 'icon-3') . '</button></th>';
}

function csrf_field(): string
{
    return Csrf::field();
}

function csrf_token(): string
{
    return Csrf::token();
}

function generatePaginationLinks(int $currentPage, int $totalPages, string $urlPattern): string
{
    $links = '<nav aria-label="Page navigation" class="mt-4"><ul class="pagination justify-content-center">';

    // Previous
    $prevClass = $currentPage <= 1 ? ' disabled' : '';
    $links .= sprintf(
        '<li class="page-item%s"><a class="page-link" href="%s">Previous</a></li>',
        $prevClass,
        str_replace('{page}', $currentPage - 1, $urlPattern)
    );

    $visiblePages = 2;

    if ($currentPage > $visiblePages + 1) {
        $links .= sprintf(
            '<li class="page-item"><a class="page-link" href="%s">1</a></li>',
            str_replace('{page}', 1, $urlPattern)
        );
        if ($currentPage > $visiblePages + 2) {
            $links .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        }
    }

    $startPage = max(1, $currentPage - $visiblePages);
    $endPage = min($totalPages, $currentPage + $visiblePages);

    for ($i = $startPage; $i <= $endPage; $i++) {
        $activeClass = $i == $currentPage ? ' active' : '';
        $links .= sprintf(
            '<li class="page-item%s"><a class="page-link" href="%s">%d</a></li>',
            $activeClass,
            str_replace('{page}', $i, $urlPattern),
            $i
        );
    }

    if ($currentPage < $totalPages - $visiblePages) {
        if ($currentPage < $totalPages - $visiblePages - 1) {
            $links .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        }
        $links .= sprintf(
            '<li class="page-item"><a class="page-link" href="%s">%d</a></li>',
            str_replace('{page}', $totalPages, $urlPattern),
            $totalPages
        );
    }

    // Next
    $nextClass = $currentPage >= $totalPages ? ' disabled' : '';
    $links .= sprintf(
        '<li class="page-item%s"><a class="page-link" href="%s">Next</a></li>',
        $nextClass,
        str_replace('{page}', $currentPage + 1, $urlPattern)
    );

    $links .= '</ul></nav>';
    return $links;
}

function generateTableFooter(int $currentPage, int $perPage, int $total, string $urlPattern): string
{
    $totalPages = max(1, (int) ceil($total / max(1, $perPage)));
    $currentPage = min(max(1, $currentPage), $totalPages);

    if ($total === 0) {
        $rangeText = '0 results';
    } else {
        $start = ($currentPage - 1) * $perPage + 1;
        $end = min($currentPage * $perPage, $total);
        $rangeText = "Showing {$start}–{$end} of {$total}";
    }

    $prevDisabled = $currentPage <= 1 ? ' disabled' : '';
    $nextDisabled = $currentPage >= $totalPages ? ' disabled' : '';
    $prevHref = str_replace('{page}', (string) max(1, $currentPage - 1), $urlPattern);
    $nextHref = str_replace('{page}', (string) min($totalPages, $currentPage + 1), $urlPattern);

    return '
    <div class="data-table-footer">
        <span>' . htmlspecialchars($rangeText, ENT_QUOTES, 'UTF-8') . '</span>
        <div class="pager">
            <a class="btn btn--outline btn--sm' . $prevDisabled . '" href="' . htmlspecialchars($prevHref, ENT_QUOTES, 'UTF-8') . '" aria-label="Previous page">' . lucide('chevron-left', 'icon-4') . '</a>
            <span class="tabular-nums">' . $currentPage . ' / ' . $totalPages . '</span>
            <a class="btn btn--outline btn--sm' . $nextDisabled . '" href="' . htmlspecialchars($nextHref, ENT_QUOTES, 'UTF-8') . '" aria-label="Next page">' . lucide('chevron-right', 'icon-4') . '</a>
        </div>
    </div>';
}
