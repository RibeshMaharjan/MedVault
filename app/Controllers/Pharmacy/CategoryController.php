<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct()
    {
        parent::__construct();
        $this->category = new Category();
    }

    public function index(): void
    {
        $userId = $this->session->pharmacyId();
        $categories = $this->category->findByPharmacy($userId);

        $this->view('pharmacy/categories/index', [
            'categories' => $categories,
            'currentPage' => 'category',
        ], 'pharmacy');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();
        $name = $this->validate(trim($_POST['category-name'] ?? ''));

        if (empty($name)) {
            $this->redirect('/pharmacy/categories', 'Category name is required');
        }

        $this->category->create($userId, $name);
        $this->redirect('/pharmacy/categories', 'Category Added');
    }

    public function update(string $id): void
    {
        $categoryId = (int) $id;
        $name = $this->validate($_POST['name'] ?? '');

        if (empty($name)) {
            $this->redirect('/pharmacy/categories', 'Category name is required');
        }

        $this->category->update($categoryId, ['category_name' => $name], 'c_id');
        $this->redirect('/pharmacy/categories', 'Category Updated Successfully');
    }

    public function destroy(string $id): void
    {
        $categoryId = (int) $id;

        $medicineCount = $this->category->hasMedicines($categoryId);
        if ($medicineCount > 0) {
            $this->redirect('/pharmacy/categories', "Cannot delete: This category contains {$medicineCount} medicines. Please reassign them first.");
        }

        $category = $this->category->findById($categoryId, 'c_id');
        if (!$category) {
            $this->redirect('/pharmacy/categories', 'Category not found');
        }

        $this->category->delete($categoryId, 'c_id');
        $this->redirect('/pharmacy/categories', 'Category deleted successfully');
    }
}
