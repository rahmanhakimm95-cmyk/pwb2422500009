<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model');
        $this->load->model('Produk_kategori_model');
    }

    /* ===================== LOGIN ===================== */
    public function login()
    {
        if ($this->session->has_userdata('pelanggan_login')) {
            redirect(base_url());
            die;
        }

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE) {
            $this->_login();
        } else {
            $this->_tampil('ecom/pelanggan_login');
        }
    }

    private function _login()
    {
        $email    = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $check    = $this->Pelanggan_model->check_login($email, $password);

        if ($check) {
            $session_data = array(
                'id_pelanggan'    => $check['id_pelanggan'],
                'email_pelanggan' => $check['email'],
                'nama_pelanggan'  => $check['nama_pelanggan'],
                'pelanggan_login' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect(base_url());
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Email atau password salah!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('login');
    }

    /* ===================== REGISTER ===================== */
    public function register()
    {
        if ($this->session->has_userdata('pelanggan_login')) {
            redirect(base_url());
            die;
        }

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nopon', 'No Telpon', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kota', 'Kota Tinggal', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode POS', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE) {
            $this->_register();
        } else {
            $this->_tampil('ecom/pelanggan_register');
        }
    }

    private function _register()
    {
        $email = $this->input->post('email');

        // cek apakah email sudah terdaftar
        if (!($this->Pelanggan_model->get_by_email($email))) {
            $data = [
                'email'          => $email,
                'password'       => md5($this->input->post('password')),
                'nama_pelanggan' => ucwords($this->input->post('nama')),
                'telp_pelanggan' => $this->input->post('nopon'),
                'alamat'         => ucwords($this->input->post('alamat')),
                'kota'           => ucwords($this->input->post('kota')),
                'kode_pos'       => $this->input->post('kodepos'),
                'provinsi'       => ucwords($this->input->post('provinsi'))
            ];

            $simpan = $this->Pelanggan_model->tambah($data);
            if ($simpan) {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Berhasil register, Silakan <b>LOGIN!!</b></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            } else {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Gagal melakukan registrasi!!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            }
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Email yang anda masukan sudah terdaftar!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('register');
    }

    /* ===================== PROFIL (TUGAS) ===================== */
    public function profil()
    {
        if (!$this->session->has_userdata('pelanggan_login')) {
            redirect('login');
            die;
        }

        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($this->session->userdata('id_pelanggan'));
        $this->_tampil('ecom/pelanggan_profil', $data);
    }

    /* ===================== LOGOUT ===================== */
    public function logout()
    {
        $session_data = array('id_pelanggan', 'email_pelanggan', 'nama_pelanggan', 'pelanggan_login');
        $this->session->unset_userdata($session_data);
        redirect(base_url());
    }

    /* Helper: header + isi + footer */
    private function _tampil($view, $data = [])
    {
        $data['list_kategori'] = $this->Produk_kategori_model->get_all();
        $this->load->view('ecom/template/header', $data);
        $this->load->view($view, $data);
        $this->load->view('ecom/template/footer');
    }
}
