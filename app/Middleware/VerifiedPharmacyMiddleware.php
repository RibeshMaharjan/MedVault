<?php

namespace App\Middleware;

use App\Models\Pharmacy;

class VerifiedPharmacyMiddleware
{
    private Pharmacy $pharmacy;

    public function __construct(?Pharmacy $pharmacy = null)
    {
        $this->pharmacy = $pharmacy ?? new Pharmacy();
    }

    public function handle(): void
    {
        $pharmacyId = isset($_SESSION['pharmacy_id']) ? (int) $_SESSION['pharmacy_id'] : 0;
        $verified = $pharmacyId > 0 && $this->pharmacy->isVerified($pharmacyId);

        if ($verified) {
            return;
        }

        $message = 'Your pharmacy must be verified before you can access this feature.';
        $_SESSION['status'] = $message;

        if (($_ENV['APP_ENV'] ?? '') === 'testing') {
            throw new \RuntimeException('Verification required');
        }

        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        if (str_starts_with($path, '/api/')) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'verification_required', 'message' => $message]);
            exit;
        }

        header('Location: /pharmacy/profile');
        exit;
    }
}
