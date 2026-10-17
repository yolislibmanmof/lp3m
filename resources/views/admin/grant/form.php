<style>
    /* Card Form Dark Mode */
    .grant-form-card { 
        background: var(--surface); 
        border-radius: 20px; 
        border: 1px solid var(--border); 
        padding: 32px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
        max-width: 800px; 
        margin: 0 auto; 
    }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group.full { grid-column: span 2; }
    
    /* Label Light */
    .form-label { font-size: 13px; font-weight: 700; color: #fde68a; /* Gold label */ }
    
    /* Input Dark Glass */
    .form-input { 
        padding: 12px 16px; 
        border-radius: 12px; 
        border: 1px solid var(--border); 
        background: rgba(255, 255, 255, 0.05); /* Dark transparent */
        color: #fff; /* White text */
        font-size: 14px; 
        transition: all 0.2s; 
        font-family: inherit; 
    }
    
    .form-input:focus { 
        outline: none; 
        border-color: var(--primary); 
        background: rgba(255, 255, 255, 0.08); 
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); 
    }
    
    .form-input::placeholder { color: rgba(255, 255, 255, 0.3); }

    /* Select Arrow Fix for Dark Mode */
    .form-select { 
        appearance: none; 
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23fde68a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); 
        background-repeat: no-repeat; 
        background-position: right 12px center; 
        padding-right: 40px; 
    }
    
    /* Select Options (Browser dependent, but helps) */
    .form-select option { background: var(--surface); color: #fff; }

    /* Buttons */
    .btn-submit { 
        background: linear-gradient(145deg, #10b981, #059669); 
        color: white; 
        padding: 14px 28px; 
        border-radius: 12px; 
        border: none; 
        font-weight: 700; 
        font-size: 15px; 
        cursor: pointer; 
        transition: transform 0.2s; 
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); 
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(5, 150, 105, 0.4); }
    
    .btn-cancel { 
        background: transparent; 
        color: var(--muted); 
        padding: 14px 28px; 
        border-radius: 12px; 
        border: 1px solid var(--border); 
        font-weight: 700; 
        font-size: 15px; 
        cursor: pointer; 
        text-decoration: none; 
        display: inline-block; 
        text-align: center; 
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.2); }
</style>

<div style="margin-bottom: 24px;">
    <a href="<?= e(url('admin/index.php?page=hibah')) ?>" style="color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--muted)'">← Kembali ke Daftar Hibah</a>
    <h2 style="font-family: var(--font-display); font-size: 24px; font-weight: 900; color: #fff; margin: 8px 0 0;"><?= $item ? 'Edit Hibah' : 'Tambah Hibah Baru' ?></h2>
</div>

<?php if (!empty($flash)): ?>
    <div style="padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 600; background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2);">
        <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<div class="grant-form-card">
    <form method="post" action="<?= e($action) ?>">
        <?= csrf_field() ?>
        <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><?php endif; ?>

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label">Judul Hibah *</label>
                <input type="text" name="title" class="form-input" value="<?= e($item['title'] ?? old('title')) ?>" required placeholder="Contoh: Hibah Penelitian Internal Pemula 2026">
            </div>

            <div class="form-group">
                <label class="form-label">Sumber Dana *</label>
                <input type="text" name="source" class="form-input" value="<?= e($item['source'] ?? old('source')) ?>" required placeholder="Contoh: LP3M UNIMOF / Kemendiktisaintek">
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="type" class="form-input form-select">
                    <?php foreach (Grant::TYPES as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($item['type'] ?? old('type')) === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Deadline *</label>
                <input type="date" name="deadline" class="form-input" value="<?= e($item['deadline'] ?? old('deadline')) ?>" required style="color-scheme: dark;">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-input form-select">
                    <?php foreach (Grant::STATUSES as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($item['status'] ?? old('status')) === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nominal / Pagu Dana</label>
                <input type="text" name="funding_amount" class="form-input" value="<?= e($item['funding_amount'] ?? old('funding_amount')) ?>" placeholder="Contoh: Rp 5.000.000 atau Max 50 Juta">
            </div>

            <div class="form-group full">
                <label class="form-label">Link Proposal / Panduan (Opsional)</label>
                <input type="url" name="link_proposal" class="form-input" value="<?= e($item['link_proposal'] ?? old('link_proposal')) ?>" placeholder="https://...">
            </div>

            <div class="form-group full">
                <label class="form-label">Link Pendaftaran (Opsional)</label>
                <input type="url" name="link_registration" class="form-input" value="<?= e($item['link_registration'] ?? old('link_registration')) ?>" placeholder="https://...">
            </div>

            <div class="form-group full">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" class="form-input" rows="4" placeholder="Informasi tambahan seputar hibah..."><?= e($item['description'] ?? old('description')) ?></textarea>
            </div>
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border);">
            <a href="<?= e(url('admin/index.php?page=hibah')) ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"><?= $item ? 'Simpan Perubahan' : 'Tambah Hibah' ?></button>
        </div>
    </form>
</div>