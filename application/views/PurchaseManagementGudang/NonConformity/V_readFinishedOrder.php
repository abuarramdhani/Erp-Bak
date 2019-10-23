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
                                                      </td>
                                                      <td><span class="deskripsiNonC"><?php echo $PoOracleNonConformityLines[0]['description']; ?></span><br>
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
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    Finished Order
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Note From Buyer</th>
                                                                <th>Problem Completion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                <?php foreach ($notesBuyer as $key => $notes) {
                                                                    echo $notes['notes'].' - '.$notes['buyer'].'<br>';
                                                                }?>
                                                                </td>
                                                                <td><?php echo $PoOracleNonConformityLines[0]['problem_completion'];?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
            <div align="right">
                <a class="btn btn-primary btn-lg btn-rect" href="javascript:history.back(1)">
                    Back
                </a>
            </div>
        </div>
    </div>
</section>