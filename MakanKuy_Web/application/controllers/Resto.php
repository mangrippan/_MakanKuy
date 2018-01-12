<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resto extends CI_Controller {
  public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','file','form'));
        $this->load->model('MResto');
        $this->load->model('MResto2');
        $this->load->model('MPemesanan');
    }

    public function login(){
        if ($this->session->userdata('login_resto') == true) {
            redirect('Resto/dashboard');
        }
        else {
            $this->load->view('Resto/v_Login');
            if($_POST){
				        $username = $this->input->post('username');
				        $password = $this->input->post('password');
                $result=$this->MResto->validasi_resto($username, $password);
                if(!empty($result)){
                    $this->session->set_userdata('login_resto',true);
                    $this->session->set_userdata('resto',$result);
                }
            }
        }
    }
  public function signup(){
      $this->load->view('Resto/signup.php');
      if($_POST){
        $username=$this->input->post('username');
        $nama=$this->input->post('nama');
        $password=$this->input->post('password');
        $result=$this->MResto->inputResto($username, $nama, $password);
        if($result){
          echo '<script type="text/javascript" >
  			       alert("Sign Up Berhasil, Silahkan Login Kembali");
               window.location.href="'.base_url().'";
  		         </script>';
        }
        else redirect('Resto/signup');
    }

  }
	function logout()
    {
        $this->session->sess_destroy();
        redirect('Resto');
    }

	public function index()
	{
     $this->load->library('session');
		 if ($this->session->userdata('login_resto') == true) {
            redirect('Resto/dashboard');
      }
      else {
            redirect('Resto/login');
      }
	}
  function load_header(){
    $contents['jml_pesan'] = $this->MPemesanan->jumlah_pesanan($this->session->userdata("resto")->id_restoran);
    $contents['data_pesan']= $this->MPemesanan->jumlah_data_pesanan($this->session->userdata("resto")->id_restoran);
    $contents['resto']= $this->MResto->getResto($this->session->userdata("resto")->id_restoran);
    $this->load->view('Layout/Header.php',$contents);
  }
	function dashboard(){
        if ($this->session->userdata('login_resto') == true) {
            $contents['restoran'] = $this->MResto->getResto($this->session->userdata("resto")->id_restoran);
            $contents['pemesanan'] = $this->MPemesanan->jumlah_booking($this->session->userdata("resto")->id_restoran);
            $this->load_header();
            $this->load->view('Resto/dashboard', $contents);
            //print_r($contents);
        }
        else {
            redirect('Resto/v_Login');
       }
  }

  //PENGATURAN RESTORAN
  function setting_akun($id){
        if ($this->session->userdata('login_resto') == true) {
            $id=$this->session->userdata('resto')->id_restoran;
            $contents['restoran']=$this->MResto->getResto($id);
            $this->load_header();
            $this->load->view('Resto/setting_akun',$contents);
        }
        else {
            redirect('Resto/v_Login');
       }
  }
  function set_akun(){
    if ($this->session->userdata('login_resto') == true) {
      if($_POST){
        $id=$this->input->post("username");
        $nama=$this->input->post('nama');
        $password=$this->input->post('password');
        $result=$this->MResto->set_akun($id, $nama, $password);
      }
      redirect('Resto/setting_akun/'.$id, 'refresh');
    }
    else {
        redirect('Resto/v_Login');
   }
  }
  function setting_resto($id){
        if ($this->session->userdata('login_resto') == true) {
            $id=$this->session->userdata('resto')->id_restoran;
            $contents['restoran']=$this->MResto->getResto($id);
            $this->load_header();
            $this->load->view('Resto/setting_resto',$contents);
        }
        else {
            redirect('Resto/v_Login');
       }
  }
  function set_resto(){
    if ($this->session->userdata('login_resto') == true) {
      $id=$this->input->post("id");
      $data=$_POST;
      $this->MResto->set_resto($data);

      redirect('Resto/setting_resto/'.$id, 'refresh');
    }
    else {
        redirect('Resto/v_Login');
   }
  }

  public function ubah_resto(){
        $this->load_header();

        $id=$this->input->post("id");
        $this->form_validation->set_rules('jalan','jalan','required');
        $this->form_validation->set_rules('kecamatan', 'kecamatan','required');
        $this->form_validation->set_rules('detail_tempat', 'detail_tempat','required');
        $this->form_validation->set_rules('no_telp', 'no_telp','required');
        $this->form_validation->set_rules('jam_buka', 'jam_buka','required');
        $this->form_validation->set_rules('jam_tutup', 'jam_tutup','required');
        $this->form_validation->set_rules('kapasitas', 'kapasitas','required');

        if ($this->form_validation->run() == FALSE)	{
  				$data['restoran'] = MResto2::find($id);
          //print_r($data);die();
  				$this->load->view('Resto/setting_resto2', $data);
  			} else {
          $data=array (
              'id_restoran' => MResto2::find($id)->id_restoran,
              'jalan' => set_value('jalan'),
              'kecamatan' => set_value('kecamatan'),
              'detail_tempat'=>set_value('detail_tempat'),
              'no_telp'=>set_value('no_telp'),
              'jam_buka'=>set_value('jam_buka'),
              'jam_tutup'=>set_value('jam_tutup'),
              'kapasitas'=>set_value('kapasitas'),
          );
          //print_r($data);die();
          $this->MResto2->ubah_resto($data);
          redirect('Resto/setting_resto/'.$id, 'refresh');
        }

    }

}
