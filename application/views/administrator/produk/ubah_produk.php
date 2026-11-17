<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/produk') ?>">Produk</a></li>
                        <li class="breadcrumb-item active">Ubah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Ubah Produk</h5>
                    <br>
                    <?= form_open_multipart('admin/produk/ubah/'.$produk['id_produk']) ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" 
                                   value="<?= $produk['nama'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_produk" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($list_kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" 
                                    <?= ($k['id_kategori'] == $produk['kategori_id']) ? 'selected' : '' ?>>
                                    <?= $k['nama'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga_produk" class="form-control" 
                                   value="<?= $produk['harga'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok_produk" class="form-control" 
                                   value="<?= $produk['stok'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi_produk" rows="4" class="form-control" required><?= $produk['deskripsi'] ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="row">
                                <?php if (!empty($daftar_gambar)): ?>
                                    <?php foreach ($daftar_gambar as $g): ?>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <img src="<?= base_url('uploads/produk/'.$g['nama_gambar']) ?>" 
                                             class="img-thumbnail mb-2" 
                                             style="height: 120px; object-fit: cover; width: 100%;">
                                        <p class="text-center small"><?= $g['nama_gambar'] ?></p>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Belum ada gambar untuk produk ini.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tambah Gambar Baru <small class="text-muted">(opsional)</small></label>
                            <input type="file" name="gambar_produk[]" class="form-control" multiple accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/produk') ?>" class="btn btn-danger">Kembali</a>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>