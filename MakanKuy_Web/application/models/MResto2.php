<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;

class MResto2 extends Eloquent {
  protected $table = 'restoran';
  public $timestamps = FALSE;
  protected $primaryKey = 'id_restoran';
  protected $fillable = ['nama','password','jalan','kecamatan','detail_tempat','no_telp','rating',
    'foto','jam_buka','jam_tutup','kapasitas','longitude','latitude', 'status'
  ];

  public function set_resto($data){
      $resto                  = MResto2::find($data['id_restoran']);
      $resto->jalan           = $data['jalan'];
      $resto->kecamatan       = $data['kecamatan'];
      $resto->detail_tempat   = $data['detail_tempat'];
      $resto->no_telp         = $data['no_telp'];
      $resto->jam_buka        = $data['jam_buka'];
      $resto->jam_tutup       = $data['jam_tutup'];
      $resto->kapasitas       = $data['kapasitas'];

      $resto->update();
  }

}
