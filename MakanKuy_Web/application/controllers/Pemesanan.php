<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {
  //$this->load->library('session');
  public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','file'));
        $this->load->model('MPemesanan');
        $this->load->model('MRestoran');
    }

    function load_header(){
        $id=$this->session->userdata("resto");
        $contents['jml_pesan'] = $this->MPemesanan->jumlah_pesanan($id);
        $contents['data_pesan']= $this->MPemesanan->jumlah_data_pesanan($id);
        $contents['restoran']= $this->MRestoran->getOne($id);
        $this->load->view('Layout/Header.php',$contents);
    }

  function pesanan($id){
    if ($this->session->userdata('login_resto') == true) {
        $contents['restoran'] = $this->session->userdata('resto');
        $contents['pemesanan']=$this->MPemesanan->data_pemesanan($id);
        $this->load_header();
        $this->load->view('Resto/daftar_pesanan', $contents);
    }
    else {
        redirect('Resto/v_Login');
   }
  }
  function booking($id){
    if ($this->session->userdata('login_resto') == true) {
        $contents['restoran'] = $this->session->userdata('resto');
        $contents['booking']=$this->MPemesanan->data_booking($id);
        $this->load_header();
        $this->load->view('Resto/daftar_booking', $contents);
    }
    else {
        redirect('Resto/v_Login');
   }
  }

  function confirm_pesan($id_k,$id_r, $tgl){
     $tanggal=urldecode($tgl);
     $this->MPemesanan->updatePemesanan($id_k,$id_r,$tanggal);
     $saldo_awal=$this->MPemesanan->ambilSaldo($id_k);
     $deposit=$this->MPemesanan->ambilDeposit($id_k,$id_r,$tanggal);
     $this->MPemesanan->updateSaldo($id_k, $saldo_awal[0]->saldo, $deposit[0]->deposit);
     redirect('Pemesanan/pesanan/'.$id_r);
  }

  function del_pesan($idK, $idR, $tgl){
    $tanggal=urldecode($tgl);
    $this->MPemesanan->delPemesanan($idK, $idR, $tanggal);
    redirect('Pemesanan/pesanan/'.$idR);
  }
  function selesai_pesan($id_k,$id_r, $tgl){
    $tanggal=urldecode($tgl);
    $this->MPemesanan->selesaiBooking($id_k,$id_r,$tanggal);
    redirect('Pemesanan/booking/'.$id_r);
  }

}
