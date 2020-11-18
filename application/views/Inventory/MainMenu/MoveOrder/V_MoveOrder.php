<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Create Move Order</b></li>
        </ul>
        <div class="tab-content">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12">
                  <label> Pilih Department </label>
                </div>
                <div class="col-md-4">
                  <select class="select4 form-control" style="width: 100%" name="slcDeptIMO" id="selectDept">
                    <option></option>
                    <?php foreach ($dept as $key => $value) { ?>
                    <option value="<?= $value['DEPT'] ?>"><?= $value['DEPT'].' - '.$value['DESCRIPTION'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label> Pilih Tanggal </label>
                </div>
                <div class="col-md-4">
                  <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control pull-right" id="txtTanggalIMO" name="txtTanggalIMO" placeholder="Start Date.." autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="form-group shiftForm">
                <div class="col-md-12">
                  <label> Pilih Shift </label>
                </div>
                <div class="col-md-4">
                  <select class="select4 form-control inputShiftIMO" name="slcShiftIMO" disabled="disabled" style="width: 100%">
                    <option></option>
                    <?php foreach ($shift as $key => $value) { ?>
                    <option value="<?= $value['SHIFT_NUM'] ?>"></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-12" style="padding-top: 5px">
                  <button class="btn btn-primary" onclick="getRequirementMO(this)" ><i class="fa fa-search"></i> FIND </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <!-- <label> Result:</label> -->
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                  <div class="col-md-12 ResultJob"  id="ResultJob"> </div>
                 </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- modal create picklist sebagian -->
<div class="modal fade" id="mdlCreateSebagian" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;">
      <div class="modal-content">
        <div class="modal-header" style="font-size:20px;background-color:#82E5FA">
            <i class="fa fa-list-alt"></i> CREATE PICKLIST SEBAGIAN
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="panel-body text-center">
							Masukkan Quantity Request :
						</div>
            <div class="panel-body">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="input-group">
									<input type="number" id="qty_request" class="form-control form-lg" style="width:100%" placeholder="masukkan qty" autocomplete="off">
										<span class="input-group-btn" id="btncheckqty">
										</span>
								</div>
							</div>
						</div>
						<div class="panel-body text-center" id="loadcheckqty"></div>
            <div class="panel-body text-center" id="printpicksebelumnya"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- modal create picklist sebagian -->