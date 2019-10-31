
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
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-3">
							
						</div>
						<div class="col-lg-8">
							<div class="text-right">
								<h1><b> EDIT DATA</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md btn-primary"><b>Tabel Input Gambar</b></button>
							</div>
							<div class="box-body">
									<div class="row">
										<form action="<?= base_url(); ?>FlowProcess/InputDataGambar/datagambar" enctype="multipart/form-data" method="post">
											<div class="form-group col-lg-12">
												<div class="col-lg-12 hh">
												</div>
												<div class="col-lg-4 hh">
													<label style="font-size: 18px;">Product:</label>
												</div>
												<div class="col-lg-6">
												<select id="selectProduct" name="productid" class="select2 form-control"></select>
												</div>
											</div>
											<div class="form-group col-lg-12">
												<div class="col-lg-12 hh">
												</div>
												<div class="col-lg-4 hh">
													<label style="font-size: 18px;">Pilih File Gambar:</label>
												</div>
												<div class="col-lg-6">
													<input type="file" class="form-control" style="border: 0px solid #a9a9a9; border-radius: 5px; padding: 3px 3px 3px 3px;" name="pdf_file" id="pdf_file" required accept=".pdf" / required>
												</div>
											</div>
											<div class="form-group col-lg-12">
												<div class="col-lg-12 hh">
												</div>
												<div class="col-lg-4 hh">
													<label style="font-size: 18px;">Jumlah Gambar:</label>
												</div>
												<div class="col-lg-6">
												<input type="number" class="form-control" placeholder="Jumlah gambar" name="jml_gambar" id="jml_gambar" required>
												</div>
											</div>
											<div class="form-group col-lg-12">
												<div class="col-lg-12 hh">
												</div>
												<div class="col-lg-4 hh">
													<label></label>
												</div>
												<div class="col-lg-6">
												<button type="submit" class="btn btn-success btn-md" id="Start"> START INPUT </button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- <br> -->
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
</section>