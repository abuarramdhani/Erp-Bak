<script>
        $(document).ready(function () {
        $('.datepicktgl').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoClose: true
        }).on('change', function(){
            $('.datepicker').hide();
        });
    });
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                        <form method="post" id="orderbaru_otm" enctype="multipart/form-data" action="<?php echo base_url('OrderToolMaking/MonitoringOrder/saveorder')?>">
                            <div class="box-body">
                                <h2 class="text-center">ORDER BARU</h2>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                    <strong>Tanggal Order :</strong> <?php echo date('d/m/Y')?>
                                        <input type="hidden" name="tgl_order" value="<?php echo date('d/m/Y')?>">
                                    </div>
                                    <!-- <div class="col-md-5">
                                    <strong>Seksi Pengorder :</strong> <span style="font-size:12px"><?= $seksi?></span>
                                        <input type="hidden" name="seksi_order" value="<?= $seksi?>">
                                    </div> -->
                                    <div class="col-md-12">
                                    <strong>Unit Pengorder :</strong> <span style="font-size:12px"><?= $unit?></span>
                                        <input type="hidden" name="unit_order" value="<?= $unit?>">
                                        <input type="hidden" id="nama_seksi_order" value="<?= $seksi?>">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                        <input type="radio" name="order" class="ganti" value="MODIFIKASI">MODIFIKASI
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="order" class="ganti" value="REKONDISI">REKONDISI
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="order" class="gantibaru" value="BARU" checked>BARU
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label>Seksi Pengorder</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select id="seksi_order" name="seksi_order" class="form-control select2 seksiorder" style="width:100%" data-placeholder="pilih seksi pengorder">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 box box-primary box-solid">
                                    <div class="panel-body modifrekon" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>User</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="user_mr" name="user_mr" class="form-control select2 userorder" style="width:100%" data-placeholder="pilih user">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Proposal Aset</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input name="file_proposal" type="file" class="form-control" accept=".pdf">
                                        </div>
                                        <div class="col-md-3">
                                            <input name="no_proposal" class="form-control baru2" placeholder="no proposal" autocomplete="off" required>
                                        </div>
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Usulan Order Selesai</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input name="tgl_usul" class="form-control datepicktgl" placeholder="pilih tanggal usulan" style="width:100%" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Jenis</label>
                                        </div>
                                        <div id="inputjenis" class="col-md-7">
                                            <select id="jenis" name="jenis" class="form-control select2" style="width:100%" data-placeholder="jenis" required>
                                                <option></option>
                                                <?php foreach ($jenis as $key => $val) {
                                                    echo '<option value="'.$val.'">'.$val.'</option>';
                                                }?>
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="tambahinputan"></div>
                                    </div>
                                    <div class="panel-body" id="tambah_gb_produk">
                                        <div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Gambar Produk</label>
                                        </div>
                                        <div class="col-md-6">
                                            <span id="view_gamker1" style="display:none"><img id="previewgamker1" style="width:100%;max-width: 350px;max-height: 350px"></span>
                                            <input name="gambar_kerja[]" type="file" id="img_gamker" accept=".jpg, .png">
                                        </div>
                                        <div class="col-md-2"><button type="button" class="btn" onclick="tmb_gb_produk(this)"><i class="fa fa-plus"></i></button></div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Skets</label>
                                        </div>
                                        <div class="col-md-7">
                                            <span id="view_skets" style="display:none"><img id="previewskets" style="width:100%;max-width: 350px;max-height: 350px"></span>
                                            <input name="file_skets" type="file" id="img_skets" accept=".jpg, .png" required>
                                        </div>
                                    </div>
                                    <div class="panel-body modifrekon" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Inspection Report</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input name="file_inspect" id="inspect_report" type="file"  accept="">
                                            <!-- <input name="inspection_report" class="form-control" placeholder="inspection report" autocomplete="off" required> -->
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Nama Komponen</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input name="nama_komponen" class="form-control" placeholder="nama komponen" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Kode Komponen</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input name="kode_komponen" class="form-control" placeholder="kode komponen" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Tipe Produk</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="tipe_produk" name="tipe_produk" class="form-control select2" style="width:100%" data-placeholder="tipe produk" required>
                                                <option></option>
                                                <?php foreach ($tipe_produk as $key2 => $val) {
                                                    echo '<option value="'.$val['PRODUK_DESC'].'">'.$val['PRODUK_DESC'].'</option>';
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Tanggal Rilis Gambar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input name="tgl_rilis" class="form-control datepicktgl" placeholder="pilih tanggal rilis" style="width:100%" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body modifrekon" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>No Alat Bantu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input name="no_alat_bantu" class="form-control modifrekon2" placeholder="no alat bantu" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 box box-primary box-solid">
                                <h4 style="font-weight:bold;">Detail Proses</h4>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Proses</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select name="poin" class="form-control select2 getprosestm" style="width:100%"  data-placeholder="pilih poin yang diproses" required></select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Proses Ke</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="proses_ke" class="form-control" placeholder="isi 1 jika tidak ada proses" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Dari</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="dari" class="form-control" placeholder="isi 1 jika tidak ada proses" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Flow Proses</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Sebelumnya</label>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="flow_sebelum" class="form-control baru2 select2 getprosestm" data-placeholder="pilih proses" ></select>
                                        </div>
                                        <div class="col-md-4">
                                            <input name="detailflow_sebelum" class="form-control baru2" placeholder="detail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-1">
                                            <label>Sesudahnya</label>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="flow_sesudah" class="form-control baru2 select2 getprosestm" data-placeholder="pilih proses"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <input name="detailflow_sesudah" class="form-control baru2" placeholder="detail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Mesin Yang Digunakan</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select name="mesin" class="form-control select2 getmesintm" style="width:100%"  data-placeholder="pilih mesin yang digunakan" required></select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 box box-primary box-solid">
                                <h4 style="font-weight:bold;">Detail Alat Bantu</h4>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Jumlah Alat</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="jml_alat" name="jml_alat" class="form-control select2 baru2" style="width:100%" data-placeholder="pilih jumlah alat">
                                                <option></option>
                                                <?php for ($i=0; $i < 10 ; $i++) { 
                                                    echo '<option value="'.($i+1).'">'.($i+1).'</option>';
                                                }?>
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-1">
                                            <label>Distribusi</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="user_baru" name="user_baru[]" class="form-control select2 userorder" multiple style="width:100%" data-placeholder="*pilih sebanyak jumlah alat">
                                                <option></option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Distribusi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="user_baru" name="user_baru[]" class="form-control select2 userorder" multiple style="width:100%" data-placeholder="*pilih sebanyak jumlah alat" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body baru khususgauge" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Dimensi dan Toleransi (Untuk Gauge)</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="dimensi" name="dimensi" class="form-control barukhususgauge2" placeholder="dimensi dan toleransi" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Acuan Alat Bantu</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="acuan_alat" id="produk" value="Produk">Produk
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="acuan_alat" id="gmbr_produk" value="Gambar Produk">Gambar Produk
                                        </div>
                                    </div>
                                    <div class="panel-body baru">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Layout Alat Bantu</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="layout_alat" id="tunggal" value="Tunggal">Tunggal
                                        </div>
                                        <div class="col-md-1">
                                            <input type="radio" name="layout_alat" id="multi" value="Multi">Multi
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="multi" id="isi_multi" class="form-control" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="panel-body baru khususdies" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Material Blank (Khusus Dies)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="material" id="afval" name="material" value="Afval" disabled>Afval
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="material" id="lembar" name="material" value="Lembaran" disabled>Lembaran
                                        </div>
                                        <div class="col-md-2" style="margin-left:-83px;">
                                            <input type="number" name="lembar1" class="form-control lembar" disabled autocomplete="off">
                                        </div>
                                        <div class="col-md-1 text-center" style="margin-left:-43px;margin-right:-50px"><label>X</label></div>
                                        <div class="col-md-2">
                                            <input type="number" name="lembar2" class="form-control lembar" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="panel-body modifrekon" style="display:none">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Alasan Modifikasi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea name="alasan_modif" placeholder="alasan modifikasi" style="height:100px;width:100%"></textarea>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label>Referensi / Datum Alat Bantu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea name="referensi2" class="modifrekon modifrekon2" placeholder="referensi / datum alat bantu" style="height:100px;width:100%;display:none"></textarea>
                                            <input name="referensi1" id="referensi1" class="form-control baru baru2" placeholder="referensi / datum alat bantu" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label>Assign</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select id="assign" name="assign_order" class="form-control select2 assignorder" style="width:100%" required >
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="panel-body khususpe" style="<?= $seksi == 'PRODUCTION ENGINEERING' ? '' : 'display:none'; ?>">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label>Assign Desainer</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select id="assign_desain" name="assign_desainer" class="form-control select2" style="width:100%" data-placeholder="pilih assign desainer" >
                                            <option></option>
                                            <option value="Desainer A">Desainer A</option>
                                            <option value="Desainer B">Desainer B</option>
                                            <option value="Desainer C">Desainer C</option>
                                        </select>
                                    </div>
                                </div>
                                </div>

                                <div class="panel-body text-center">
                                    <button type="submit" class="btn btn-lg btn-danger"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="mdlloading" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top:200px;width:20%">
		<div class="modal-content">
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Mohon Tunggu Sebentar...</b></h3>
		    </div>
		</div>
	</div>
</div>