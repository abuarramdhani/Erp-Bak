<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 style="font-weight:bold;margin:0"><i class="fa fa-edit"></i> <?= $Title?></h3>
              </div>
              <div class="box-body">
                <div class="row">
                <div class="col-md-12">
                  <h3 style="margin-left:20px;margin-bottom:-10px">Achievement Order Hari Ini :</h3>
                  <div class="panel-body" id="oth_order_achievement"></div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h3 style="margin-left:20px;margin-bottom:-10px">Achievement Order :</h3>
                  <div class="panel-body">
                    <div class="col-md-3">
                      <label>Periode Awal</label>
                      <input id="prd_awal" name="prd_awal" class="form-control oth_datepicker" autocomplete="off" placeholder="<?= date('Y-m-d')?>">
                    </div>
                    <div class="col-md-4">
                      <label>Periode Akhir</label>
                      <div class="input-group">
                          <input id="prd_akhir" name="prd_akhir" class="form-control oth_datepicker" autocomplete="off" placeholder="<?= date('Y-m-d')?>">
                          <span class="input-group-btn">
                              <button type="button" class="btn" style="background-color:#0AA86C;color:white;margin-left:15px" onclick="schAchievement(this)"><i class="fa fa-search"></i> Search</button>
                          </span>
                      </div>
                    </div>
                  </div>
                  <div class="panel-body" id="oth_sch_achievement"></div>
                  <br>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>