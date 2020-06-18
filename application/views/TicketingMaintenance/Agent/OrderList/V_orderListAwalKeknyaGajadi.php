<style type="text/css">
  .select2-container {
    width: 100% !important;
    padding: 0;

}
  .btn-real-dis{
   /*cursor: pointer;*/
   color: #888;
  }

  .btn-real-ena{
    cursor: pointer;
  }
</style>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li><a href="#order-rejected" data-toggle="tab">Rejected</a></li>
          <li><a href="#order-close" data-toggle="tab">Close</a></li>
          <li><a href="#order-done" data-toggle="tab">Done</a></li>
          <li><a href="#order-overdue" data-toggle="tab">Overdue</a></li>
          <li><a href="#order-action" data-toggle="tab">Action</a></li>
          <li><a href="#order-reviewed" data-toggle="tab">Reviewed</a></li>
          <li><a href="#order-acc" data-toggle="tab">ACC</a></li>
          <li class="active"><a href="#order-all" data-toggle="tab">Open</a></li>
          <li class="pull-left header"><b class="fa fa-file-text-o"></b> <b>Order List</b></li>
        </ul>
        <div class="tab-content">
          <!--  -->
          <?php
            $desc[0]['name'] = '';
            $desc[0]['id_tab'] = 'kaizen-all';
            $desc[0]['id_table'] = 'tblKaizen';
            $desc[0]['name_array'] = 'kaizen';
            $desc[0]['bg_color'] = 'bg-primary';

            $desc[1]['name'] = 'Unchecked';
            $desc[1]['id_tab'] = 'kaizen-check';
            $desc[1]['id_table'] = 'tblKaizenCheck';
            $desc[1]['name_array'] = 'kaizen_unchecked';
            $desc[1]['bg_color'] = 'bg-info';

            $desc[2]['name'] = 'Approved Ide';
            $desc[2]['id_tab'] = 'kaizen-ok-ide';
            $desc[2]['id_table'] = 'tblKaizenOkIde';
            $desc[2]['name_array'] = 'kaizen_approved_ide';
            $desc[2]['bg_color'] = 'bg-success';

            $desc[3]['name'] = 'Approved';
            $desc[3]['id_tab'] = 'kaizen-ok';
            $desc[3]['id_table'] = 'tblKaizenOk';
            $desc[3]['name_array'] = 'kaizen_approved';
            $desc[3]['bg_color'] = 'bg-green';

            $desc[4]['name'] = 'Revisi';
            $desc[4]['id_tab'] = 'kaizen-revise';
            $desc[4]['id_table'] = 'tblKaizenRevise';
            $desc[4]['name_array'] = 'kaizen_revised';
            $desc[4]['bg_color'] = 'bg-yellow';

            $desc[5]['name'] = 'Rejected';
            $desc[5]['id_tab'] = 'kaizen-reject';
            $desc[5]['id_table'] = 'tblKaizenReject';
            $desc[5]['name_array'] = 'kaizen_rejected';
            $desc[5]['bg_color'] = 'bg-red';

            $statusTakbolehEdit = array('2','3','6','7','9');

           for ($a=0; $a < 6; $a++) { ?>

          <div class="tab-pane <?= $a == 0 ? 'active' : '' ?>" id="<?= $desc[$a]['id_tab'] ?>">
            <div class="">
              <table width="100%" class="table table-bordered table-fit tblMonitoringOrder" id="<?= $desc[$a]['id_table'] ?>" >
                <thead>
                  <tr class="<?= $desc[$a]['bg_color'] ?>">
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="10%">No Order</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="25%">Nama Mesin</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="40%">Kerusakan</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2" width="15%">Last Response</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="10%">Action</th>
                  </tr>
                </thead>
                 <tbody>
                  <?php 
                  foreach ($orderById as $dataOrder) {
                      # code...
                  }
                  if ($$desc[$a]['name_array']): $no = 0; foreach ($$desc[$a]['name_array'] as $kaizen_item):; $no++ 
                  ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= $kaizen_item['pencetus'] ?></td>
                      <td class="text-center" data-order="<?php echo $kaizen_item['created_date']; ?>"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td></td>
                    </tr>
                  <?php //endforeach; ?>
                  <?php// endif; ?>
                </tbody>
               
              </table>
            </div>
          </div>

          <?php } ?>
          <!--  -->
        </div>
      </div>
    </div>
  </div>
</section>




huehe



<div class="tab-pane fade" id="pg_5" role="tabpanel" aria-labelledby="#pg_5">
                                                <div class="col-lg-12">
                                                <table class="datatable table table-striped table-bordered table-hover text-left" id="tbDone" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Alasan Keterlambatan</th>
                                                            <th class="text-center">Waktu Mulai</th>
                                                            <th class="text-center">Waktu Selesai</th>
                                                            <!-- <th class="text-center">Jam Selesai</th>
                                                            <th class="text-center">Keterangan</th> -->
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                            $no = 1;
                                                            if (empty($viewKeterlambatan)) {
                                                                # code...
                                                            }else{
                                                                foreach ($viewKeterlambatan as $kt) {
                                                                        $alasan = $kt['alasan'];
                                                                        $waktu_mulai = $kt['waktu_mulai'];                                                                
                                                                        $waktu_selesai = $kt['waktu_selesai'];                                                                
                                                            ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $alasan; ?></td>
                                                            <td><?php echo $waktu_mulai; ?></td>
                                                            <td><?php echo $waktu_selesai; ?></td>
                                                            <!-- <td>02:00</td>
                                                            <td>Tanpa Keterangan</td> -->
                                                            </tr>
                                                            <?php
                                                                $no++;
                                                            } }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--THE END OF TAB DONE-->