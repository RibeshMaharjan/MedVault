<?= pageHeader('Settings', 'Manage the public landing page content.') ?>

<?php if ($settings): ?>
    <form action="/admin/settings" method="POST">
        <?= csrf_field() ?>
        <div class="grid-2col">
            <div class="card">
                <div class="card__header"><div class="card__title" style="font-size:1rem;">Hero</div></div>
                <div class="card__content">
                    <div class="field">
                        <label class="label" for="title">Title</label>
                        <input class="input" type="text" id="title" name="title" value="<?= htmlspecialchars($settings['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="field">
                        <label class="label" for="sub-title">Subtitle</label>
                        <input class="input" type="text" id="sub-title" name="sub-title" value="<?= htmlspecialchars($settings['sub_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="field">
                        <label class="label" for="small-description">Description</label>
                        <textarea class="textarea" id="small-description" name="small-description" rows="3"><?= htmlspecialchars($settings['small_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                    <div class="field">
                        <label class="label" for="sub-description">Extended description</label>
                        <textarea class="textarea" id="sub-description" name="sub-description" rows="3"><?= htmlspecialchars($settings['sub_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card__header"><div class="card__title" style="font-size:1rem;">Contact</div></div>
                <div class="card__content">
                    <div class="field">
                        <label class="label" for="email">Email</label>
                        <input class="input" type="email" id="email" name="email" value="<?= htmlspecialchars($settings['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="field">
                        <label class="label" for="phone">Phone</label>
                        <input class="input" type="text" id="phone" name="phone" value="<?= htmlspecialchars($settings['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn--primary" style="margin-top:1rem;">Save settings</button>
    </form>
<?php else: ?>
    <p class="text-sm text-muted">Settings not found.</p>
<?php endif; ?>
