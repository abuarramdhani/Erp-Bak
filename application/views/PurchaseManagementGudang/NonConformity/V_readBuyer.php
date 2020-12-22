<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?php echo $Title; ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <!-- <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PurchaseManagement/NonConformity');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <?php 
                                $encrypted_string = $this->encrypt->encode($PoOracleNonConformityHeaders[0]['header_id']);
                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                            ?>
                            <div class="box-header with-border">
                                Non Conformity Headers
                                <a href="<?php echo base_url('PurchaseManagementGudang/NonConformity/edit/'.$encrypted_string.''); ?>" class="btn btn-primary pull-right" style="border: 1px solid white;"><i class="fa fa-pencil"> Edit</i></a>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php foreach ($PoOracleNonConformityHeaders as $headerRow): ?>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Conformity Number
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['non_conformity_num']; ?>
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Po Number
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['po_number']; ?>
                                                    </div>
                                                </div> -->
                                                <div class="row">
                                                <input type="hidden" class="hdnHeaderIdNonC" value="<?php echo $headerRow['header_id']; ?>">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Delivery Date
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['delivery_date']; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Packing List
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['packing_list']; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Courier Agent
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['courier_agent']; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Verificator
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['verificator']; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- <div class="col-lg-4">
                                                        <strong>
                                                            Buyer
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php echo $headerRow['buyer']; ?>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <!-- <strong>
                                                            Header Status
                                                        </strong>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        :
                                                        <?php if ($headerRow['status'] == NULL || $headerRow['status'] == '' || $headerRow['status'] == 'open') {
                                                    $status = 'open';}else{$status = $headerRow['status'];} echo '<div id="header_status" style="display:inline;">
                                                        '.strtoupper($status).'
                                                    </div>
                                                    '; ?> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Supplier Name
                                                    </strong>
                                                </div>
                                                <div class="col-lg-8">
                                                    :
                                                    <?php echo $headerRow['supplier']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Person In Charge
                                                    </strong>
                                                </div>
                                                <div class="col-lg-8">
                                                    :
                                                    <?php echo $headerRow['person_in_charge']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Phone Number
                                                    </strong>
                                                </div>
                                                <div class="col-lg-8">
                                                    :
                                                    <?php 
                                                        $telp = '-';
                                                        $fax = '-'; 
                                                        if(!empty($Phone)){
                                                             if (!empty($Phone[0]['TELP'])) {
                                                                $telp = $Phone[0]['TELP'];
                                                            }
                                                            // if (!empty($Phone[0]['FAX'])) {
                                                            //     $fax = $Phone[0]['FAX'];
                                                            // }
                                                        }

                                                    
                                                    echo $telp; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Supplier Address
                                                    </strong>
                                                </div>
                                                <div class="col-lg-8">
                                                    :
                                                    <?php echo $headerRow['supplier_address']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="header_id" name="header_id" type="hidden" value="<?php echo $headerRow['header_id']; ?>">
                                            <?php endforeach; ?>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <br/>
                                <div class="row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Non Conformity Lines
                                        </div>
                                        <div class="panel-body">
                                          <div class="table-responsive">
                                              <table class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                <thead>
                                                    <tr>
                                                      <th>Case Name :</th>
                                                      <th>Description</th>
                                                      <th>Status</th>
                                                      <th>PO Number(line)</th>
                                                      <th>Items</th>
                                                      <th>Judgement</th>
                                                      <!-- <th>Remark</th> -->
                                                      <th>Export</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class="tdCaseNonC"><?php $no = 1; foreach($PoOracleNonConformityLines as $man): ?>
                                                              <span><?= $no++.'. '.$man['case_name'];?></span><br>
                                                          <?php endforeach; ?>
                                                          <!-- <button type="button" class="btn btn-primary btn-xs btnEditCaseNonC">Edit</button> -->
                                                      </td>
                                                      <td><span class="deskripsiNonC"><?php echo $PoOracleNonConformityLines[0]['description']; ?></span><br>
                                                      <!-- <button type="button" class="btn btn-xs btn-primary btnEditDeskripsiNonC">Edit</button> -->
                                                      </td>
                                                      <!-- <td><?php if ($PoOracleNonConformityLines[0]['judgement'] == NULL || $PoOracleNonConformityLines[0]['judgement'] == ''|| $PoOracleNonConformityLines[0]['status'] == NULL) {
                                                           echo "OPEN";}else{ echo strtoupper($PoOracleNonConformityLines[0]['status']);} ?>
                                                      </td> -->
                                                      <td><?php $stat = '';
                                                      if ($PoOracleNonConformityLines[0]['status']==0) {
                                                          $stat = 'OPEN';
                                                      }elseif ($PoOracleNonConformityLines[0]['status']==1) {
                                                          $stat = 'CLOSE';
                                                      }else{
                                                        $stat = '<span style="color: red"><i class="fa fa-warning"></i>Belum diset</span>';
                                                      }
                                                      ?>
                                                      <span class="statusNonC"><?php echo $stat?></span>
                                                      <br>
                                                      <!-- <button type="button" class="btn btn-primary btn-xs btnEditStatusNonC" status="<?= $PoOracleNonConformityLines[0]['status']?>">Edit</button> -->
                                                      </td>
                                                      <td>
                                                      <?php if (count($linesItem)==0) { ?>
                                                        <span style="color: red"><i class="fa fa-warning"></i>Belum diset</span><br>
                                                      <?php }else { ?>
                                                          <?php foreach ($linesItem as $key => $item) { ?>
                                                            <span><?php echo $item['no_po'].'('.$item['line'].')'; ?></span><br>
                                                          <?php }?>
                                                      <?php }?>
                                                      </td>
                                                      <td>
                                                      <?php if (count($linesItem)==0) { ?>
                                                        <span style="color: red"><i class="fa fa-warning"></i>Belum diset</span><br>
                                                      <?php }else { ?>
                                                          <?php foreach ($linesItem as $key => $item) { ?>
                                                            <span><?php echo $item['item_code'].'-'.$item['item_description']; ?></span><br>
                                                          <?php }?>
                                                      <?php }?>
                                                      </td>
                                                      <td>
                                                      <?php $judgement=''; if (count($PoOracleNonConformityLines)==0)  { ?>
                                                        <span style="color: red"><i class="fa fa-warning"></i>Belum diset</span>
                                                      <?php }else { ?>
                                                        <?php if ($PoOracleNonConformityLines[0]['judgement'] == 'CAR') {
                                                           $judgement = 'Close with CAR';
                                                        }else if ($PoOracleNonConformityLines[0]['judgement'] == 'NO CAR'){
                                                            $judgement = 'Close without CAR';
                                                        }else{ 
                                                            $judgement='<span style="color: red"><i class="fa fa-warning"></i>Belum diset</span>';
                                                        }?>
                                                        <span><?php echo $judgement?></span><br>
                                                        <span><?php echo $PoOracleNonConformityLines[0]['judgement_description']?></span>
                                                      <?php } ?>
                                                      </td>
                                                      <!-- <td>
                                                        <?php if (count($PoOracleNonConformityLines)==0) {?>
                                                            <span style="color: red"><i class="fa fa-warning"></i>Belum diset</span></td>
                                                        }<?php }else { ?>
                                                          <span><?php echo $PoOracleNonConformityLines[0]['remark']?></span><br>
                                                      <?php } ?> -->
                                                      <td><a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="exportPDF(this)" data-id="<?php echo $man['line_id']; ?>">PDF</a></td>
                                                    </tr>
                                                </tbody>
                                              </table>
                                              <input type="hidden" class="hdrNonC" value="<?php echo $PoOracleNonConformityHeaders[0]['header_id'];?>">
                                              <input type="hidden" class="descNonC" value="<?php echo $PoOracleNonConformityLines[0]['description'];?>">
                                              <input type="hidden" class="judgementNonC" value="<?php echo $PoOracleNonConformityLines[0]['judgement'];?>">
                                              <input type="hidden" class="statusNonC" value="<?php echo $PoOracleNonConformityLines[0]['status'];?>">
                                              <input type="hidden" class="sourceNonC" value="<?php echo $PoOracleNonConformityLines[0]['source_id'];?>">
                                              <input type="hidden" class="problemTrackNonC" value="<?php echo $PoOracleNonConformityLines[0]['problem_tracking'];?>">
                                              <input type="hidden" class="scopeNonC" value="<?php echo $PoOracleNonConformityLines[0]['scope'];?>">
                                              <input type="hidden" class="problemCompNonC" value="<?php echo $PoOracleNonConformityLines[0]['problem_completion'];?>">
                                              <input type="hidden" class="CompDateNonC" value="<?php echo $PoOracleNonConformityLines[0]['completion_date'];?>">
                                          </div>
                                          <table>
                                              <tr>
                                                  <td><button type="button" class="btn btn-success btnForwardBuyerNonC"><i>Return To Admin</i></button></td>
                                              </tr>
                                          </table>
                                          <span>Attachment :</span><br>
                                          <?php foreach ($image as $key => $img) { ?>
                                            <img style="max-height : 100px;" src="<?php echo base_url().$img['image_path'].''.$img['file_name']; ?>">
                                          <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <form class="form-horizontal" id="form-simpan"  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/pendingExecute');?>">
                <div align="right">
                    <?php if ($PoOracleNonConformityLines[0]['problem_completion'] != null && $PoOracleNonConformityLines[0]['problem_tracking'] != null && $PoOracleNonConformityLines[0]['problem_completion'] != null && $PoOracleNonConformityLines[0]['scope'] != null && $PoOracleNonConformityLines[0]['completion_date'] != null && $PoOracleNonConformityLines[0]['judgement'] != null) { ?>
                            <input type="hidden" name="hdnHdr" value="<?php echo $PoOracleNonConformityHeaders[0]['header_id'];?>">
                            <button type="submit" class="btn btn-success btn-lg">Pending Execute</button>
                    <?php } ?>
                    <a class="btn btn-primary btn-lg btn-rect" href="javascript:history.back(1)">
                     Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-ubahdeskripsi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title">Edit Deskripsi</h4>
        </div>
        <div class="modal-body">
            <textarea class="form-control txtAreaDeskripsiNonC"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="button" id="" class="btn btn-primary btnUpdateDeskripsiNonC">Yes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-ubahCase">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title">Edit Case</h4>
        </div>
        <div class="modal-body">
        <select class="form-control select2 slcRemarkNonConformity" name="remark[]" style="width:100%" multiple>
        <?php foreach ($case as $key => $cases) { ?>
            <option value="<?= $cases['case_id']?>" namaCase="<?= $cases['case_name']?>"><?= $cases['case_name']?></option>
        <?php } ?>
        </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="button" id="" class="btn btn-primary btnUpdateCaseNonC">Yes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-ubahStatus">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title">Change Status</h4>
        </div>
        <div class="modal-body">
        <select class="select select2 slcStatusNonC form-control" width="100%" name="slcCaseStatus">
            <option value="0" stat="OPEN">OPEN</option>
            <option value="1" stat="CLOSE">CLOSE</option>
        </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="button" id="" class="btn btn-primary btnUpdateStatusNonC">Yes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-forwardBuyer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Return to Admin</h4>
            </div>
            <form class="form-horizontal" id="form-simpan"  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/submitReturn');?>">
                <div class="modal-body">
                    <input type="hidden" name="hdnHdr" value="<?php echo $PoOracleNonConformityHeaders[0]['header_id'];?>">
                    <h4>Apakah anda yakin ingin mengembalikan data nonconformity ini ke admin ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

