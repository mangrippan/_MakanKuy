<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restoran{
  protected $id_restoran;
  protected $nama;
  protected $password;
  protected $jalan;
  protected $kecamatan;
  protected $detail_tempat;
  protected $no_telp;
  protected $foto;
  protected $jam_buka;
  protected $jam_tutup; 
  protected $kapasitas;
  protected $latitude;
  protected $longitude;
  protected $status;

  public function validasi_resto($id_restoran, $password)
  {
    if($password==$this->password) return true;
    else return false;
  }

  public function get($value)
  {
    if(isset($this->{$value})) return $this->{$value};
    else return NULL;
  }

  public function inputResto($id_restoran, $nama, $password)
  {
    if (!empty($id_restoran) && !empty($nama) && !empty($password)) {
      $this->id_restoran=$id_restoran;
      $this->nama=$nama;
      $this->password=$password;
      return true;
    }
    else return false;
  }

  public function set($attr, $value){
    $this->{$attr}=$value;
  }

}
