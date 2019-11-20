<style type="text/css">
    .button7 {
      background-color: white; 
      color: black; 
      border: 1px solid #00c0ef;
  }
  .button7:hover {
      background-color: #00c0ef;
      color: white;
  }
</style>

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
                                href="<?php echo site_url('MonitoringSubkont/Monitoring/');?>">
                                <i class="fa-area-chart icon-2x">
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
                <div class="form-group col-md-12">
                    <div class="box box-info box-solid">
                        <div class="box-header with-border"><b>Monitoring</b></div>
                        <div class="box-body">
                                <div class="panel-body">

                            <div class="col-md-4" align="right" ><b>Nama Subkont</b></div>

                                <div class="col-md-4"  style="float: none;margin: 0 auto;">

                                     <select class="form-control select2" data-placeholder="Nama Subkont" id="searchasek" name="namasubkont"></select>

                                </div>
                        </div> 
                        <div class="panel-body">

                            <div class="col-md-4" align="right" ><b>Assy Komponen</b></div>

                                <div class="col-md-4"  style="float: none;margin: 0 auto;">

                                     <select class="form-control select2" data-placeholder="Assy Komp" id="searchasekomp" name="kompp"></select>

                                </div>
                        </div> 
                            <div class="panel-body">
                                <div class="col-md-4" align="right" ><b>Job</b></div>
                                <div class="col-md-4"  style="float: none;margin: 0 auto;">
                                    <center><input  type="text" class="form-control pull-right" placeholder="No Job" name="job"></center>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-4" align="right" ><b>Tanggal Awal</b></div>
                                <div class="col-md-4"  style="float: none;margin: 0 auto;">
                                 <center><input  type="text" class="form-control pull-right" placeholder="Tanggal Dibuat MO" id="tgAwal" name="tgAwal" ></center>
                             </div>
                         </div> 
                         <div class="panel-body">
                            <div class="col-md-4" align="right" ><b>Tanggal Akhir</b></div>
                            <div class="col-md-4"  style="float: none;margin: 0 auto;">
                                <center><input  type="text" class="form-control pull-right" placeholder="Tanggal Dibuat MO" id="tgAkhir" name="tgAkhir"></center>
                            </div>
                        </div> 
                    </div>
                   

                    <div class="panel-body">
                        <div class="col-md-12"><br />
                            <center ><button style="border-radius: 50px;" class="btn button7" onclick="getMonitor(this)"><i class="fa fa-search"></i> Find </button></center>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="panel-body">
                            <div class="col-md-12" id="review"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- haha -->

</section>