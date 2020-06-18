<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Kategori</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterKategoriPenilaian');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Edit Master Kategori Nilai</b>
					</div>
					
					<?php foreach ($GetKatNil as $gk) {?>
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterKategoriPenilaian/update/'.$gk['id_kategori'])?>">
					<input type="text" name="txtIdKatNil" value="<?php echo $gk['id_kategori']; ?>" hidden>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control JurnalPenilaian-daterangepickersingledate" name="txtDate" value="<?php echo $gk['tberlaku']; ?>"  >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Kategori </label>
								<div class="col-lg-7">
									<input name="txtKategori" class="form-control" value="<?php echo $gk['kategori']; ?>"  >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Standar Nilai </label>
								<div class="col-lg-7">
									<input name="txtStandar" class="form-control" type="number" value="<?php echo $gk['std_nilai']; ?>"  >
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterKategoriPenilaian');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					</div>
					</form>
					<?php } ?>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
