<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Report Seksi Personalia</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Record');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b data-toogle="tooltip" title="">Report Seksi Personalia</b>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-1 control-label">Seksi</label>
								<div class="col-lg-6">
									<select name="slcSectionPK" class="form-control js-slcSectionPK">
									</select>
								</div>
								<label class="col-lg-1 control-label">Tahun</label>
								<div class="col-lg-2">
									<div class="form-group">
							            <div class='input-group date'>
							                <select class="form-control SlcRuang" name="slcTahun" data-placeholder="Tahun" required>
												<option></option>
												<?php foreach($tahunTrain as $tt){?>
												<option value="<?php echo $tt['tahun']; ?>"><?php echo $tt['tahun']; ?></option>
												<?php }?>
											</select>
							                <span class="input-group-addon">
							                    <span class="glyphicon glyphicon-calendar">
							                    </span>
							                </span>
							            </div>
							        </div>
								</div>
								<div class="col-lg-2">
									<button class="btn btn-primary btn-flat btn-block" id="SearchReport2">Filter</button>
								</div>
								<div class="col-lg-1" align="center" id="loading">
								</div>
							</div>
						</div>
						<div id="table-full">