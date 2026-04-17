<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\Order;
use App\Models\UserMedicine;

class OrderController extends Controller
{
    private Order $order;
    private UserMedicine $medicine;

    public function __construct()
    {
        parent::__construct();
        $this->order = new Order();
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
            $conditions[] = "order_date BETWEEN :date_from AND :date_to";
            $params['date_from'] = $_GET['date_from'];
            $params['date_to'] = $_GET['date_to'];
        }

        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';
        $result = $this->order->paginateByPharmacy($userId, $page, 10, $where, $params);

        $this->view('pharmacy/orders/index', [
            'orders' => $result['data'],
            'pagination' => $result,
            'filters' => $_GET,
            'currentPage' => 'order-display',
        ], 'pharmacy');
    }

    public function create(): void
    {
        $this->view('pharmacy/orders/create', [
            'currentPage' => 'order-create',
        ], 'pharmacy');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();
        $medicineId = (int) ($_POST['m_id'] ?? 0);
        $price = (float) ($_POST['price'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $total = (float) ($_POST['total'] ?? 0);
        $date = $_POST['order_date'] ?? '';

        if (!is_numeric($quantity) || $quantity <= 0) {
            $this->redirect('/pharmacy/orders/create', 'Invalid quantity');
        }
        if (!is_numeric($price) || $price <= 0) {
            $this->redirect('/pharmacy/orders/create', 'Invalid price');
        }
        if (strtotime($date) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/orders/create', 'Order date cannot be in the past');
        }

        $med = $this->medicine->findById($medicineId, 'm_id');
        if (!$med || $med['in_stock'] < $quantity) {
            $this->redirect('/pharmacy/orders/create', 'Not enough stock available');
        }

        $this->order->insert([
            'pharmacy_id' => $userId,
            'm_id' => $medicineId,
            'price' => $price,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
            'order_date' => $date,
        ]);

        $this->medicine->updateStock($medicineId, -$quantity);
        $this->redirect('/pharmacy/orders', 'Order has been submitted successfully');
    }

    public function update(string $id): void
    {
        $orderId = (int) $id;
        $userId = $this->session->pharmacyId();

        $order = $this->order->findByIdAndPharmacy($orderId, $userId);
        if (!$order) {
            $this->redirect('/pharmacy/orders', 'Order not found');
        }

        $newStatus = $_POST['status'] ?? 'pending';
        $mId = (int) ($_POST['m_id'] ?? $order['m_id']);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $oldStatus = $order['status'];

        // Stock adjustments on status changes
        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            $med = $this->medicine->findById($mId, 'm_id');
            if ($med && $med['in_stock'] < $quantity) {
                $this->redirect('/pharmacy/orders', 'Not enough stock to complete this order.');
            }
            $this->medicine->updateStock($mId, -$quantity);
        } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
            $this->medicine->updateStock($mId, (int) $order['quantity']);
        }

        $this->order->updateByPharmacy($orderId, $userId, [
            'price' => (float) ($_POST['price'] ?? 0),
            'quantity' => $quantity,
            'total_amount' => (float) ($_POST['total'] ?? 0),
            'status' => $newStatus,
            'order_date' => $_POST['order_date'] ?? '',
        ]);

        $this->redirect('/pharmacy/orders', 'Order updated successfully');
    }

    public function destroy(string $id): void
    {
        $orderId = (int) $id;
        $userId = $this->session->pharmacyId();

        $order = $this->order->findByIdAndPharmacy($orderId, $userId);
        if (!$order) {
            $this->redirect('/pharmacy/orders', 'Order not found');
        }

        if ($order['status'] === 'completed') {
            $this->medicine->updateStock((int) $order['m_id'], (int) $order['quantity']);
        }

        $this->order->deleteByPharmacy($orderId, $userId);
        $this->redirect('/pharmacy/orders', 'Order deleted successfully');
    }
}
