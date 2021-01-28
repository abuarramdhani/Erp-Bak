
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
                    <?php echo $Title ?>
                  </b>
                </h1>
              </div>
            </div>
            <div class="col-lg-1 ">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterItem');?>">
                  <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                  </i>
                  <span>
                    <br />
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <br />

        <form class="" action="<?php echo base_url('PendaftaranBomRouting/InputBOMRouting/sendEmailSubmit ') ?>" method="post">
        <div class="row">
            <div class="col-md-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <h4>Compose New Message</h4>
                </div>
                <div class="panel-body">
                  <div class="tab-pane fade in">
                    <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="">To Email Address</label>
                          <input type="text" class="form-control" id="BOMemail" name="txtemail" placeholder="Email Address (&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu email&nbsp;.)">
                        </div>
                        <div class="form-group">
                          <label for="">CC. Email Address</label>
                          <input type="email" class="form-control" id="BOMccemail" name="txtccemail" placeholder="Email Address CC (&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu email&nbsp;.)" >
                        </div>
                        <!-- <div class="form-group">
                          <label for="">BCC. Email Address</label>
                          <input type="email" class="form-control" name="txtbccemail" id="BOMbccemail" placeholder="Email Address BCC (&nbsp;Pisahkan dengan tanda koma ( , ) jika mengirim ke lebih dari satu email&nbsp;.)">
                        </div> -->
                        <div class="form-group">
                          <label for="">Subject</label>
                          <input type="email" class="form-control" id="BOMsubject" name="txtsubject" placeholder="Subject This Message" >
                        </div>
                        <div class="form-group">
                          <label for="">Attachment</label>
                          <input type="file" id="BOMAttachment" name="txtAttachment">
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                      <div class="col-md-12" style="margin-top:10px">
                        <div class="form-group">
                          <textarea class="form-control" id="BOMredactor" name="txtredactor" style="height: 300px" disabled></textarea>
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <div class="pull-right">
                          <span class="spnBtnSendWait" style="display:none">
                            <button type="button" class="btn btn-primary" disabled><i class="fa fa-envelope-o" ></i> Sending Message</button>
                            <img src="<?=base_url('assets/img/gif/loading5.gif')?>" style="width:35px; height:35px; float:left; margin-left:-20px;" class="PMSPOimgLoadAddr">
                          </span>
                          <button type="button" class="btn btn-primary btnBOMcheckSend"><i class="fa fa-envelope-o"></i> Send</button>
                        </div>
                        <!-- <button type="button" class="btn btn-default btnConfirmDiscard"><i class="fa fa-times"></i> Discard</button> -->
                      </div>
                      <!-- /.box-footer -->
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
         </div>

      </div>
    </div>
  </div>
</section>
