<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('EvaluasiPekerjaNonStaf/');?>">
									<i class="icon-pencil icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
          <div class="col-ld-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="col-lg-1 text-right">
                      <label>Jenis</label>
                    </div>
                    <div class="col-lg-3">
                    <select class="select select2 form-control" name="OptionJenisEvaluasi" id="OptionJenisEvaluasi">
                      <option></option>
                      <option value="C">Evaluasi Cabang</option>
                      <option value="J">Kontrak Staf</option>
                      <option value="G">Kontrak Staf TKPW</option>
                      <option value="H">Kontrak Non Staf</option>
                      <option value="T">Kontrak Non Staf Khusus</option>
                      <option value="P">OS / PP</option>
                      <option value="F">PKL</option>
                    </select>
                  </div>
                  <div class="col-lg-1 text-right">
                    <label>Periode</label>
                  </div>
                  <div class="col-lg-3">
                    <input type="text" name="dateEvaluasi" class="form-control pickerevaluasi" id="pickerevaluasi">
                  </div>
                  <div class="col-lg-1">
                    <button type="search" name="button" id="btnSearchEvaluasi" class="fa fa-search btn btn-primary form-control"></button>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 20px;" id="CreatePekerjaEvaluasi">

              </div>
              <div class="panel-footer">
                <div class="row text-right">
                  <a href="<?php echo base_url('EvaluasiPekerjaNonStaf/');?>" class="btn btn-danger btn-lg btn-rect">Back</a>
                  &nbsp;&nbsp;
                  <a href="<?php echo base_url('EvaluasiPekerjaNonStaf/Create');?>" class="btn btn-info btn-lg btn-rect">Reset</a>
                  &nbsp;&nbsp;
                  <button type="submit" class="btn btn-success btn-lg" id="btn_save_pekerja_evaluasi">Save Data</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<a onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="buttonGoTop" class="fa fa-arrow-up" style="display: none;  position: fixed;  bottom: 48px;  right: 26px;  z-index: 99;  font-size: 18px;  border: none; outline: none; background-color: #7ae7ff;  color: white; cursor: pointer; padding: 15px; border-radius: 4px;" title="Go to top"></a>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>

<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script>
 CKEDITOR.disableAutoInline = true
 window.onscroll = _ => {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
   document.getElementById("buttonGoTop").style.display = "block";
  } else {
   document.getElementById("buttonGoTop").style.display = "none";
  }
 }
</script>
