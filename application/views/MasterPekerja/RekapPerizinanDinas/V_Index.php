<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Rekap Perizinan Dinas Keluar</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                <form id="" method="post" action="<?php echo site_url('MasterPekerja/RekapPerizinanDinas/rekapbulanan');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label for="txtTanggalCetak" class="col-lg-3 control-label text-left">Periode Rekap</label>
                                                <div class="col-lg-7">
                                                   <input class="form-control periodeRekap"  autocomplete="off" type="text" name="periodeRekap" id="periodeRekap" placeholder="Masukkan Periode" value=""/>
                                                    <!-- <button type="submit" class="btn btn-primary">Cari</button> -->
                                                   <p>*kosongkan kolom periode , untuk menampilkan semua data</p>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                     </div>
                     </form>
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                              <div id="izin-ok">
                              <table class="datatable table table-striped table-bordered table-hover tabel_izin" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">ID Izin</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Nama Pekerja</th>
                                    <th class="text-center">Jenis Izin</th>
                                    <th class="text-center">Atasan Approved</th>
                                    <th class="text-center">Tempat Makan</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
