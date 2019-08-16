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
          <li><a href="#kaizen-ok" data-toggle="tab">Approved Kaizen</a></li>
          <li><a href="#kaizen-check" data-toggle="tab">Uncheck Kaizen</a></li>
          <li class="active"><a href="#kaizen-all" data-toggle="tab">All Kaizen</a></li>
          <li class="pull-left header"><i class="fa fa-tag"></i> Approval Kaizen</li>
        </ul>
        <div class="tab-content">
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

            $desc[2]['name'] = 'Approved';
            $desc[2]['id_tab'] = 'kaizen-ok';
            $desc[2]['id_table'] = 'tblKaizenOk';
            $desc[2]['name_array'] = 'kaizen_approved';
            $desc[2]['bg_color'] = 'bg-green';

            $desc[3]['name'] = 'Revisi';
            $desc[3]['id_tab'] = 'kaizen-revise';
            $desc[3]['id_table'] = 'tblKaizenRevise';
            $desc[3]['name_array'] = 'kaizen_revised';
            $desc[3]['bg_color'] = 'bg-yellow';

            $desc[4]['name'] = 'Rejected';
            $desc[4]['id_tab'] = 'kaizen-reject';
            $desc[4]['id_table'] = 'tblKaizenReject';
            $desc[4]['name_array'] = 'kaizen_rejected';
            $desc[4]['bg_color'] = 'bg-red';


          for ($i=0; $i < 5; $i++) {   
          ?>
          <div class="tab-pane <?= $i == 0 ? 'active' : '' ?>" id="<?= $desc[$i]['id_tab'] ?>">
            <div class="table-responsive">
              <table class="table table-bordered table-fit tblSIKaizen" id="<?= $desc[$i]['id_table'] ?>">
                <thead>
                  <tr class="<?= $desc[$i]['bg_color'] ?>">
                    <th class="text-center" width="3%">No</th>
                    <th class="text-center" width="28%">Judul Kaizen</th>
                    <th class="text-center" width="20%">Pencetus</th>
                    <th class="text-center" width="12%">Tanggal Dibuat</th>
                    <th class="text-center" width="22%">Status</th>
                    <th class="text-center" width="10%">Lapor</th>
                    <th class="text-center" width="5%">Action</th>
                  </tr>
                </thead>
                 <tbody>
                  <?php if ($kaizen): $no = 0; foreach ($$desc[$i]['name_array'] as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td><?= $kaizen_item['pencetus']; ?></td>
                      <td class="text-center" data-order="<?php echo $kaizen_item['created_date']; ?>"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status_approve']) { ?>
                                <table width="100%">
                                        <tr>
                                            <td width="38%">
                                              <span class="label 
                                              label-<?= ($kaizen_item['status_approve'] == 5) ? 'danger' 
                                                        : (($kaizen_item['status_approve'] == 3) ? 'success' 
                                                        : (($kaizen_item['status_approve'] == 4) ? 'warning' 
                                                        : (($kaizen_item['status_approve'] == 2) ? 'info' : 'default' )));  ?>">
                                                <?php 
                                                  if ($kaizen_item['status_approve'] == 2) {
                                                    echo "Req. Approve";
                                                  }elseif ($kaizen_item['status_approve'] == 3) {
                                                    echo "Approved";
                                                  }elseif ($kaizen_item['status_approve'] == 4) {
                                                    echo "Revision";
                                                  }elseif ($kaizen_item['status_approve'] == 5) {
                                                    echo "Rejected";
                                                  }

                                                ?>
                                                
                                              </span> 
                                            </td>
                                            <td width="62%">
                                              &nbsp;&nbsp;<b class="fa fa-angle-double-right"> 
                                                </b> <?= $kaizen_item['level'] == 6 ? 'Approval Realisasi' : 'Approval Ide' ?> 
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                         <?php if ($kaizen_item['status'] == 7) { ?>
                          <!-- <a href="" > -->
                          <span data-id="<?= $kaizen_item['kaizen_id'] ?>" class="SIlaporkanKai label label-primary btn-real-ena faa-flash faa-slow animated">Laporkan <b class="fa fa-arrow-right"></b></span>
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
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach;endif;?>
                </tbody>
               
              </table>
            </div>
          </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>