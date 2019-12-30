<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.datepicktgl').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoClose: true
            });
         });
    </script>

<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Export Job</b></li>
        </ul>
        <div class="tab-content">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12">
                  <label> Piih Department </label>
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
                  <label> Piih Tanggal </label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control pull-right datepicktgl" id="tglAwl" name="tglAwl" autocomplete="off" placeholder="Start Date..">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control pull-right datepicktgl" id="tglAkh" name="tglAkh" autocomplete="off" placeholder="End Date..">
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-12" style="padding-top: 5px">
                  <button class="btn btn-primary" onclick="getExportMO(this)" ><i class="fa fa-search"></i> FIND </button>
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
                  <div class="col-md-12"  id="ResultExport"> </div>
                 </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>