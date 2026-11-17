<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('Produk_model');
        $this->load->model('Produk_kategori_model');
        $this->load->model('Produk_gambar_model');
    }

    // Tampil Daftar Produk
    public function index()
    {
        $data['title'] = 'Daftar Produk';
        $data['list_produk'] = $this->Produk_model->get_all();
        
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/produk/index');
        $this->load->view('administrator/templates/footer');
    }

    // Form Tambah Produk
    public function tambah_produk()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
        
        if ($this->form_validation->run() !== FALSE) {
            $this->_simpan_produk();
        } else {
            $data['title'] = 'Tambah Produk';
            $data['list_kategori'] = $this->Produk_kategori_model->get_all();
            
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/produk/tambah_produk', $data);
            $this->load->view('administrator/templates/footer');
        }
    }

    // Proses Simpan Produk
    private function _simpan_produk()
    {
        $data = [
            'nama'         => ucwords($this->input->post('nama_produk')),
            'harga'        => $this->input->post('harga_produk'),
            'stok'         => $this->input->post('stok_produk'),
            'deskripsi'    => ucfirst($this->input->post('deskripsi_produk')),
            'kategori_id'  => $this->input->post('kategori_produk')
        ];
        
        $id_produk = $this->Produk_model->tambah($data);
        
        // Upload Gambar
        $count = count($_FILES['gambar_produk']['name']);
        if ($count > 0) {
            $this->_produk_gambar_upload($count, $id_produk);
        }
        
        $this->session->set_flashdata('message', '
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
                <div>Berhasil menambahkan produk!!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('admin/produk');
    }

    // Proses Upload Gambar
    private function _produk_gambar_upload($count, $id_produk)
    {
        for ($i = 0; $i < $count; $i++) {
            if (!empty($_FILES['gambar_produk']['name'][$i])) {
                $_FILES['file']['name']     = $_FILES['gambar_produk']['name'][$i];
                $_FILES['file']['type']     = $_FILES['gambar_produk']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['gambar_produk']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['gambar_produk']['error'][$i];
                $_FILES['file']['size']     = $_FILES['gambar_produk']['size'][$i];
                
                $config['upload_path']   = './uploads/produk/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 5000;
                $config['file_name']     = 'produk-' . $id_produk . '-' . $i;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    
                    $gambar_data = [
                        'nama_gambar' => $filename,
                        'produk_id'   => $id_produk
                    ];
                    $this->Produk_gambar_model->tambah($gambar_data);
                }
            }
        }
    }

    // Form Ubah Produk
    public function ubah_produk($id)
    {
        $produk = $this->Produk_model->get_by_id($id);
        
        if ($produk) {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
            $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
            
            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_produk($id);
            } else {
                $data['title'] = 'Ubah Produk';
                $data['produk'] = $produk;
                $data['list_kategori'] = $this->Produk_kategori_model->get_all();
                
                // Ambil daftar gambar produk
                $data['daftar_gambar'] = $this->Produk_gambar_model->get_by_produk_id($id);
                
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/produk/ubah_produk', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>Produk tidak ditemukan!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('admin/produk');
        }
    }

    // Proses Ubah Produk
    private function _ubah_produk($id)
    {
        $data = [
            'nama'         => ucwords($this->input->post('nama_produk')),
            'harga'        => $this->input->post('harga_produk'),
            'kategori_id'  => $this->input->post('kategori_produk'),
            'stok'         => $this->input->post('stok_produk'),
            'deskripsi'    => ucfirst($this->input->post('deskripsi_produk'))
        ];
        
        $ubah = $this->Produk_model->ubah($data, $id);
        
        if ($ubah) {
            // Upload gambar baru jika ada
            $count = count($_FILES['gambar_produk']['name']);
            if ($count > 0) {
                $this->_produk_gambar_upload($count, $id);
            }
            
            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                        <use xlink:href="#check-circle-fill"/>
                    </svg>
                    <div>Berhasil mengubah produk!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>Gagal mengubah produk!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('admin/produk');
    }

    // Hapus Produk
    public function hapus_produk($id)
    {
        $produk = $this->Produk_model->get_by_id($id);
        
        if ($produk) {
            // Ambil semua gambar terkait
            $list_gambar = $this->Produk_gambar_model->get_by_produk_id($id);
            
            foreach ($list_gambar as $gambar) {
                // Hapus dari database
                $this->Produk_gambar_model->hapus($gambar['id_gambar']);
                // Hapus file dari folder
                $path = './uploads/produk/' . $gambar['nama_gambar'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            
            // Hapus produk
            $this->Produk_model->hapus($id);
            
            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                        <use xlink:href="#check-circle-fill"/>
                    </svg>
                    <div>Berhasil menghapus produk!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>Produk tidak ditemukan!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('admin/produk');
    }
}