<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-plus"></i> Submit Order
            </h3>
        </div>
        <form method="post" id="SubmitOrder" name="SubmitOrder" action="<?php echo base_url('OrderSeksiRekayasa/Submit/Create'); ?>" autocomplete="off" role="form" enctype="multipart/form-data">
            <div class="box-body">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> Nama</label>
                        <input type="text" name="Nama" id="Nama" class="form-control" readonly value="<?= $this->session->employee ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Order</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <!-- <input type="text" name="TanggalOrder" id="TanggalOrder" class="form-control pull-right datetimeSI" readonly value="<?= $start; ?>"> -->
                            <input type="text" name="TanggalOrder" id="TanggalOrder" class="form-control" readonly value="<?php echo date("d/m/Y") ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> Seksi</label>
                        <input type="text" name="Seksi" id="Seksi" class="form-control" readonly value="<?= $seksi ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Estimasi Selesai</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input name="TanggalEstimasiSelesai" id="TanggalEstimasiSelesai" class="form-control pull-right datetimeOSR" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Jenis Order</label>
                        <select class="form-control" style="width: 50%" data-allow-clear="false" required="" data-placeholder="Pilih Jenis Order" id="JenisOrder" name="JenisOrder">
                            <option></option>
                            <option value="MEMBUAT ALAT/MESIN">MEMBUAT ALAT/MESIN</option>
                            <option value="OTOMASI">OTOMASI</option>
                            <option value="MODIFIKASI ALAT/MESIN">MODIFIKASI ALAT/MESIN</option>
                            <option value="REBUILDING MESIN">REBUILDING MESIN</option>
                            <option value="HANDLING MESIN">HANDLING MESIN</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 namaForm">
                    <div class="form-group">
                        <label>Nama Alat/Mesin</label>
                        <input type="text" name="NamaAlatMesin" id="NamaAlatMesin" class="form-control" placeholder="Masukkan nama alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 nomorForm">
                    <div class="form-group">
                        <label>Nomor Alat/Mesin</label>
                        <input type="text"name="NomorAlatMesin" id="NomorAlatMesin" class="form-control" placeholder="Masukkan nomor alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 jmlForm">
                    <div class="form-group">
                        <label>Jumlah Alat/Mesin</label>
                        <input type="text" name="JumlahAlatMesin" id="JumlahAlatMesin" class="form-control" placeholder="Masukkan jumlah alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 spekForm">
                    <div class="form-group">
                        <label>Spesifikasi Alat/Mesin</label>
                        <input type="text" name="SpesifikasiAlatMesin" id="SpesifikasiAlatMesin" class="form-control" placeholder="Masukkan spesifikasi alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 tipeForm">
                    <div class="form-group">
                        <label>Tipe Alat/Mesin</label>
                        <input type="text" name="TipeAlatMesin" id="TipeAlatMesin" class="form-control" placeholder="Masukkan tipe alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 fungsiForm">
                    <div class="form-group">
                        <label>Fungsi Alat/Mesin</label>
                        <input type="text" name="FungsiAlatMesin" id="FungsiAlatMesin" class="form-control" placeholder="Masukkan fungsi alat/mesin..." required>
                    </div>
                </div>
                <div class="col-lg-12 docForm">
                    <div class="form-group">
                        <label>Unggah Dokumen Layout Alat/Mesin</label>
                        <input type="file" name="LayoutAlatMesin" id="LayoutAlatMesin" class="form-control" accept=".bmp, .jpg, .png, .pdf" required/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Benefit</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="ManPower" value="Man Power"> 
                        <label class="form-check-label" for="ManPower">Man Power</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Productivity" value="Productivity">
                        <label class="form-check-label" for="Productivity">Productivity</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Safety" value="Safety">
                        <label class="form-check-label" for="Safety">Safety</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Quality" value="Quality">
                        <label class="form-check-label" for="Quality">Quality</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Cost" value="Cost">
                        <label class="form-check-label" for="Cost">Cost</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Delivery" value="Delivery">
                        <label class="form-check-label" for="Delivery">Delivery</label><br/>
                        <input type="checkbox" class="form-check-input" name="Benefit[]" id="Others" value="Others">
                        <label class="form-check-label" for="Others">Others</label><br/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                    <label>Target</label>
                    <textarea type="textarea" name="Target" id="Target" placeholder="Masukkan target yang diharapkan..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                    <input type="file" name="DokumenTarget" id="DokumenTarget" class="form-control" accept=".bmp, .jpg, .png, .pdf" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                    <label>Kondisi Sebelum</label>
                    <textarea type="textarea" name="KondisiSebelum" id="KondisiSebelum" placeholder="Masukkan kondisi saat ini..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                    <input type="file" name="DokumenKondisiSebelum" id="DokumenKondisiSebelum" class="form-control" accept=".bmp, .jpg, .png, .pdf" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                    <label>Kondisi Sesudah</label>
                    <textarea type="textarea" name="KondisiSesudah" id="KondisiSesudah" placeholder="Masukkan kondisi yang diharapkan..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                    <input type="file" name="DokumenKondisiSesudah" id="DokumenKondisiSesudah"  class="form-control" accept=".bmp, .jpg, .png, .pdf" />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                    <label>Keterangan Pelengkap</label>
                    <textarea type="textarea" name="KetPelengkap" id="KetPelengkap" placeholder="Masukkan keterangan pelengkap dari target dan perbandingan kondisi..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                    <input type="file" name="DokumenKetPelengkap" id="DokumenKetPelengkap" class="form-control" accept=".bmp, .jpg, .png, .pdf" />
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <center>
                    <!-- <button type="button" class="btn btn-success" id="btn_submit">Save</button> -->
                    <button type="submit" class="btn btn-success"><b>Save</b></button>
                </center>
            </div>
        </form>

    </div>
</section>