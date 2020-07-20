<html>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right"><h1>Database QTW</h1></div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-3x fa-database"></span></div>
            </div>
        </div>
        <div class="box">
            <form action="<?= base_url('QuickWisata/DBQTW/save') ?>" method="post" class="form-horizontal" id="formHorizQtw" onSubmit="return confirm('Are you sure you wish to Submit ?');">
            <div class="row">
                <div class="col-lg-12" style="margin-bottom: 20px;">
                    <div class="box-header" style="background-color: #d2d6de; font-weight: bold; font-size: 18px;"><span class="fa fa-2x fa-clock-o"></span>&emsp;WAKTU KUNJUNGAN</div>
                    <div class="box-body box-solid box-default">
                        <div class="row">
                            <div class="col-lg-5">
                                <label for="txttglqtw" class="col-lg-3">Tanggal :</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control txttglqtw" name="txttglqtw" required>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <label for="txtTimeAwalqtw" class="col-lg-2">Waktu :</label>
                                <div class="col-lg-3">
                                    <input type="time" class="form-control txtTimeAwalqtw" name="txtTimeAwalqtw" required>
                                </div>
                                <p class="col-lg-1 text-center">-</p>
                                <div class="col-lg-3">
                                    <input type="time" class="form-control txtTimeAkhirqtw" name="txtTimeAkhirqtw" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box-header" style="background-color: #d2d6de; font-weight: bold; font-size: 18px;"><span class="fa fa-2x fa-archive"></span>&emsp;DATA KUNJUNGAN</div>
                    <div class="box-body box-solid box-default">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="slcTjnQtw" class="col-lg-4">Tujuan :</label>
                                <div class="col-lg-8">
                                    <select name="slcTjnQtw" class="slcTjnQtw form-control select select2" required>
                                        <option value="" selected disabled>---Pilih Tujuan---</option>
                                        <option value="Pusat">Pusat</option>
                                        <option value="Tuksono">Tuksono</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <label for="slcJnsQtw" class="col-lg-3 text-right">Jenis Kunjungan :</label>
                                <div class="col-lg-3" style="margin-left: -2px;">
                                    <select name="slcJnsQtw" id="slcJnsQtw" class="form-control select select2" required>
                                        <option value=""></option>
                                        <option value="1">SMA / SMK / MA</option>
                                        <option value="2">Universitas</option>
                                        <option value="3">Lain - lain</option>
                                    </select>
                                </div>
                                <div class="col-lg-6"  style="margin-left: -2px;" id="applyDetailInstansi"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="slcPicQtw" class="col-lg-4">PIC Quick :</label>
                                <div class="col-lg-8">
                                    <select name="slcPicQtw" class="slcPicQtw form-control select select2" required> 
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <label for="inpPicLawan" class="col-lg-3 text-right">PIC Peserta / No.HP :</label>
                                <div class="col-lg-5" style="margin-left: -2px;">
                                    <input type="text" name="inpPicLawan" id="inpPicLawan" placeholder="---Masukkan Nama PIC---" class="form-control" style="text-transform: uppercase" required>
                                </div>
                                <div class="col-lg-4" style="margin-left: -2px;">
                                    <input type="text" name="inpHpLawan" id="inpHpLawan" placeholder="---Masukkan No.Hp PIC---" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-lg-6">
                            <div class="box box-success col-lg-6">
                                <div class="box-header with-border">
                                <label style="font-size:14px;"><span class="fa fa-2x fa-building-o"></span>&emsp;ALAMAT PENGUNJUNG</label>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <label for="txtaAlamatQtw" class="col-lg-3">Alamat :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <textarea name="txtaAlamatQtw" id="txtaAlamatQtw" cols="30" rows="5" width="253px;" class="form-control"  style="text-transform: uppercase;" placeholder="JL. XXX / DUKUH XXX RT XX RW XX" required></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="txtProvQtw" class="col-lg-3">Propinsi :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <select class="select select2 form-control Provinsi_QTW" width="238px;" name="txtProvQtw" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="txtKabQtw" class="col-lg-3">Kabupaten :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <select class="select select2 form-control Kabupaten_QTW" width="238px;"  name="txtKabQtw" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="txtKecQtw" class="col-lg-3">Kecamatan :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <select class="select select2 form-control Kecamatan_QTW" width="238px;"  name="txtKecQtw" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="txtKelQtw" class="col-lg-3">Desa :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <select class="select select2 form-control Desa_QTW" width="238px;" name="txtKelQtw" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="txtKodePosQtw" class="col-lg-3">Kodepos :</label>
                                        <div class="col-lg-7" style="margin-left: -15px;">
                                            <input type="text" id="txtKodePosQtw" name="txtKodePosQtw" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box box-primary col-lg-6">
                                <div class="box-header with-border">
                                    <label style="font-size:14px;"><span class="fa fa-2x fa-users"></span>&emsp;JUMLAH PESERTA</label>
                                </div>
                                <div class="box-body" style="margin-left: -50px;">
                                    <div class="col-lg-12">
                                        <label class="col-lg-4" style="margin-top: 10px; margin-left: -3px; text-align: right;" id="label_tua_qtw">Pendamping :</label>
                                        <div class="input-group margin col-lg-4" style="margin-left: -20px !important;">
                                            <input type="number" class="col-lg-4 form-control inp_tua_qtw" name ="inp_tua_qtw" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-falt" disabled>Orang</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="col-lg-4" style="margin-top: 10px; margin-left: -3px; text-align: right;" id="label_muda_qtw">Peserta :</label>
                                        <div class="input-group margin col-lg-4" style="margin-left: -20px !important;">
                                            <input type="number" class="col-lg-4 form-control inp_muda_qtw" name ="inp_muda_qtw" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-falt" disabled>Orang</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary col-lg-6">
                                <div class="box-header with-border">
                                    <label style="font-size:14px;"><span class="fa fa-2x fa-bus"></span>&emsp;TRANSPORTASI PENGUNJUNG</label>
                                </div>
                                <div class="box-body">
                                    <div class="col-lg-12">
                                        <table class="table table-stripped" id="tblKendaraanQtw">
                                            <thead>
                                                <tr>
                                                    <th width="280px;">Kendaraan</th>
                                                    <th>Jumlah</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><select name="kendaraan_qtw[]" id="" class="form-control select select2 kendaraan_Qtw" required>
                                                        <option value=""></option>
                                                        <option value="Sepeda Motor">Sepeda Motor</option>
                                                        <option value="Travello">Travello</option>
                                                        <option value="Mobil Dinas">Mobil Dinas</option>
                                                        <option value="Bus Kecil">Bus Kecil</option>
                                                        <option value="Bus Besar">Bus Besar</option>
                                                    </select></td>
                                                    <td><input name="jml_kdrn_qtw[]" type="number" min="1" class="form-control lastInput_Qtw" required></td>
                                                    <td><button class="btn btn-danger delRow_Kendaraan_Qtw" disabled><span class="fa fa-close"></span></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <button class="col-lg-12 btn btn-info" id="plus_kendaraan_qtw"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a class="btn btn-danger" href="<?= base_url('QuickWisata/DBQTW')?>"><span class="fa fa-sign-out">&nbsp;Back</span></a>&emsp;
                    <button type="submit" class="btn btn-success"><span class="fa fa-2 fa-save">&nbsp;Save</span></button>&emsp;
                    <a class="btn btn-info" onclick="window.location.reload()"><span class="fa fa-2 fa-refresh">&nbsp;Reset</span></a>&emsp;
                </div>
            </div>
            <br>
        </form>
        </div>
    </div>
</section>
</html>