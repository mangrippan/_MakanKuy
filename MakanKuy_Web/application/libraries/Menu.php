<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu{
  protected $id_restoran;
  protected $menu;

  public function get($value)
  {
    if(isset($this->{$value})) return $this->{$value};
    else return NULL;
  }
  public function set($attr, $value){
    $this->{$attr}=$value;
  }
}
