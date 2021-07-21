<section class="content">
<style media="screen">
   .active > a{
    background-color: green !important;
    border-color: white !important;
  }
</style>
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Revisi Master Item - Excel</b></li>
        </ul>
        <br>
        <?= $this->session->flashdata('flashdata_success');?>
        <br>
        <form method="post" enctype="multipart/form-data">
        <div class="tab-content">
          <div class="row">
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <label> Masukkan File </label>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-6 input-group">
                    <input type="file" class="form-control" name="file_master_item" accept=".csv">    
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" id="submit_go" formaction="<?php echo base_url("RevisiMasterItem/UpdateItem/searchdata")?>">Go!</button>
                    </span>
                    <div class="col-md-2">
                      <button class="btn btn-warning btn-flat" id="downloadcsv" formaction="<?php echo base_url("RevisiMasterItem/UpdateItem/downloadtemplate")?>"><i class="fa fa-download"></i> Template</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </form>
        <table class="datatable-rmi table table-bordered table-hover table-striped text-center" style="width: 100%;table-layout:fixed">
          <ul class="nav nav-tabs pull-right">
            <li class="pull-left header"><i class="fa fa-newspaper-o"></i> <b>Last Updated Items</b></li>
          </ul>
          <thead class="bg-success">
            <tr>
                <th style="width:5%">No</th>
                <th>Item</th>
                <th>Description</th>
                <th>Updated By</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($valueupdate as $key=>$val) { ?>
            <tr>
              <td> <?php echo $key+1; ?>
              </td>
              <td> <?php echo $val['ITEM'] ; ?>
              </td>
              <td> <?php echo $val['DESCRIPTION'] ; ?>
              </td>
              <td> <?php echo $val['UPDATED_BY'] ; ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
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