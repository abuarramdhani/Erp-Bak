<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Input Log Server</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringServer/InputMonitoring');?>">
									<i class="icon-pencil icon-2x"></i>
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
								
								Form Input Log Server
							</div>
							<div class="box-body">
								<div class="row">
									<form action="<?php echo base_url('MonitoringServer/InputMonitoring/save') ?>" method="post">
										
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Petugas</label>
												<div class="col-lg-8">
													<select multiple data-placeholder="Pilih Pekerja" class="form-control select4" name="employeeLS[]" style="width: 100%">
														<option></option>
														<?php foreach ($PekerjaLS as $employee) { ?>
															<option value="<?php echo $employee['employee_id'] ?>"> <?php echo $employee['employee_code'].' - '.$employee['employee_name']; ?></option>
															<?php } ?>
													</select>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Ruang Server</label>
												<div class="col-lg-4">
													<select name="serverRoom" data-placeholder="Pilih Ruang Server" class="form-control select2">
														<option></option>
														<?php foreach ($RuangServer as $RS) { ?>
															<option value="<?php echo $RS['sc_ruang_server_id']; ?>"><?php echo $RS['ruang_server_name']; ?></option>
														<?php }?>
													</select>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Tanggal</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Input Tanggal" name="dateLS" id="dateLS" class="form-control " data-date-format="dd-M-yyyy " required/>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Jam Masuk</label>
												<div class="col-lg-4">
													<!-- <input type="time" placeholder="Input Tanggal" name="timeInLS" id="timeInLS" class="form-control " id="jamMasukSL" required/> -->
													<input class="form-control" placeholder="00:00" type="text" onkeyup="jamForm(this)" onkeypress='return event.charCode <= 66 && event.charCode <=91' id="timeInLS" name="timeInLS" maxlength ="5">
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Jam Keluar</label>
												<div class="col-lg-4">
													<input class="form-control" placeholder="00:00" type="text" onkeyup="jamForm(this)" onkeypress='return event.charCode <= 66 && event.charCode <=91' id="timeOutLS" name="timeOutLS" maxlength ="5">
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-3">Keperluan</label>
												<div class="col-lg-8">
													<textarea class="" id="KeperluanLS" name="KeperluanLS" style="width: 100%; height: 120px">
														
													</textarea>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<button type="submit" class="btn btn-primary ">SAVE</button>
										<a href="<?php echo base_url('MonitoringServer/Monitoring') ?>">
										<button type="button" class="btn btn-default ">CANCEL</button>
										</a>
									</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>

<script type="text/javascript">
	
	$(document).ready(function(){

	$('.textarea').redactor({
        imageUpload: '<?php echo base_url('MonitoringServer/InputMonitoring/upload') ?>',

        imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }          
    }); 

	$('#KeperluanLS').redactor({
        imageUpload: '<?php echo base_url('MonitoringServer/InputMonitoring/upload') ?>',

        imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }          
    });
});


function jamForm(th){
	var a = $(th).val();
	if ( a.length == 2) {
		if (a > 23) {
		$(th).val('23'+':');
		}else{
		$(th).val(a+':');
		}
	} else if (a.length == 1) {
		if (a > 2) {
		$(th).val('2');
		}
	} else if (a.length == 4) {
		var b = a.replace(':','')
		if (b > 235) {
		$(th).val('23:5');
		}
	} else if (a.length == 5) {
		var b = a.replace(':','')
		if (b > 2359) {
		$(th).val('00:00');
		}
	}

};


</script>