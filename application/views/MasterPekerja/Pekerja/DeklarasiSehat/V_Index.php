<style media="screen">
  td{
    padding-bottom: 20px !important;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">

            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="mon_agt_2021" value="1">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header">
                      <input type="hidden" id="pbb_mon_stok_barkas" value="1">
                      <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-bar-chart-o"></i> Monitoring Deklarasi Sehat</h4>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <!-- <div class="panel-body"> -->
                      <div class="row pt-3">
                        <div class="col-md-4">
                          <label for="">Tanggal</label>
                          <input type="text" class="form-control mpds_range_tgl" name="" value="">
                        </div>
                        <div class="col-md-4">
                          <label for="">Seksi</label>
                          <select class="form-control mpds_getseksi" name="" style="width:100%">
                            <option value="" selected>Select..</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="">No Induk</label>
                          <select class="form-control mpds_getnoind" name="" style="width:100%">
                            <option value="" selected>Select..</option>
                          </select>
                        </div>
                        <div class="col-md-8 mt-4">
                          <label for="">Pernyataan Kosong</label>
                          <select class="form-control mpds_pertanyaan" name="" style="width:100%" multiple>
                            <option value="" selected>Select..</option>
                            <?php foreach ($pertanyaan as $key => $value): ?>
                              <option value="<?php echo $value['aspek'] ?>"><?php echo $value['pertanyaan'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-2 mt-4">
                          <label for="" style="color:transparent">hiahia</label>
                          <button type="button" class="btn btn-success text-bold" onclick="mpds_getdata()" style="width:100%" name="button"> Tampilkan Data</button>
                        </div>
                        <div class="col-md-1 mt-4">
                          <label for="" style="color:transparent">hiahia</label>
                          <button type="button" class="btn btn-success text-bold" style="width:100%" name="button"> Excel </button>
                        </div>
                        <div class="col-md-1 mt-4">
                          <label for="" style="color:transparent">hiahia</label>
                          <button type="button" class="btn btn-danger text-bold" style="width:100%" name="button"> PDF </button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <hr>
                        </div>
                        <div class="col-md-12">
                          <div class="mon_d_sehat">

                          </div>
                        </div>
                      </div>

                    <!-- </div> -->
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


<script>
  const SESSION_USER = '<?= $this->session->user ?>'
</script>
