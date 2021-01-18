<style media="screen">

.tblJMT {
  display: none !important;
}
.loadingjti{
  display: none;
}

</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1>
                  <b>
                    Cetak KIB Motor Bensin
                  </b>
                </h1>
              </div>
            </div>
            <div class="col-lg-1 ">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-danger btn-lg" href="#">
                  <i aria-hidden="true" class="fa fa-file-pdf-o fa-2x">
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                 <h4>Filter Data</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                          <i class="fa fa-close"></i>
                        </span>
                      </button>
                      <strong>Type Engine</strong> dapat dikosongi jika hanya keperluan monitoring. Sedangkan untuk keperluan cetak <strong>Type Engine</strong> perlu di isi.</strong>
                    </div>
                  </div>
                  <!-- <form id="formSPB" onsubmit="getDataSPB()"> -->
                  <div class="col-md-7">
                    <label for="">Select Date Range</label>
                    <input type="text" name="" class="form-control tanggal_ckmb" placeholder="Select Yout Current Date" required="" >
                  </div>
                  <div class="col-md-3">
                    <label for="">Type Engine</label>
                    <select class="form-control select2_ckmb" name="" style="width:100%">
                      <option value=""></option>
                      <?php foreach ($get_type as $key => $value): ?>
                        <option value="<?php echo $value['TYPE'] ?>"><?php echo $value['TYPE'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="" style="color:transparent">Ini Filter</label>
                    <button type="button" onclick="filter_ckmb()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
                  </div>
                </div>
                <div class="row" style="padding-top:30px;">
                  <div class="col-md-12">
                    <div class="area_ckmb">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- form aja -->
        <div class="row" id="nothing" style="padding-top:30px; color: #3c8dbc;  display: none;">
          <div class="col-md-12 text-center">
            <div style="text-align:center">
              <h2>Can't found data.<br> Please try again</h2>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
