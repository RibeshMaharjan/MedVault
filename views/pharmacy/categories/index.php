<!-- Edit Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Category Edit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="categoryEditForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input class="form-control" type="text" id="edit_name" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-category">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5">Confirm Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="categoryDeleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="delete_category_id" id="delete_category_id">
                    <p>Are you sure you want to delete this category?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.
                    </div>
                    <div class="category-details mt-3">
                        <p><strong>Category ID:</strong> <span id="delete_category_display_id"></span></p>
                        <p><strong>Category Name:</strong> <span id="delete_category_name"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete-category">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Categories</h1>
            <p class="mv-page-subtitle">Group medicines for scanning and reports.</p>
        </div>
    </div>
    <div class="mv-two-col">
    <div class="mv-section">
            <h2 class="h5 mb-3">Add Category</h2>
            <form action="/pharmacy/categories" method="POST" class="mv-filter-actions">
                <?= csrf_field() ?>
                <div class="flex-grow-1">
                    <input class="form-control" type="text" placeholder="Category Name" name="category-name" required>
                </div>
                <button type="submit" class="btn btn-danger" name="submit-category">Add Category</button>
            </form>
    </div>
    <div class="mv-table-wrap">
        <?php if (!empty($categories)): ?>
        <div class="table-responsive">
        <table class="table table-striped mv-responsive-table">
            <thead class="table-danger">
                <tr><th>C.ID</th><th>Category Name</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td data-label="ID"><?= $cat['c_id'] ?></td>
                    <td data-label="Category"><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td class="mv-actions-cell" data-label="Action">
                        <div class="mv-icon-actions">
                            <button class="btn btn-success mv-icon-btn categoryEditBtn"
                                data-id="<?= $cat['c_id'] ?>"
                                data-name="<?= htmlspecialchars($cat['category_name']) ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger mv-icon-btn categoryDeleteBtn"
                                data-id="<?= $cat['c_id'] ?>"
                                data-name="<?= htmlspecialchars($cat['category_name']) ?>">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
            <div class="mv-empty">No categories found</div>
        <?php endif; ?>
    </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.categoryEditBtn').on('click', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#categoryEditForm').attr('action', '/pharmacy/categories/' + id);
        $('#update_id').val(id);
        $('#edit_name').val(name);
        $('#categoryEditModal').modal('show');
    });

    $('.categoryDeleteBtn').on('click', function () {
        var id = $(this).data('id');
        $('#categoryDeleteForm').attr('action', '/pharmacy/categories/' + id + '/delete');
        $('#delete_category_id').val(id);
        $('#delete_category_display_id').text(id);
        $('#delete_category_name').text($(this).data('name'));
        $('#categoryDeleteModal').modal('show');
    });
});
</script>
