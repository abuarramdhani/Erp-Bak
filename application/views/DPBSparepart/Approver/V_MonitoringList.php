<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- <h3 class="box-title">Approved List DPB</h3> -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item active" style="background:#e7e7e7">
                            <a class="nav-link" onclick="normalll()" id="pills-normal-tab" data-toggle="pill" href="#pills-normal" aria-controls="pills-normal" role="tab" aria-selected="true">NORMAL </a>
                        </li>
                        <li class="nav-item" style="background:#e7e7e7">
                            <a class="nav-link" onclick="urgent()" id="pills-urgent-tab" data-toggle="pill" href="#pills-urgent" role="tab" aria-controls="pills-urgent" aria-selected="false">URGENT</a>
                        </li>
                        <li class="nav-item" style="background:#e7e7e7">
                            <a class="nav-link" onclick="eceran()" id="pills-eceran-tab" data-toggle="pill" href="#pills-eceran" role="tab" aria-controls="pills-eceran" aria-selected="false">ECERAN</a>
                        </li>
                        <li class="nav-item" style="background:#e7e7e7">
                            <a class="nav-link" onclick="bagro()" id="pills-bagro-tab" data-toggle="pill" href="#pills-bagro" role="tab" aria-controls="pills-bagro" aria-selected="false">BEST AGRO</a>
                        </li>
                        <li class="nav-item" style="background:#e7e7e7">
                            <a class="nav-link" onclick="ecommerce()" id="pills-ecommerce-tab" data-toggle="pill" href="#pills-ecommerce" role="tab" aria-controls="pills-ecommerce" aria-selected="false">E-COMMERCE</a>
                        </li>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade in active" id="pills-normal" role="tabpanel" aria-labelledby="pills-normal-tab">
                            <div id="loadingAreanormal" style="display:none;">
                                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                            </div>
                            <div class="table_area_normal">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-urgent" role="tabpanel" aria-labelledby="pills-urgent-tab">
                            <div id="loadingAreaurgent" style="display:none;">
                                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                            </div>
                            <div class="table_area_urgent">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-eceran" role="tabpanel" aria-labelledby="pills-eceran-tab">
                            <div id="loadingAreaeceran" style="display:none;">
                                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                            </div>
                            <div class="table_area_eceran">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-bagro" role="tabpanel" aria-labelledby="pills-bagro-tab">
                            <div id="loadingAreabagro" style="display:none;">
                                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                            </div>
                            <div class="table_area_bagro">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-ecommerce" role="tabpanel" aria-labelledby="pills-ecommerce-tab">
                            <div id="loadingAreaecommerce" style="display:none;">
                                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                            </div>
                            <div class="table_area_ecommerce">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>