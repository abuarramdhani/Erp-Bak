    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="PurchaseManagementSendPOTitle"><?= $MenuName ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <form action="<?= base_url('PurchaseManagementSendPO/SendPO/SendEmail') ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Compose New Message</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="txtPMSPONoPO" class="col-sm-2 control-label" style="font-weight:normal">PO
                                    Number</label>
                                <div class="col-sm-3">
                                    <input class="form-control" id="txtPMSPONoPO" name="txtPMSPONoPO"
                                        placeholder="Purchase Order Number" value="<?= $po_Lnumber; ?>">
                                </div>
                                <div class="col-sm-6 divPMSPOWarnAddrNotFound"
                                    style="height: 30px; float:left;display:none">
                                    <!-- timeline time label -->
                                    <ul class="timeline" style="margin:0px">
                                        <li class="time-label" style="margin:0px">
                                            <span class="bg-red">&nbsp;<i class="fa fa-remove"></i><span
                                                    class="spnPMSPOWarnAddrNotFound"></span></span>
                                        </li>
                                    </ul>
                                    <!-- /.timeline-label -->
                                </div>
                                <div class="col-sm-3 divPMSPOSite" style="height: 20px; float:left;display:none">
                                    <!-- info site label -->
                                    <label style="font-weight:normal">SITE &nbsp;</label>
                                    <input name="txtPMSPONoPOSite" id="txtPMSPONoPOSite" size="6px" disabled>
                                    <!-- /.info site-label -->
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="txtPMSPOToEmailAddr" class="col-sm-2 control-label"
                                    style="font-weight:normal">To Email Address</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control" id="txtPMSPOToEmailAddr"
                                        name="txtPMSPOToEmailAddr" placeholder="Email Address" required multiple>
                                </div>
                                <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                                    style="width:35px; height:35px; float:left; margin-left:-20px; display:none;"
                                    class="PMSPOimgLoadAddr">
                                <div class="col-sm-6 divPMSPOEmailAddrWarn"
                                    style="height: 30px; float:left;display:none">
                                    <!-- timeline time label -->
                                    <ul class="timeline" style="margin:0px">
                                        <li class="time-label" style="margin:0px">
                                            <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan
                                                dengan tanda koma ( , ) jika mengirim ke lebih dari satu
                                                email&nbsp;.</span>
                                        </li>
                                    </ul>
                                    <!-- /.timeline-label -->
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="txtPMSPOCCEmailAddr" class="col-sm-2 control-label"
                                    style="font-weight:normal">CC. Email Address</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control" id="txtPMSPOCCEmailAddr"
                                        name="txtPMSPOCCEmailAddr" placeholder="Email Address CC">
                                </div>
                                <div class="col-sm-6 divPMSPOCCEmailAddrWarn"
                                    style="height: 30px; float:left;display:none">
                                    <!-- timeline time label -->
                                    <ul class="timeline" style="margin:0px">
                                        <li class="time-label" style="margin:0px">
                                            <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan
                                                dengan tanda koma ( , ) jika mengirim ke lebih dari satu CC
                                                email&nbsp;.</span>
                                        </li>
                                    </ul>
                                    <!-- /.timeline-label -->
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="txtPMSPOBCCEmailAddr" class="col-sm-2 control-label"
                                    style="font-weight:normal">BCC. Email Address</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control" id="txtPMSPOBCCEmailAddr"
                                        name="txtPMSPOBCCEmailAddr" placeholder="Email Address BCC">
                                </div>
                                <div class="col-sm-6 divPMSPOBCCEmailAddrWarn"
                                    style="height: 30px; float:left;display:none">
                                    <!-- timeline time label -->
                                    <ul class="timeline" style="margin:0px">
                                        <li class="time-label" style="margin:0px">
                                            <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan
                                                dengan tanda koma ( , ) jika mengirim ke lebih dari satu BCC
                                                email&nbsp;.</span>
                                        </li>
                                    </ul>
                                    <!-- /.timeline-label -->
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="txtPMSPOSubject" class="col-sm-2 control-label"
                                    style="font-weight:normal">Subject</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="txtPMSPOSubject" name="txtPMSPOSubject"
                                        placeholder="Subject This Message">
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="font-weight:normal">Attachment</label>
                                <div class="col-sm-2" style="width:12%">
                                    <div class="btn btn-default btn-file">
                                        <i class="fa fa-paperclip"></i> Attachment 1
                                        <input id="inpPMSPOAttachment1" name="inpPMSPOAttachment1" type="file">
                                    </div>
                                    <!-- <p class="help-block" style="margin-top:-2px"><a href=""><i>View Attachment</i></a></p> -->
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn btn-default btn-file">
                                        <i class="fa fa-paperclip"></i> Attachment 2
                                        <input id="inpPMSPOAttachment2" type="file" name="inpPMSPOAttachment2">
                                    </div>
                                    <!-- <p class="help-block" style="margin-top:-2px"><a href=""><i>View Attachment</i></a></p> -->
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="slcPMSPOFormatMessage" class="col-sm-2 control-label"
                                    style="font-weight:normal">Format Message</label>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select id="slcPMSPOFormatMessage" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Indonesia</option>
                                            <option>English</option>
                                        </select>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <textarea id="txaPMSPOEmailBody" class="form-control" name="txaPMSPOEmailBody"
                                    style="height: 300px" disabled></textarea>
                            </div>
                            <div class="callout divPMSPOcalloutWarning" style="background-color:#ffa8a8;display:none;">
                                <h4 style="color:#990b0b">Warning!</h4>
                                <p class="pPMSPOwarningDetails" style="color:#990b0b"></p>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <span class="spnBtnSendWait" style="display:none">
                                    <button type="button" class="btn btn-primary" disabled><i
                                            class="fa fa-envelope-o"></i> Sending Message</button>
                                    <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                                        style="width:35px; height:35px; float:left; margin-left:-20px;"
                                        class="PMSPOimgLoadAddr">
                                </span>
                                <button type="button" class="btn btn-primary btnPMSPOcheckSend"><i
                                        class="fa fa-envelope-o"></i> Send</button>
                            </div>
                            <button type="button" class="btn btn-default btnConfirmDiscard"><i class="fa fa-times"></i>
                                Discard</button>
                            <button type="reset" class="btn btn-default btnPMSPODiscard" style="display:none"><i
                                    class="fa fa-times"></i> Discard</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /. box -->
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->