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
          <li><a href="#kaizen-reject" data-toggle="tab">Rejected Kaizen</a></li>
          <li><a href="#kaizen-revise" data-toggle="tab">Revised Kaizen</a></li>
          <li><a href="#kaizen-ok-ide" data-toggle="tab">Approved Ide Kaizen</a></li>
          <li><a href="#kaizen-ok" data-toggle="tab">Approved Kaizen</a></li>
          <li><a href="#kaizen-check" data-toggle="tab">Uncheck Kaizen</a></li>
          <li class="active"><a href="#kaizen-all" data-toggle="tab">All Kaizen</a></li>
          <li class="pull-left header"><b class="fa fa-users"></b> My Team Kaizen</li>
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
              <table width="100%" class="table table-bordered table-fit tblSIKaizen" id="<?= $desc[$a]['id_table'] ?>" >
                <thead>
                  <tr class="<?= $desc[$a]['bg_color'] ?>">
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="2%">No</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="24%">Judul Kaizen</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="10%">Tanggal Dibuat</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2" width="36%">Status</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="15%">Lapor</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="13%">Action</th>
                  </tr>
                  <tr class="<?= $desc[$a]['bg_color'] ?>">
                    <th class="text-center" style="vertical-align: middle;" width="24%" >Ide Kaizen</th>
                    <th class="text-center" style="vertical-align: middle;" width="12%" >Realisasi Ide </th>
                  </tr>
                </thead>
                 <tbody>
                  <?php if ($$desc[$a]['name_array']): $no = 0; foreach ($$desc[$a]['name_array'] as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                        <?php $arrIdeDone = array('3','6','7','9');
                            if ($kaizen_item['status'] == 0) { ?>
                                <strong><i class="fa fa-angle-right"></i></strong>
                                <span class="label label-default" >Created Ide</span>
                            <?php } elseif ($kaizen_item['status'] == 1) { ?>
                                 <strong><i class="fa fa-angle-right"></i></strong>
                                <span class="label label-default" >Edited Ide</span>
                            <?php } elseif ($kaizen_item['status'] == 4) { ?>
                                <strong><i class="fa fa-angle-right"></i> </strong>
                                <span class="label label-warning">Revisi Ide</span>
                            <?php } elseif (in_array($kaizen_item['status'], $arrIdeDone)) { ?>
                                <strong><i class="fa fa-angle-right"></i> </strong>
                                 <span class="label label-success">Approved Ide <b class="fa fa-check-circle"> </b></span>
                            <?php } elseif ($kaizen_item['status'] == 5) { ?>
                                <strong><i class="fa fa-angle-right"></i> </strong>
                                <span class="label label-danger">Rejected Ide</span>
                            <?php } elseif ($kaizen_item['status'] == 2) { ?>
                                <strong><i class="fa fa-angle-right"></i> </strong>
                                <span class="label label-info">Req. Approve Ide</span>
                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <?php if ($kaizen_item['status'] == 3) { ?>
                          <span class="label label-primary btn-real-ena">Submit Realisasi <b class="fa fa-arrow-right"></b></span>
                        <?php } elseif ($kaizen_item['status'] == 6) { ?>
                              <?php if ($kaizen_item['approval_realisasi'] == 1) { ?>
                                <span class="label label-info ">Req. Approve Realisasi</span>
                              <?php }else{ ?>
                                <span class="label label-info btn-real-ena">Requested Approve <b class="fa fa-info-circle"></b></span>
                              <?php } ?>
                        <?php } elseif ($kaizen_item['status'] == 7 || $kaizen_item['status'] == 9 ) {?>
                          <span class="label label-success">Approved Realisasi <b class="fa fa-check-circle"></b></span>
                        <?php } else {?>
                          <span class="label label-default btn-real-dis">Submit Realisasi </span>
                        <?php } ?>
                      </td>
                      <td class="text-center ">
                        <?php if ($kaizen_item['status'] == 7) { ?>
                          <!-- <a href="" > -->
                          <?php if($kaizen_item['user_id'] == $this->session->userdata('userid')): ?>
                          <span data-id="<?= $kaizen_item['kaizen_id'] ?>" id="SIlaporkanKai" class="label label-primary btn-real-ena faa-flash faa-slow animated">Laporkan <b class="fa fa-arrow-right"></b></span>
                          <?php else: ?>
                            <span data-id="<?= $kaizen_item['kaizen_id'] ?>" class="label label-primary btn-real-ena faa-flash faa-slow animated">Laporkan <b class="fa fa-arrow-right"></b></span>
                          <?php endif; ?>
                          <!-- </a> -->
                        <?php }elseif ($kaizen_item['status'] == 9) { ?>
                          <span style="background-color: #f8f9fa" class="label btn-light btn-real-dis" >Laporkan <i class="fa fa-check-circle text-info"></i>
                          </span>
                            <br>(<?= date('d M Y', strtotime($kaizen_item['status_date'])) ?>)
                        <?php } else{?>
                          <span class="label label-default btn-real-dis">Laporkan </span>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- Req Approve -->
                        <!-- <a class="btn btn-xs btn-info"  href="#" data-toggle="modal" data-target="#req<?= $kaizen_item['kaizen_id'] ?>"><i class="fa fa-check"></i></a> -->
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                        <?php if($kaizen_item['user_id'] == $this->session->userdata('userid')): ?>
                        <!-- edit -->
                        <a title="edit Kaizen" class="btn btn-xs <?php echo in_array($kaizen_item['status'], $statusTakbolehEdit) ? 'btn-default disabled' : 'btn-primary' ; ?>" 
                          href="<?= base_url('SystemIntegration/KaizenGenerator/Edit/'.$kaizen_item['kaizen_id']);?>"><i class="fa fa-edit"></i></a>
                        <!-- delete -->
                        <a class="btn btn-xs btn-danger" title="Delete Kaizen.." href="#" data-toggle="modal" data-target="#del<?= $kaizen_item['kaizen_id'] ?>"><i class="fa fa-trash"></i></a>
                        <!-- pdf -->
                        <a id="SIpdf" href="<?= base_url("SystemIntegration/KaizenGenerator/Pdf/$kaizen_item[kaizen_id]") ?>" class="btn btn-xs  <?= ($kaizen_item['status'] == 9) ? 'btn-info ' : 'btn-default disabled'?>"><i class="fa fa-download"></i></a>
                         <div class="modal fade" id="del<?= $kaizen_item['kaizen_id'] ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog" style="min-width:800px;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Apakah anda Yakin?</h4>
                              </div>
                              <div class="modal-body" >
                                <center>
                                  Menghapus : <b><?= $kaizen_item['judul']; ?></b>
                                </center>
                              </div>
                              <div class="modal-footer">
                                <a href="<?php echo base_url("SystemIntegration/KaizenGenerator/Delete/$kaizen_item[kaizen_id]") ?>">
                                <button type="submit" class="btn btn-danger" >Delete</button>
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
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