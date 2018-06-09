<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
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
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">    
                                <span style="font-size: 20px;">Input Presensi Dinas Luar</span>
                            </div>
                            <div class="box-body">
                            <form action="<?php echo site_url('Presensi/PresensiDL/InsertPresensiManual') ?>" method="post">
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-4">
                                        <select class="form-control select-nama-prs" id="idNoind_prs" name="NamaPekerja" style="width: 100%" >
                                        </select>
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="text" name="txtSPDL" placeholder="[SPDL]" class="form-control" >
                                      </div>
                                      <div class="col-sm-6">
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-2">
                                        <b>Realisasi Berangkat</b>
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="text" name="txtTglBerangkat" placeholder="[tanggal berangkat]" class="form-control datepicker" data-date="" data-date-format="yyyy-mm-dd">
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="time" name="txtTimeBerangkat" class="form-control">
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-2">
                                        <b>Realisasi Pulang</b>
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="text" name="txtTglPulang" placeholder="[tanggal pulang]" class="form-control datepicker" data-date="" data-date-format="yyyy-mm-dd">
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="time" name="txtTimePulang" class="form-control">
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary" style="width: 100%;" value="Simpan">
                                      </div>
                                    </div> 
                                </div>
                            </div> 
                            </form>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">    
                                <span style="font-size: 20px;">Halaman Pencarian</span>
                            </div>
                            <div class="box-body">
                            <form action="<?php echo site_url('Presensi/PresensiDL/CariDataDinasLuar') ?>" method="post">
                            <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-6">
                                        <select class="form-control select-pencarian-prs" id="idPencarian_prs" name="Pencarian" style="width: 100%" required>
                                          <option value=""></option>
                                          <option value="data">Data Presensi</option>
                                          <option value="rekap">Rekap Presensi</option>
                                          <option value="monitoring">Monitoring Pekerja Habis Masa Kontrak</option>
                                        </select>
                                      </div>
                                      <div class="col-sm-6">
                                        <select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbDepartemen" style="width:100%" name="cmbDepartemen">
                                      </select>
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-6">
                                        <select class="form-control select-nama-prs" id="idNoind_prs" name="NamaPekerja" style="width: 100%">
                                        </select>
                                      </div>
                                      <div class="col-sm-6">
                                         <select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbBidang" style="width:100%" name="cmbBidang">
                                        </select>
                                      </div>
                                    </div> 
                                </div>
                                 <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-3">
                                        <input class="form-control RekapAbsensi-daterangepicker" disabled="disabled" id="idTglBerangkat_prs" name="txtTglBerangkat_prs" style="width: 100%"></input>
                                      </div>
                                      <div class="col-sm-2">
                                          <input style="width: 20px;height: 20px;" type="checkbox" id="actDate"><b>Date</b></input>
                                       </div>
                                       <div class="col-sm-1">
                                       </div>
                                      <div class="col-sm-6">
                                          <select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbUnit" style="width:100%" name="cmbUnit">
                                          </select>
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-3">
                                            <a class="btn btn-warning" style="width: 100%;">Reset Pencarian</a>
                                       </div>
                                      <div class="col-sm-3">
                                       </div>
                                      <div class="col-sm-6">
                                          <select data-placeholder="Pilih Salah Satu!" class="form-control select2 RekapAbsensi-cmbSeksi" style="width:100%" name="cmbSeksi">
                                          </select>
                                      </div>
                                    </div> 
                                </div>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-3">
                                       </div>
                                    </div> 
                                </div>
                                 <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-3">
                                        <input type="submit" class="btn btn-primary" id="idSubmit_prs" value="SEARCH" style="width: 100%"></input>
                                      </div>
                                    </div> 
                                </div>
                            </div> 
                            </form>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </div>
</section>
