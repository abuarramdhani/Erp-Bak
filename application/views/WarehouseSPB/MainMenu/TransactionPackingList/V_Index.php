<section class="content" >
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        Packing List
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('WarehouseSPB/Transaction/PackingList');?>">
                                    <i aria-hidden="true" class="fa fa-car fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Search data Packing List
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="formPackingList" onsubmit="getDataPackingList()">
                                            <div class="col-md-10">
                                                <input type="number"  name="nomerSPB" class="form-control" placeholder="Masukkan Nomer SPB..." required="" min="0">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-sm btn-block">SEARCH</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row" id="loadingArea" style="display: none; padding-top:30px; color: #3c8dbc;">
                                    <div class="col-md-12 text-center">
                                        <i class="fa fa-spinner fa-4x fa-pulse"></i>
                                    </div>
                                </div>
                                <div id="tablePackingListArea"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="loadingMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="col-md-12 text-center" style="color: white; font-size: 5em">
            <i class="fa fa-spinner fa-pulse"></i>
        </div>
    </div>
  </div>
</div>