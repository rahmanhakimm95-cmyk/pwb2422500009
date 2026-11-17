<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kota2422500009_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kota2422500009_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function index() {
        $data['kota'] = $this2422500009->ambil_semua();
        $this->load->view('Kota009/index', $data);
    }

    public function tambah() {
        $this->form_validation->set_rules('nama_kota009', 'Nama Kota', 'required');
        $this->form_validation->set_rules('jenis_kota009', 'Jenis', 'required');
        $this->form_validation->set_rules('provinsi009', 'Provinsi', 'required');
        $this->form_validation->set_rules('status009', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Kota2422500009/tambah');
        } else {
            $simpan = [
                'nama_kota009' => $this->input->post('nama_kota009'),
                'jenis_kota009' => $this->input->post('jenis_kota009'),
                'provinsi009' => $this->input->post('provinsi009'),
                'status009' => $this->input->post('status009')
            ];
            $this->Kota2422500009_model->tambah($simpan);
            redirect('Kota009_controller');
        }
    }

    public function ubah($id) {
        $data['kota'] = $this->Kota2422500009_model->ambil_satu($id);
        
        $this->form_validation->set_rules('nama_kota009', 'Nama Kota', 'required');
        $this->form_validation->set_rules('jenis_kota009', 'Jenis', 'required');
        $this->form_validation->set_rules('provinsi009', 'Provinsi', 'required');
        $this->form_validation->set_rules('status009', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Kota2422500009/ubah', $data);
        } else {
            $perbarui = [
                'nama_kota009' => $this->input->post('nama_kota009'),
                'jenis_kota009' => $this->input->post('jenis_kota009'),
                'provinsi009' => $this->input->post('provinsi009'),
                'status009' => $this->input->post('status009')
            ];
            $this->Kota2422500009_model->ubah($id, $perbarui);
            redirect('Kota2422500009_controller');
        }
    }

    public function hapus($id) {
        $this->Kota2422500009_model->hapus($id);
        redirect('Kota2422500009_controller');
    }
}