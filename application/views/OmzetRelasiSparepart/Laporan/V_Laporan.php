<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">ERP OMZET RELASI SPAREPART</h3>
                </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="Tahun" class="col-sm-2 control-label">Tahun</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control tahunORS" id="" placeholder="Tahun" style="width: 200px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Cabang" class="col-sm-2 control-label">Cabang</label>

                            <div class="col-sm-10">
                                <select class="slcCabangORS from-control" style="width: 200px;">
                                    <option></option>
                                    <option value="82">KHS Pusat (OU)</option>
                                    <option value="506">KHS Nganjuk (OU)</option>
                                    <option value="507">KHS Sidrap (OU)</option>
                                    <option value="141">KHS Jakarta (OU)</option>
                                    <option value="142">KHS Tanjung Karang (OU)</option>
                                    <option value="143">KHS Makassar (OU)</option>
                                    <option value="144">KHS Medan (OU)</option>
                                    <option value="929">KHS Pontianak (OU)</option>
                                    <option value="930">KHS Banjarmasin (OU)</option>
                                    <option value="931">KHS Jambi (OU)</option>
                                    <option value="932">KHS Palu (OU)</option>
                                    <option value="766">KHS Padang (OU)</option>
                                    <option value="121">KHS Surabaya (OU)</option>
                                    <option value="726">KHS Tugumulyo (OU)</option>
                                    <option value="869">KHS Pekanbaru (OU)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ordertype" class="col-sm-2 control-label">Order Type</label>

                            <div class="col-sm-10">
                                <select class="slcOrderTypeORS form-control" style="width: 200px;">
                                    <option></option>
                                    <option value="1">OU-Traktor (SAP)-DN</option>
                                    <option value="2">OU-HDE (SHDE)-DN</option>
                                    <option value="3">OU-VDE (SVDE)-DN</option>
                                    <option value="4">OU-Vbelt Mitsuboshi-DN</option>
                                    <option value="5">OU-Vbelt Bando-DN</option>
                                    <option value="6">OU-Bearing Nachi Quick-DN</option>
                                    <option value="7">OU-Bearing SKF Quick-DN</option>
                                    <option value="8">OU-Rubber Roll-DN</option>
                                </select>
                            </div>
                        </div>
                        <div align="center">
                            <button type="button" class="btn btn-success btnSearchReportORS"><i class="fa fa-search"></i>Search</button>
                        </div>
                        <br>
                        <div class="loadingORS" align="center" style="display:none;">
                            <img src="<?= base_url('assets/img/gif/loading11.gif');?>" alt="loading">
                        </div>
                        <div class="tableReportORS">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>