<style type="text/css">
    .dataTable_Button {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-bottom: 8px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-bottom: 2px;
    }
    .dataTable_Information {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-top: 7px;
    }
    .dataTable_Pagination {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-top: 14px;
    }
    .dataTable_Processing {
        z-index: 999;
    }
</style>
<section class="content">
	<div
		class="loader"
		style="	position: fixed; 
				width: 90%;
				height: 90%;
				z-index: 999;
				background: url('../assets/img/gif/loadingtwo.gif') 50% 50% no-repeat rgb(249,249,249);"></div>
	<div class="inner">
		<div class="box box-info">
			<h2 style="text-align: center; font-wight: bold;"><b>PILIH DATA MINMAX UNTUK IMPORT EXPORT EXCEL</b></h2>
			<div class="box-body">
			<?php foreach ($minmax as $mm) { ?>
			<?php } ?>
			<div class="col-lg-12" style="padding-top: 8px;">
					<div style="text-align: center;">
						<a style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-danger" id="export_excell"><span class="fa fa-download"> EXPORT</a>
						<a style="float: center; margin-right: 3%; margin-top: -0.5%;" data-toggle="modal" data-target="#Modalku<?php echo $mm['SEGMENT1']; ?>"  class="btn btn-warning" ><span class="fa fa-upload"> IMPORT</a>
						<a style="float: center; margin-right: 3%; margin-top: -0.5%;" href="<?php echo base_url('SettingMinMax/IE')?>" class="btn btn-success"><span class="fa fa-check-square"> SELESAI</a>
					</div>
				</div>
				<table id="tableDataMinMaxIE" class="table table-striped table-bordered table-responsive table-hover">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<th style="text-align:center; width: 5%">NO</th>
						<th class="text-center"><input type="checkbox" id="check-all"/></th>
						<th style="text-align:center; width: 15%">ITEM CODE</th>
						<th style="text-align:center; width: 20%">DESCRIPTION</th>
						<th style="text-align:center; width: 10%">UOM</th>
						<th style="text-align:center; width: 15%">MIN</th>
						<th style="text-align:center; width: 15%">MAX</th>
						<th style="text-align:center; width: 15%">ROP</th>
						<th style="display:none">ACTION</th>
					</thead>
					<tbody>
						<?php $i = 1; foreach ($minmax as $mm) { 	?>
						<tr id="<?php echo $mm['SEGMENT1']; ?>" row-id="">
							<td style="text-align:center" class="no"><?php echo $i++; ?>.</td>
							<td style="text-align:center"></td>
							<td style="text-align:center" class="code"><?php echo $mm['SEGMENT1']; ?></td>
							<td style="text-align:center" class="desc"><?php echo $mm['DESCRIPTION']; ?></td>
							<td style="text-align:center" class="uom"><?php echo $mm['PRIMARY_UOM_CODE']; ?></td>
							<td style="text-align:center" class="min"><?php echo $mm['MIN']; ?></td>
							<td style="text-align:center" class="max"><?php echo $mm['MAX']; ?></td>
							<td style="text-align:center" class="rop"><?php echo $mm['ROP']; ?></td>
							<td style="display:none">
								<a class="btn btn-warning btn-xs" title="Edit" href="<?php echo base_url(); ?>SettingMinMax/EditbyRoute<?php echo '/EditItem/'.$org.'/'.$routeaktif.'/'.$mm['SEGMENT1'] ?>"><span class="icon-edit"></span> Edit</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="Modalku<?php echo $mm['SEGMENT1']; ?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-header with border" id="formModalLabel">Import Data</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadFile">
			<div class="form-group" >
								<label class="col-sm-4">Pilih File yang Akan Di-import</label>
								<input class="col-md-6 btn btn-info" type="file" name="fileCsv" id="fileCsv" accept=".xls,.xlsx" style="margin: 0px 0px 5px 0px;" required>
								<input type="hidden" id="fileName" >
			</div>
			<br>
			<br>
							<div class="form-group" align="right" style="margin:0px 5px 0px 0px;">
                				<button class="btn btn-success" name="btn_upload" id="btn_upload">Upload</button>
							</div>
			<br>
            </form>
        </div>
    </div>
</div>