<!DOCTYPE html>
<div id="content">
    <div class="inner" style="min-height: 700px;">
          <div class="row">
                <div class="col-lg-12">
                    <h1> Pengaturan Resto </h1>
                </div>
          </div>
          <hr />

    <div class="row">
    <form class="form-horizontal" method="post" action="<?php echo site_url();?>CRestoran/set_resto">

    <div class="col-lg-7">
          <div class="form-group" >
              <label class="control-label col-lg-3">Username</label>
              <div class="col-lg-5">
                <input type="text"  value="<?php echo $restoran->get('id_restoran');?>" disabled="disabled" class="form-control"  />
                <input type="hidden" name="username" value="<?php echo $restoran->get('id_restoran');?>"/>
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Jalan</label>
              <div class="col-lg-5">
                  <input type="text" id="jalan" name="jalan" value="<?php echo $restoran->get('jalan')?>" class="form-control" />
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Kecamatan</label>
              <div class="col-lg-5">
                  <input type="text" id="kecamatan" name="kecamatan" value="<?php echo $restoran->get('kecamatan')?>" class="form-control" />
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Detail Tempat</label>
              <div class="col-lg-5">
                  <textarea class="form-control" rows="3" name="detail_tempat"><?php echo $restoran->get('detail_tempat')?></textarea>
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">No Telepon</label>
              <div class="col-lg-5">
                  <input type="text" id="telp" name="no_telp" value="<?php echo $restoran->get('no_telp')?>" class="form-control" />
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Kapasitas</label>
              <div class="col-lg-5">
                      <input type="text" id="kap" name="kapasitas" value="<?php echo $restoran->get('kapasitas')?>" class="form-control" />
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Jam Buka</label>
              <div class="col-lg-5">
                  <input class="form-control timepicker-default" name="jam_buka" type="text" value="<?php echo $restoran->get('jam_buka')?>">
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-lg-3">Jam Tutup</label>
              <div class="col-lg-5">
                  <input class="form-control timepicker-default" name="jam_tutup" type="text" value="<?php echo $restoran->get('jam_tutup')?>">
              </div>
          </div>

          <div class="form-group">
              <div class="col-lg-9" style="float:right;">
                  <input type="submit" value="Update" class="btn btn-success" >
              </div>
          </div>
    </div> <!--div col 7-->

    <div class="col-lg-5">

    </div> <!-- div col 5-->
  </form>
  </div> <!--row-->

  </div>
  </div> <!--div inner-->
</div> <!--content-->

<?php $this->load->view('Layout/Footer');?>
