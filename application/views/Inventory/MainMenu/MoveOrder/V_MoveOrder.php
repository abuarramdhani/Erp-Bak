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
                  <button class="btn btn-success" onclick="getRequirementMO(1)" ><i class="fa fa-search"></i> Sudah Picklist </button>
                  <button class="btn btn-primary" onclick="getRequirementMO(0)" ><i class="fa fa-search"></i> Belum Picklist </button>
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
