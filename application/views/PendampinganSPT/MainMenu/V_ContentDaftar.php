<!-- Main content -->
<section class="content" style="background: url({BaseUrl}assets/img/3.jpg); background-size: cover;">
    <div class="row">
        <div class="col-md-1"></div>
        <!-- /.col -->
        <div class="col-md-10">
                <div class="box box-primary container-fluid">
                    <div class="box-header with-border text-center">
                        <h4><b>PENDAFTARAN PELAPORAN SPT TAHUNAN 2019 ORANG PRIBADI</b></h3>
                        <h5>- KHUSUS UNTUK PEKERJA CV. KARYA HIDUP SENTOSA YANG MEMILIKI NPWP -</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="text-justify">
                            <h4 class="text-center"><span class="bd-content-title text-red"><b>PERHATIAN !</b></span></h4>
                            <dl>
                                <dt>Mohon membaca informasi berikut sebelum Anda melakukan pendaftaran pendampingan pengisian SPT Tahunan 2019.</dt>
                                <dd>1. Pendaftaran pendampingan pengisian SPT Tahunan Orang Pribadi Tahun 2019 ini hanya di peruntukan kepada Pekerja CV Karya Hidup Sentosa (bukan OS) yang memiliki NPWP.</dd>
                                <dd>2. Pendaftaran pendampingan SPT akan dibuka mulai tanggal <b>31 Januari 2020 - 8 Februari 2020 (lebih dari tanggal tersebut maka tidak dibuatkan jadwal susulan).</b></dd>
                                <dd>3. Untuk jadwal dan tempat pendampingan ditentukan oleh Kasie Perpajakan dengan mempertimbangkan kapasitas tempat pendampingan dan jumlah pendaftar. Jadwal dapat dilihat di <a href="http://quick.com">Quick.com</a> - <a href="{BaseUrl}PendampinganSPT/Daftar">Menu Pendampingan SPT</a> - <a href="#divPSPTDetailSchedule">Jadwal Pendampingan</a> <b>mulai tanggal 10 Februari 2020.</b></dd>
                                <dd>4. Pendampingan akan diberikan selama jam kerja dengan perkiraan tanggal sebagai berikut:
                                    <ol type="a" style="margin-bottom: 0px;">
                                        <li>Tuksono &nbsp;=&nbsp; Rabu - Kamis, 12-13 Februari 2020 (Pk 09.30 - 15.20 WIB)</li>
                                        <li>Pusat &emsp;&nbsp; =&nbsp; Senin - Rabu, 17-19 Februari 2020 (Pk 08.00 - 15.20 WIB)</li>
                                    </ol>
                                </dd>
                                <dd>5. <b>Mohon Bpk/Ibu menyiapkan dokumen berikut ketika pendampingan:</b>
                                    <ol type="a" style="margin-bottom: 0px;">
                                        <li>Bukti Potong A1 Th 2019 (Bukti Potong dari CV KHS)</li>
                                        <li>Alamat email, password email, password djp online yang pernah di daftarkan</li>
                                        <li>EFIN (bagi Bpk/Ibu yang lupa password djp online-nya)</li>
                                        <li>Handphone</li>
                                        <li>FC KK (untuk menginput data tanggungan)</li>
                                        <li>Menyiapkan data harta dan hutang tahun 2019</li>
                                    </ol>
                                </dd>
                            </dl>
                        </div>
                        <div class="divPSPTRegisterFormField hidden">
                            <div class="form-group">
                                <label for="txtPSPTIdentityNumber" class="col-sm-2 control-label">No. Induk</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control" id="txtPSPTIdentityNumber" placeholder="Nomor Induk">
                                    <span class="input-group-addon spnPSPTLoading" style="display: none"><i style="width:15px;" class="fa fa-spinner fa-spin"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtPSPTWorkerStats" class="col-sm-2 control-label">Status Pekerja</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-signal"></i></span>
                                    <input class="form-control" id="txtPSPTWorkerStats" placeholder="Status Pekerja" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtPSPTWorkerName" class="col-sm-2 control-label">Nama</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control" id="txtPSPTWorkerName" placeholder="Nama Pekerja" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtPSPTSection" class="col-sm-2 control-label">Seksi</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                    <input class="form-control" id="txtPSPTSection" placeholder="Seksi Pekerja" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slcPSPTWorkLocation" class="col-sm-2 control-label">Lokasi Kerja</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-map-marker"></i></span>
                                    <select id="slcPSPTWorkLocation" class="form-control" style="width: 100%;">
                                        <option selected="selected" disabled="disabled"></option>
                                        <option>PUSAT</option>
                                        <option>TUKSONO</option>
                                    </select>
                                </div>
                            </div><br>
                        </div>
                        <div class="text-justify hidden">
                            <p>Mohon dicek kembali data di atas, jika belum sesuai silahkan diperbaiki sesuai data yang benar dan jika sudah sesuai klik "<b>Kirim</b>".</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer hidden">
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary btnPSPTRegister"><i class="fa fa-send"></i> Kirim</button>
                        </div>
                        <button type="reset" class="btn btn-default btnPSPTRefresh"><i class="fa fa-refresh"></i> Refresh</button>
                    </div>
                    <!-- /.box-footer -->
                    <div id="divPSPTDetailSchedule" class="text-center box-footer" style="padding: 3rem;">
                        <p>Untuk melihat jadwal pendampingan silahkan klik link dibawah ini</p>
                        <a href="{BaseUrl}PendampinganSPT/Jadwal" class="btn btn-primary"><i class="fa fa-calendar"></i> &nbsp;Jadwal Pendampingan</a>
                    </div>
                    
                </div>
                <!-- /. box -->
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<div id="mdlPSPTAlertNPWP" class="modal fade" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-slg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-warning"></i> Peringatan</h4>
            </div>
            <div class="modal-body" style="word-wrap: break-word">
                <p class="text-justify">Data NPWP Anda tidak terdapat di data hubker, silahkan mengisikan nomor NPWP Anda di kotak dibawah ini.</p><br>
                <div class="form-group">
                    <div class="col-sm-1"></div>
                    <div class="input-group col-sm-10">
                        <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                        <input class="form-control" id="txtPSPTTRN" placeholder="Nomor Pokok Wajib Pajak">
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                <button type="button" class="btn btn-primary btnPSPTRegister"><i class="fa fa-send-o"></i> Kirim</button>
            </div>
        </div>
    </div>
</div>

<div id="mdlPSPTAlertRegister" class="modal fade" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-slg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="word-wrap: break-word">
                <p class="text-justify"></p><br>
                <div class="form-group">
                    <div class="col-sm-1"></div>
                    <div class="input-group col-sm-10">
                        <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                        <input class="form-control" id="txtPSPTRegisterId" placeholder="Nomor Pendaftaran" readonly>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

<div id="mdlPSPTDetailSchedule" class="modal fade" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-slg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-info"></i> Informasi</h4>
            </div>
            <div class="modal-body" style="word-wrap: break-word">
                <p class="text-center text-red">Jadwal Pendampingan belum tersedia.</p>
                <p class="text-center text-red">Jadwal Pendampingan dapat dilihat mulai tanggal 10 Februari 2020.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>