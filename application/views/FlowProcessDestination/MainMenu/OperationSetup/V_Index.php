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

	.slc-20{
		width: 20% !important;
	}
	.slc-50{
		width: 50% !important;
	}
	
</style>
<section class="content">
	<div class="inner">
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Operation Setup</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-cog"></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md btn-primary"><b>Form Input New Operation</b></button>
							</div>
							<div class="box-body">
								<form method="post" action="#" enctype="multipart/form-data">
									<div class="col-lg-12 " style=" margin-top: 20px">
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Operation Sequence:</label>
											</div>
											<div class="col-lg-6">
											    <input placeholder="Input Sequence Number.." type="number" name="txtSeqNum" class="form-control slc-50">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Planning Make Buy:</label>
											</div>
											<div class="col-lg-6">
											    <input placeholder="Planning Make Buy.." type="text" name="txtDrawingCode" class="form-control ">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Operation Process:</label>
											</div>
											<div class="col-lg-6">
											    <input placeholder="Input Drawing Description.." type="number" name="txtDrawingDesc" class="form-control ">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Operation Process Detail:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" style="width: 25%" id="" name="dateDrawingDate">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Machine Minimal Requirement:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Material.. " name="txtDrawingMaterial">
											</div>
										</div>

										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Planning Tool:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Code.. " name="txtUpperLevelCode">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Planning Measurement Tool:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Planning Measurement Tool:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Measurement Tool:</label>
											</div>
											<div class="col-lg-6">
											    <select class="form-control">
											    	<option></option>
											    </select>
											</div>
										</div>
										<div class="form-group col-lg-12 old-code" >
											<div class="col-lg-4 hh">
											    <label >Process Sheet Doc</label>
											</div>
											<div class="col-lg-6">
											    <input type="file" class="" id="" placeholder="Process Sheet Doc.. " name="fileGambarUnit">
											</div>
										</div>
										<div class="form-group col-lg-12 old-code" >
											<div class="col-lg-4 hh">
											    <label >QCPC Doc</label>
											</div>
											<div class="col-lg-6">
											    <input type="file" class="" id="" placeholder="Process Sheet Doc.. " name="fileGambarUnit">
											</div>
										</div>
										<div class="form-group col-lg-12 old-code" >
											<div class="col-lg-4 hh">
											    <label >CBO Doc</label>
											</div>
											<div class="col-lg-6">
											    <input type="file" class="" id="" placeholder="Process Sheet Doc.. " name="fileGambarUnit">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Oracle Kode:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Oracle Description:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Upper Level Oracle Code:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Upper Level Oracle Description:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Oracle Operation Sequence Number:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										<div class="form-group col-lg-12">
											<div class="col-lg-4 hh">
											    <label >Oracle Resource Type:</label>
											</div>
											<div class="col-lg-6">
											    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
											</div>
										</div>
										
										<div class="form-group col-lg-12" sty >
											<div class="col-lg-4"></div>
											<div class="col-lg-4" style="text-align: center;">
												<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
												<button class="btn btn-success " type="submit" ><B> SAVE DATA </B></button>
											</div>
										</div>
										</form>
									</div>
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
<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
