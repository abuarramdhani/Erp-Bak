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
          <li class="pull-left header"><i class="fa fa-tag"></i> My Kaizen</li>
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
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="30%">Judul Kaizen</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="12%">Tanggal Dibuat</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2" width="40%">Status</th>
                    <!-- <th class="text-center" style="vertical-align: middle;" rowspan="2" width="15%">Lapor</th> -->
                    <th class="text-center" style="vertical-align: middle;" rowspan="2" width="16%">Action</th>
                  </tr>
                  <tr class="<?= $desc[$a]['bg_color'] ?>">
                    <th class="text-center" style="vertical-align: middle;" width="24%" >Ide Kaizen</th>
                    <th class="text-center" style="vertical-align: middle;" width="16%" >Realisasi Ide </th>
                  </tr>
                </thead>
                 <tbody>
                  <?php if ($$desc[$a]['name_array']): $no = 0; foreach ($$desc[$a]['name_array'] as $kaizen_item): $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td id="judul"><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center" data-order="<?php echo $kaizen_item['created_date']; ?>"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
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
                                <table>
                                  <?php $x=0;$i= 1; foreach ($kaizen_item['status_app'] as $key => $value) {  
                                      //if ($kaizen_item['status_app'][$x]['level'.$i] != 0 ) { ?>
                                        <tr>
                                            <td class="text-left" style="width:8px"><strong><i class="fa fa-angle-right"></i></strong></td>
                                            <td style="">
                                              <span class="label 
                                              label-<?= ($kaizen_item['status_app'][$x]['status'] == 5) ? 'danger' 
                                                        : (($kaizen_item['status_app'][$x]['status'] == 3) ? 'success' 
                                                        : (($kaizen_item['status_app'][$x]['status'] == 4) ? 'warning' 
                                                        : (($kaizen_item['status_app'][$x]['status'] == 2) ? 'info' : 'default' )));  ?>">
                                                <?php 
                                                  if ($kaizen_item['status_app'][$x]['status'] == 2) {
                                                    echo "Req. Approve Ide";
                                                  }elseif ($kaizen_item['status_app'][$x]['status'] == 3) {
                                                    echo "Approved Ide";
                                                  }elseif ($kaizen_item['status_app'][$x]['status'] == 4) {
                                                    echo "Revision Ide";
                                                  }elseif ($kaizen_item['status_app'][$x]['status'] == 5) {
                                                    echo "Rejected Ide";
                                                  }

                                                ?>
                                                
                                              </span>
                                              <?= ' ('.$kaizen_item['status_app'][$x]['staff'].')'; ?>
                                            </td>
                                        </tr>
                                       <?php // } 
                                       $x++; $i++; ?>
                                  <?php } ?>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <?php if ($kaizen_item['status'] == 3) { ?>
                          <a href="<?= base_url('SystemIntegration/KaizenGenerator/SubmitRealisasi/'.$kaizen_item['kaizen_id']);?>" >
                          <span class="label label-primary btn-real-ena faa-flash faa-slow animated">Submit Realisasi <b class="fa fa-arrow-right"></b>&nbsp;</span>
                          </a>
                        <?php } elseif ($kaizen_item['status'] == 6) { ?>
                              <?php if ($kaizen_item['approval_realisasi'] == 1) { ?>
                                <span class="label label-info ">Req. Approve Realisasi</span>
                              <?php }else{ ?>
                                <a href="<?= base_url('SystemIntegration/KaizenGenerator/View/'.$kaizen_item['kaizen_id']);?>" >
                                <span class="label label-info btn-real-ena faa-flash faa-slow animated">Request Approve <b class="fa fa-info-circle"></b>&nbsp;</span>
                                </a>
                              <?php } ?>
                        <?php } elseif ($kaizen_item['status'] == 7 || $kaizen_item['status'] == 9 ) {?>
                          <span class="label label-success">Approved Realisasi <b class="fa fa-check-circle"></b>&nbsp;</span>
                        <?php } else {?>
                          <span class="label label-default btn-real-dis">Submit Realisasi </span>
                        <?php } ?>
                      </td>
                     
                      <td class="text-center">
                        <!-- Req Approve -->
                        <!-- <a class="btn btn-xs btn-info"  href="#" data-toggle="modal" data-target="#req<?= $kaizen_item['kaizen_id'] ?>"><i class="fa fa-check"></i></a> -->
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                        <!-- edit -->
                        <a title="edit Kaizen" class="btn btn-xs <?php echo in_array($kaizen_item['status'], $statusTakbolehEdit) ? 'btn-default disabled' : 'btn-primary' ; ?>" 
                          href="<?= base_url('SystemIntegration/KaizenGenerator/Edit/'.$kaizen_item['kaizen_id']);?>"><i class="fa fa-edit"></i></a>
                        <!-- delete -->
                        <a class="btn btn-xs btn-danger" data-id="<?= $kaizen_item['kaizen_id'] ?>" title="Delete Kaizen.." href="#" data-toggle="modal" data-target="#del" onclick="getDelDataSI(this)"><i class="fa fa-trash"></i></a>
                        <!-- pdf -->
                        <a id="SIpdf" href="<?= base_url("SystemIntegration/KaizenGenerator/Pdf/$kaizen_item[kaizen_id]") ?>" class="btn btn-xs  <?= ($kaizen_item['status'] == 9) ? 'btn-info ' : 'btn-default disabled'?>"><i class="fa fa-download"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <?php } ?>
                         <div class="modal fade" id="del" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog" style="min-width:800px;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Apakah anda Yakin?</h4>
                              </div>
                              <div class="modal-body" >
                                <center>
                                  Menghapus : <b id="deljudul"></b>
                                </center>
                              </div>
                              <div class="modal-footer">
                                <a id="delUrlSI" href="">
                                <button type="submit" class="btn btn-danger" >Delete</button>
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
        </div>
      </div>
    </div>
  </div>
</section>