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
                    <li class="active" onclick="agtMonJobRelease()"><a href="#job-release" data-toggle="tab">Monitoring Job Release</a></li>
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
