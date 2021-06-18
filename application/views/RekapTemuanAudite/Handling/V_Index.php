<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-12">
              <div class="text-right">
                <h1><b><?php echo $title ?></b></h1>
              </div>
            </div>
            <!-- <div class="col-lg-1">
              <div class="text-right hidden-md hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php //echo site_url('RekapTemuanAudite/Handling'); ?>">
                  <i class="icon-wrench icon-2x"></i><br>
                </a>
              </div>
            </div> -->
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h4><i class="fa fa-pencil"></i> <b>REKAP TEMUAN AUDITE</b></h4>
              </div>
              <div class="box-body" style="background:#f0f0f0 !important">
                <div class="box-body" style="background:#ffffff !important;border-radius:8px;margin-bottom:10px">
                  <div class="row">
                    <h3><center><b>REKAP TEMUAN AUDITE</b></center></h3>
                    <hr>
                  </div>
                  <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-7">
                      <label>Select Seksi</label>
                      <select class="form-control select-handling" style="width:100%" name="" data-placeholder="Pilih Seksi">
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="col-lg-1">
                      <label style="color:transparent">For Filter</label>
                      <button type="button" id="handlingRTA" onclick="handling_rta()" style="font-size:15px" class="btn btn-primary btn-sm btn-block" disabled><strong><i class="fa fa-search"></i></strong></button>
                    </div>
                    <div class="col-lg-2"></div>
                  </div>
                  <div class="row" style="margin-top:12px">
                    <hr>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 rta_handling_area">
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
</section>
