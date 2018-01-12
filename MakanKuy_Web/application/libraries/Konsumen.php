<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumen{
  protected $id_konsumen;
  protected $nama;
  protected $password;
  protected $email;
  protected $no_telp;
  protected $foto;
  protected $saldo;

  public function login($id_restoran, $password)
  {
    if($password==$this->password) return true;
    else return false;
  }

  public function register($id_konsumen, $nama, $password, $email, $no_telp,$foto)
  {
    if (!empty($id_restoran) && !empty($nama) && !empty($password) && !empty($email) && !empty($no_telp) && !empty($foto)) {
      $this->id_restoran=$id_restoran;
      $this->nama=$nama;
      $this->password=$password;
      $this->email=$email;
      $this->$no_telp=$no_telp;
      $foto->foto=$foto;
      return true;
    }
    else return false;
  }

  public function getProfile($value)
  {
    if(isset($this->{$value})) return $this->{$value};
    else return NULL;
  }
}
