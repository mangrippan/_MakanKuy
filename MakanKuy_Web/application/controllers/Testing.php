<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->helper(array('url','file','form'));
      $this->load->model('MRestoran');
      $this->load->library('Restoran');
  }
  public function index()
  {
    // $tes=$this->MRestoran->getAll()[0];
    // $tes->set('nama','dua stories');
    // $this->MRestoran->save($tes);

    print_r($this->MRestoran->getOne('2stories'));

    $baru=new Restoran();
    $baru->inputResto('renis', 'cantik', 'sekali');
    $this->MRestoran->save($baru);
  }
  public function signUp($value='')
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
        else redirect('Testing/signUp');
    }
  }
  public function login()
  {
    if ($this->session->userdata('login_resto') == true) {
        redirect('Testing/dashboard');
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

  public function dashboard()
  {
      echo "Login Berhasil";
  }

  //PENGATURAN Restoran
  public function setting($value='')
  {
    # code...
  }

}

?>
