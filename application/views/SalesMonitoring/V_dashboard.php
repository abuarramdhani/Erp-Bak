<div class="wrapper">

	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<h1 align="center">
						<b>
							<i class="fa fa-home"></i>
							<abbr> Dashboard</abbr>
						<b>
					</h1>
				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-3">
					<div class="box box-success">
						<div class="box-header with-border">
							<i class="fa fa-database"></i>
							<h3 class="box-title">Data</h3>
							<div class="box-tools pull-right">
								<button data-toggle="tooltip" title="Collapse" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button data-toggle="tooltip" title="Close" type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
								
						<div class="box-body no-padding">
							<div class="pad box-pane-right bg-white" >
								
								<div>
									<b>Pricelist Index </b>
									<?php foreach($cpi as $cpi_item) {?> 
										<span class="label label-warning"><i class="fa fa-book"></i> <?php echo $cpi_item['count'] ?></span></br>
									<?php }?>									
								</div>
								<div>
									<b>Sales Omset </b>
									<?php foreach($cso as $cso_item) {?> 
									<span class="label label-info"><i class="fa fa-book"></i> <?php echo $cso_item['count'] ?></span></br>
									<?php }?>
								</div>
								<div>
									<b>Sales Target </b>
									<?php foreach($cst as $cst_item) {?> 
									<span class="label label-danger"><i class="fa fa-book"></i> <?php echo $cst_item['count'] ?></span>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-warning">
						<div class="box-header with-border">
							<div class="box-body">
								</br></br>
								<center> 
									<img  src="<?php echo base_url('assets/img/Quick.png') ?>" style="max-width:50%;" />
								</center>
								</br></br>
								<center>
									CV. KARYA HIDUP SENTOSA </br>
									<small> Halaman ini dimuat dalam {elapsed_time} detik</small>
								</center>
							 </div>
						</div>
					</div>
				</div>
			</div>
		</Section>
	</div>
  