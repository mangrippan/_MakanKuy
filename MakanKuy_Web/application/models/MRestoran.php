<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRestoran extends CI_Model  {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Restoran');
  }
  public function getAll()
  {
      $result=array();
      $array=$this->db->get('restoran')->result();
      foreach ($array as $resto) {
         $temp=new Restoran();
         foreach ($resto as $key => $value) {
           $temp->set($key, $value);
         }
         $result[]=$temp;
      }
      return $result;
  }
  public function getOne($id){
    $result= new Restoran();
    $query=$this->db->select('*')->from('restoran')->where('id_restoran',$id)->get()->result()[0];
    foreach ($query as $key=>$value) {
        $result->set($key, $value);
    }
    return $result;
  }

  public function save($obj)
  {
      $attr=$this->db->list_fields('restoran');
      $data=array();
      foreach ($attr as $key) {
          $data[$key]=$obj->get($key);
      }
      $this->db->replace('restoran', $data);
  }
}

?>
