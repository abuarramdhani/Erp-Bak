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
                                    href="<?php echo site_url('CetakKartuBody/Cetak');?>">
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
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">

                            <nav class="navbar" style="width:30%">
                                <div class="container-fluid">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="active"><a data-toggle="tab" href="#baru" id="ctk_baru">Cetak Baru</a></li>
                                        <li><a data-toggle="tab"  href="#lagi" id="ctk_lagi">Cetak Manual</a></li>
                                    </ul>
                                </div>
                            </nav>

                            <div class="box-body">
                            <div class="tab-content">
                                <div class="panel-body tab-pane fade in active" id="baru">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <select id="kompKartu" name="kompKartu" class="form-control select2 kompKartu" data-placeholder="Nama Komponen" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="qty" name="qty" class="form-control" placeholder="Masukan Qty" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <select id="sizekertas" name="sizekertas" class="form-control select2" data-placeholder="Ukuran Kertas" style="width:100%">
                                            <option></option>
                                            <option value="A3">A3</option>
                                            <option value="folio">Folio</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="getKartu(this)">OK</button>    
                                    </div>
                                </div>

                                <div class="panel-body tab-pane fade" id="lagi">
                                    <div class="form-group">
                                        <div class="col-md-2 text-right">
                                             No Serial Awal :
                                        </div> 
                                        <div class="col-md-3">
                                            <input  id="no_awal" name="nomors[]" class="form-control" placeholder="No Serial Awal" autocomplete="off">
                                        </div> 
                                        <div class="col-md-3 text-right">
                                             No Serial Akhir :
                                        </div> 
                                        <div class="col-md-3">
                                            <input  id="no_akhir" name="nomors[]" class="form-control" placeholder="No Serial Akhir" autocomplete="off">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <div class="col-md-2 text-right">
                                             Nama Komponen :
                                        </div> 
                                        <div class="col-md-3">
                                            <select id="namakomp" name="namakomp[]" class="form-control select2 kompKartu" data-placeholder="Nama Komponen" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            Ukuran Kertas :
                                        </div> 
                                        <div class="col-md-3">
                                            <select id="size" name="size[]" class="form-control select2" data-placeholder="Ukuran Kertas" style="width:100%">
                                            <option></option>
                                            <option value="A3">A3</option>
                                            <option value="folio">Folio</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-primary" onclick="getNoSerial(this)">FIND</button>   
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div id="tb_kartu">
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
