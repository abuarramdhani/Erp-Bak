<html>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right">
                    <h1>Edit Database QTW</h1>
                </div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-3x fa-database"></span></div>
            </div>
        </div>
        <div class="box">
            <form action="<?= base_url('QuickWisata/DBQTW/updateQTW') ?>" method="post" class="form-horizontal" id="formHorizQtw" onSubmit="return confirm('Are you sure you wish to Update ?');">
                <div class="row">
                    <div class="col-lg-12" style="margin-bottom: 20px;">
                        <div class="box-header" style="background-color: #d2d6de; font-weight: bold; font-size: 18px;"><span class="fa fa-2x fa-clock-o"></span>&emsp;WAKTU KUNJUNGAN</div>
                        <div class="box-body box-solid box-default">
                            <div class="row">
                                <input type="text" name="id_qtw" value="<?= $data[0]['id_qtw'] ?>" hidden>
                                <div class="col-lg-5">
                                    <label for="txttglqtw" class="col-lg-3">Tanggal :</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control txttglqtw" name="txttglqtw" value="<?= date('d F Y', strtotime($data[0]['tanggal'])) ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <label for="txtTimeAwalqtw" class="col-lg-2">Waktu :</label>
                                    <div class="col-lg-3">
                                        <input type="time" class="form-control txtTimeAwalqtw" name="txtTimeAwalqtw" value="<?= $data[0]['wkt_mulai'] ?>" required>
                                    </div>
                                    <p class="col-lg-1 text-center">-</p>
                                    <div class="col-lg-3">
                                        <input type="time" class="form-control txtTimeAkhirqtw" name="txtTimeAkhirqtw" value="<?= $data[0]['wkt_selesai'] ?>" required>
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
                                            <option <?= ($data[0]['tujuan'] == 'Pusat') ? 'selected' : '' ?> value="Pusat">Pusat</option>
                                            <option <?= ($data[0]['tujuan'] == 'Tuksono') ? 'selected' : '' ?> value="Tuksono">Tuksono</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <label for="slcJnsQtw" class="col-lg-3 text-right">Jenis Kunjungan :</label>
                                    <div class="col-lg-3" style="margin-left: -2px;">
                                        <input type="text" class="form-control" value="<?php if ($data[0]['jenis_institusi'] == '1') {
                                                                                            echo 'SMA / SMK / MA';
                                                                                        } else if ($data[0]['jenis_institusi'] == '2') {
                                                                                            echo 'Universitas';
                                                                                        } else {
                                                                                            echo 'Lain - lain';
                                                                                        } ?>" readonly>
                                    </div>
                                    <div class="col-lg-6" style="margin-left: -2px;">
                                        <input type="text" class="form-control" value="<?= $data[0]['dtl_institusi']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="slcPicQtw" class="col-lg-4">PIC Quick :</label>
                                    <div class="col-lg-8">
                                        <select name="slcPicQtw" class="slcPicQtw form-control select select2">
                                            <option value="<?= $data[0]['pemandu'] ?>"><?= $data[0]['nama_pemandu'] ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <label for="inpPicLawan" class="col-lg-3 text-right">PIC Peserta / No.HP :</label>
                                    <div class="col-lg-5" style="margin-left: -2px;">
                                        <input type="text" name="inpPicLawan" id="inpPicLawan" value="<?= $data[0]['pic'] ?>" placeholder="---Masukkan Nama PIC---" class="form-control" style="text-transform: uppercase" required>
                                    </div>
                                    <div class="col-lg-4" style="margin-left: -2px;">
                                        <input type="text" name="inpHpLawan" id="inpHpLawan" value="<?= $data[0]['nohp_pic'] ?>" placeholder="---Masukkan No.Hp PIC---" class="form-control" required>
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
                                                <textarea name="txtaAlamatQtw" cols="30" rows="5" width="253px;" class="form-control" style="text-transform: uppercase;" placeholder="JL. XXX / DUKUH XXX RT XX RW XX" readonly><?= $data[0]['alamat'] ?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="txtProvQtw" class="col-lg-3">Propinsi :</label>
                                            <div class="col-lg-7" style="margin-left: -15px;">
                                                <input type="text" name="txtProvQTW" value="<?= $data[0]['prop'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="txtKabQtw" class="col-lg-3">Kabupaten :</label>
                                            <div class="col-lg-7" style="margin-left: -15px;">
                                                <input type="text" name="txtKabQtw" value="<?= $data[0]['kab'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="txtKecQtw" class="col-lg-3">Kecamatan :</label>
                                            <div class="col-lg-7" style="margin-left: -15px;">
                                                <input type="text" name="txtKecQtw" value="<?= $data[0]['kec'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="txtKelQtw" class="col-lg-3">Desa :</label>
                                            <div class="col-lg-7" style="margin-left: -15px;">
                                                <input type="text" name="txtKelQtw" value="<?= $data[0]['desa'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="txtKodePosQtw" class="col-lg-3">Kodepos :</label>
                                            <div class="col-lg-7" style="margin-left: -15px;">
                                                <input type="text" id="txtKodePosQtw" name="txtKodePosQtw" class="form-control" value="<?= $data[0]['kd_pos'] ?>" readonly>
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
                                            <label class="col-lg-4" style="margin-top: 10px; margin-left: -3px; text-align: right;"><?= $data[0]['jenis_institusi'] == '1' ? 'Guru' : $data[0]['jenis_institusi'] == '2' ? 'Dosen' : 'Pendamping' ?> :</label>
                                            <div class="input-group margin col-lg-4" style="margin-left: -20px !important;">
                                                <input type="number" class="col-lg-4 form-control inp_tua_qtw" name="inp_tua_qtw" value="<?= $data[0]['pendamping'] ?>" required>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-falt" disabled>Orang</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="col-lg-4" style="margin-top: 10px; margin-left: -3px; text-align: right;"><?= $data[0]['jenis_institusi'] == '1' ? 'Siswa' : $data[0]['jenis_institusi'] == '2' ? 'Mahasiswa' : 'Peserta' ?> :</label>
                                            <div class="input-group margin col-lg-4" style="margin-left: -20px !important;">
                                                <input type="number" class="col-lg-4 form-control inp_muda_qtw" name="inp_muda_qtw" value="<?= $data[0]['peserta'] ?>" required>
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
                                                    <?php $loop = explode(', ', $data[0]['kendaraan']);
                                                    $jumlah = explode(', ', $data[0]['jml_kendaraan']);
                                                    $kendaraan = array(
                                                        '0' => '',
                                                        '1' => 'Sepeda Motor',
                                                        '2' => 'Travello',
                                                        '3' => 'Mobil Dinas',
                                                        '4' => 'Bus Kecil',
                                                        '5' => 'Bus Besar',
                                                    );
                                                    for ($i = 0; $i < count($loop); $i++) {  ?>
                                                        <tr>
                                                            <td><select name="kendaraan_qtw[]" class="form-control select select2 kendaraan_Qtw" required>
                                                                    <?php
                                                                    for ($j = 0; $j < count($kendaraan); $j++) { ?>
                                                                        <option <?= $loop[$i] == $kendaraan[$j] ? 'selected' : '' ?> value="<?= $kendaraan[$j] ?>"><?= $kendaraan[$j] ?></option>
                                                                    <?php } ?>
                                                                </select></td>
                                                            <td><input name="jml_kdrn_qtw[]" type="number" min="1" class="form-control lastInput_Qtw" value="<?= $jumlah[$i] ?>" required></td>
                                                            <td><button class="btn btn-danger delRow_Kendaraan_Qtw" disabled><span class="fa fa-close"></span></button></td>
                                                        </tr>
                                                    <?php } ?>
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
                        <a class="btn btn-danger" href="<?= base_url('QuickWisata/DBQTW') ?>"><span class="fa fa-sign-out">&nbsp;Back</span></a>&emsp;
                        <button type="submit" class="btn btn-success"><span class="fa fa-2 fa-save">&nbsp;Save</span></button>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</section>

</html>