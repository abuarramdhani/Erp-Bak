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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ConsumableSEKSI/Inputkebutuhan');?>">
									<i class="fa fa-pencil fa-2x">
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
				<!-- <form name="Orderform" action="<?php echo base_url('ConsumableSEKSI/Inputkebutuhan/'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post"> -->
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="col-md-12" style="text-align: left;"><button onclick="addkebutuhan()" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create New</button></div>
								<br><br>
								<div class="col-md-12" id="tabel_kebutuhan"></div>
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			<!-- </form> -->
			</div>
		</section>

<div class="modal fade" id="modaladdkebutuhan" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Kebutuhan</h3></center>
        </div>
        <div class="modal-body">
            <div id="addkebutuhan"></div>
        </div>
      </div>
      
    </div>
</div>