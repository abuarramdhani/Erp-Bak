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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ConsumablePPIC/MasterItem'); ?>">
									<i class="fa fa-cog fa-2x">
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
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="col-md-12" style="text-align: left;"><button onclick="additem()" class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</button></div>
								<br><br>
								<div class="col-md-12" id="tabel_master_item"></div>
							</div>
						</div>
						<div class="row">

						</div>
					</div>
				</div>
			</div>
</section>
<div class="modal fade" id="modaladditem" role="dialog">
	<div class="modal-dialog" style="width:60%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<center>
					<h3 class="modal-title">Add Item</h3>
				</center>
			</div>
			<div class="modal-body">
				<div id="additem"></div>
			</div>
		</div>

	</div>
</div>