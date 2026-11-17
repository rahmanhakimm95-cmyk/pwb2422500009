<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Kategori Produk</h5>
                    <br>
                    
                    <a href="<?= base_url('administrator/kategori/tambah') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Kategori
                    </a>
                    <br><br>
                    
                    <?php if ($this->session->flashdata('pesan')): ?>
                        <?= $this->session->flashdata('pesan') ?>
                    <?php endif; ?>
                    
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($list_kategori as $k): ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $k['nama'] ?></td>
                                <td><?= $k['deskripsi'] ?></td>
                                <td>
                                    <a href="<?= base_url('administrator/kategori/ubah/'.$k['id_kategori']) ?>">
                                        <span class="badge bg-success">Ubah</span>
                                    </a>
                                    &nbsp;
                                    <a href="<?= base_url('administrator/kategori/hapus_kategori/'.$k['id_kategori']) ?>" onclick="return confirm('Yakin ingin menghapus?')">
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
    </section>
</div>