<style type="text/css">
  .select2-container {
    width: 100% !important;
    padding: 0;
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
          <div class="tab-pane active" id="kaizen-all">
            <div class="table-responsive">
              <table class="table table-bordered table-fit" id="tblKaizen">
                <thead>
                  <tr class="bg-success">
                    <th class="text-center" width="6%">No</th>
                    <th class="text-center">Judul Kaizen</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="">Action</th>
                  </tr>
                </thead>
                 <tbody>
                  <?php if ($kaizen): $no = 0; foreach ($kaizen as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status'] == 2
                                      || $kaizen_item['status'] == 3 
                                      || $kaizen_item['status'] == 4
                                      || $kaizen_item['status'] == 5) { ?>
                                <table>
                                        <tr>
                                            <td style="">
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
                                            <td class="pull-left">
                                              <?php /* if($kaizen_item['status_date'] != null) {
                                              echo '('.date("d M Y", strtotime($kaizen_item['status_date'])).')';
                                                } */ ?>
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach;else: ?>
                    <tr>
                      <td colspan="5"> No Kaizen- </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
               
              </table>
            </div>
          </div>
          <div class="tab-pane" id="kaizen-check">
            <div class="table-responsive">
              <table class="table table-bordered table-fit" id="tblKaizenCheck">
                <thead>
                  <tr class="bg-success">
                    <th class="text-center" width="6%">No</th>
                    <th class="text-center">Judul Kaizen</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" >Action</th>
                  </tr>
                </thead>
               <tbody>
                  <?php
                    if ($kaizen_unchecked):
                   $no = 0; foreach ($kaizen_unchecked as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status'] == 2
                                      || $kaizen_item['status'] == 3 
                                      || $kaizen_item['status'] == 4
                                      || $kaizen_item['status'] == 5) { ?>
                                <table>
                                        <tr>
                                            <td style="">
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
                                            <td class="pull-left">
                                              <?php if($kaizen_item['status_date'] != null) {
                                              echo '('.date("d M Y", strtotime($kaizen_item['status_date'])).')';
                                                } ?>
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach;
                  else: ?>
                    <tr>
                      <td colspan="5"> No Unchecked Kaizen- </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="kaizen-ok">
            <div class="table-responsive">
              <table class="table table-bordered table-fit" id="tblKaizenOk">
                <thead>
                  <tr class="bg-success">
                    <th class="text-center" width="6%">No</th>
                    <th class="text-center">Judul Kaizen</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" >Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($kaizen_approved): $no = 0; foreach ($kaizen_approved as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status'] == 2
                                      || $kaizen_item['status'] == 3 
                                      || $kaizen_item['status'] == 4
                                      || $kaizen_item['status'] == 5) { ?>
                                <table>
                                        <tr>
                                            <td style="">
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
                                            <td class="pull-left">
                                              <?php if($kaizen_item['status_date'] != null) {
                                              echo '('.date("d M Y", strtotime($kaizen_item['status_date'])).')';
                                                } ?>
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; 
                  else: ?>
                    <tr>
                      <td colspan="5"> No Approved Kaizen- </td>
                    </tr>
                  <?php endif;?>
                </tbody>
                
              </table>
            </div>
          </div>
          <div class="tab-pane" id="kaizen-revise">
            <div class="table-responsive">
              <table class="table table-bordered table-fit" id="tblKaizenRevise">
                <thead>
                  <tr class="bg-success">
                    <th class="text-center" width="6%">No</th>
                    <th class="text-center">Judul Kaizen</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" >Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($kaizen_revised): $no = 0; foreach ($kaizen_revised as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status'] == 2
                                      || $kaizen_item['status'] == 3 
                                      || $kaizen_item['status'] == 4
                                      || $kaizen_item['status'] == 5) { ?>
                                <table>
                                        <tr>
                                            <td style="">
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
                                            <td class="pull-left">
                                              <?php if($kaizen_item['status_date'] != null) {
                                              echo '('.date("d M Y", strtotime($kaizen_item['status_date'])).')';
                                                } ?>
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="5"> No Revised Kaizen- </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
               
              </table>
            </div>
          </div>
          <div class="tab-pane" id="kaizen-reject">
            <div class="table-responsive">
              <table class="table table-bordered table-fit" id="tblKaizenReject">
                <thead>
                  <tr class="bg-success">
                    <th class="text-center" width="6%">No</th>
                    <th class="text-center">Judul Kaizen</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" >Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tbody>
                  <?php if ($kaizen_rejected): $no = 0; foreach ($kaizen_rejected as $kaizen_item):; $no++ ?>
                    <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td><?= $kaizen_item['judul']; ?></td>
                      <td class="text-center"><?= date("d M Y", strtotime($kaizen_item['created_date'])); ?></td>
                      <td class="text-left">
                            <?php if ($kaizen_item['status'] == 2
                                      || $kaizen_item['status'] == 3 
                                      || $kaizen_item['status'] == 4
                                      || $kaizen_item['status'] == 5) { ?>
                                <table>
                                        <tr>
                                            <td style="">
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
                                            <td class="pull-left">
                                              <?php if($kaizen_item['status_date'] != null) {
                                              echo '('.date("d M Y", strtotime($kaizen_item['status_date'])).')';
                                                } ?>
                                            </td>
                                          
                                        </tr>
                                </table>

                            <?php } ?>
                      </td>
                      <td class="text-center">
                        <!-- view -->
                        <a title="View Kaizen.." class="btn btn-xs btn-success" href="<?= base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/View/'.$kaizen_item['kaizen_id']); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="5"> No Rejected Kaizen- </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>