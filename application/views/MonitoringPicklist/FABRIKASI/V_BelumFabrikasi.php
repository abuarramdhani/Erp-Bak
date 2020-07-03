<!-- <script>
        $(document).ready(function () {
        var refreshId = setInterval(function()
        {
            $("#notiffabrks").load(notiffabrikasi());
        }, 1000);
    });
</script> -->
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
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" onclick="belumapproveFabrikasi(this)">
                                    <i class="fa fa-2x fa-bell-o"></i>
                                    <span id="notiffabrks" class="label" style="border-radius:100%"></span>
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
                                <table class="table table-bordered" style="width:100%;table-layout:fixed">
                                    <tr>
                                        <td style="width: 25%">
                                            <select id="dept" class="form-control select2 deptpicklist" data-placeholder="pilih department" style="width:100%">
                                                <option></option>
                                            </select>
                                        </td>
                                        <td style="width: 5%"></td>
                                        <td style="width: 25%"></td>
                                        <td style="width: 10%"></td>
                                        <td rowspan="2" style="text-align:right;width:40%">
                                            <div class="text-center">
                                                <table class="table table-bordered" style="width:70px;margin-left:70%">
                                                    <tr><td style="font-size:40px;background-color:white" id="jmlbrs">0</td></tr>
                                                        <input type="hidden" id="tmpfab" value="-">
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tanggal1" class="form-control datepicklist" placeholder="pilih tanggal awal" style="width:100%" autocomplete="off">
                                            </div>
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tanggal2" class="form-control datepicklist" placeholder="pilih tanggal akhir" style="width:100%" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                        <div class="col-md-1">
                                            <button type="button" class="btn bg-orange" onclick="belumapproveFabrikasi(this)"><i class="fa fa-search"></i> Find</button>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                
                                <div class="panel-body">
                                    <div id="tb_blmfabrikasi">
                                        
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


