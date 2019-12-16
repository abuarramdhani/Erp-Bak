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
                    </div>
                </div>
                <br>
                <div class="row">
                <form class="form-horizontal" id=""  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/saveData');?>">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Non Conformity Headers
                            </div>
                            <input type="hidden" class="hdrNonC" value="<?php echo $PoOracleNonConformityHeaders[0]['header_id'];?>">
                            <input type="hidden" class="descNonC" value="<?php echo $PoOracleNonConformityLines[0]['description'];?>">
                            <input type="hidden" class="judgementNonC" value="<?php echo $PoOracleNonConformityLines[0]['judgement'];?>">
                            <input type="hidden" class="statusNonC" value="<?php echo $PoOracleNonConformityLines[0]['status'];?>">
                            <input type="hidden" class="sourceNonC" value="<?php echo $PoOracleNonConformityLines[0]['source_id'];?>">
                            <input type="hidden" class="problemTrackNonC" value="<?php echo $PoOracleNonConformityLines[0]['problem_tracking'];?>">
                            <input type="hidden" class="scopeNonC" value="<?php echo $PoOracleNonConformityLines[0]['scope'];?>">
                            <input type="hidden" class="problemCompNonC" value="<?php echo $PoOracleNonConformityLines[0]['problem_completion'];?>">
                            <input type="hidden" class="CompDateNonC" value="<?php echo $PoOracleNonConformityLines[0]['completion_date'];?>">
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php foreach ($PoOracleNonConformityHeaders as $headerRow): ?>
                                            <div class="col-lg-6">
                                                <!-- <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Po Number
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class ="col-md-6">
                                                            <input style="width: 200px;" type="text" class="form-control poNonC" name="txtPONumber" value="<?php echo $headerRow['po_number']; ?>">
                                                        </div>
                                                        <button type="button" class="btn btn-success poNumberNonC pull-right">Search</button>
                                                    </div>
                                                </div><br> -->
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Conformity Number
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <?php echo $headerRow['non_conformity_num']; ?>
                                                        <input type="hidden" name="txtHeaderId" value="<?php echo $headerRow['header_id'];?>">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Receive Date
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control dateDelivNonConformity" name="txtDeliveryDate" required value="<?php if(count($headerRow['delivery_date'])!= 0){
                                                                echo date("d-M-y", strtotime($headerRow['delivery_date']));
                                                            } ?>">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Packing List
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control" name="txtPackingList" value="<?php echo $headerRow['packing_list']; ?>">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Expedition/Courier Agent
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control" name="txtCourierAgent" value="<?php echo $headerRow['courier_agent']; ?>">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Verificator
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control" name="txtVerificator" value="<?php echo $headerRow['verificator']; ?>">
                                                    </div>
                                                </div><br>
                                                <!-- <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Buyer
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control byrNonC" name="txtBuyer" value="<?php echo $headerRow['buyer']; ?>">
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Header Status
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8 headerStatusNonC">
                                                    <?php echo $headerRow['status']; ?>
                                                    <!-- </div> -->
                                                </div>
                                                    <input type="hidden" class="form-control txtheaderStatusNonC" name="txtheaderStatusNonC">
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Supplier Name
                                                    </strong>
                                                    <span class="pull-right">:</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input style="width: 310px;" type="text" class="form-control splrNonC" name="txtSupplierName" value="<?php echo $headerRow['supplier']; ?>">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Person In Charge
                                                    </strong>
                                                    <span class="pull-right">:</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input style="width: 310px;" type="text" class="form-control picNonC" name="txtPersonInCharge" value="<?php echo $headerRow['person_in_charge']; ?>"> 
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Phone Number
                                                    </strong>
                                                    <span class="pull-right">:</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <?php 
                                                        $telp = '-';
                                                        $fax = '-'; 
                                                        if(!empty($Phone)){
                                                             if (!empty($Phone[0]['TELP'])) {
                                                                $telp = $Phone[0]['TELP'];
                                                            }
                                                            if (!empty($Phone[0]['FAX'])) {
                                                                $fax = $Phone[0]['FAX'];
                                                            }
                                                        }
                                                     ?>
                                                    <input style="width: 150px;background: white;border: 1px solid #d2d6de;height: 40px;padding: 10px;" type="text" class="phoneNonC" name="txtPhoneNumber" value="<?php echo $telp; ?>"> 
                                                    <!-- / <input style="width: 150px;background: white;border: 1px solid #d2d6de;height: 40px;padding: 10px;" type="text" class="" name="txtFaxNumber" value="<?php echo $fax; ?>"> -->
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Supplier Address
                                                    </strong>
                                                    <span class="pull-right">:</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea style="width: 310px;" type="text" name="txtSupplierAddress" class="form-control splrAddresNonC"><?php echo $headerRow['supplier_address']; ?></textarea>
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
                                                <table class="table table-bordered">
                                                    <thead style="background: #ededed">
                                                        <tr>
                                                            <th>Case Name</th>
                                                            <th>Case Description</th>
                                                            <th>Status [Open/Close]</th>
                                                            <th>Attachment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="tdCaseNonC">
                                                                <?php $no = 1; foreach($PoOracleNonConformityLines as $man): ?>
                                                                    <span><?= $no++.'. '.$man['case_name'];?></span><br>
                                                                <?php endforeach; ?>
                                                                <button type="button" class="btn btn-primary btn-xs btnEditCaseNonC">Edit</button>
                                                            </td>
                                                            <td><span class="deskripsiNonC"><?php echo              $PoOracleNonConformityLines[0]['description']; ?></span><br>
                                                            <button type="button" class="btn btn-xs btn-primary btnEditDeskripsiNonC">Edit</button></td>
                                                            <td>
                                                                <?php
                                                                    $open = '';
                                                                    $close = '';

                                                                    if ($PoOracleNonConformityLines[0]['status']=='0') {
                                                                        $open = 'selected';
                                                                    }else if ($PoOracleNonConformityLines[0]['status']=='1') {
                                                                        $close = 'selected';
                                                                    }
                                                                ?>
                                                                <select class="select select2 slcCaseNonC form-control" width="100%" name="slcCaseStatus">
                                                                    <option></option>
                                                                    <option <?php echo $open;?> value="0">OPEN</option>
                                                                    <option <?php echo $close;?> value="1">CLOSE</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                            <?php foreach ($image as $key => $img) { ?>
                                                                <img style="max-height : 100px;" src="<?php echo base_url().$img['image_path'].''.$img['file_name']; ?>">
                                                            <?php } ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table><br>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <strong>
                                                            Po Number
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class ="col-md-3">
                                                            <input style="width: 200px;" type="text" class="form-control poNonC" name="txtPONumber" value="<?php echo $headerRow['po_number']; ?>">
                                                        </div>
                                                        <button type="button" class="btn btn-success poNumberNonC pull-right">Search</button>
                                                    </div>
                                                </div><br>
                                                <div class="addLineNonC">
                                                </div>
                                                <!-- <table class="table table-bordered text-center" id="tblLinesNonC">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th><input type="checkbox" class="minimal checkBoxAllNonC"></th>
                                                            <th>Line Number</th>
                                                            <th>Item Code</th>
                                                            <th>Item Description</th>
                                                            <th>Qty Amount</th>
                                                            <th>Qty Billed</th>
                                                            <th>Qty Reject</th>
                                                            <th>Unit Price</th>
                                                            <th>Qty PO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="lineNonC">
                                                        
                                                    </tbody>
                                                </table> -->
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-primary btnAddNonCLine"><i class="fa fa-plus"></i> add</button>
                                                </div>
                                            </div>
                                        <!-- <div class="pull-right">
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> Submit</button>
                                        </div> -->
                                    </div>
                                    <div class="panel panel-warning panelSelectedLineNonC">
                                        <div class="panel-heading">
                                            Lines Selected <i class="fa fa-plus"></i>
                                        </div>
                                        <div class="panel-body">
                                        <?php if ($this->session->responsibility_id == 2569 || $this->session->responsibility_id == 2641) { ?>
                                            
                                            <table>
                                                <tr>
                                                    <td><button type="button" class="btn btn-success btnForwardBuyerNonC"><i>Forward To Buyer</i></button></td>
                                                </tr>
                                            </table><br>
                                        <?php } ?>
                                            <table class="table table-bordered text-center">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th>PO No.</th>
                                                            <th>Line No.</th>
                                                            <th>Closure Status</th>
                                                            <th>Buyer</th>
                                                            <th>LPPB No.</th>
                                                            <th>Item Code</th>
                                                            <th>Item Description</th>
                                                            <th>UOM</th>
                                                            <!-- <th>Qty Amount</th>
                                                            <th>Qty Billed</th>
                                                            <th>Qty Reject</th>
                                                            <th>Currency</th>
                                                            <th>Unit Price</th> -->
                                                            <th>Qty PO</th>
                                                            <th>Qty Receipt</th>
                                                            <th>Qty Problem</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="selectedLineNonC">
                                                    <?php foreach ($linesItem as $key => $item) { ?>
                                                        <tr>
                                                            <td><?= $item['no_po'];?></td>
                                                            <td><?= $item['line'];?></td>
                                                            <td><?= $item['closure_status'];?></td>
                                                            <td><?= $item['buyer'];?></td>
                                                            <td><?= $item['no_lppb'];?></td>
                                                            <td><?= $item['item_code'];?></td>
                                                            <td><?= $item['item_description'];?></td>
                                                            <td><?= $item['uom'];?></td>
                                                            <!-- <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td> -->
                                                            <td><?= $item['quantity_po'];?></td>
                                                            <td><?= $item['quantity_amount'];?></td>
                                                            <td><?= $item['quantity_problem'];?></td>
                                                            <td><button type="button" class="btn btn-danger btnHapusLineNonC" lineid="<?= $item['line_item_id'];?>"><i class="fa fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php }?>
                                                    </tbody>
                                            </table>
                                            <!-- <div class="pull-right">
                                                <button type="button" class="btn btn-success">Save</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            Notes From Buyer
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-lg-6">
                                                <?php if (count($notes) == 0) { ?>
                                                    <p>Tidak ada notes !</p>
                                                <?php } else { ?>
                                                    <table class="table table-responsive table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Buyer</th>
                                                                <th>Notes</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $no = 0; foreach ($notes as $key => $note) { $no++; ?>
                                                            <tr>
                                                                <td><?= $no; ?></td>
                                                                <td><?= $note['buyer'];?></td>
                                                                <td><?= $note['notes'];?></td>
                                                                <td><?= date("Y-m-d H:i:s", strtotime($note['date']));?></td>
                                                            </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                <?php }?>
                                            </div>
                                            <?php if ($this->session->responsibility_id == 2663) {
                                                $display = "";
                                            } else{
                                                $display = 'style="display:none;"';
                                            }?>
                                            <div class="col-lg-6" <?php echo $display; ?>>
                                                <table>
                                                    <tr>
                                                        <th>Add Notes</th>
                                                        <th>:</th>
                                                        <td><textArea class="form-control" name="noteFromBuyer" style="width:420px" placeholder="add notes here!"></textArea></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Problem Solving
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-bordered text-center">
                                                    <thead style="background: #ededed">
                                                        <tr>
                                                            <th>Problem Tracking</th>
                                                            <th>Scope [External/Internal]</th>
                                                            <th>Problem Completion</th>
                                                            <th>Completion Date</th>
                                                            <th>CAR [Yes/No]</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" class="form-control" placeholder="Set Problem Tracking" name="txtProblemTracking" value="<?php echo $PoOracleNonConformityLines[0]['problem_tracking']?>"></td>
                                                            <td>
                                                                <?php
                                                                    $external = '';
                                                                    $internal = '';

                                                                    if ($PoOracleNonConformityLines[0]['scope']=='0') {
                                                                        $external = 'selected';
                                                                    }else if ($PoOracleNonConformityLines[0]['scope']=='1') {
                                                                        $internal = 'selected';
                                                                    }
                                                                ?>
                                                                <select class="select select2 form-control slcScopeNonC" name="slcScope">
                                                                    <option></option>
                                                                    <option <?php echo $external?> value="0">External</option>
                                                                    <option <?php echo $internal?> value ="1">Internal</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control" placeholder="Set Problem Completion" name="txtProblemCompletion" value="<?php echo $PoOracleNonConformityLines[0]['problem_completion']?>"></td>
                                                            <td><input type="text" class="form-control dateDelivNonConformity" placeholder="Set Date" name="txtDate" value="<?php if(count($PoOracleNonConformityLines[0]['completion_date'])!= 0){
                                                                echo date("d-M-y", strtotime($PoOracleNonConformityLines[0]['completion_date']));
                                                            } ?>"></td>
                                                            <td>
                                                                <?php
                                                                    $yes = '';
                                                                    $no = '';

                                                                    if ($PoOracleNonConformityLines[0]['judgement']=='CAR') {
                                                                        $yes = 'selected';
                                                                    }else if ($PoOracleNonConformityLines[0]['judgement']=='NO CAR') {
                                                                        $no = 'selected';
                                                                    }
                                                                ?>
                                                            <select class="select select2 form-control slcCarNonC" name="slcCar">
                                                                    <option></option>
                                                                    <option <?php echo $yes;?> value="CAR">Yes</option>
                                                                    <option <?php echo $no;?> value ="NO CAR">No</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="panel-footer">
                <div align="left">
                    <a class="btn btn-primary btn-lg btn-rect" href="javascript:history.back(1)">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="waitLineNonC" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        x
                    </span>
                </button> -->
            </div>
            <div class="modal-body">
            <h3 class="text-center">Mohon tunggu</h3>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-default" data-dismiss="modal" type="button">
                    Close
                </button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-konfirmasi">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- <div class="modal-header"> -->
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span></button> -->
          <!-- <h4 class="modal-title">Tambah Keterangan</h4> -->
        <!-- </div> -->
        <div class="modal-body">
          <p>Data ini sudah tersimpan di database, apakah anda yakin ingin menghapus ?</p>
          <input type="hidden" class="form-control hdnLineItemIdNonC">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="button" id="" class="btn btn-primary btnKonfirmasiHapusLineNonC">Yes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
<div class="modal fade" id="modal-forwardBuyer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Forward to Buyer</h4>
            </div>
            <form class="form-horizontal" id="form-simpan"  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/submitForward');?>">
                <div class="modal-body">
                    <input type="hidden" name="hdnHdr" value="<?php echo $PoOracleNonConformityHeaders[0]['header_id'];?>">
                    <table>
                        <tr>
                            <td>Select Buyer :&nbsp;</td>
                            <td>
                            <select class="select2 slcBuyerNonC" style="width:300px;" name="slcBuyerNonC">
                                    <option></option>
                                    <?php foreach ($buyer as $key => $byr) {?>
                                        <option value="<?= $byr['noind'];?>"><?= $byr['nama'];?></option>
                                    <?php } ?>
                            </select>
                            </td>
                        </tr>
                    </table>
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
    
                                   