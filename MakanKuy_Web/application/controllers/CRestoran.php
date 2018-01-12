<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRestoran extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->helper(array('url','file','form'));
      $this->load->model('MRestoran');
      $this->load->model('MPemesanan');
      $this->load->library('Restoran');
  }
  public function index()
  {
    if ($this->session->userdata('login_resto') == true) {
           redirect('CRestoran/dashboard');
     }
     else {
           redirect('CRestoran/login');
     }
  }
  public function signUp()
  {
      $this->load->view('Resto/signup.php');
      if($_POST){
        $username=$this->input->post('username');
        $nama=$this->input->post('nama');
        $password=$this->input->post('password');

        $resto_baru=new Restoran();
        $resto_baru->inputResto($username,$nama,$password);
        $this->MRestoran->save($resto_baru);

        if($resto_baru){
          echo '<script type="text/javascript" >
               alert("Sign Up Berhasil, Silahkan Login Kembali");
               window.location.href="'.base_url().'";
               </script>';
        }
        else redirect('CRestoran/signUp');
    }
  }
  public function login()
  {
    if ($this->session->userdata('login_resto') == true) {
        redirect('CRestoran/dashboard');
    }
    else {
        $this->load->view('Resto/v_Login');
        if($_POST){
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $cek= new Restoran();
            $cek->validasi_resto($username,$password);
            if($cek){
                $this->session->set_userdata('login_resto',true);
                $this->session->set_userdata('resto',$username);
            }
        }
      }
  }

  function logout()
    {
        $this->session->sess_destroy();
        redirect('CRestoran');
    }

  function load_header(){
      $id=$this->session->userdata("resto");
      $contents['jml_pesan'] = $this->MPemesanan->jumlah_pesanan($id);
      $contents['data_pesan']= $this->MPemesanan->jumlah_data_pesanan($id);
      $contents['restoran']= $this->MRestoran->getOne($id);
      $this->load->view('Layout/Header.php',$contents);
  }

  public function dashboard()
  {
      $id=$this->session->userdata("resto");
      if ($this->session->userdata('login_resto') == true) {
          $contents['restoran'] = $this->MRestoran->getOne($id);
          $contents['pemesanan'] = $this->MPemesanan->jumlah_booking($id);
          $this->load_header();
          $this->load->view('Resto/dashboard', $contents);
          //print_r($contents);
      }
      else {
          redirect('Resto/v_Login');
     }
  }

  //PENGATURAN Restoran
  public function setting_akun($id)
  {
     if ($this->session->userdata('login_resto') == true) {

        $contents['restoran']=$this->MRestoran->getOne($id);
        //print_r($contents);
        $this->load_header();
        $this->load->view('Resto/setting_akun',$contents);
     }
     else {
        redirect('CRestoran/v_Login');
    }
  }

  public function set_akun()
  {
    if ($this->session->userdata('login_resto') == true) {
      if($_POST){
        $id=$this->input->post("username");
        $nama=$this->input->post('nama');
        $password=$this->input->post('password');

        $updateAkun=$this->MRestoran->getOne($id);
        $updateAkun->set('id_restoran',$id);
        $updateAkun->set('nama',$nama);
        $updateAkun->set('password', $password);
        $this->MRestoran->save($updateAkun);
      }
      redirect('CRestoran/setting_akun/'.$id, 'refresh');
    }
    else {
        redirect('CRestoran/v_Login');
   }
  }

  public function setting_resto($id)
  {
     if ($this->session->userdata('login_resto') == true) {
        $contents['restoran']=$this->MRestoran->getOne($id);
        $this->load_header();
        $this->load->view('Resto/setting_resto',$contents);
     }
     else {
        redirect('CRestoran/v_Login');
    }
  }

  public function set_resto()
  {
    if ($this->session->userdata('login_resto') == true) {
      if($_POST){
        $id=$this->input->post("username");
        $jalan=$this->input->post('jalan');
        $kec=$this->input->post('kecamatan');
        $detail_tempat=$this->input->post("detail_tempat");
        $telp=$this->input->post("no_telp");
        $kap=$this->input->post("kapasitas");
        $jam_buka=$this->input->post("jam_buka");
        $jam_tutup=$this->input->post("jam_tutup");

        $update=$this->MRestoran->getOne($id);
        $update->set('id_restoran',$id);
        $update->set('jalan',$jalan);
        $update->set('kecamatan',$kec);
        $update->set('detail_tempat', $detail_tempat);
        $update->set('no_telp',$telp);
        $update->set('kapasitas', $kap);
        $update->set('jam_buka', $jam_buka);
        $update->set('jam_tutup', $jam_tutup);
        $this->MRestoran->save($update);
      }
      redirect('CRestoran/setting_resto/'.$id, 'refresh');
    }
    else {
        redirect('CRestoran/v_Login');
   }
  }
}

?>
