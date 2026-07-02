<?php

use App\Core\Security\Csrf;

function alertMessage(): void
{
    if (isset($_SESSION['status'])) {
        echo '
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">MedVault</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ' . htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8') . '
            </div>
        </div>';
        unset($_SESSION['status']);
    }
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
