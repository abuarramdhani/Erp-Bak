<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Revisi Master Item - per Item</b></li>
        </ul>
        <table class="table table-bordered table-hover table-striped text-center tablePerItem" style="width: 100%;table-layout:fixed">
          <thead class="bg-primary">
          <tr>
            <th class="text-center" style="width:30%; !important">Item Code</th>
            <th class="text-center" style="width:65%; !important">Description</th>
            <th class="text-center" style="width:5%; !important"><button class="btn btn-sm btn-default" onClick="addElement()"><i class="fa fa-plus"></i></button></th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td class="text-center">
          <select class="form-control itemRMI1" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" required>
            <option selected="selected"></option>
          </select></td>
          <td> <input type="text" class="form-control descRMI1"></input>
          </td>
          <!-- <td>
          <button class="btn btn-info btn-flat" id="submit_go" formaction="<?php echo base_url("RevisiMasterItem/UpdateItem/insertData")?>">Change</button>
          </td> -->
          </tr>
          </tbody>
        </table>
        <button class="btn btn-info btn-flat" id="submit_go" formaction="<?php echo base_url("RevisiMasterItem/UpdatePerItem/insertData")?>">Change</button>
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