<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">Sub Inventory</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <form action="<?php echo base_url('MonitoringDO/SettingDO/Subinv_submit') ?>" method="post">
                <div class="form-group">
                  <label for="usr">Sub Inventory</label>
                  <select class="form-control" name="Subinv" required>
                    <option value="FG-TKS">FG-TKS</option>
                    <option value="MLATI-DM">MLATI-DM</option>
                  </select>
                </div>
                <center><button type="submit" style="!important;font-weight:bold" class="btn btn-success" name="button">Submit</button></center>
              </form>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
