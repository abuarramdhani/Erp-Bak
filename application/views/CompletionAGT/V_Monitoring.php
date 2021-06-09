<style media="screen">
.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-default color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="mon_agt_2021" value="1">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <li onclick="agtHistoryAndon()"><a href="#history-andon" data-toggle="tab">History Andon System</a></li>
                    <li onclick="agtRunningAndon()"><a href="#running-andon" data-toggle="tab">Running Andon System</a></li>
                    <li class="active" onclick="agtMonJobRelease()"><a href="#job-release" data-toggle="tab">Monitoring Job Release (PRKTA)</a></li>
                    <li class="pull-left header"><b class="fa fa-tv"></b> Monitoring </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="job-release">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive area-agt-job-release">

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="running-andon">
                      <div class="table-responsive area-agt-running-andon">

                      </div>
                    </div>
                    <div class="tab-pane" id="history-andon">
                      <div class="table-responsive area-agt-history-andon">

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
  </div>
</section>

<div class="modal fade bd-example-modal-sm" id="modal-agt-edit-pos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;"><span id="agt_nojob"></span> </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <input type="hidden" class="agt_item_id" value="">
                    <select class="agt_pos" name="" style="width:100%">
                      <option value="POS_1">POS_1</option>
                      <option value="POS_2">POS_2</option>
                      <option value="POS_3">POS_3</option>
                      <option value="POS_4">POS_4</option>
                      <option value="POS_5">FINISH</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-12">
                    <center><button type="button" class="btn btn-primary btn-sm" name="button" style="" onclick="agt_update_pos_submit()"> <i class="fa fa-file"></i> Update</button></center>
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
