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
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('MasterPekerja/Other');?>">
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
                        <form action="<?php echo site_url('MasterPekerja/Other/cetakIDCard') ?>" method="post">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <button type="submit" style="float:right;margin-right:1%;margin-top:0px;" disabled="true" class="btn btn-default btn-sm disabled" id="print_card"><i class="fa fa-print fa-2x"></i></button>
                                </div>
                                <div class="box-body">
                                    <div class="row" style="margin: 10px 10px">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <label for="nama" class="col-sm-2 control-label">Pekerja :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select-nama" id="NamaPekerja" name="NamaPekerja[]" style="width: 100%" multiple="multiple"></select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="" class="btn btn-primary disabled" id="CariPekerja">SEARCH</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <label for="nama" class="col-sm-2 control-label">Cetak Noind baru :</label>

                                                <div class="col-sm-10">
                                                    <input type="radio" name="noind_baru" value="1"> Ya
                                                    <input type="radio" name="noind_baru" value="0" checked> Tidak
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="hidden" id="tampil-data">
                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="tabel-idcard" style="font-size:12px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="text-align:center; width:30px">No</th>
                                                    <th>Noind</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan/Seksi</th>
                                                    <th>Foto</th>
                                                    <th>Input Nickname</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataIDcard">
                                            </tbody>
                                        </table>
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