<style>
  .fc-day.fc-sun {
    background-color: #ffbdb8;
  }

  .fc-event {
    background-color: none;
  }

  .fc-day.selected {
    background-color: #d3ebff;
    filter: brightness(0.7);
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="text-right">
            <h1>
              <b>Order Nomor <a target="_blank" href="<?= base_url('civil-maintenance-order/order/view_order/' . $order_id)  ?>">
                  #<?= $order_id ?>
                </a>
              </b>
            </h1>
          </div>
        </div>
        <br />
        <div class="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-bottom: 1em;">
                    <a href="<?= base_url('civil-maintenance-order/order/monitoring') ?>" class="btn btn-warning">
                      <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                  </div>
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-body">
                        <div id="calender-container" style="margin-bottom: 1em;">
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <label for="">Keterangan</label>
                            <a id="fetch_calendar" title="Muat ulang data kalender" class="btn btn-primary btn-sm pull-right">
                              <i class="fa fa-refresh"></i>
                            </a>
                          </div>
                          <div class="col-lg-3" style="position: relative;">
                            <div style="height: 20px; width: 20px; display: inline-block; background-color: #ffbdb8;"></div>
                            <span style="position: absolute; margin-left: 1em;">Hari Minggu</span>
                          </div>
                          <div class="col-lg-3" style="position: relative;">
                            <div style="height: 20px; width: 20px; display: inline-block; background-color: rgb(48, 219, 63);"></div>
                            <span style="position: absolute; margin-left: 1em;">Mulai</span>
                          </div>
                          <div class="col-lg-3" style="position: relative;">
                            <div style="height: 20px; width: 20px; display: inline-block; background-color: rgb(230, 168, 44);"></div>
                            <span style="position: absolute; margin-left: 1em;">Progress</span>
                          </div>
                          <div class="col-lg-3" style="position: relative;">
                            <div style="height: 20px; width: 20px; display: inline-block; background-color: #b5180d;"></div>
                            <span style="position: absolute; margin-left: 1em;">Selesai</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div id="task" class="card shadow hidden">
                      <div class="card-header">
                        <h4 class="text-center" style="font-size: 1.7em; font-weight: bold;" id="task_date"></h4>
                      </div>
                      <div class="card-body">
                        <form action="#" id="task_form">
                          <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <button type="button" role="button" id="task_job_add" class="btn btn-sm btn-primary rounded-circle pull-right">
                              <i class="fa fa-plus"></i>
                            </button>
                          </div>
                          <table id="job_task" class="table">
                            <thead>
                              <tr>
                                <th width="10px">No</th>
                                <th>Pekerjaan</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- from js -->
                            </tbody>
                          </table>
                          <div class="form-group">
                            <label for="">Kondisi / Kendala di lapangan</label>
                            <textarea name="detail" id="task_detail" id="" cols="30" rows="5" class="form-control"></textarea>
                          </div>
                        </form>
                        <div id="action_wrapper">
                          <div style="display: block;">
                            <div id="end_wrapper">
                              <input type="checkbox" name="is_end" id="task_is_end">
                              <label for="">Selesai</label>
                            </div>
                            <div class="pull-right">
                              <button class="btn btn-default" id="task_cancel">Batal</button>
                              <button type="submit" id="task_save" class="btn btn-primary">Simpan</button>
                            </div>
                          </div>
                          <div class="row" style="padding-top: 4em">
                            <div class="col-md-12">
                              <a href="#" id="task_delete" class="text-danger pull-right">hapus</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
<div id="fullscreen-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11; display: none;">
  <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<input type="hidden" id="monitoring_schedule_order_id" value="<?= $order_id ?>">