<style type="text/css">

.form-control{
	border-radius: 20px;
}

textarea.form-control{
	border-radius: 10px;
}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.select2-selection{
		border-radius: 20px !important;
	}

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	input.select2-search__field{
		border-radius: 20px !important;
	}

	span.select2-dropdown{ 
		border-radius: 20px !important;
	}

.loadOSIMG{
	width: 30px;
	height: auto;
}

#label-src{
	cursor: help;
	border-radius: 20px;
}

.hh{
	text-align: right;
}

.btn {
		border-radius: 20px !important;
	}
.rs {
	background-color: whitesmoke;
	padding: 20px;
	border-radius: 20px;
	margin-top: 20px !important;
	display: none ;
}

.table-curved {
	   border-collapse: separate;
	   border: solid #ddd 1px;
	   border-radius: 6px;
	   border-left: 0px;
	   border-top: 0px;
	}

	.table-curved th {                                                                                                            
		background-color: #3c8dbc !important;
		color: white;
		text-align: center;
		vertical-align: middle !important;
	}
	.table-curved > thead:first-child > tr:first-child > th {
	    border-bottom: 0px;
	    border-top: solid #ddd 1px;

	}
	.table-curved td, .table-curved th {
	    border-left: 1px solid #ddd;
	    border-top: 1px solid #ddd;
	}
	.table-curved > :first-child > :first-child > :first-child {
	    border-top-left-radius: 6px;
	}
	.table-curved > :first-child > :first-child > :last-child {
	    border-top-right-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :first-child {
	    border-bottom-left-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :last-child {
	    border-bottom-right-radius: 6px;
	}

.dataTables_scroll
	{
	    overflow:auto;
	}

.btn2 {
		border-bottom-right-radius: 20px !important; 
		border-top-right-radius: 20px !important;
		border-top-left-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
	}
#delFileOldDrawing:hover{
	cursor: pointer;
}

.blue {
	background-color: #84e5ff;
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
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Grafik</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-bar-chart "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md  btn-primary btnFrmFPDHome0"><b>Grafik Komponen</b></button>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub01" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub1"></b></button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="col-lg-8 " style="height: 330px; padding: 5px ;" >
									<div style="height: 100%; width: 100%" >
									<div id="chartFPDKomp" style="height: 100%; width: 100%">
									</div>
									<i class="text-danger" > <b>* click on the Point for detail.</b></i>
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
													<td>
														<center><?= date('Y-m-d',strtotime($value['creation_date'])) ?></center>
													</td>
													<td>
														<?= $value['drw_code'] ?> di Product <?= $value['product_description'] ?>
													</td>
												</tr>
											<?php } ?>
										</table>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<?php
									

								 ?>
							</div>
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