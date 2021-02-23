<?php
// Helper
function commaToList($str)
{
  $split = explode(',', $str);

  $list = "<ol style='padding-left: 1em;'>";
  $list .= implode('', array_map(function ($item) {
    return "<li>$item</li>";
  }, $split));
  $list .= "</ol>";

  return $list;
}
?>
<style>
  .dataTables_filter {
    float: right;
  }

  .pointer {
    cursor: pointer;
  }

  .buttons-excel {
    background-color: green;
    color: white;
  }

  #monitoring-table_filter input {
    width: 300px;
  }

  .hover:hover .hover-darken {
    background-color: #02000087;
  }

  .hover .hover-display {
    display: none !important;
  }

  .hover:hover .hover-display {
    display: flex !important;
  }

  .text-white {
    color: white !important;
  }

  /* // remove arrow sort datatable */
  .sorting,
  .sorting_asc,
  .sorting_desc {
    background: none;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="text-right">
            <h1><b>Monitoring Order</b></h1>
          </div>
        </div>
        <br />
        <div class="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover" id="monitoring-table">
                    <thead class="bg-primary">
                      <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>No Order</th>
                        <th>Status</th>
                        <th>Nama Pekerjaan</th>
                        <th>Noind - Nama</th>
                        <th>Seksi</th>
                        <th>Tgl Order</th>
                        <th>Tgl Masuk Order</th>
                        <th>Target Selesai</th>
                        <th>Tgl Dikerjakan</th>
                        <th>Tgl Selesai</th>
                        <th>Jumlah Hari Kerja</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($allOrders as $index => $order) : ?>
                        <tr>
                          <td>
                            <?= $index + 1 ?>
                          </td>
                          <td>
                            <!-- <button class="btn btn-primary calender-toggle" data-toggle="modal" data-target="#modal-calender">
                              <i class="fa fa-calendar"></i>
                            </button> -->
                            <a class="btn btn-primary calendar-toggle <?= $order->status == 1 ? 'hidden' : '' ?>" href="<?= base_url('civil-maintenance-order/order/monitoring/schedule/' . $order->order_id) ?>">
                              <i class="fa fa-calendar"></i>
                            </a>
                          </td>
                          <td>
                            <a target="_blank" href="<?= base_url('civil-maintenance-order/order/view_order/' . $order->order_id)  ?>">
                              #<?= $order->order_id ?>
                            </a>
                          </td>
                          <td class="hover pointer" style="background-color: <?= $order->status_color ?>; position: relative;">
                            <span class="status_name"><?= $order->status ?></span>
                            <div data-status_id="<?= $order->status_id ?>" data-order_id="<?= $order->order_id ?>" data-toggle="modal" data-target="#modal-change-status" class="hover-display hover-darken change-status" style="position: absolute; top: 0; right:0; left:0; bottom: 0; z-index: 2; display: flex; transition: 0.5s;">
                              <span class="text-white" style="margin: auto;">Ubah</span>
                            </div>
                          </td>
                          <td><?= commaToList($order->pekerjaan) ?></td>
                          <td><?= "<b>" . $order->noind . "</b>" . " - " . $order->nama ?></td>
                          <td><?= $order->seksi ?></td>
                          <td><?= $order->tgl_order ? date('d/m/Y', strtotime($order->tgl_order)) : '' ?></td>
                          <td data-tanggal_masuk_order="<?= $order->tgl_terima ? date('Y-m-d', strtotime($order->tgl_terima)) : "" ?>">
                            <?= $order->tgl_terima ? date('d/m/Y', strtotime($order->tgl_terima)) : "<button data-order_id='" . $order->order_id . "' data-toggle='modal' data-target='#modal-change-date' class='btn btn-primary btn-sm change_acc_date'>Ubah</button>" ?>
                          </td>
                          <td><?= $order->tgl_dibutuhkan ? date('d/m/Y', strtotime($order->tgl_dibutuhkan)) : '' ?></td>
                          <td data-tanggal_dikerjakan="<?= $order->tgl_dikerjakan ? date('Y-m-d', strtotime($order->tgl_dikerjakan)) : '' ?>"><?= $order->tgl_dikerjakan ? date('d/m/Y', strtotime($order->tgl_dikerjakan)) : '' ?></td>
                          <td data-tanggal_selesai="<?= $order->tgl_selesai ? date('Y-m-d', strtotime($order->tgl_selesai)) : '' ?>"><?= $order->tgl_selesai ? date('d/m/Y', strtotime($order->tgl_selesai)) : '' ?></td>
                          <td><?= $order->jumlah_hari ?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CHANGE DATE MODAL -->
<div class=" modal fade" id="modal-change-date" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 400px; margin: 0 auto; border-radius: 8px;">
      <div class="modal-header text-center">
        <label class="modal-title">Ubah Tanggal Terima</label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <form action="#" style="margin: 0 2.5em;">
          <input type="hidden" name="order_id">
          <div class="form-group">
            <label for="">Tanggal</label>
            <input id="datepicker" name='date' data-placeholder="Tanggal terima" placeholder="Tanggal terima" type="text" class="form-control">
          </div>
          <button id="submit" role="button" class="btn btn-block btn-primary">Ubah Tanggal</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- CHANGE STATUS MODAL -->
<div class="modal fade" id="modal-change-status" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 400px; margin: 0 auto; border-radius: 8px;">
      <div class="modal-header text-center">
        <label class="modal-title">Ubah Status</label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <form action="#" style="margin: 0 2.5em;">
          <input type="hidden" name="order_id">
          <div class="form-group">
            <label for="">Status</label>
            <select class="form-control" name="status" id="">
              <?php foreach ($allStatus as $status) : ?>
                <option value="<?= $status['status_id'] ?>" data-color="<?= $status['status_color'] ?>"><?= $status['status'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <button id="submit" role="button" class="btn btn-block btn-primary">Ubah</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- // STATUS COLOR -->

<script>
  $(window).load(() => {
    // when load complete
    // open the sidebar
    $(".sidebar-toggle").trigger("click");
    console.log("hai")
  })
</script>