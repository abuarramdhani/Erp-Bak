<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/PerhitunganPesangon/add');?>" class="form-horizontal" >
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
                        #txtUangPesangon, #txtUangUMPK, #txtSisaCutiHari {
                            font-family: monospace;
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Tambah / Edit Pesangon</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label text-left">Jumlah Cuti Dihitung ? <span style="color: red">*</span></label>
                                                        <div class="col-lg-8">
                                                           <input type="checkbox" value="1" id="MasterPekerja-PerhitunganPesangon-HitungCuti" checked>
                                                           <input type="hidden" id="MasterPekerja-PerhitunganPesangon-StatusCuti" value="1"><br><span style="color: red">*checkbox hanya memiliki efek ketika memilih pekerja</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label text-left">Pekerja Keluar</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2 MasterPekerja-PerhitunganPesangon-DaftarPekerja" name="txtNoind" id="MasterPekerja-PerhitunganPesangon-DaftarPekerja" style="width: 100%">
                                                                <option></option>
                                                            </select>
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
                                                                         <input type="text" name="txtSeksi" class="form-control" id="txtSeksi" readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtJabatan" class="col-lg-4 control-label">Jabatan Terakhir
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtJabatan" class="form-control" id="txtJabatan">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtUnit" class="col-lg-4 control-label ">Unit</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtUnit" class="form-control" id="txtUnit" readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtLokasi" class="col-lg-4 control-label">Lokasi
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtLokasi" class="form-control" id="txtLokasi" readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtDepartemen" class="col-lg-4 control-label ">Departemen</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtDepartemen" class="form-control" id="txtDepartemen" readonly="">
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
                                                                      readonly="">
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
                                                                        <input type="text" name="txtAlamat" class="form-control" id="txtAlamat" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtProses" class="col-lg-4 control-label">Tgl Keluar
                                                                    </label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="txtAkhir" class="form-control" id="txtAkhir" readonly>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txtHari" class="form-control" id="txtHariLmt"
                                                                      readonly="" >
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
                                                                      readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtProses" class="col-lg-4 control-label">Tgl Proses PHK
                                                                    </label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="txtProses" class="form-control" id="txtProses" autocomplete="off" required>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txtPrs" class="form-control" id="txtHariPrs"
                                                                      readonly="">
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
                                                                        <input type="text" name="txtMasaKerja" class="form-control" id="txtMasaKerja" readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtNPWP" class="col-lg-4 control-label">NPWP
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtNPWP" class="form-control" id="txtNPWP"
                                                                      readonly="">
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
                                                                        <input type="text" name="txtSisaCuti" class="form-control" id="txtSisaCuti"  readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtNIK" class="col-lg-4 control-label">NIK
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtNIK" class="form-control" id="txtNIK"
                                                                      readonly="">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtStatus" class="col-lg-4 control-label">Sebab Keluar
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtStatus" class="form-control" id="txtStatus"  readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="txtHukum" class="col-lg-4 control-label">Dasar Hukum
                                                                    </label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtHukum" class="form-control" id="txtHukum"  readonly="">
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
                                                                                <label for="txtUangPesangon" class="col-lg-4 control-label ">Perhitungan Pesangon </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtUangPesangon" class="form-control" id="txtUangPesangon"  readonly="">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtUangUMPK" class="col-lg-4 control-label ">Penghargaan Masa Kerja</label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtUangUMPK" class="form-control" id="txtUangUMPK"  readonly="">
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                     <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtSisaCutiHari" class="col-lg-4 control-label ">Sisa Cuti Hari </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtSisaCutiHari" class="form-control" id="txtSisaCutiHari"  readonly="">
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
                                                                                    <input type="text" name="txtNomorRekening" class="form-control" id="txtNomorRekening" autocomplete="off" required>
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
                                                                                    <input type="text" name="txtNamaRekening" class="form-control" id="txtNamaRekening" autocomplete="off" required>
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
                                                                                    <input type="text" name="txtBank" class="form-control" id="txtBank" required >
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
                                                                                    <input type="text" name="txtHutangKoperasi" class="form-control" id="txtHutangkoperasi" required>
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtHutangPerusahaan" class="col-lg-4 control-label">Hutang Perusahaan
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtHutangPerusahaan" class="form-control" id="txtHutangPerusahaan" required >
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="txtLainLain" class="col-lg-4 control-label">Lain-lain
                                                                                </label>
                                                                                <div class="col-lg-8">
                                                                                    <input type="text" name="txtLainLain" class="form-control" id="txtLainLain" required >
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
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <legend>Memo</legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="cmbPengirim" class="col-lg-4 control-label text-left">Pengirim Memo</label>
                                                                    <div class="col-lg-8">
                                                                        <select required class="select2 MasterPekerja-PerhitunganPesangon-DaftarPekerja" name="txtPengirim" id="" style="width: 100%">
                                                                            <option></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="cmbPenerima" class="col-lg-4 control-label text-left">Penerima Memo</label>
                                                                    <div class="col-lg-8">
                                                                        <select required class="select2 MasterPekerja-PerhitunganPesangon-DaftarPekerja" name="txtPenerima" id="" style="width: 100%">
                                                                            <option></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="form-group ">
                                                            <input type="hidden" name="txtTahun" class="form-control" id="txtTahun" >
                                                            <input type="hidden" name="txtBulan" class="form-control" id="txtBulan" >
                                                            <input type="hidden" name="txtHari" class="form-control" id="txtHari" >
                                                            <input type="hidden" name="txtPengaliUPesangon" class="form-control" id="txtPengaliUPesangon" >
                                                            <input type="hidden" name="txtPesangon" class="form-control" id="txtPesangon" >
                                                            <input type="hidden" name="txtUPMK" class="form-control" id="txtUPMK" >
                                                            <input type="hidden" name="txtPengaliUPMK" class="form-control" id="txtPengaliUPMK" >
                                                            <input type="hidden" name="txtCuti" class="form-control" id="txtCuti" >
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect" id="btnSubmit">Save Data</button>
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
