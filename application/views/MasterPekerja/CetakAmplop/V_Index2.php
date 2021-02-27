<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('MasterPekerja/CetakAmplop');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <form action="<?php echo site_url('MasterPekerja/CetakAmplop/cetakAmplop2') ?>" method="post" target="_blank">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    
                                </div>
                                <div class="box-body">
                                    <div class="row" style="margin: 10px 10px">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <label for="nama" class="col-sm-2 control-label">Pekerja :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select-nama-amplop2" id="mpk_slcnmamp2" style="width: 100%" multiple="multiple"></select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" href="" class="btn btn-primary" disabled="" id="mpk_crpkjamp2">SEARCH</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12" id="mpk_tblamp2">
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label style="margin-top: 5px;">Nama Pengirim</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="pengirim" class="form-control" value="Ayu Seksi Hubungan Kerja" />
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 5px;">
                                        <div class="col-md-2">
                                            <label style="margin-top: 5px;">Format Amplop</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control mpk_slcamplop" id="mpk_slcukrkts" name="format">
                                                <!-- <option value="DL">DL (1/3 A4)</option>
                                                <option value="C7">C7 (A7 atau A6 dilipat Sekali)</option>
                                                <option value="C7/C6">C7/C6 (1/3 A5)</option>
                                                <option value="C6">C6 (A6 atau A4 dilipat dua kali)</option>
                                                <option value="C6/C5">C6/C5 (1/3 A4)</option> -->
                                                <option value="C5">C5 (A5 atau A4 dilipat sekali)</option>
                                                <option value="C4">C4 (A4)</option>
                                               <!--  <option value="C3">C3 (A3)</option>
                                                <option value="B6">B6 (C6)</option>
                                                <option value="B5">B5 (C5)</option>
                                                <option value="B4">B4 (C4)</option>
                                                <option value="E4">E4 (B4)</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 10px;" hidden="">
                                        <div class="col-md-3">
                                            <label style="margin-top: 5px;">Horizontal (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="lebar" id="mpk_lbr" class="form-control" value="220" />
                                        </div>
                                        <div class="col-md-3">
                                            <label style="margin-top: 5px;">Vertikal (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="panjang" id="mpk_pjng" class="form-control" value="110" />
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;"></div>
                                        <div class="col-md-3">
                                            <label style="margin-top: 5px;">Margin Atas (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="matas" class="form-control" value="48" />
                                        </div>
                                        <div class="col-md-3">
                                            <label style="margin-top: 0px;">Margin Bawah (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="mbawah" class="form-control" value="10" />
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 10px;" hidden="">
                                        <div class="col-md-3">
                                            <label style="margin-top: 5px;">Orientasi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="mpk_slcamplop form-control" name="orientasi">
                                                <option value="P">Potrait</option>
                                                <option value="L">Landscape</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 25px; color: white"></div>
                                        <div class="col-md-3">
                                            <label style="margin-top: 0px;">Margin Kanan (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="mkanan" class="form-control" value="10" />
                                        </div>
                                        <div class="col-md-3">
                                            <label style="margin-top: 0px;">Margin Kiri (mm)</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="mkiri" class="form-control" value="20" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-success btn-sm" disabled="" id="mpk_print_amplop"><i class="fa fa-print fa-2x"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.addEventListener('load', function () {
        $('#mpk_slcukrkts').trigger('change');
    });
</script>