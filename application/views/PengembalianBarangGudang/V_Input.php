<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-plus"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body box box-info box-solid">
                                    <!-- <form method="POST" action="<?php echo base_url("PengembalianBarangGudang/Input/InputPengembalian")?>"> -->
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <p style="margin: 5px 0 20px 0;"><label>Proses Assembly</label></p>
                                                <p style="margin: 5px 0 20px 0;"><label>Komponen</label></p>
                                                <p style="margin: 5px 0 20px 0;"><label>Qty Komponen</label></p>
                                                <p style="margin: 5px 0 20px 0;"><label>Alasan Pengembalian</label></p>
                                                <p style="margin: 5px 0 20px 0;"><label>PIC Assembly</label></p>
                                                <p style="margin: 5px 0 20px 0;"><label>PIC Gudang</label></p>
                                            </div>
                                            <div class="col-md-10">
                                                <p>
                                                    <select class="form-control select2 proses_assembly" name="proses_assembly" id="proses_assembly" style="width: 400px;" required></select>
                                                </p>
                                                <p>
                                                    <select class="form-control select2 kode_komponen" name="kode_komponen" id="kode_komponen" style="width: 400px;" required></select>
                                                    <!-- onchange="getNamaKomponenPBG()" -->
                                                </p>
                                                <p>
                                                    <input type="text" class="form-control" name="qty_komponen" id="qty_komponen" placeholder="Input Qty Komponen" autocomplete="off" style="width: 200px;" required>
                                                </p>
                                                <p>
                                                    <input type="text" class="form-control" name="alasan_pengembalian" id="alasan_pengembalian" placeholder="Input Alasan Pengembalian" autocomplete="off" required>
                                                </p>
                                                <p>
                                                    <select class="form-control select2 pic_assembly" name="pic_assembly" id="pic_assembly" style="width: 400px;" required></select>
                                                </p>
                                                <p>
                                                    <select class="form-control select2 pic_gudang" name="pic_gudang" id="pic_gudang" style="width: 400px;" required></select>
                                                </p>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <!-- <button type="submit" class="btn btn-primary" style="float: center;">
                                                    Save
                                                </button> -->
                                                <button class="btn btn-success" onclick="InputBarang()"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                    <!-- </form> -->
                                </div>
                                <div class="panel-body" id="tb_data_input"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>