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
                    <select class="form-control select2" name="Subinv" required>
                    <?php foreach ($get as $key => $value): ?>
                      <option value="<?php echo $value['SUBINVENTORY'] ?>"><?php echo $value['SUBINVENTORY'] ?> (<?php echo $value['GUDANG_PENGIRIM'] ?>)</option>
                    <?php endforeach; ?>
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
