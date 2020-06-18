
<style type="text/css">
	th, td {
    white-space: nowrap;
}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OrderPro/monorderpro');?>">
									<i class="fa fa-list fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<!-- <form name="Orderform" action="<?php echo base_url('OrderPro/neworderpro/Insert'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post"> -->
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border"></div>
							<div class="box-body" id="tbl_monitoring_fabrikasi">
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			<!-- </form> -->
			</div>
		</section>
<!-- MODAL GAMBAR -->
<div class="modal fade" id="modalgambar" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Gambar Kerja</h3></center>
        </div>
        <div class="modal-body">
            <div id="gambarnya"></div>
        </div>
      </div>
      
    </div>
</div>
<!-- MODAL PROGRESS -->
<div class="modal fade" id="modalprogress" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Progress</h3></center>
        </div>
        <div class="modal-body">
            <div id="progress"></div>
        </div>
      </div>
      
    </div>
</div>
<!-- MODAL EDIT -->
<div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Edit</h3></center>
        </div>
        <div class="modal-body">
            <div id="edit"></div>
        </div>
      </div>
      
    </div>
</div>

<!-- MODAL INSERT TGL JOB -->

<div class="modal fade" id="modaljob" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Input Tanggal Job Turun</h3></center>
        </div>
        <div class="modal-body">
            <div id="tgl_job" style="text-align: center;"></div>
        </div>
      </div>
      
    </div>
</div>

<!-- MODAL INSERT QTY JOB -->

<div class="modal fade" id="modalqty" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Input Qty Finish</h3></center>
        </div>
        <div class="modal-body">
            <div id="qty_finish" style="text-align: center;"></div>
        </div>
      </div>
      
    </div>
</div>
<!-- MODAL INSERT PIC FABRIKASI -->

<div class="modal fade" id="modalpic" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Input PIC Fabrikasi</h3></center>
        </div>
        <div class="modal-body">
            <div id="pic_fabrikasi" style="text-align: center;"></div>
        </div>
      </div>
      
    </div>
</div>