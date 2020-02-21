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
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('ConsumableSeksi/Input/');?>">
                                    <i class="fa fa-list icon-2x">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header"></div>
                            <div class="box-footer">
                                <div class="col-md-12 ">
                                    <div class="panel-body">
                                        <div class="col-md-2"  style="text-align: left;"><b>DEPARTEMENT</b></div>
                                        <br>
                                         <div class="col-md-4" style="text-align: left; width: 30%">
                                            <select class="form-control" id="pilihdept" data-placeholder= "Departement"></select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"  style="text-align: left;"><b>KODE ASSY</b></div>
                                        <br>
                                         <div class="col-md-4" style="text-align: left; width: 30%">
                                            <select type="text" name="kodeassy" class="form-control" id="masukkanassy" data-placeholder= "Kode Assy"><select>
                                        </div>
                                    </div>
                                     <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;"  >
                                       <button class="btn btn-primary" onclick="getAssy(this)"><i class="fa fa-search"></i> Find</button>
                                       </div>
                                    </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="tb_monitorassy">
                                        <!-- Table Result -->
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