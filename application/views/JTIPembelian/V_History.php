<style media="screen">
.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}
</style>
<input type="hidden" id="jtipem" value="inijtipembelian">
<div class="content" style="min-width:100%">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">JTI History Pembelian</h4>
        </div>
        <div class="box-body">
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">
                <i class="fa fa-close"></i>
              </span>
            </button>
            <strong>Pembaruan data otomatis</strong> <span>dilakukan setiap 10 detik.</span>
          </div>
          <div class="table-responsive">
            <p> <b>*NB:</b> Klik kolom nama driver untuk melakukan update.
            </p>
            <br>
            <center>
              <div id="tableareajti">

              </div>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="MyModalJTIPembelian" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Response Untuk Notifikasi</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" name="button-done-jti-pembelian" style="font-weight:bold;margin-right:5px !important;text-align:center;float:right" onclick="donejti()" ><i class="fa fa-Done"> </i> Selesai</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <label for="valueReport">Notifikasi</label>
                    <textarea id="valueReport" style="border-radius:10px;padding:15px;width:100%" name="name" rows="5" placeholder="Message.." disabled></textarea><br>
                    <textarea name="response-jti-send-pembelian" id="valueResponse" style="border:1px solid #1b82c4;border-radius:10px;padding:15px;width:80%;float:left" rows="3" placeholder="Message.."></textarea>
                    <input type="hidden" id="idnotifikasi" >
                    <center><button type="button" class="btn btn-primary" name="button-send-jti-pembelian" style="font-weight:bold;float:left;margin-left:5px !important;width:19%;height: 90px;text-align:center" onclick="sendjtiahai()" ><i class="fa fa-send"> </i> Kirim</button></center><br>
                  </div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="JTIUPDATE" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Update Nama Driver (<span id="jtip_nodok"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <label for="valueReport">Nama Driver</label>
                    <input type="text" class="form-control" id="nama_driver" >
                    <input type="hidden" id="id_driver">
                    <br>
                    <center><button type="button" class="btn btn-primary" name="button-send-jti-pembelian" onclick="SaveDriver()" ><i class="fa fa-send"> </i> Update</button></center><br>
                  </div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="MyModalJtiEdit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Update (<span id="jtip_nodok_p2"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <!-- <div class="form-group">
                      <label>No. Dokumen</label>
                      <input type="text" class="form-control" id="no_dokumen" >
                    </div> -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">No Dokumen</label><br>
                          <input type="text" class="form-control" id="no_dokumen" name="" placeholder="No Dokumen">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Dokumen</label><br>
                          <div class="jt-select-area">
                          </div>
                          <select class="form-control select2" id="jenis_dokumen" name="type" style="width:100%" data-placeholder="Jenis Kegiatan">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Waktu Estimasi</label>
                          <input type="text" class="form-control datepickerJTIP" id="estimasi_jti" name="" placeholder="Waktu Estimasi">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" id="id_document">
                    <br>
                    <center><button type="button" class="btn btn-primary" onclick="update_doc()" ><i class="fa fa-send"> </i> Update</button></center><br>
                  </div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
