<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_gambar_model extends CI_Model
{
    // Ubah nama tabel sesuai yang ada di database kamu
    // Coba salah satu: 'gambar_produk' atau 'produk_gambar' atau 'gambar'
    private $_table = 'produk_gambar';  // ← GANTI INI JIKA TETAP ERROR

    public function get_pertama_by_produk_id($produk_id)
    {
        $this->db->where('produk_id', $produk_id);
        $this->db->order_by('id_gambar', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get($this->_table);
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }
}