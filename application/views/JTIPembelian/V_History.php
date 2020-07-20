
<input type="hidden" id="jtipem" value="inijtipembelian">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">JTI History Pembelian</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
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
