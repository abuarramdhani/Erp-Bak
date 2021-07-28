<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 style="font-weight:bold;margin:0"><i class="fa fa-edit"></i> <?= $Title?></h3>
              </div>
              <div class="box-body">
                <div class="row">
                <div class="col-md-12">
                  <div class="panel-body" id="oth_status_order"></div>
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


<div class="modal fade" id="mdl_rev_order" role="dialog">
    <div class="modal-dialog" style="width:70%">
      <div class="modal-content" style="border-radius:20px">
        <div class="modal-header text-left" style="font-size:20px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label><i class="fa fa-edit"></i> Revisi Order Tim Handling</label>
        </div>
        <div class="modal-body">
            <div id="data_revisi"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>