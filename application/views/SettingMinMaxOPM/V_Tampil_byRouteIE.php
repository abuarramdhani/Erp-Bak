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

	.buttons-html5{
		display:none;
	}

</style>

<section class="content">
	<div
		class="loader"
		style="	position: fixed;
				width: 90%;
				height: 90%;
				z-index: 999;
				background: url('../assets/img/gif/loading5.gif') 50% 50% no-repeat rgb(249,249,249);"></div>
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

      <input type="hidden" id="kind" name="org" value="IE">
      <input type="hidden" id="org_ss" name="org" value="<?= $org ?>">
      <input type="hidden" id="routeraktif_ss" name="route" value="<?= $routeaktif ?>">
      <br><br>
      <div class="row" id="loadingArea" style="padding-top:30px; color: #3c8dbc;  display: none;">
        <div class="col-md-12 text-center">
          <i class="fa fa-spinner fa-4x fa-pulse"></i>
        </div>
      </div>
      <div id="tablearea">

      </div>

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
