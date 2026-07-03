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

        foreach ($categories as &$cat) {
            $cat['medicine_count'] = $this->category->hasMedicinesByPharmacy((int) $cat['c_id'], $userId);
        }
        unset($cat);

        $this->view('pharmacy/categories/index', [
            'categories' => $categories,
            'currentPage' => 'category',
        ], 'app');
    }

    public function store(): void
    {
        $userId = $this->session->pharmacyId();
        $name = $this->validate(trim($_POST['category-name'] ?? ''));

        if (empty($name)) {
            $this->redirect('/pharmacy/categories?open=create', 'Category name is required', 'error');
        }
        if ($this->category->findByNameAndPharmacy($name, $userId)) {
            $this->redirect('/pharmacy/categories?open=create', 'Category already exists', 'error');
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
            $this->redirect('/pharmacy/categories', 'Category name is required', 'error');
        }

        if (!$this->category->findByIdAndPharmacy($categoryId, $userId)) {
            $this->redirect('/pharmacy/categories', 'Category not found', 'error');
        }

        $existing = $this->category->findByNameAndPharmacy($name, $userId);
        if ($existing && (int) $existing['c_id'] !== $categoryId) {
            $this->redirect('/pharmacy/categories', 'Category already exists', 'error');
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
            $this->redirect('/pharmacy/categories', 'Category not found', 'error');
        }

        $medicineCount = $this->category->hasMedicinesByPharmacy($categoryId, $userId);
        if ($medicineCount > 0) {
            $this->redirect('/pharmacy/categories', "Cannot delete: This category contains {$medicineCount} medicines. Please reassign them first.", 'error');
        }

        $this->category->deleteByPharmacy($categoryId, $userId);
        $this->redirect('/pharmacy/categories', 'Category deleted successfully');
    }
}
