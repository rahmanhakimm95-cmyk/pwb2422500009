<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kota2422500009_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kota2422500009_model');
    }

    public function index()
    {
        $data['list_kota'] = $this->Kota2422500009_model->get_all();
        $this->load->view('administrator/templates/header');
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/Kota009/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    public function tambah_kota2422500009()
    {
        $data['title'] = 'Tambah Kota2422500009';
        $this->form_validation->set_rules('nama_kota', 'Nama Kota', 'required');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() !== FALSE) {
            $this->_simpan_kota2422500009();
        } else {
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/Kota2422500009/tambah_kota2422500009');
            $this->load->view('administrator/templates/footer');
        }
    }

    private function _simpan_kota2422500009()
    {
        $data = [
            'nama_kota009'   => ucwords($this->input->post('nama_kota')),
            'jenis_kota009'  => ucwords($this->input->post('jenis')),
            'provinsi009'    => strtoupper($this->input->post('provinsi')),
            'status009'      => ucwords($this->input->post('status'))
        ];

        $simpan = $this->Kota2422500009_model->tambah($data);

        if ($simpan) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
                <div>Berhasil menambahkan data Kota009!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>Gagal menambahkan data Kota009!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }
        redirect('administrator/Kota2422500009');
    }

    public function hapus_kota2422500009($id)
    {
        $kota = $this->Kota2422500009_model->get_by_id($id);
        if ($kota) {
            $hapus = $this->Kota2422500009_model->hapus($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                        <use xlink:href="#check-circle-fill"/>
                    </svg>
                    <div>Berhasil menghapus data Kota009!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>Gagal menghapus data Kota2422500009!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            }
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>Data Kota2422500009 tidak ditemukan!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }
        redirect('administrator/Kota2422500009');
    }

    public function ubah_kota2422500009($id)
    {
        $kota = $this->Kota2422500009_model->get_by_id($id);
        if ($kota) {
            $this->form_validation->set_rules('nama_kota', 'Nama Kota', 'required');
            $this->form_validation->set_rules('jenis', 'Jenis', 'required');
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() === FALSE) {
                $data['title'] = 'Ubah Kota2422500009';
                $data['kota']  = $kota;
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/Kota009/ubah_kota009', $data);
                $this->load->view('administrator/templates/footer');
            } else {
                $this->_perbarui_kota2422500009($id);
            }
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>Data Kota24500009 tidak ditemukan!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('administrator/Kota2422500009');
        }
    }

    private function _perbarui_kota2422500009($id)
    {
        $data = [
            'nama_kota009'   => ucwords($this->input->post('nama_kota')),
            'jenis_kota009'  => ucwords($this->input->post('jenis')),
            'provinsi009'    => strtoupper($this->input->post('provinsi')),
            'status009'      => ucwords($this->input->post('status'))
        ];

        $ubah = $this->Kota2422500009_model->ubah($data, $id);

        if ($ubah) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
                <div>Berhasil mengubah data Kota2422500009!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>Gagal mengubah data Kota2422500009!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }
        redirect('administrator/Kota2422500009');
    }
}