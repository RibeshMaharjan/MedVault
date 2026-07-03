<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;

class AnalyticsController extends Controller
{
    public function sales(): void
    {
        $this->view('pharmacy/analytics/sales', [
            'currentPage' => 'analysis-sales',
        ], 'app');
    }

    public function orders(): void
    {
        $this->view('pharmacy/analytics/orders', [
            'currentPage' => 'analysis-order',
        ], 'app');
    }
}
