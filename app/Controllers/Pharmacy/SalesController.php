<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\Sale;
use App\Models\UserMedicine;

class SalesController extends Controller
{
    private Sale $sale;
    private UserMedicine $medicine;

    public function __construct()
    {
        parent::__construct();
        $this->sale = new Sale();
        $this->medicine = new UserMedicine();
    }

    public function index(): void
    {
        $userId = $this->session->pharmacyId();
        $page = (int) ($_GET['page'] ?? 1);
        $conditions = [];
        $params = [];

        if (!empty($_GET['status'])) {
            $conditions[] = "status = :status";
            $params['status'] = $_GET['status'];
        }
        if (!empty($_GET['date_from']) && !empty($_GET['date_to'])) {
            $conditions[] = "sales_date BETWEEN :date_from AND :date_to";
            $params['date_from'] = $_GET['date_from'];
            $params['date_to'] = $_GET['date_to'];
        }

        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';
        $result = $this->sale->paginateByPharmacy($userId, $page, 10, $where, $params);

        $this->view('pharmacy/sales/index', [
            'sales' => $result['data'],
            'pagination' => $result,
            'filters' => $_GET,
            'currentPage' => 'sales-display',
        ], 'pharmacy');
    }

    public function create(): void
    {
        $this->view('pharmacy/sales/create', [
            'currentPage' => 'sales-create',
        ], 'pharmacy');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();
        $medicineId = (int) ($_POST['m_id'] ?? 0);
        $price = (float) ($_POST['sellprice'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $total = (float) ($_POST['total'] ?? 0);
        $date = $_POST['sales_date'] ?? '';

        $med = $this->medicine->findById($medicineId, 'm_id');
        if (!$med || $med['in_stock'] < $quantity) {
            $this->redirect('/pharmacy/sales/create', 'Not enough stock available');
        }

        $this->sale->insert([
            'pharmacy_id' => $userId,
            'm_id' => $medicineId,
            'price' => $price,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
            'sales_date' => $date,
        ]);

        $this->redirect('/pharmacy/sales', 'Sale added successfully');
    }

    public function update(string $id): void
    {
        $saleId = (int) $id;
        $userId = $this->session->pharmacyId();

        $sale = $this->sale->findByIdAndPharmacy($saleId, $userId);
        if (!$sale) {
            $this->redirect('/pharmacy/sales', 'Sale not found');
        }

        $newStatus = $_POST['status'] ?? 'pending';
        $mId = (int) ($_POST['m_id'] ?? $sale['m_id']);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $oldStatus = $sale['status'];

        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            $this->medicine->updateStock($mId, -$quantity);
        } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
            $this->medicine->updateStock($mId, (int) $sale['quantity']);
        }

        $this->sale->updateByPharmacy($saleId, $userId, [
            'm_id' => $mId,
            'price' => (float) ($_POST['price'] ?? 0),
            'quantity' => $quantity,
            'total_amount' => (float) ($_POST['total'] ?? 0),
            'status' => $newStatus,
            'sales_date' => $_POST['sales_date'] ?? '',
        ]);

        $this->redirect('/pharmacy/sales', 'Sales Updated Successfully');
    }

    public function destroy(string $id): void
    {
        $saleId = (int) $id;
        $userId = $this->session->pharmacyId();

        $sale = $this->sale->findByIdAndPharmacy($saleId, $userId);
        if (!$sale) {
            $this->redirect('/pharmacy/sales', 'Sales record not found');
        }

        if ($sale['status'] === 'completed') {
            $this->medicine->updateStock((int) $sale['m_id'], (int) $sale['quantity']);
        }

        $this->sale->deleteByPharmacy($saleId, $userId);
        $this->redirect('/pharmacy/sales', 'Sales record removed and inventory adjusted successfully');
    }
}
