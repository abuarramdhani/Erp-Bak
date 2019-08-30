    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Management Send PO Subcontractor
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label for="txtPMSPOSNoPO" class="col-sm-2 control-label" style="font-weight:normal">PO Number</label>
                <div class="col-sm-3">
                  <input class="form-control" id="txtPMSPOSNoPO" name="txtPMSPOSNoPO" placeholder="Purchase Order Number">
                </div>
                <div class="col-sm-6 divPMSPOSWarnAddrNotFound" style="height: 30px; float:left;display:none">
                  <!-- timeline time label -->
                  <ul class="timeline" style="margin:0px">
                    <li class="time-label" style="margin:0px">
                      <span class="bg-red">&nbsp;<i class="fa fa-remove"></i><span class="spnPMSPOSWarnAddrNotFound"></span></span>
                    </li>
                  </ul>
                  <!-- /.timeline-label -->
                </div>
              </div>
              <br>
              <div class="form-group">
                <label for="txtPMSPOSToEmailAddr" class="col-sm-2 control-label" style="font-weight:normal">To Email Address</label>
                <div class="col-sm-3">
                  <input type="email" class="form-control" id="txtPMSPOSToEmailAddr" name="txtPMSPOSToEmailAddr" placeholder="Email Address" required multiple>
                </div>
                <img src="<?=base_url('assets/img/gif/loading5.gif')?>" style="width:35px; height:35px; float:left; margin-left:-20px; display:none;" class="PMSPOSimgLoadAddr">
                <div class="col-sm-6 divPMSPOSEmailAddrWarn" style="height: 30px; float:left;display:none">
                  <!-- timeline time label -->
                  <ul class="timeline" style="margin:0px">
                    <li class="time-label" style="margin:0px">
                      <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu email&nbsp;.</span>
                    </li>
                  </ul>
                  <!-- /.timeline-label -->
                </div>
              </div><br>
              <div class="form-group">
                <label for="txtPMSPOSCCEmailAddr" class="col-sm-2 control-label" style="font-weight:normal">CC. Email Address</label>
                <div class="col-sm-3">
                  <input type="email" class="form-control" id="txtPMSPOSCCEmailAddr" name="txtPMSPOSCCEmailAddr" placeholder="Email Address CC">
                </div>
                <div class="col-sm-6 divPMSPOSCCEmailAddrWarn" style="height: 30px; float:left;display:none">
                  <!-- timeline time label -->
                  <ul class="timeline" style="margin:0px">
                    <li class="time-label" style="margin:0px">
                      <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu CC email&nbsp;.</span>
                    </li>
                  </ul>
                  <!-- /.timeline-label -->
                </div>
              </div><br>
              <div class="form-group">
                <label for="txtPMSPOSBCCEmailAddr" class="col-sm-2 control-label" style="font-weight:normal">BCC. Email Address</label>
                <div class="col-sm-3">
                  <input type="email" class="form-control" id="txtPMSPOSBCCEmailAddr" name="txtPMSPOSBCCEmailAddr" placeholder="Email Address BCC">
                </div>
                <div class="col-sm-6 divPMSPOSBCCEmailAddrWarn" style="height: 30px; float:left;display:none">
                  <!-- timeline time label -->
                  <ul class="timeline" style="margin:0px">
                    <li class="time-label" style="margin:0px">
                      <span class="bg-yellow">&nbsp;<i class="fa fa-warning"></i>&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu BCC email&nbsp;.</span>
                    </li>
                  </ul>
                  <!-- /.timeline-label -->
                </div>
              </div><br>
              <div class="form-group">
                <label for="txtPMSPOSSubject" class="col-sm-2 control-label" style="font-weight:normal">Subject</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="txtPMSPOSSubject" name="txtPMSPOSSubject" placeholder="Subject This Message">
                </div>
              </div><br>
              <div class="form-group">
                <label class="col-sm-2 control-label" style="font-weight:normal">Attachment</label>
                <div class="col-sm-2" style="width:12%">
                  <div class="btn btn-default btn-file">
                    <i class="fa fa-paperclip"></i> Attachment 1
                    <input id="inpPMSPOSAttachment1" name="inpPMSPOSAttachment1" type="file">
                  </div>
                  <!-- <p class="help-block" style="margin-top:-2px"><a href=""><i>View Attachment</i></a></p> -->
                </div>
                <div class="col-sm-2">
                  <div class="btn btn-default btn-file">
                    <i class="fa fa-paperclip"></i> Attachment 2
                    <input id="inpPMSPOSAttachment2" type="file" name="inpPMSPOSAttachment2">
                  </div>
                  <!-- <p class="help-block" style="margin-top:-2px"><a href=""><i>View Attachment</i></a></p> -->
                </div>
              </div><br>
              <div class="form-group">
                <label for="slcPMSPOSFormatMessage" class="col-sm-2 control-label" style="font-weight:normal">Format Message</label>
                <div class="col-sm-3">
                  <div class="form-group">
                      <select id="slcPMSPOSFormatMessage" class="form-control select2" style="width: 100%;">
                        <option selected="selected">Indonesia</option>
                        <option>English</option>
                      </select>
                  </div>
                </div>
              </div><br><br>
              <div class="form-group">
                    <textarea id="txaPMSPOSEmailBody" class="form-control" name="txaPMSPOSEmailBody" style="height: 300px" disabled></textarea>
              </div>
              <div class="callout divPMSPOScalloutWarning" style="background-color:#ffa8a8;display:none;">
                <h4 style="color:#990b0b">Warning!</h4>
                <p class="pPMSPOSwarningDetails" style="color:#990b0b"></p>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <span class="spnBtnSendWait" style="display:none">                  
                  <button type="button" class="btn btn-primary" disabled><i class="fa fa-envelope-o" ></i> Sending Message</button>
                  <img src="<?=base_url('assets/img/gif/loading5.gif')?>" style="width:35px; height:35px; float:left; margin-left:-20px;" class="PMSPOSimgLoadAddr">
                </span>
                <button type="button" class="btn btn-primary btnPMSPOScheckSend"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <button type="button" class="btn btn-default btnConfirmDiscard"><i class="fa fa-times"></i> Discard</button>
              <button type="reset" class="btn btn-default btnPMSPOSDiscard" style="display:none"><i class="fa fa-times"></i> Discard</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->