<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Upload File Otorisasi</h3>
                </div>
                <div class="box-body" style="background:#f0f0f0 !important;">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <br>
                            <form action="<?php echo base_url('OrderSeksiRekayasa/MyOrder/SaveOtorisasi'); ?>" method="post" enctype="multipart/form-data">
                                <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>No Order :</label>
                                                <input type="text" id="NoOrder" name="NoOrder" class="form-control" value="<?= $myorder[0]['id_order'] ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Jenis Order :</label>
                                                <input type="text" id="JenisOrder" name="JenisOrder" class="form-control" value="<?= $myorder[0]['jenis_order'] ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nama Alat/Mesin :</label>
                                                <input type="text" id="NamaAlatMesin" name="NamaAlatMesin" class="form-control" value="<?= $myorder[0]['nama_alat_mesin'] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>File Otorisasi :</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="file" class="form-control" name="FileOtorisasi" id="FileOtorisasi" accept=".bmp, .jpg, .png, .pdf" onchange="readFile(this)" required>
                                                <br>
                                                <iframe id="showPre" src="<?php echo base_url('/assets/img/erp.png') ?>" frameborder="0" class="mt-1" style="width:100%;height:250px"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <center><button type="submit" class="btn btn-md btn-primary"><b>Save</b></button> </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1"></div>
                    <div>
                </div>
            </div>
        </div>
    </div>
</section>