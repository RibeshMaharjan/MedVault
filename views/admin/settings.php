<div class="container-fluid bg-white">
    <div class="row pt-3 ps-2"><div class="col"><h1 class="fw-normal mb-3">WebSite Settings</h1></div></div>
    <div class="row px-2 pt-3">
        <?php if ($settings): ?>
        <form action="/admin/settings" method="POST" class="form">
            <div class="mb-3"><label class="form-label">Heading</label><input class="form-control" type="text" name="title" value="<?= htmlspecialchars($settings['title'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">Small Description</label><textarea class="form-control" rows="3" name="small-description"><?= htmlspecialchars($settings['small_description'] ?? '') ?></textarea></div>
            <div class="mb-3"><label class="form-label">Sub-Heading</label><input type="text" class="form-control" name="sub-title" value="<?= htmlspecialchars($settings['sub_title'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">Sub-Description</label><textarea class="form-control" rows="3" name="sub-description"><?= htmlspecialchars($settings['sub_description'] ?? '') ?></textarea></div>
            <div class="mb-3"><label class="form-label">Phone</label><input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($settings['email'] ?? '') ?>"></div>
            <input type="submit" value="Save Setting" class="btn btn-danger" name="saveSetting">
        </form>
        <?php else: ?>
            <h5>Settings not found</h5>
        <?php endif; ?>
    </div>
</div>
