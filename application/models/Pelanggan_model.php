<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{
    private $_table = 'pelanggan';

    public function get_all()
    {
        return $this->db->get($this->_table)->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        // cek apakah data berhasil disimpan atau tidak
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function get_by_id($id)
    {
        $this->db->where('id_pelanggan', $id);
        return $this->db->get($this->_table)->row_array();
    }

    public function get_by_email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get($this->_table)->row_array();
    }

    public function check_login($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        return $this->db->get($this->_table)->row_array();
    }

    public function ubah($data, $id)
    {
        $this->db->where('id_pelanggan', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
