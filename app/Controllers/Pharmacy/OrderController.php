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
        ], 'app');
    }

    public function create(): void
    {
        $this->redirect('/pharmacy/orders?open=create');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();
        $medicineId = (int) ($_POST['m_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $date = $_POST['order_date'] ?? '';

        if (!is_numeric($quantity) || $quantity <= 0) {
            $this->redirect('/pharmacy/orders?open=create', 'Invalid quantity', 'error');
        }
        if (strtotime($date) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/orders?open=create', 'Order date cannot be in the past', 'error');
        }

        $med = $this->medicine->findByIdAndPharmacy($medicineId, $userId);
        if (!$med || $med['in_stock'] < $quantity) {
            $this->redirect('/pharmacy/orders?open=create', 'Not enough stock available', 'error');
        }
        if (strtotime($med['exp_date']) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/orders?open=create', 'Cannot order expired medicine', 'error');
        }

        $price = (float) $med['sell_price'];
        $total = $price * $quantity;

        try {
            $this->order->beginTransaction();
            $this->order->insert([
                'pharmacy_id' => $userId,
                'm_id' => $medicineId,
                'price' => $price,
                'quantity' => $quantity,
                'total_amount' => $total,
                'status' => 'pending',
                'order_date' => $date,
            ]);
            $this->medicine->updateStockByPharmacy($medicineId, $userId, -$quantity);
            $this->order->commit();
        } catch (\Throwable) {
            $this->order->rollBack();
            $this->redirect('/pharmacy/orders?open=create', 'Unable to create order', 'error');
        }

        $this->redirect('/pharmacy/orders', 'Order has been submitted successfully');
    }

    public function update(string $id): void
    {
        $orderId = (int) $id;
        $userId = $this->session->pharmacyId();

        $order = $this->order->findByIdAndPharmacy($orderId, $userId);
        if (!$order) {
            $this->redirect('/pharmacy/orders', 'Order not found', 'error');
        }

        $newStatus = $_POST['status'] ?? 'pending';
        $mId = (int) ($_POST['m_id'] ?? $order['m_id']);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $orderDate = $_POST['order_date'] ?? '';

        if (!in_array($newStatus, ['pending', 'completed', 'cancelled'], true)) {
            $this->redirect('/pharmacy/orders', 'Invalid status', 'error');
        }
        if ($quantity <= 0) {
            $this->redirect('/pharmacy/orders', 'Invalid quantity', 'error');
        }
        if (empty($orderDate) || strtotime($orderDate) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/orders', 'Invalid order date', 'error');
        }

        $med = $this->medicine->findByIdAndPharmacy($mId, $userId);
        if (!$med) {
            $this->redirect('/pharmacy/orders', 'Medicine not found', 'error');
        }
        if ($newStatus !== 'cancelled' && strtotime($med['exp_date']) < strtotime(date('Y-m-d'))) {
            $this->redirect('/pharmacy/orders', 'Cannot order expired medicine', 'error');
        }

        $oldMedicineId = (int) $order['m_id'];
        $oldQuantity = (int) $order['quantity'];
        $oldReserved = $order['status'] !== 'cancelled';
        $newReserved = $newStatus !== 'cancelled';

        $availableStock = (int) $med['in_stock'];
        if ($oldReserved && $oldMedicineId === $mId) {
            $availableStock += $oldQuantity;
        }
        if ($newReserved && $availableStock < $quantity) {
            $this->redirect('/pharmacy/orders', 'Not enough stock available', 'error');
        }

        $price = (float) $med['sell_price'];
        try {
            $this->order->beginTransaction();
            if ($oldReserved && $newReserved && $oldMedicineId === $mId) {
                $this->medicine->updateStockByPharmacy($mId, $userId, $oldQuantity - $quantity);
            } else {
                if ($oldReserved) {
                    $this->medicine->updateStockByPharmacy($oldMedicineId, $userId, $oldQuantity);
                }
                if ($newReserved) {
                    $this->medicine->updateStockByPharmacy($mId, $userId, -$quantity);
                }
            }
            $this->order->updateByPharmacy($orderId, $userId, [
                'm_id' => $mId,
                'price' => $price,
                'quantity' => $quantity,
                'total_amount' => $price * $quantity,
                'status' => $newStatus,
                'order_date' => $orderDate,
            ]);
            $this->order->commit();
        } catch (\Throwable) {
            $this->order->rollBack();
            $this->redirect('/pharmacy/orders', 'Unable to update order', 'error');
        }

        $this->redirect('/pharmacy/orders', 'Order updated successfully');
    }

    public function destroy(string $id): void
    {
        $orderId = (int) $id;
        $userId = $this->session->pharmacyId();

        $order = $this->order->findByIdAndPharmacy($orderId, $userId);
        if (!$order) {
            $this->redirect('/pharmacy/orders', 'Order not found', 'error');
        }

        try {
            $this->order->beginTransaction();
            if ($order['status'] !== 'cancelled') {
                $this->medicine->updateStockByPharmacy((int) $order['m_id'], $userId, (int) $order['quantity']);
            }
            $this->order->deleteByPharmacy($orderId, $userId);
            $this->order->commit();
        } catch (\Throwable) {
            $this->order->rollBack();
            $this->redirect('/pharmacy/orders', 'Unable to delete order', 'error');
        }

        $this->redirect('/pharmacy/orders', 'Order deleted successfully');
    }
}
