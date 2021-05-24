<style media="screen">
    .ahad {
        color: red;
        font-weight: bold;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/PerhitunganPesangon/edit/'.$id);?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/PerhitunganPesangon/Pesangon');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <style type="text/css">
                        fieldset{
                            padding: 20px;
                            border: 2px solid #60A5FA;
                            margin-bottom: 20px;
                            border-radius: 10px;
                        }
                        legend{
                            padding: 5px 10px 5px 10px;
                            border: 2px solid #60A5FA;
                            color: #60A5FA;
                            font-weight: bold;
                            width: auto;
                            border-radius: 10px;
                            margin-bottom: 0px;
                        }
                        fieldset fieldset{
                            border-color: #34D399;
                        }
                        fieldset fieldset > legend{
                            border-color: #34D399;
                            color: #34D399;
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Tambah / Edit Pesangon</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                            <?php
                                                foreach ($editHitungPesangon as $edit)
                                                {
                                            ?>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-2 control-label text-left">Pekerja</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" readonly="" value ="<?php echo $edit['noind'].' - '.$edit['nama']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <legend>A. Data Pekerja</legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtSeksi" class="col-lg-4 control-label ">Seksi </label>
                                                                    <div class="col-lg-8">
                                                                         <input type="text" name="txtSeksi" class="form-control" id="txtSeksi" readonly="" value ="<?php echo $edit['seksi']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtJabatan" class="col-lg-4 control-label">Jabatan Terakhir
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtJabatan" class="form-control" id="txtJabatan"
                                                                        value ="<?php echo $edit['pekerjaan']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtUnit" class="col-lg-4 control-label ">Unit</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtUnit" class="form-control" id="txtUnit" readonly="" value ="<?php echo $edit['unit']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtLokasi" class="col-lg-4 control-label">Lokasi
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtLokasi" class="form-control" id="txtLokasi" readonly="" value ="<?php echo $edit['lokasi_kerja']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtDepartemen" class="col-lg-4 control-label ">Departemen</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtDepartemen" class="form-control" id="txtDepartemen" readonly="" value ="<?php echo $edit['departemen']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="txtLahir" class="col-lg-2 control-label ">Tempat,Tgl lahir
                                                                    </label>
                                                                    <div class="col-lg-4">
                                                                      <input type="text" name="txtLahir" class="form-control" id="txtLahir"
                                                                      readonly="" value ="<?php echo $edit['tempat']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtAlamat" class="col-lg-4 control-label ">Alamat
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtAlamat" class="form-control" id="txtAlamat" value ="<?php echo $edit['alamat']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtProses" class="col-lg-4 control-label">Tgl Keluar
                                                                    </label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="txtAkhir" class="form-control" id="txtAkhir" value="<?php echo $edit['metu'] ?>" readonly>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txtHari" class="form-control  <?= ($hari_terakhir == 'Minggu') ? 'ahad':''?>" id="txtHariLmt" value="<?php echo $hari_terakhir ?>" readonly="" >
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtDiangkat" class="col-lg-4 control-label ">Tgl Diangkat</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtDiangkat" class="form-control" id="txtDiangkat"
                                                                      readonly="" value ="<?php echo $edit['diangkat']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtProses" class="col-lg-4 control-label">Tgl Proses PHK
                                                                    </label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="txtProses" class="form-control" id="txtProses" value="<?php echo ($edit['tgl_phk'] != null)? $edit['tgl_phk']:'' ?>" autocomplete="off">
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txtPrs" class="form-control <?= ($hari_proses == 'Minggu') ? 'ahad':''?>" id="txtHariPrs" value="<?php echo ($edit['tgl_phk'] != null)? $hari_proses: '' ?>"readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtMasaKerja" class="col-lg-4 control-label ">Masa Kerja
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtMasaKerja" class="form-control" id="txtMasaKerja" readonly="" value ="<?php echo $edit['masakerja']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                         <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtNPWP" class="col-lg-4 control-label">NPWP
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtNPWP" class="form-control" id="txtNPWP"
                                                                      readonly="" value ="<?php echo $edit['npwp']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtSisaCuti" class="col-lg-4 control-label ">Sisa Cuti
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtSisaCuti" class="form-control" id="txtSisaCuti"  readonly="" value ="<?php echo $edit['sisacuti']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtNIK" class="col-lg-4 control-label">NIK
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtNIK" class="form-control" id="txtNIK"
                                                                      readonly="" value ="<?php echo $edit['nik']; ?>">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="txtStatus" class="col-lg-2 control-label">Status
                                                                    </label>
                                                                    <div class="col-lg-4">
                                                                        <input type="text" name="txtStatus" class="form-control" id="txtStatus"  readonly="" value ="<?php echo $edit['alasan']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <legend>B. Detail</legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <fieldset>
                                                                    <legend>Pesangon</legend>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtUangPesangon" class="col-lg-4 control-label ">Uang Pesangon </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtUangPesangon" class="form-control" id="txtUangPesangon"  readonly="" value ="<?php echo $edit['pengali']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtUangUMPK" class="col-lg-4 control-label ">Uang UPMK </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtUangUMPK" class="form-control" id="txtUangUMPK"  readonly="" value ="<?php echo $edit['upmk']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtSisaCutiHari" class="col-lg-4 control-label ">Sisa Cuti Hari </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtSisaCutiHari" class="form-control" id="txtSisaCutiHari"  readonly="" value ="<?php echo $edit['sisacutihari']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <fieldset>
                                                                    <legend>Rekening</legend>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtNomorRekening" class="col-lg-4 control-label ">Nomor Rekening
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtNomorRekening" class="form-control" id="txtNomorRekening"  value ="<?php echo $edit['no_rek']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtNamaRekening" class="col-lg-4 control-label ">Nama Pemilik Rekening
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtNamaRekening" class="form-control" id="txtNamaRekening" value ="<?php echo $edit['nama_rek']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtBank" class="col-lg-4 control-label ">Bank
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtBank" class="form-control" id="txtBank"
                                                                                    value ="<?php echo $edit['bank']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <fieldset>
                                                                    <legend>Potongan</legend>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtHutangKoperasi" class="col-lg-4 control-label">Hutang Koperasi
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtHutangKoperasi" class="form-control" id="txtHutangkoperasi" value ="<?php echo $edit['hutang_koperasi']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                     <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtHutangPerusahaan" class="col-lg-4 control-label">Hutang Perusahaan
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtHutangPerusahaan" class="form-control" id="txtHutangPerusahaan" value ="<?php echo $edit['hutang_perusahaan']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                     <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtLainLain" class="col-lg-4 control-label">Lain-lain
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtLainLain" class="form-control" id="txtLainLain" value ="<?php echo $edit['lain_lain']; ?>">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtTahun" class="form-control" id="txtTahun" value ="<?php echo $edit['masakerja_tahun']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtBulan" class="form-control" id="txtBulan" value ="<?php echo $edit['masakerja_bulan']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtHari" class="form-control" id="txtHari" value ="<?php echo $edit['masakerja_hari']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtPasal" class="form-control" id="txtPasal" value ="<?php echo $edit['pasal']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtPesangon" class="form-control" id="txtPesangon" value ="<?php echo $edit['pesangon']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtUPMK" class="form-control" id="txtUPMK" value ="<?php echo $edit['up']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group hidden">
                                                            <input type="text" name="txtCuti" class="form-control" id="txtCuti" value ="<?php echo $edit['cuti']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group  hidden">
                                                            <input type="text" name="txtRugi" class="form-control" id="txtRugi" value ="<?php echo $edit['rugi']; ?>">
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                            ?>
                                            </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
