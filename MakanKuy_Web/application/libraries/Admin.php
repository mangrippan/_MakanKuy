<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin{
  protected $id_admin;
  protected $nama;
  protected $password;

  public function validasi_admin($id_admin, $password)
  {
    if($password==$this->password) return true;
    else return false;
  }

  public function getAdmin($value)
  {
    if(isset($this->{$value})) return $this->{$value};
    else return NULL;
  }


}
