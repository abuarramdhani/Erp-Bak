<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Report Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Record');?>">
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
						<b data-toogle="tooltip" title="">Rekap Report Pelatihan</b>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
						 <hr> 
						  <div class="col-lg-4">
                                <center>
                                    <br>
                                    <div class="btn-group-vertical">
                                            <a type="button" class="btn bg-teal btn-lg buttonlistDocUpper buttonlistDoc" title="REKAP TRAINING" href="<?php echo site_url('ADMPelatihan/Report/Rekap/RekapTraining'); ?>" style="width: 259px; height: 79px;">REKAP TRAINING<br><h6 style="white-space:normal;">REKAPITULASI SEMUA TRAINING YANG BELUM/TELAH TERLAKSANA</h6></a>
                                    </div>
                                    <br>
                                </center>
                            </div> 
                            <div class="col-lg-4">
                                <center>
                                    <br>
                                    <div class="btn-group-vertical">
                                            <a type="button" class="btn bg-orange btn-lg buttonlistDocUpper buttonlistDoc" title="PRESENTASE KEHADIRAN" href="<?php echo site_url('ADMPelatihan/Report/Rekap/PresentaseKehadiran'); ?>" style="width: 259px; height: 79px;">PRESENTASE KEHADIRAN<br><h6 style="white-space:normal;">REKAPITULASI KEHADIRAN PESERTA TRAINING</h6></a>
                                    </div>
                                    <br>
                                </center>
                            </div>  
                            <div class="col-lg-4">
                                <center>
                                    <br>
                                    <div class="btn-group-vertical ">
                                            <a type="button" class="btn bg-purple btn-lg buttonlistDocUpper buttonlistDoc" title="EFEKTIVITAS TRAINING" href="<?php echo site_url('ADMPelatihan/Report/Rekap/EfektivitasTraining'); ?>" style="width: 259px; height: 79px;">EFEKTIVITAS TRAINING<br><h6 style="white-space:normal;">REKAPITULASI EFEKTIVITAS TRAINING</h6></a>
                                    </div>
                                    <br>
                                </center>
                            </div>
						</div>
						<div id="table-full">
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>		