<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan{
  protected $id_restoran;
  protected $id_konsumen;
  protected $tanggal_pesan;
  protected $jumlah_pesan
  protected $deposit;
  protected $status;

  public function get($value)
  {
    if(isset($this->{$value})) return $this->{$value};
    else return NULL;
  }
  public function set($attr, $value){
    $this->{$attr}=$value;
  }
}
