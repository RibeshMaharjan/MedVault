<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Add Medicine</h1>
            <p class="mv-page-subtitle">Create an inventory item with stock, pricing, and expiry details.</p>
        </div>
    </div>
    <div class="mv-section mv-form-card">
        <form action="/pharmacy/medicines" method="POST" class="mv-form-grid" autocomplete="off">
            <?= csrf_field() ?>
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
            <div class="full mv-filter-actions">
                <button type="submit" class="btn btn-danger" name="add-medicine">Add Medicine</button>
                <a href="/pharmacy/medicines" class="btn btn-outline-secondary">View Medicines</a>
            </div>
        </form>
    </div>
</div>
