<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\UserMedicine;
use App\Models\Category;

class MedicineController extends Controller
{
    private UserMedicine $medicine;
    private Category $category;

    public function __construct()
    {
        parent::__construct();
        $this->medicine = new UserMedicine();
        $this->category = new Category();
    }

    public function index(): void
    {
        $userId = $this->session->pharmacyId();
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 10;

        // Build filter conditions with prepared statement params
        $conditions = [];
        $params = [];

        if (!empty($_GET['search'])) {
            $conditions[] = "medicine_name LIKE :search";
            $params['search'] = "%" . $_GET['search'] . "%";
        }
        if (!empty($_GET['category'])) {
            $conditions[] = "c_id = :category";
            $params['category'] = $_GET['category'];
        }
        if (!empty($_GET['exp_date_from']) && !empty($_GET['exp_date_to'])) {
            $conditions[] = "exp_date BETWEEN :date_from AND :date_to";
            $params['date_from'] = $_GET['exp_date_from'];
            $params['date_to'] = $_GET['exp_date_to'];
        }
        if (($_GET['buy_price_min'] ?? '') !== '') {
            $conditions[] = "buy_price >= :buy_min";
            $params['buy_min'] = $_GET['buy_price_min'];
        }
        if (($_GET['buy_price_max'] ?? '') !== '') {
            $conditions[] = "buy_price <= :buy_max";
            $params['buy_max'] = $_GET['buy_price_max'];
        }
        if (($_GET['sell_price_min'] ?? '') !== '') {
            $conditions[] = "sell_price >= :sell_min";
            $params['sell_min'] = $_GET['sell_price_min'];
        }
        if (($_GET['sell_price_max'] ?? '') !== '') {
            $conditions[] = "sell_price <= :sell_max";
            $params['sell_max'] = $_GET['sell_price_max'];
        }
        if (($_GET['stock_min'] ?? '') !== '') {
            $conditions[] = "in_stock >= :stock_min";
            $params['stock_min'] = $_GET['stock_min'];
        }
        if (($_GET['stock_max'] ?? '') !== '') {
            $conditions[] = "in_stock <= :stock_max";
            $params['stock_max'] = $_GET['stock_max'];
        }

        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';
        $paginatedResults = $this->medicine->paginateByPharmacy($userId, $page, $perPage, $where, $params);
        $categories = $this->category->findByPharmacy($userId);

        $data = [
            'medicines' => $paginatedResults['data'],
            'pagination' => $paginatedResults,
            'categories' => $categories,
            'filters' => $_GET,
            'currentPage' => 'medicine-display',
        ];

        $this->view('pharmacy/medicines/index', $data, 'app');
    }

    public function create(): void
    {
        $this->redirect('/pharmacy/medicines?open=create');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();

        $name = $this->validate($_POST['name'] ?? '');
        $description = $this->validate($_POST['description'] ?? '');
        $category = (int) ($_POST['category'] ?? 0);
        $inStock = (int) ($_POST['quantity'] ?? 0);
        $buyPrice = (float) ($_POST['buy_price'] ?? 0);
        $sellPrice = (float) ($_POST['sell_price'] ?? 0);
        $expDate = $_POST['exp_date'] ?? '';

        if (empty($name) || empty($category)) {
            $this->redirect('/pharmacy/medicines?open=create', 'Fill All the Fields', 'error');
        }
        if ($inStock < 0 || $buyPrice <= 0 || $sellPrice <= 0) {
            $this->redirect('/pharmacy/medicines?open=create', 'Invalid stock or price', 'error');
        }
        if (empty($expDate) || strtotime($expDate) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/medicines?open=create', 'Invalid expiration date', 'error');
        }
        if (!$this->category->findByIdAndPharmacy($category, $userId)) {
            $this->redirect('/pharmacy/medicines?open=create', 'Invalid category', 'error');
        }

        $this->medicine->insert([
            'pharmacy_id' => $userId,
            'medicine_name' => $name,
            'medicine_desc' => $description,
            'c_id' => $category,
            'in_stock' => $inStock,
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'exp_date' => date("Y-m-d", strtotime($expDate)),
        ]);

        $this->redirect('/pharmacy/medicines', 'Medicine Added Successfully');
    }

    public function update(string $id): void
    {
        $medicineId = (int) $id;
        $userId = $this->session->pharmacyId();

        $name = $this->validate($_POST['name'] ?? '');
        $description = $this->validate($_POST['description'] ?? '');
        $category = (int) ($_POST['category'] ?? 0);
        $inStock = (int) ($_POST['in_stock'] ?? 0);
        $buyPrice = (float) ($_POST['buy_price'] ?? 0);
        $sellPrice = (float) ($_POST['sell_price'] ?? 0);
        $expDate = $_POST['exp_date'] ?? '';

        if (empty($name) || empty($category)) {
            $this->redirect('/pharmacy/medicines', 'Please fill all required fields', 'error');
        }
        if ($inStock < 0 || $buyPrice <= 0 || $sellPrice <= 0) {
            $this->redirect('/pharmacy/medicines', 'Invalid stock or price', 'error');
        }
        if (empty($expDate) || strtotime($expDate) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/medicines', 'Invalid expiration date', 'error');
        }

        if (!$this->medicine->findByIdAndPharmacy($medicineId, $userId)) {
            $this->redirect('/pharmacy/medicines', 'Medicine not found', 'error');
        }
        if (!$this->category->findByIdAndPharmacy($category, $userId)) {
            $this->redirect('/pharmacy/medicines', 'Invalid category', 'error');
        }

        $this->medicine->updateByPharmacy($medicineId, $userId, [
            'medicine_name' => $name,
            'medicine_desc' => $description,
            'c_id' => $category,
            'in_stock' => $inStock,
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'exp_date' => $expDate,
        ]);

        $this->redirect('/pharmacy/medicines', 'Medicine updated successfully');
    }

    public function destroy(string $id): void
    {
        $medicineId = (int) $id;
        $userId = $this->session->pharmacyId();

        $medicine = $this->medicine->findByIdAndPharmacy($medicineId, $userId);
        if (!$medicine) {
            $this->redirect('/pharmacy/medicines', 'Medicine not found', 'error');
        }

        $related = $this->medicine->hasRelatedRecordsByPharmacy($medicineId, $userId);
        if ($related['sales'] > 0 || $related['orders'] > 0) {
            $this->redirect('/pharmacy/medicines', 'Cannot delete: This medicine has related sales or order records', 'error');
        }

        $this->medicine->deleteByPharmacy($medicineId, $userId);
        $this->redirect('/pharmacy/medicines', 'Medicine deleted successfully');
    }
}
