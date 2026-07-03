<?php $p = $pharmacy; ?>

<?= pageHeader('Profile', 'Manage your pharmacy business information and verification status.') ?>

<div class="grid-3col">
    <div class="card grid-3col--span2">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Business information</div></div>
        <div class="card__content">
            <form action="/pharmacy/profile" method="post">
                <?= csrf_field() ?>
                <div class="field-group field-group--2col">
                    <div class="field">
                        <label class="label" for="pharmacy_name">Pharmacy name</label>
                        <input type="text" class="input" id="pharmacy_name" name="pharmacy_name" value="<?= htmlspecialchars($p['pharmacy_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="field">
                        <label class="label" for="pan">PAN number</label>
                        <input type="text" class="input" id="pan" name="pan" value="<?= htmlspecialchars($p['pan'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="field">
                        <label class="label" for="email">Email</label>
                        <input type="email" class="input" id="email" name="email" value="<?= htmlspecialchars($p['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="field">
                        <label class="label" for="phone">Phone</label>
                        <input type="text" class="input" id="phone" name="phone" value="<?= htmlspecialchars($p['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="field" style="grid-column:1 / -1;">
                        <label class="label" for="address">Address</label>
                        <input type="text" class="input" id="address" name="address" value="<?= htmlspecialchars($p['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn--primary" style="margin-top:0.5rem;">Save changes</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Verification</div></div>
        <div class="card__content">
            <?php if ((int) ($p['isverified'] ?? 0) === 1): ?>
                <?= statusBadge('verified') ?>
                <div style="margin-top:0.75rem;font-size:0.875rem;">
                    <p><strong>Verified on:</strong> <?= !empty($p['verification_date']) ? date('F j, Y', strtotime($p['verification_date'])) : 'N/A' ?></p>
                    <p><strong>License:</strong> <?= htmlspecialchars($p['license_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <?php if (!empty($p['verification_notes'])): ?>
                        <p class="text-muted"><?= htmlspecialchars($p['verification_notes'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                </div>
            <?php elseif (!empty($p['verification_request_date'])): ?>
                <?= statusBadge('pending') ?>
                <div style="margin-top:0.75rem;font-size:0.875rem;">
                    <p><strong>Requested:</strong> <?= date('F j, Y', strtotime($p['verification_request_date'])) ?></p>
                    <p><strong>License:</strong> <?= htmlspecialchars($p['license_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <?php if (!empty($p['reg_document'])): ?>
                        <p><a href="/uploads/documents/<?= htmlspecialchars(basename($p['reg_document']), ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--outline btn--sm"><?= lucide('file-text', 'icon-4') ?> View document</a></p>
                    <?php endif; ?>
                </div>
                <div style="margin-top:0.75rem;padding:0.75rem;border-radius:var(--radius-md);background:color-mix(in oklab, var(--warning) 10%, transparent);font-size:0.75rem;color:var(--warning-foreground);">
                    Your verification request is under review.
                </div>
            <?php else: ?>
                <?= statusBadge('unverified') ?>
                <div style="margin-top:0.75rem;padding:0.75rem;border-radius:var(--radius-md);background:color-mix(in oklab, var(--warning) 10%, transparent);font-size:0.75rem;color:var(--warning-foreground);">
                    Verification is required to access all features.
                </div>
                <form action="/pharmacy/profile/verify" method="post" enctype="multipart/form-data" style="margin-top:1rem;">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label class="label" for="license_number">License number</label>
                        <input type="text" class="input" id="license_number" name="license_number" required>
                    </div>
                    <div class="field">
                        <label class="label">Registration document</label>
                        <label class="file-upload" data-file-upload>
                            <div data-file-upload-prompt>
                                <div class="file-upload__icon"><?= lucide('upload-cloud', 'icon-5') ?></div>
                                <p class="file-upload__text">Drag &amp; drop, or click to browse<br><span class="text-xs">PDF, PNG or JPG</span></p>
                            </div>
                            <div data-file-upload-chip hidden></div>
                            <input type="file" class="file-upload__input" name="reg_document" accept=".pdf,.png,.jpg,.jpeg" required>
                        </label>
                    </div>
                    <button type="submit" class="btn btn--outline" style="width:100%;">Request re-verification</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
