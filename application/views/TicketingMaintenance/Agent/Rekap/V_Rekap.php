<style type="text/css">

#SearchRangeOrder {
    border-radius: 25px; 
}

#SearchRangeOrderMesin {
    border-radius: 25px;
}

/*#rangeAwal {
    border-radius: 25px; 
}

#rangeAkhir {
    border-radius: 25px; 
}*/

/*#pilihParameterRekap {
     border-radius: 25px !important; 
}*/

</style>
</head>

<body>

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
                                        REKAP ORDER
                                    </b>
                                </h1>
                         </div>
                     </div>
                     <div class="col-lg-1 ">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="">
                                <i aria-hidden="true" class="fa fa-ticket fa-2x">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                           Rekap Order Perbaikan dan Perawatan Mesin (OPPM)
                       </div>
                       <br>
                       <div class="box-body">
                        <form cautocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/selectRekapOPPM'); ?>" method="post">
                            <!-- <div class="row"> -->
                                <div class="col-md-3 " style="text-align: left;">
                                    <label>PARAMETER REKAP</label>
                                </div>
                                <div class="col-lg-12 text-left" style="margin-bottom : 20px">
                                    <input type="radio" name="filterRekap" value="FilterMesin" checked> <label for="norm" class="control-label">&nbsp;&nbsp;Mesin </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="filterRekap" value="FilterSeksi"><label for="norm" class="control-label">&nbsp;&nbsp; Seksi</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="filterRekap" value="FilterRangeTanggal"><label for="norm" class="control-label">&nbsp;&nbsp; Range Tanggal </label>
                                    <!-- <select name="pilihParameterRekap" id="pilihParameterRekap" class="form-control select parameterRekap" style="width: 250px;" placeholder="Pilih Parameter">
                                            <option value="">---Pilih---</option>
                                            <option value="MESIN">Mesin</option>
                                            <option value="SEKSI">Seksi</option>
                                            <option value="RANGE TANGGAL">Range Tanggal</option>
                                    </select> -->
                                </div>
                                <!-- <div style="text-align: left;margin-left: 15px;margin-bottom: 3px;">
                                    <button type="button" onclick="//detectParameter(this)" class="btn btn-info" id="SearchRangeOrderTanggal">
                                        <span class="fa fa-search" style="padding-right: 5px"></span> FIND
                                    </button><p>
                                        <span style="height: 50px"></span>
                                    </p>
                                </div> -->

                        <!--filter by mesin-->
                            <div class="row filterMesin" style="display">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-3" style="text-align: center;">
                                            <label>Nama Mesin</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <select name="txtParMesin[]" id="parMesin" class="form-control select2" style="padding-left: 12px; width: 350px; margin-left:-30px;" data-placeholder="Pilih Nama Mesin" multiple>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrderMesin">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by mesin-->

                        <!--filter by seksi-->
                            <div class="row filterSeksi" style="display:none">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-3" style="text-align: center;">
                                            <label>Seksi</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <select name="txtParSeksi" id="parSeksi" class="form-control select2" style="padding-left: 12px; width: 350px; margin-left:-30px;" data-placeholder="Pilih Seksi">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrderSeksi">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by seksi-->

                        <!--filter by date range-->
                            <div class="row filterRange" style="display:none">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-md-3 " style="text-align: right;margin-left: 30px;">
                                            <label>Input Range Tanggal</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="" name="txtRangeAwal" id="rangeAwal" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
                                                <input type="text" value=""  name="txtRangeAkhir" id="rangeAkhir" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrder">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by date range-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>

