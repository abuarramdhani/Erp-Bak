<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('MasterPekerja/Surat/gajipekerjacutoff/saveInfo');?>" enctype="multipart/form-data" id="MPK_InfoGaji">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/gajipekerjacutoff');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title"></h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row col-lg-6" style="padding-left: 30px">
											<div class="row">
												<div class="form-group">
													<label class="control-label col-lg-4">Periode Cutoff</label>
													<div class="col-lg-5">
														<input type="text" class="monthpickerq form-control" name="monthpickerq" id="monthpickerq" autocomplete="off">
													</div>
												</div>
											</div>
										</div>
										<div id="periodikCutoff">
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('MasterPekerja/Surat/gajipekerjacutoff');?>" class="btn btn-danger btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
																						<a href="<?php echo base_url('MasterPekerja/Surat/gajipekerjacutoff/create_Info');?>" class="btn btn-info btn-lg btn-rect">Reset</a>
																						&nbsp;&nbsp;
																						<button type="submit" class="btn btn-success btn-lg btn_save_info" id="btn_save_info">Save Data</button>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
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
