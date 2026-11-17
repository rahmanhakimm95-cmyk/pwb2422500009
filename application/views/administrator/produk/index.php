<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                                <i class="fas fa-table me-1"></i> Semua Produk
                                <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label"></span> Tambah Produk <i class="fa fa-plus"></i>
                                </a>
                            </p>
                            
                            <?php if ($this->session->flashdata('message')): ?>
                                <?= $this->session->flashdata('message') ?>
                            <?php endif; ?>
                            
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($list_produk as $p): ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $p['pd_nama'] ?></td>
                                        <td><?= $p['kt_nama'] ?></td>
                                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                        <td><?= $p['stok'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/produk/ubah/'.$p['id_produk']) ?>">
                                                <span class="badge bg-success">Ubah</span>
                                            </a>
                                            &nbsp;
                                            <a href="<?= base_url('admin/produk/hapus/'.$p['id_produk']) ?>" 
                                               onclick="return confirm('Yakin ingin menghapus?')">
                                                <span class="badge bg-danger">Hapus</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>