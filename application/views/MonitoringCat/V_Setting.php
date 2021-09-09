<style media="screen">

</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div class="col-md-6">
                <h2 style="font-weight:bold;margin:0"><i class="fa fa-edit"></i> <?= $Title?>
                <span class="sr-only"> </span></h2>
                </div>
                <div class="col-md-6  text-right">
                    <button type="button" data-toggle="modal" data-target="#mdl_tambah_setting" class="btn btn-default"><i class="fa fa-2x fa-plus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="panel-body" id="cat_setting"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="modal fade" id="mdl_tambah_setting" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius:20px">
        <div class="modal-header text-center" style="font-size:20px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label>Tambah Data Setting Cat</label>
        </div>
        <div class="modal-body">
            <div class="panel-body">
                <div class="col-md-3 text-right"><label>Kode Item :</label></div>
                <div class="col-md-7">
                    <select id="kode_item" name="kode_item" class="form-control select2 getkodesettingcat" style="width:100%" data-placeholder="pilih item"></select>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-3 text-right"><label>Konversi :</label></div>
                <div class="col-md-7">
                    <input type="number" id="konversi" name="konversi" class="form-control" placeholder="masukkan konversi cat">
                </div>
            </div>
            <div class="panel-body text-center">
                <button type="button" class="btn btn-success" onclick="submit_setting_cat(this)"><i class="fa fa-check"></i> Submit</button>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>