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

<div class="row pt-4 g-5">
    <div class="col bg-white">
        <div class="row">
            <div class="col"><h1 class="fw-normal mb-3">Add Category</h1></div>
        </div>
        <div class="row pt-4 pb-4 w-50">
            <form action="/pharmacy/categories" method="POST" class="form">
                <?= csrf_field() ?>
                <div class="mb-3 category-input">
                    <input class="form-control" type="text" placeholder="Category Name" name="category-name" required>
                </div>
                <input type="submit" value="Add" class="btn btn-danger" name="submit-category">
            </form>
        </div>
    </div>
    <div class="col-md-6 pt-4 bg-white ms-md-auto">
        <?php if (!empty($categories)): ?>
        <table class="table table-striped">
            <thead class="table-danger">
                <tr><th>C.ID</th><th>Category Name</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['c_id'] ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td class="row g-0">
                        <div class="col">
                            <button class="btn btn-success btn-md px-3 py-2 my-2 categoryEditBtn"
                                data-id="<?= $cat['c_id'] ?>"
                                data-name="<?= htmlspecialchars($cat['category_name']) ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger btn-md px-3 py-2 my-2 categoryDeleteBtn"
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
        <?php else: ?>
            <h4 style="font-size: 26px; text-align: center;">No Data Found!</h4>
        <?php endif; ?>
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
