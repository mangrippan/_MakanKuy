<?php

class MPemesanan extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function data_pemesanan($id){
      $query=$this->db->select('*')-> from('pemesanan')->where('status',0)->where('id_restoran',$id)->get();
		  return $query->result();
    }
    function data_booking($id){
      $query=$this->db->select('*')->from('pemesanan')->where('status',1)->where('id_restoran',$id)->get();
      return $query->result();
    }
    function jumlah_pesanan($id) {
      $query=$this->db->select('*')->from('pemesanan')->where('status',0)->where('id_restoran',$id)->get();
      $jml_pesan=$query->num_rows();
      return $jml_pesan;
    }
    function jumlah_data_pesanan($id){
      $query=$this->db->select('*')->from('pemesanan')->where('status',1)->where('id_restoran',$id)->get();
      $data_pesan=$query->num_rows();//baru
      return $data_pesan;

    }
    function jumlah_booking($id){
      $query=$this->db->select('sum(jumlah_pesan) as booking')->from('pemesanan')->where('status',1)->where('id_restoran',$id)->get();
      //print_r($query);die();
      return $query->result();
    }
    //update pemesanan konsumen
    function updatePemesanan($idK, $idR, $tgl){
        $this->db->set('status',1);
        $this->db->where('id_konsumen', $idK);
        $this->db->where('id_restoran', $idR);
        $this->db->where('tanggal_pesan', $tgl);
        $this->db->update('pemesanan');
    }
    function ambilSaldo($idK){
      $query=$this->db->select('saldo')->from('konsumen')->where('id_konsumen',$idK)->get();
      return $query->result();
    }
    function ambilDeposit($idK, $idR, $tgl){
      $query=$this->db->select('deposit')->from('pemesanan')->where('id_konsumen',$idK)->where('id_restoran',$idR)->where('tanggal_pesan',$tgl)->get();
      return $query->result();
    }
    function updateSaldo($idK, $saldo_awal, $jml){
      $jumlah=(int)$jml; $saldo=(int)$saldo_awal;
      $saldo_update=$saldo-$jumlah;
      $this->db->set('saldo',$saldo_update);
      $this->db->where('id_konsumen',$idK);
      $this->db->update('konsumen');
    }
    function delPemesanan($idK, $idR, $tgl){
      $this->db->where('id_konsumen', $idK);
      $this->db->where('id_restoran', $idR);
      $this->db->where('tanggal_pesan',$tgl);
      $this->db->delete('pemesanan');
    }
    //selesai di resto
    function selesaiBooking($idK, $idR, $tgl){
        $this->db->set('status',2);
        $this->db->where('id_konsumen', $idK);
        $this->db->where('id_restoran', $idR);
        $this->db->where('tanggal_pesan', $tgl);
        $this->db->update('pemesanan');
    }
}
