<script>
$(document).ready(function () {
    $('.datepickbln').datepicker({
        format: 'mm/yyyy',
        todayHighlight: true,
        viewMode: "months",
        minViewMode: "months",
        autoClose: true
    }).on('change', function(){
            $('.datepicker').hide();
        });
})
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-calendar"></i> <?= $Title?></h2>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label>Kategori :</label>
                                        <select id="kategori" name="kategori" class="form-control select2" style="width:100%" data-placeholder="* wajib diisi">
                                            <option></option>
                                            <?php foreach ($kategori as $key => $val) { ?>
                                            <option value="<?= $val['ID_CATEGORY']?>"><?= $val['CATEGORY_NAME']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Bulan :</label>
                                        <input id="periode_bulan" name="periode_bulan" class="form-control datepickbln" placeholder="* wajib diisi" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label>File :</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="file_import" name="file_import" accept=".xls, .xlsx, .csv">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" style="margin-left:15px" formaction="<?php echo base_url("MonitoringJobProduksi/Import/SaveImport")?>"><i class="fa fa-upload"></i> Import</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <button class="btn btn-success" style="margin-left:15px" formaction="<?php echo base_url("MonitoringJobProduksi/Import/downloadlayout")?>"><i class="fa fa-download"></i> Download Layout</button>
                                    <br><br>
                                    <span style="color:red;margin-left:15px;font-weight:bold">PERHATIAN!</span>
                                    <!-- <br>
                                    <span style="margin-left:15px">* Pembacaan data dimulai dari baris 1 file import.</span> -->
                                    <br>
                                    <span style="margin-left:15px">* Pastikan <strong>SubKategori</strong> sudah terdaftar dalam <strong>Kategori</strong> yang dipilih.</span>
                                    <br>
                                    <!-- <span style="margin-left:15px">* Pastikan <strong>Item</strong> yang akan diimport belum terdaftar pada <strong>Kategori</strong> dan <strong>SubKategori</strong> yang dipilih.</span>
                                    <br> -->
                                    <span style="margin-left:15px">* Jika <strong>Item</strong> sudah terdaftar pada Kategori yang dipilih, pastikan <strong>Item</strong> belum memiliki plan dibulan yang dipilih.</span>
                                    <!-- <br> -->
                                    <!-- <span style="margin-left:15px">* Jika ingin menambahkan <strong>Item</strong> dan <strong>Plan Bulanan</strong> pada <strong>Kategori</strong> tanpa <strong>SubKategori</strong>, maka kolom untuk menulis <strong>SubKategori</strong> pada file import dibiarkan kosong.</span> -->
                                </div>
                            </div>
                        <form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>