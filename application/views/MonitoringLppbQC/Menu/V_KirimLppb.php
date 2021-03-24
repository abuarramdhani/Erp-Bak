<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border text-center"><b>Kirim Lppb</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                        <label class="control-label"><?php echo date("l/d F Y H:i:s"); ?></label>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <form action="<?php echo base_url('MonitoringLppbQC/KirimLppb/Save') ?>" method="post">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="no_induk">No Induk</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control slc_no_induk" id="no_induk" name="no_induk" onchange="getNama()" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="nama">Nama</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="hari_tgl">Hari/Tanggal</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right dateMLQ" id="hari_tgl" name="hari_tgl" placeholder="Hari/Tanggal" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="jam">Jam</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control timeMLQ" id="jam" name="jam" placeholder="Jam" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-lg-12 mt-4">
                                                <div class="table-responsive">
                                                    <div class="row" style="margin: 1px;">
                                                        <div class="panel-body">
                                                            <table class="table table-bordered cektabel">
                                                                <thead class="bg-primary">
                                                                    <tr>
                                                                        <th class="text-center" style="width:7%;">No</th>
                                                                        <th class="text-center" style="width:9%;">No Lppb</th>
                                                                        <th class="text-center text-nowrap" style="width:9%;">Nama Vendor</th>
                                                                        <th class="text-center text-nowrap" style="width:10.5%;">Kode Komponen</th>
                                                                        <th class="text-center text-nowrap" style="width:10.5%;">Nama Komponen</th>
                                                                        <th class="text-center" style="width:9%;">Jumlah</th>
                                                                        <th class="text-center" style="width:9%;">OK</th>
                                                                        <th class="text-center" style="width:9%;">NOT OK</th>
                                                                        <th class="text-center" style="width:9%;">Keterangan</th>
                                                                        <th class="text-center" style="width:9%;" hidden>Shipment Header Id</th>
                                                                        <th class="text-center" style="width:9%;" hidden>Shipment Line Id</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="body-lppb">
                                                                    <tr id="tr1">
                                                                        <td class="text-center"><input type="text" class="form-control no" name="no[]" id="no_1" value="1" readonly></td>
                                                                        <td class="text-center">
                                                                            <select class="form-control slc_no_lppb" id="no_lppb_1" name="no_lppb[]" onchange="autofill(1)" required>
                                                                                <option selected="selected"></option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="nama_vendor_1" name="nama_vendor[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="kode_komponen_1" name="kode_komponen[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="nama_komponen_1" name="nama_komponen[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="jumlah_1" name="jumlah[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="ok_1" name="ok[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="not_ok_1" name="not_ok[]" readonly></td>
                                                                        <td class="text-center"><input type="text" class="form-control" id="keterangan_1" name="keterangan[]" readonly></td>
                                                                        <td class="text-center" hidden><input type="text" class="form-control" id="sh_1" name="sh[]" readonly></td>
                                                                        <td class="text-center" hidden><input type="text" class="form-control" id="sl_1" name="sl[]" readonly></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="text-left">
                                                            <button type="button" onclick="addRowElement()">
                                                                <span style="color: #337AB7; margin-top: 2px" class='fa fa-plus fa-2x' title="Tambah Row" alt="Tambah Row"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 cek_pengirim">
                                                        <div class="text-right">
                                                            <button type="submit" style="float:right !important;font-weight:bold" class="btn btn-primary" name="button" id="btn_kirim" onclick="kirimlppb()">
                                                                <i class="fa fa-paper-plane"></i>  Kirim LPPB
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>