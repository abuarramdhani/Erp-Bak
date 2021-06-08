<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Create KIB</b></li>
        </ul>
        <div class="tab-content">
          <div class="row">
            <div class="col-md-12">
              <label class=""> Inputkan Job Number:</label>
            </div>
            <div class="col-md-6">
            <input class="form-control" type="text" id="NoJob" name="txtNoJob" placeholder="Masukkan Job Number..">
            </div>
            <div class="col-md-6">
            <button class="btn btn-primary" type="submit" onclick="getDetailJobInv(this)" ><i class="fa fa-search"></i> FIND </button>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <!-- <label> Result:</label> -->
          <div class="row">
              <div class="col-md-12" id="ResultJob">
                
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>