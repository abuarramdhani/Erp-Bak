<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">Input DO</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <form action="<?php echo base_url('MonitoringDO/SaveDO') ?>" method="post">
                <div class="form-group">
                  <label for="usr">NOMOR DO</label>
                  <input type="text" class="form-control" id="nomorDO" placeholder="Nomor DO" value="">
                </div>
                <div class="form-group">
                  <label for="usr">ASSIGN</label>
                  <div class="form-group">
                    <input class="form-control" type="text" id="person_id" name="" placeholder="Assign">
                  </div>
                </div>
                <button type="button" onclick="insertManual()" style="float:right !important;font-weight:bold" class="btn btn-success" name="button">SAVE</button>
              </form>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
