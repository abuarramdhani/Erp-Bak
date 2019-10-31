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
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Upload Sini Aje</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-upload "></b>
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
								<button class="btn btn-md btn-primary"><b>Form Upload</b></button>
							</div>
							<div class="box-body" >
								<form method="post" action="<?= base_url('FlowProcess/ComponentSetup/ProcessUpload') ?>" enctype="multipart/form-data">
									<div class="col-lg-12">
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Type Data:</label>
										</div>
										<div class="col-lg-8">
										    <input type="radio" value="1" id="status1" name="type">
											<label for="status1" class="label-checkbox" >Komponen</label>
										    <input type="radio" value="2" id="status2" name="type">
											<label for="status2" class="label-checkbox" >Operation</label>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >File Upload:</label>
										</div>
										<div class="col-lg-8">
										    <input type="file" placeholder="Upload Gambar Kerja" name="file_upload" class="">
										</div>
									</div>
									<div class="form-group col-lg-12 text-center" >
										<button class="btn btn-success " type="submit"><B> UPLOADD </B></button>
									</div>
								</div>
								</form>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>