<section class="content-header">
    <h1>Upload From CSV</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload Data</h3>
                </div>
                <div class="box-body">
                    <div>
                        <a href="<?php echo base_url('assets/upload/StandarisasiItem/uploadcontoh-standarisasi-item3.csv');?>" type="button" class="btn btn-success">Download Contoh File <i class="fa fa-file-excel-o"></i></a>
                        <br><span><b>notes: *</b>Jika menggunakan browser Chrome, Gunakan klik kanan kemudian Save link As kemudian Save</span>
                        <br>
                        <span><b>(</b>Mohon diperhatikan, Pastikan ekstensi file <b>.CSV</b>. Jika belum, ubah ekstensi saat save menjadi <b>All files</b> kemudian tambahkan <b>.csv</b> dibelakang nama file kemudian save<b>)</b></span>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Pilih File</th>
                            <th>:</th>
                            <th><input type="file" name="userfile" id="uploadSIP"></th>
                            <th><button type="button" class="btn btn-primary btnUploadSIP">Upload</button></th>
                        </tr>
                    </table>
                </div>
            </div>
                <div class="text-center loadingImportSIP" style="display:none;">
                    <img src="<?= base_url('assets/img/gif/loading14.gif');?>">
                </div>
            <div class="listSIP">
            </div>
        </div>
    </div>
</section>