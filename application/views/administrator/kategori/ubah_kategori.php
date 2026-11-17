<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator/kategori') ?>">Kategori</a></li>
                        <li class="breadcrumb-item active">Ubah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- FORM UBAH KATEGORI — TETAP SAMA PERSIS -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Ubah Data Kategori</h5>
                    <br>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" 
                                   value="<?= $kategori['nama'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_kategori" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi_kategori" id="deskripsi_kategori" rows="5" class="form-control"><?= $kategori['deskripsi'] ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('administrator/kategori') ?>" class="btn btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
            <!-- AKHIR FORM — TIDAK DIUBAH SEDIKITPUN -->

            <!-- DAFTAR PRODUK DENGAN GAMBAR — DITAMBAHKAN DI BAWAH, TIDAK MENGGANTI YANG ADA -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produk dalam Kategori Ini</h5>
                    <br>
                    
                    <?php if (!empty($daftar_produk)): ?>
                    <div class="row">
                        <?php foreach ($daftar_produk as $p): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card mb-3">
                                <?php if (!empty($p['gambar_pertama'])): ?>
                                <img src="<?= base_url('uploads/produk/'.$p['gambar_pertama']['nama_gambar']) ?>" 
                                     class="card-img-top" style="height: 180px; object-fit: cover;">
                                <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 180px;">
                                    <span class="text-muted">Tidak ada gambar</span>
                                </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h6 class="card-title mb-1"><?= $p['nama'] ?></h6>
                                    <p class="card-text text-success fw-bold">
                                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                                    </p>
                                    <a href="<?= base_url('admin/produk/ubah/'.$p['id_produk']) ?>" 
                                       class="btn btn-sm btn-primary">Ubah Produk</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p class="text-muted">Belum ada produk dalam kategori ini.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- AKHIR BAGIAN BARU -->
        </div>
    </section>
</div>