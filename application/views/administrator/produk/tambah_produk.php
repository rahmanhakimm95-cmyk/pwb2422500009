<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/produk') ?>">Produk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Produk</h5>
                    <br>

                    <?= form_open_multipart('admin/produk/tambah') ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_produk" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($list_kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>"><?= $k['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi_produk" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Produk <small class="text-muted">(bisa pilih lebih dari satu)</small></label>
                            <input type="file" name="gambar_produk[]" class="form-control" multiple accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('admin/produk') ?>" class="btn btn-danger">Kembali</a>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>