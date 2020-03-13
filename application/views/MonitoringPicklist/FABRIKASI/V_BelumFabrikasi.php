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
                                    href="<?php echo site_url('MonitoringPicklistFabrikasi/BelumApprove/');?>">
                                    <i class="icon-wrench icon-2x">
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
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="panel-body bg-warning">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <select id="dept" class="form-control select2 deptpicklist" data-placeholder="pilih department" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tanggal" class="form-control datepicklist" placeholder="pilih tanggal" style="width:100%" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn bg-orange" onclick="belumapproveFabrikasi(this)"><i class="fa fa-search"></i> Find</button>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <table class="table table-bordered" style="width:70px;margin-left:400px">
                                                <tr><td style="font-size:40px;background-color:white" id="jmlbrs">0</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div class="table-responsive" id="tb_blmfabrikasi">
                                        
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


