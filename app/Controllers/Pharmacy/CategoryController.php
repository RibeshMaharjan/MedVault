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
        $userId = $this->session->pharmacyId();
        $name = $this->validate($_POST['name'] ?? '');

        if (empty($name)) {
            $this->redirect('/pharmacy/categories', 'Category name is required');
        }

        if (!$this->category->findByIdAndPharmacy($categoryId, $userId)) {
            $this->redirect('/pharmacy/categories', 'Category not found');
        }

        $this->category->updateByPharmacy($categoryId, $userId, ['category_name' => $name]);
        $this->redirect('/pharmacy/categories', 'Category Updated Successfully');
    }

    public function destroy(string $id): void
    {
        $categoryId = (int) $id;
        $userId = $this->session->pharmacyId();

        $category = $this->category->findByIdAndPharmacy($categoryId, $userId);
        if (!$category) {
            $this->redirect('/pharmacy/categories', 'Category not found');
        }

        $medicineCount = $this->category->hasMedicinesByPharmacy($categoryId, $userId);
        if ($medicineCount > 0) {
            $this->redirect('/pharmacy/categories', "Cannot delete: This category contains {$medicineCount} medicines. Please reassign them first.");
        }

        $this->category->deleteByPharmacy($categoryId, $userId);
        $this->redirect('/pharmacy/categories', 'Category deleted successfully');
    }
}
