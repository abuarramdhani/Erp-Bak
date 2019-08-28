
<style type="text/css">
	.form-control{
		border-radius: 20px;
	}

	.hh {
		text-align: right;
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
	.btn {
		border-radius: 20px !important;
	}
	
</style>

<?php 
    // echo '<pre>';
    // echo FCPATH;
    // exit();
?>

<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Import CSV</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-cog "></b>
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
								<button class="btn btn-md btn-primary"><b>Import CSV</b></button>
							</div>
							<div class="box-body">
                                <center>
									<table style="border: none;">
										<tr>
											<form method="post" class="import_csv" id="import_csv" enctype="multipart/form-data" action="<?= base_url(); ?>PerhitunganLoadingODM/Input/import">
											<td>
												<div class="col-md-1"> 
					 								 <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
					 							</div>
											</td>
											<td>
												<div class="col-md-1">
													<button type="submit" name="import_csv" class="btn btn-md bg-blue" id="import_csv_btn">IMPORT CSV</button>
												</div>
											</td>
											<td>
												<div class="col-md-1">
												OR  
												</div>
											</td>
											</form>
											<td>
												<div>
													<a href="<?php echo site_url('PerhitunganLoadingODM/Input/exportCSV');?>" target="_blank"><button Onclick="" class="btn btn-md">Download Layout CSV</button></a>
												</div>
											</td>
										</tr>
									</table>
								</center>
							</div>
							<div class="box-footer" >
								<div class="col-lg-12">
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>