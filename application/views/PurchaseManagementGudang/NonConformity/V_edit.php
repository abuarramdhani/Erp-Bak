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
                <form class="form-horizontal" id=""  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/saveData');?>">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
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
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <?php echo $headerRow['non_conformity_num']; ?>
                                                        <input type="hidden" name="txtHeaderId" value="<?php echo $headerRow['header_id'];?>">
                                                        <input type="hidden" name="last_menu" value="list Buyer">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Po Number
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control poNumberNonC" name="txtPONumber" value="<?php echo $headerRow['po_number']; ?>">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Delivery Date
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control dateDelivNonConformity" name="txtDeliveryDate" value="<?php echo $headerRow['delivery_date']; ?>">
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
                                                            Courier Agent
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
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Buyer
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input style="width: 310px;" type="text" class="form-control byrNonC" name="txtBuyer" value="<?php echo $headerRow['buyer']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <strong>
                                                            Header Status
                                                        </strong>
                                                        <span class="pull-right">:</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <?php if ($headerRow['status'] == NULL || $headerRow['status'] == '' || $headerRow['status'] == 'open') {
                                                    $status = 'open';}else{$status = $headerRow['status'];} echo '<div id="header_status" style="display:inline;">
                                                        '.strtoupper($status).'
                                                    </div>
                                                    '; ?>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Supplier Name
                                                    </strong>
                                                    <span class="pull-right">:</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <!-- <input style="width: 310px;" type="text" class="form-control splrNonC" name="txtSupplierName" value="<?php echo $headerRow['supplier']; ?>"> -->
                                                    <?php if ($headerRow['supplier'] == null) {
                                                            $opt = '<option value="'.$headerRow['supplier'].'">'.$headerRow['supplier'].'</option>';

                                                         }else{
                                                            $opt = '';
                                                        } ?>
                                                    <select class="form-control slcSupplierNC" name="txtSupplierName">
                                                        <?= $opt;?>
                                                    </select>
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
                                                    <input style="width: 310px;" type="text" class="form-control" name="txtPersonInCharge" value="<?php echo $headerRow['person_in_charge']; ?>"> 
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>
                                                        Phone Number / Fax
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
                                                    <input style="width: 150px;background: white;border: 1px solid #d2d6de;height: 40px;padding: 10px;" type="text" class="" name="txtPhoneNumber" value="<?php echo $telp; ?>"> / <input style="width: 150px;background: white;border: 1px solid #d2d6de;height: 40px;padding: 10px;" type="text" class="" name="txtFaxNumber" value="<?php echo $fax; ?>">
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
                                                <div class="col-lg-6">
                                                   <b><span>Case Name :</span></b><br>
                                                        <?php $no = 1; foreach($PoOracleNonConformityLines as $man): ?>
                                                            <span><?= $no++.'. '.$man['case_name'];?></span><br>
                                                        <?php endforeach; ?>
                                                    <br>
                                                    <b><span>Case Description :</span></b><br>
                                                    <span><?php echo $PoOracleNonConformityLines[0]['case_description'].' '.$PoOracleNonConformityLines[0]['description']; ?></span><br><br>
                                                    <b><span>Status :</span></b><br>
                                                    <span><?php if ($PoOracleNonConformityLines[0]['judgement'] == NULL || $PoOracleNonConformityLines[0]['judgement'] == ''|| $PoOracleNonConformityLines[0]['status'] == NULL) {
                                                            echo "OPEN";}else{ echo strtoupper($PoOracleNonConformityLines[0]['status']);} ?></span><br><br>
                                                    <b><span>Attachment :</span></b><br>
                                                    <?php foreach ($image as $key => $img) { ?>
                                                        <img style="max-height : 100px;" src="<?php echo base_url().$img['image_path'].''.$img['file_name']; ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div style="background: #f5f5f5; border: 10px solid #f5f5f5;">
                                                        <b><span>Set Item :</span></b>
                                                        <select class="form-control select2 slcItemNonConformity" multiple name="slcItem[]">
                                                        <?php foreach ($linesItem as $key => $item) { ?>
                                                            <option value="<?php echo $item['item_code'].'|'.$item['item_description']?>" selected><?php echo $item['item_code'].'|'.$item['item_description']?></option>
                                                        <?php } ?>
                                                        </select>
                                                        <input type="hidden" name="txtLineId" value="<?php echo $PoOracleNonConformityLines[0]['line_id']?>">
                                                    </div><br>
                                                    <div style="background: #f5f5f5; border: 10px solid #f5f5f5;">
                                                        <b><span>Set Judgement :</span></b>
                                                        <select class="select2 form-control slcJudgementNonConformity" name="slcJudgement" style="width: 100%;">
                                                            <?php if ($PoOracleNonConformityLines[0]['judgement']=='CAR') { ?>
                                                                <option value="CAR" selected>Close with CAR</option>
                                                                <option value="NO CAR">Close without CAR</option>
                                                            <?php }elseif ($PoOracleNonConformityLines[0]['judgement']=='NO CAR') { ?>
                                                                <option value="CAR">Close with CAR</option>
                                                                <option value="NO CAR" selected>Close without CAR</option>
                                                            <?php } else { ?>
                                                                <option></option>
                                                                <option value="CAR">Close with CAR</option>
                                                                <option value="NO CAR">Close without CAR</option>
                                                            <?php } ?>
                                                        </select><br><br>
                                                        <textarea id="judgementData" required="" rows="4" name="txtJudgementDescription" style="width: 100%;"><?php echo $PoOracleNonConformityLines[0]['judgement_description']; ?></textarea>
                                                        <!-- <input id="judgement_line_id" name="line_id" type="hidden">
                                                        <input id="header" name="header" type="hidden"> -->
                                                    </div><br>
                                                    <div style="background: #f5f5f5; border: 10px solid #f5f5f5;">
                                                        <b><span> Set Remark :</span></b>
                                                        <textarea id="remarkData" name="txtRemark" rows="4" style="width: 100%;"><?php echo $PoOracleNonConformityLines[0]['remark']; ?></textarea>
                                                        <!-- <input id="remark_line_id" name="line_id" type="hidden"> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> Submit</button>
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
    </section>
                                    <!-- <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Non Conformity Lines
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                    <thead>
                                                        <tr class="bg-primary">
                                                            <th style="text-align:center; width:30px">
                                                                No
                                                            </th>
                                                            <th style="text-align:center;">
                                                                Case Name
                                                            </th>
                                                            <th style="text-align:center;">
                                                                Case Description
                                                            </th>
                                                            <th style="text-align:center;">
                                                                Status
                                                            </th>
                                                            <th style="text-align:center;width: 140px;">
                                                                Image
                                                            </th>
                                                            <th style="text-align:center;width: 70px;">
                                                                Items
                                                            </th>
                                                            <th style="text-align:center;width: 70px;">
                                                                Judgement
                                                            </th>
                                                            <th style="text-align:center;width: 70px;">
                                                                Remark
                                                            </th>
                                                            <th style="text-align:center;width: 70px;">
                                                                Export
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; foreach($PoOracleNonConformityLines as $man): ?>
                                                        <tr>
                                                            <td style="text-align:center; width:30px">
                                                                <?php echo $no++;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $man['case_name']; ?>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <?php echo $man['case_description'].' '.$man['description']; ?>
                                                            </td>
                                                            <td id="LineStatus" row-id="<?php echo $man['line_id']; ?>">
                                                                <?php if ($man['judgement'] == NULL || $man['judgement'] == ''|| $man['status'] == NULL) {
                                                                        echo "OPEN";}else{ echo strtoupper($man['status']);} ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group-justified" role="group">
                                                                    <a class="btn btn-default btn-sm" href="javascript:void(0)" onclick="previewImg(this)" src="<?php echo base_url('assets/upload_pm/'.$man['image1']); ?>">
                                                                        IMAGE-1
                                                                    </a>
                                                                    <a class="btn btn-default btn-sm" href="javascript:void(0)" onclick="previewImg(this)" src="<?php echo base_url('assets/upload_pm/'.$man['image2']); ?>">
                                                                        IMAGE-2
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-default btn-sm" data-id="<?php echo $man['line_id']; ?>" href="javascript:void(0);" onclick="ItemsModal(this)" style="width: 100%">
                                                                    Items
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-default btn-sm" data-id="<?php echo $man['line_id']; ?>" data-judgement="<?php echo $man['judgement_description']; ?>" data-judgementtype="<?php echo $man['judgement']; ?>" data-line="judgement" data-status="<?php if ($man['judgement'] == NULL || $man['judgement'] == ''|| $man['status'] == NULL|| $man['status'] == '') { echo 'open';}else{echo $man['status'];}?>
                                                                    " href="javascript:void(0)" onclick="judgementModal(this)" style="width: 100%" data-id="
                                                                    <?php echo $man['line_id']; ?>
                                                                    " >
                                                                        Show
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-default btn-sm" data-id="<?php echo $man['line_id']; ?>" data-line="remark" data-remark="<?php echo $man['remark']; ?>" href="javascript:void(0)" onclick="remarkModal(this)" style="width: 100%">
                                                                    Remark
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="exportPDF(this)" data-id="<?php echo $man['line_id']; ?>">PDF</a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
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
<div class="modal fade" id="ItemsModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        x
                    </span>
                </button>
                <h4 class="modal-title">
                    Line Items
                </h4>
            </div>
            <div class="modal-body" id="ItemsModalArea">
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="judgementModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        x
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Judgement
                </h4>
            </div>
            <form action="javascript:judgementSubmit()" id="formJudgement" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12" id="judgementTypeArea">
                        </div>
                    </div>
                    <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <textarea id="judgementData" name="judgement" required="" rows="4" style="width: 100%;">
                                </textarea>
                                <input id="judgement_line_id" name="line_id" type="hidden">
                                    <input id="header" name="header" type="hidden">
                                    </input>
                                </input>
                            </div>
                        </div>
                    </br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        Close
                    </button>
                    <button class="btn btn-primary" id="judgementSubmit" type="submit">
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="remarkModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        x
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Remark
                </h4>
            </div>
            <form action="javascript:remarkSubmit()" id="formRemark" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea id="remarkData" name="remark" rows="4" style="width: 100%;">
                            </textarea>
                            <input id="remark_line_id" name="line_id" type="hidden">
                            </input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        Close
                    </button>
                    <button class="btn btn-primary" id="remarkSubmit" type="submit">
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="previewArea" id="previewImgArea">
    <span class="preview-close" onclick="closepreviewImg()">
        ×
    </span>
    <img class="preview-content" id="preview-Img">
    </img>
</div> -->