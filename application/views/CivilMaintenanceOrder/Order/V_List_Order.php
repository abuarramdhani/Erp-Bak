<?php
// JUST FOR HELPER
/**
 * @param Array $approver
 * @param Int Level
 */
function getApprovalDisplay($data, $level)
{
  $approver = array_filter($data, function ($item) use ($level) {
    return $item['jenis_approver'] == $level;
  });

  if (!$approver) return '';
  $approver = $approver[0];

  $htmlParagraph = '';

  $approver_name = $approver['employee_name'];

  if ($approver['status_approval'] == 1) {
    $htmlParagraph .= '<p style="color: green">- ' . $approver_name;
  } elseif ($approver['status_approval'] == 2) {
    $htmlParagraph .= '<p style="color: red">- ' . $approver_name;
  } else {
    $htmlParagraph .= '<p style="color: grey">- ' . $approver_name;
  }

  if ($approver['status_approval'] == 0) {
    $htmlParagraph .= ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="' . $approver['order_approver_id'] . '"></i>
                                              <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="' . $approver['order_approver_id'] . '"></i>
                                              </p>';
  } else {
    $htmlParagraph .= "</p>";
  }

  return $htmlParagraph;
}

?>

<style>
  .dataTables_filter {
    float: right;
  }

  .buttons-excel {
    background-color: green;
    color: white;
  }

  .setPointer {
    cursor: pointer;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b><?= $Title ?></b></h1>
          </div>
        </div>
        <div class="col-lg-1">
          <div class="text-right hidden-md hidden-sm hidden-xs">

          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11"></div>
            <div class="col-lg-1 "></div>
          </div>
        </div>
        <br />
        <div class="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div class="col-md-12 text-right">
                  <a href="<?= base_url('civil-maintenance-order/order/create_order') ?>" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-lg-12">
                    <ul class="nav nav-pills nav-justified" role="tablist" id="mco_tablistorder">
                      <li role="presentation" class="active">
                        <a href="#tab_all" aria-controls="all" role="tab" data-toggle="tab">Semua Pekerjaan</a>
                      </li>
                      <?php foreach ($jenis_order as $index => $order) : ?>
                        <li role="presentation">
                          <a href="#tab_<?= $index ?>" aria-controls="pedo" role="tab" data-toggle="tab"> <?= $order['jenis_order'] ?></a>
                        </li>
                      <?php endforeach ?>
                    </ul>
                    <hr>
                    <div class="tab-content">
                      <style type="text/css">
                        .dt-buttons,
                        .dataTables_info {
                          float: left;
                        }

                        .dataTables_filter,
                        .dataTables_paginate {
                          float: right;
                        }
                      </style>
                      <div role="tabpanel" class="tab-pane fade in active" id="tab_all">
                        <div class="row">
                          <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                            <div class="table-responsive">
                              <table class="table table-bordered table-hover table-striped table-civil-maintenance-order">
                                <thead class="bg-primary">
                                  <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                  <!-- <th class="bg-primary" style="text-align: center;">No Log</th> -->
                                  <th class="bg-primary" width="10%" style="text-align: center;">No Order</th>
                                  <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Jenis Order</th>
                                  <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Pekerjaan</th>
                                  <th style="text-align: center;">Order Tanggal</th>
                                  <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                  <th style="text-align: center;">Approval Pengorder</th>
                                  <th style="text-align: center;">Approval Penerima Order</th>
                                  <th style="text-align: center; width: 130px;">Action</th>
                                  <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                  <th style="text-align: center;">Pemberi Order</th>
                                  <th style="text-align: center;">Voip</th>
                                  <th style="text-align: center;">Jenis Pekerjaan</th>
                                  <th style="text-align: center;">Total Pekerjaan</th>
                                  <th class="bg-primary" style="text-align: center;">Status</th>
                                </thead>
                                <tbody class="text-center">
                                  <?php
                                  $number = 1;
                                  ?>
                                  <?php foreach ($all_order as $order) : ?>
                                    <tr>
                                      <td><?= $number++ ?></td>
                                      <!-- <td><?= $order['nomor_log'] ?></td> -->
                                      <td><?= $order['order_id'] ?></td>
                                      <td><?= $order['jenis_order'] ?></td>
                                      <td class="text-left"><?= $order['pekerjaan'] ?></td>
                                      <td><?= date('d-M-Y', strtotime($order['tgl_order'])) ?></td>
                                      <td><?= date('d-M-Y', strtotime($order['tgl_dibutuhkan'])) ?></td>
                                      <td><?= getApprovalDisplay($order['approver'], 1) ?></td>
                                      <td><?= getApprovalDisplay($order['approver'], 2) ?></td>
                                      <td>
                                        <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/' . $order['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                          <i class="fa fa-eye"></i>
                                        </a>
                                        <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/' . $order['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $order['order_id'] ?>">
                                          <i class="fa fa-trash"></i>
                                        </a>
                                      </td>
                                      <td><?= $order['section_name'] ?></td>
                                      <td style="white-space: nowrap; text-align: left"><?= $order['pengorder'] . ' - ' . $order['dari'] ?></td>
                                      <td><?= $order['voip'] ?></td>
                                      <td style="white-space: nowrap; text-align: left"><?= $order['jenis_pekerjaan'] ?></td>
                                      <td><?= $order['total_order'] ?></td>
                                      <td style="background-color: <?= $order['status_color'] ?>">
                                        <?= $order['status'] ?>
                                      </td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php foreach ($sub_order as $index => $order_type) : ?>
                        <div role="tabpanel" class="tab-pane fade in" id="tab_<?= $index ?>">
                          <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                              <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-civil-maintenance-order">
                                  <thead class="bg-primary">
                                    <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                    <!-- <th class="bg-primary" style="text-align: center;">No Log</th> -->
                                    <th class="bg-primary" width="10%" style="text-align: center;">No Order</th>
                                    <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Jenis Order</th>
                                    <th style="text-align: center;">Order Tanggal</th>
                                    <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                    <th style="text-align: center;">Approval Pengorder</th>
                                    <th style="text-align: center;">Approval Penerima Order</th>
                                    <th style="text-align: center; width: 130px;">Action</th>
                                    <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                    <th style="text-align: center;">Pemberi Order</th>
                                    <th style="text-align: center;">Voip</th>
                                    <th style="text-align: center;">Jenis Pekerjaan</th>
                                    <th style="text-align: center;">Total Pekerjaan</th>
                                    <th class="bg-primary" style="text-align: center;">Status</th>
                                  </thead>
                                  <tbody class="text-center">
                                    <?php
                                    $number = 1;
                                    ?>
                                    <?php foreach ($order_type['list_order'] as $order) : ?>
                                      <tr>
                                        <td><?= $number++ ?></td>
                                        <!-- <td><?= $order['nomor_log'] ?></td> -->
                                        <td><?= $order['order_id'] ?></td>
                                        <td><?= $order['jenis_order'] ?></td>
                                        <td><?= date('d-M-Y', strtotime($order['tgl_order'])) ?></td>
                                        <td><?= date('d-M-Y', strtotime($order['tgl_dibutuhkan'])) ?></td>
                                        <td><?= getApprovalDisplay($order['approver'], 1) ?></td>
                                        <td><?= getApprovalDisplay($order['approver'], 2) ?></td>
                                        <td>
                                          <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/' . $order['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                            <i class="fa fa-eye"></i>
                                          </a>
                                          <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/' . $order['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                            <i class="fa fa-edit"></i>
                                          </a>
                                          <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $order['order_id'] ?>">
                                            <i class="fa fa-trash"></i>
                                          </a>
                                        </td>
                                        <td><?= $order['section_name'] ?></td>
                                        <td style="white-space: nowrap; text-align: left"><?= $order['pengorder'] . ' - ' . $order['dari'] ?></td>
                                        <td><?= $order['voip'] ?></td>
                                        <td style="white-space: nowrap; text-align: left"><?= $order['jenis_pekerjaan'] ?></td>
                                        <td><?= $order['total_order'] ?></td>
                                        <td style="background-color: <?= $order['status_color'] ?>">
                                          <?= $order['status'] ?>
                                        </td>
                                      </tr>
                                    <?php endforeach ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach ?>
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
<?php
if (isset($order_id) && !empty($order_id)) {
?>
  <script type="text/javascript">
    $(document).ready(function() {
      cetakOrderCM(<?php echo $order_id ?>)
    })
  </script>
<?php
}
?>