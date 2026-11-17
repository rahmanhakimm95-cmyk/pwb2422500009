<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    private $_table = 'produk';

    // TETAP SAMA
    public function get_all()
    {
        $this->db->select('produk.id_produk, produk.nama as pd_nama, produk.stok, 
                          produk.deskripsi, produk.harga, kategori.nama as kt_nama');
        $this->db->from($this->_table);
        $this->db->join('kategori', 'kategori.id_kategori = produk.kategori_id');
        return $this->db->get()->result_array();
    }

    // DITAMBAHKAN — Ambil produk per kategori
    public function get_by_kategori_id($kategori_id)
    {
        $this->db->where('kategori_id', $kategori_id);
        return $this->db->get($this->_table)->result_array();
    }

    // TETAP SAMA
    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    // TETAP SAMA
    public function get_by_id($id)
    {
        $this->db->where('id_produk', $id);
        return $this->db->get($this->_table)->row_array();
    }

    // TETAP SAMA
    public function ubah($data, $id)
    {
        $this->db->where('id_produk', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // TETAP SAMA
    public function hapus($id)
    {
        $this->db->where('id_produk', $id);
        return $this->db->delete($this->_table);
    }
}