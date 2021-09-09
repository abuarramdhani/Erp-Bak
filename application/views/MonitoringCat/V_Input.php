<style media="screen">

</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 style="font-weight:bold;margin:0"><i class="fa fa-edit"></i> <?= $Title?>
                <span class="sr-only"> </span></h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="panel-body" >
                    <div class="col-md-4">
                        <label>No LPPB</label>
                        <div class="input-group">
                            <input id="no_lppb" name="no_lppb" class="form-control" placeholder="masukkan no lppb" autocomplete="off">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" style="margin-left:15px" onclick="submitCat(this)"><i class="fa fa-check"></i> Submit</button>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="panel-body" id="cat_input"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>