<section class="content">
    <div class="inner">
        <!-- <div class="row">
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
                                    href="<?php echo site_url('CetakNCDataReport/Cetak');?>">
                                    <i class="fa fa-2x fa-file-text-o">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger box-solid">
                            <div class="box-body">
                            <div class="panel-body" style="text-align:center;font-weight:bold">
                                <h2><?= $Title?></h2>
                            </div>
                            <form method="post" target="_blank" class="import_txt" id="import_txt" enctype="multipart/form-data" action="<?php echo base_url('CetakNCDataReport/Cetak/CetakData')?>">
                                <div class="panel-body">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                        <label>Tool No / Item : </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="toolno" name="toolno" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                    <label>Part Name : </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="partname" name="partname" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                    <label>Programmer :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="programmer" class="form-control select2" data-placeholder="pilih programmer" autocomplete="off">
                                        <option></option>
                                        <option value="SUDEX">SUDEX</option>
                                        <option value="MANTO">MANTO</option>
                                        <option value="HURI">HURI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                    <label>Shift :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="shift" class="form-control select2" data-placeholder="pilih shift" autocomplete="off">
                                        <option></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                    <label>Masukan Gambar : </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="file" name="img_file" id="img_file" accept=".png, .jpeg" />
                                    </div>
                                </div>
                                <div class="panel-body" id="tambahTarget">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-2">
                                    <label>Masukan File : </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="file" name="txt_file[]" id="txt_file" accept=".txt, .NC, .NF" />
                                    </div>
                                    <div class="col-md-2" style="text-align:right">
                                            <a href="javascript:void(0);" id="addinputFile" onclick="addinputFile()" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                        </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="text-align:center">
                                        <button type="submit" class="btn btn-lg btn-success"> Cetak</button>
                                    </div>
                                </div>
                            </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


