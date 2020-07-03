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
                                <a class="btn btn-default btn-lg" onclick="belumapproveGudang(this)">
                                    <i class="fa fa-2x fa-bell-o"></i>
                                    <span id="notifgdg" class="label" style="border-radius:100%"></span>
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
                                <div class="panel-body" style="background-color: #c4ffef;">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <select id="subinv" class="form-control select2 subinvpicklist" data-placeholder="pilih subinventory" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="background-color: #c4ffef;">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tanggal1" class="form-control datepicklist" placeholder="tanggal awal" style="width:100%" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tanggal2" class="form-control datepicklist" placeholder="tanggal akhir" style="width:100%" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-success" onclick="belumapproveGudang(this)"><i class="fa fa-search"></i> Find</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div id="tb_blmgudang">
                                        
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


