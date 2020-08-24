<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Simulasi Kebutuhan Komponen</b></li>
        </ul>
        <form method="post" enctype="multipart/form-data">
        <div class="tab-content">
          <div class="row">
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <label> Masukkan File </label>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-6 input-group">
                    <input type="file" class="form-control" name="file_simulasi" accept=".csv">    
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" id="submit_go" formaction="<?php echo base_url("InventoryManagement/SimulasiKebutuhan/searchdata")?>">Go!</button>
                    </span>
                    <div class="col-md-2">
                      <button class="btn btn-warning btn-flat" id="downloadcsv" formaction="<?php echo base_url("InventoryManagement/SimulasiKebutuhan/downloadtemplate")?>"><i class="fa fa-download"></i> Template</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </form>
        <div class="tab-content">
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                  <div class="col-md-12 "  id="loadingsimulasi"> </div>
                 </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>