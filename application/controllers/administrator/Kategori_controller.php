<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('Produk_kategori_model');
        $this->load->model('Produk_model');       // Tetap ada
        $this->load->model('Produk_gambar_model');// Ditambahkan
    }

    // Daftar Kategori — TIDAK DIUBAH
    public function index()
    {
        $data['title'] = 'Daftar Kategori';
        $data['list_kategori'] = $this->Produk_kategori_model->get_all();
        
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/kategori/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    // Form Tambah Kategori — TIDAK DIUBAH
    public function tambah()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        
        if ($this->form_validation->run() === TRUE) {
            $data_simpan = [
                'nama'      => $this->input->post('nama_kategori'),
                'deskripsi' => $this->input->post('deskripsi_kategori')
            ];
            
            if ($this->Produk_kategori_model->tambah($data_simpan)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Kategori berhasil ditambahkan!</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menambah kategori!</div>');
            }
            redirect('administrator/kategori');
        }

        $data['title'] = 'Tambah Kategori';
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/kategori/tambah_kategori', $data);
        $this->load->view('administrator/templates/footer');
    }

    // Form Ubah Kategori — DILENGKAPI TANPA MENGUBAH YANG SUDAH ADA
    public function ubah($id)
    {
        $data['kategori'] = $this->Produk_kategori_model->get_by_id($id);
        if (!$data['kategori']) {
            show_404();
        }

        // Ambil daftar produk sesuai kategori — ditambahkan
        $data['daftar_produk'] = $this->Produk_model->get_by_kategori_id($id);
        
        // Siapkan gambar pertama untuk setiap produk — ditambahkan
        if (!empty($data['daftar_produk'])) {
            foreach ($data['daftar_produk'] as &$produk) {
                $produk['gambar_pertama'] = $this->Produk_gambar_model->get_pertama_by_produk_id($produk['id_produk']);
            }
        }

        // Bagian validasi & simpan — TETAP SAMA, TIDAK DIUBAH
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        
        if ($this->form_validation->run() === TRUE) {
            $update_data = [
                'nama'      => $this->input->post('nama_kategori'),
                'deskripsi' => $this->input->post('deskripsi_kategori')
            ];
            
            if ($this->Produk_kategori_model->ubah($id, $update_data)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Kategori berhasil diubah!</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal mengubah kategori!</div>');
            }
            redirect('administrator/kategori');
        }

        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/kategori/ubah_kategori', $data);
        $this->load->view('administrator/templates/footer');
    }

    // Hapus Kategori — TETAP SAMA, TIDAK DIUBAH
    public function hapus_kategori($id)
    {
        $kategori = $this->Produk_kategori_model->get_by_id($id);
        if ($kategori) {
            $hapus = $this->Produk_kategori_model->hapus($id);
            if ($hapus) {
                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>Berhasil menghapus kategori!!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            } else {
                $this->session->set_flashdata('pesan', '
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>Gagal menghapus kategori!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            }
        } else {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Kategori tidak ditemukan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('administrator/kategori');
    }
}