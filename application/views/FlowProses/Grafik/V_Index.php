<style type="text/css">
.box-body{
	height: 368px !important;
}
.form-control{
	border-radius: 20px;
}

.colketgraf1{
	height: 150px !important;
	width: 100% !important;
	/*background-color: #ececec;*/
	margin-bottom: 5px;
	border-radius: 5px;
	border: 2px solid #c9c9c9;
}

.colketgraf2{
	height: 170px !important;
	width: 100% !important;
	/*background-color: #ececec;*/
	margin-bottom: 5px;
	border-radius: 5px;
	border: 2px solid #c9c9c9;
}

.tbl-comp td {
	border: 1px solid grey;
	font-size: 12px;
}

#div-tbl-comp{
	height: 75%;
	overflow: auto;
}


</style>
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h4 style="font-weight:bold"> <i class="fa fa-area-chart"></i> Grafik Komponen</h4>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub01" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub1"></b></button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="col-lg-8 " style="height: 330px; padding: 5px ;" >
									<div style="height: 100%; width: 100%" >
									<div id="chartFPDKomp" style="height: 100%; width: 100%">
									</div>
									<div class="pt-2 pb-2">
										<i class="text-danger" > <b>* click on the Point for detail.</b></i>
									</div>
									</div>
								</div>
								<div class="col-lg-4" style="height:  330px; padding :5px;">
									<div class="colketgraf1">
										<div id="chartFPDKomp2" style="height: 100%;vertical-align: middle;">

										</div>
									</div>
									<div class="colketgraf2" style="padding: 5px; height: 50%;">
										<center><H6>DAFTAR KOMPONEN</H6></center>
										<div id="div-tbl-comp">
										<table style="width: 100%; " class="table-curved tbl-comp">
											<?php foreach ($recapComp as $key => $value) { ?>
												<tr>
													<td style="width:27%">
														<center><?= date('Y-m-d',strtotime($value['created_date'])) ?></center>
													</td>
													<td style="padding:5px">
														<?= $value['component_code'] ?> di Product <?= $value['product_name'] ?>
													</td>
												</tr>
											<?php } ?>
										</table>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="box-footer">
								<?php


								 ?>
							</div> -->
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>
<script type="text/javascript">
	var jenisFPD = 'GRAFIKPFD';
</script>
