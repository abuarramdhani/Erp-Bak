
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box box-primary color-palette-box">
              <div class="box-header with-border">
                 <h4 style="font-weight:bold" class="text-primary"><i aria-hidden="true" class="fa fa-cube"></i> Scan Kartu Body</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="agt_area_qr">
                      <label for="">Scan QR Code</label>
                      <input type="text" name="QRCODE" class="form-control" id="qrcodeAGT" placeholder="Scan your QRcode" required="" onchange="ScanKartuBodyAGT(this)">
                    </div>
                    <div class="agt_area_item" style="display:none">
                      <label for="">Pilih Kode Item</label>
                      <select class="agt_get_item_code" onchange="ScanKartuBodyAGT(this)" style="width:100%">
                        <option value="" selected></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" id="agt_jenis_scan" value="qr">
                    <button type="button" class="btn btn-primary" onclick="byqrorkodeitem_agt(this)" name="button" style="width:100%;margin-top:24px"><b>By QR Code</b></button>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-reset-agt" name="button" style="width:100%;margin-top:24px"> <b>Reset</b> </button>
                  </div>
                </div>
                <div class="row" style="padding-top:15px;">
                  <div class="col-md-12">
                    <div id="areaAGT" style="overflow-x:auto;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
