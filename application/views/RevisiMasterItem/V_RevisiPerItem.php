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
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Revisi Master Item - per Item</b></li>
        </ul>
        <br>
        <?= $this->session->flashdata('flashdata_success');?>
        <br>
        <form method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-hover table-striped text-center tablePerItem" style="width: 100%;table-layout:fixed">
          <thead class="bg-primary">
          <tr>
            <th class="text-center" style="width:5%; !important">No</th>
            <th class="text-center" style="width:25%; !important">Item Code</th>
            <th class="text-center" style="width:60%; !important">Description</th>
            <th class="text-center" style="width:5%; !important"><button class="btn btn-sm btn-default" onClick="addElement()"><i class="fa fa-plus"></i></button></th>
          </tr>
          </thead>
          <tbody>
          <tr class = "add_row1" id="add_row">
          <td class="text-center"><input type="text" class="form-control no1" name="no[]" id="no" value="1" readonly></td>
          <td class="text-center">
          <select class="form-control itemRMI1" id="item_code" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" required>
            <option selected="selected"></option>
          </select></td>
          <td> <input type="text" class="form-control descRMI1" id="item_desc" name="item_desc[]" placeholder="Item Description"></input>          
          <td><button class="btn btn-danger btn-sm btn_del1" onClick="addElement()"><i class="fa fa-trash-o"></i></button></td>
          </td>
          </tr>
          </tbody>
        </table>
        <button class="btn btn-primary btn-lg" id="btn_changeItem" style="float: right" formaction="<?php echo base_url("RevisiMasterItem/UpdatePerItem/insertData")?>">Change</button>
        </form>
      </div>
    </div>
    <div class="box-body">
      <div class="nav-tabs-custom">    
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
      </div>    
    </div>
    <div class="tab-content">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-md-12 "  id="loadingsimulasi">
            </div>
          </div>
        </div>
      </div>
    </div>   
  </div>
</section>