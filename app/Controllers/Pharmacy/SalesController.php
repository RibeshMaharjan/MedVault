<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Core\TransactionStatus;
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
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $date = $_POST['sales_date'] ?? '';

        if ($quantity <= 0) {
            $this->redirect('/pharmacy/sales/create', 'Invalid quantity');
        }
        if (empty($date) || strtotime($date) === false) {
            $this->redirect('/pharmacy/sales/create', 'Invalid sales date');
        }

        $med = $this->medicine->findByIdAndPharmacy($medicineId, $userId);
        if (!$med || $med['in_stock'] < $quantity) {
            $this->redirect('/pharmacy/sales/create', 'Not enough stock available');
        }
        if (UserMedicine::isExpired($med)) {
            $this->redirect('/pharmacy/sales/create', 'Cannot sell expired medicine');
        }

        $price = (float) $med['sell_price'];
        $total = $price * $quantity;

        try {
            $this->sale->beginTransaction();
            $this->sale->insert([
                'pharmacy_id' => $userId,
                'm_id' => $medicineId,
                'price' => $price,
                'quantity' => $quantity,
                'total_amount' => $total,
                'status' => 'completed',
                'sales_date' => $date,
            ]);
            $this->medicine->updateStockByPharmacy($medicineId, $userId, -$quantity);
            $this->sale->commit();
        } catch (\Throwable) {
            $this->sale->rollBack();
            $this->redirect('/pharmacy/sales/create', 'Unable to create sale');
        }

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
        $salesDate = $_POST['sales_date'] ?? '';
        $oldStatus = $sale['status'];

        if (!TransactionStatus::isValid($newStatus)) {
            $this->redirect('/pharmacy/sales', 'Invalid status');
        }
        if ($quantity <= 0) {
            $this->redirect('/pharmacy/sales', 'Invalid quantity');
        }
        if (empty($salesDate) || strtotime($salesDate) === false) {
            $this->redirect('/pharmacy/sales', 'Invalid sales date');
        }

        $med = $this->medicine->findByIdAndPharmacy($mId, $userId);
        if (!$med) {
            $this->redirect('/pharmacy/sales', 'Medicine not found');
        }
        if ($newStatus === 'completed' && UserMedicine::isExpired($med)) {
            $this->redirect('/pharmacy/sales', 'Cannot sell expired medicine');
        }

        if ($newStatus === 'completed') {
            $availableStock = (int) $med['in_stock'];
            if ((int) $sale['m_id'] === $mId && $oldStatus === 'completed') {
                $availableStock += (int) $sale['quantity'];
            }
            if ($availableStock < $quantity) {
                $this->redirect('/pharmacy/sales', 'Not enough stock available');
            }
        }

        $price = (float) $med['sell_price'];
        try {
            $this->sale->beginTransaction();
            if ($oldStatus === 'completed') {
                $this->medicine->updateStockByPharmacy((int) $sale['m_id'], $userId, (int) $sale['quantity']);
            }
            if ($newStatus === 'completed') {
                $this->medicine->updateStockByPharmacy($mId, $userId, -$quantity);
            }
            $this->sale->updateByPharmacy($saleId, $userId, [
                'm_id' => $mId,
                'price' => $price,
                'quantity' => $quantity,
                'total_amount' => $price * $quantity,
                'status' => $newStatus,
                'sales_date' => $salesDate,
            ]);
            $this->sale->commit();
        } catch (\Throwable) {
            $this->sale->rollBack();
            $this->redirect('/pharmacy/sales', 'Unable to update sale');
        }

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

        try {
            $this->sale->beginTransaction();
            if ($sale['status'] === 'completed') {
                $this->medicine->updateStockByPharmacy((int) $sale['m_id'], $userId, (int) $sale['quantity']);
            }
            $this->sale->deleteByPharmacy($saleId, $userId);
            $this->sale->commit();
        } catch (\Throwable) {
            $this->sale->rollBack();
            $this->redirect('/pharmacy/sales', 'Unable to delete sale');
        }

        $this->redirect('/pharmacy/sales', 'Sales record removed and inventory adjusted successfully');
    }
}
