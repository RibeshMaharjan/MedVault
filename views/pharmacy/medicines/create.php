<div class="bg-white">
    <div class="row px-3 p-4">
        <div class="col"><h1 class="fw-normal mb-3">Append Medicine Form</h1></div>
    </div>
    <div class="row px-3 pb-4">
        <form action="/pharmacy/medicines" method="POST" class="form" autocomplete="off">
            <div class="mb-3">
                <label for="name" class="form-label">Medicine Name</label>
                <input class="form-control" type="text" placeholder="Medicine Name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['c_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" placeholder="Quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="buy_price" class="form-label">Buy Price</label>
                <input type="number" step="0.01" class="form-control" placeholder="Buy Price" name="buy_price" required>
            </div>
            <div class="mb-3">
                <label for="sell_price" class="form-label">Sell Price</label>
                <input type="number" step="0.01" class="form-control" placeholder="Sell Price" name="sell_price" required>
            </div>
            <div class="mb-3">
                <label for="exp_date" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" name="exp_date" required>
            </div>
            <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
        </form>
    </div>
</div>
