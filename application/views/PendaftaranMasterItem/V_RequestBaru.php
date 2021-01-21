<script>
        $(document).ready(function () {
            $('#tblongoingreq').dataTable({
                "scrollX": true,
                "paging" : false,
                "searching" : false,
                "bInfo": false,
            });
    });
</script>

<?php
$bg_kode = empty($kode_seksi) ? '#F6B0AF' : '';
$wn_kode = empty($kode_seksi) ? 'red;font-weight:bold' : '#333333';
?>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <h2 class="text-center" style="font-weight:bold">REQUEST BARU</h2>
                                <div class="box box-primary"><br>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>SEKSI :</label>
                                        <input type="hidden" class="ininumber" id="number" name="number" value="0">
                                        <input type="hidden" name="seksi" id="seksi" value="<?= $seksi?>">
                                        <input type="hidden" id="id_kode" name="id_kode" class="form-control" value="<?= $id_seksi?>" >
                                    </div>
                                    <div class="col-md-3"><?= $seksi?></div>
                                    <div class="col-md-1 text-right"><label>KODE :</label></div>
                                    <div class="col-md-2"><input id="kode" name="kode" class="form-control" style="background-color:<?= $bg_kode?>" value="<?= $kode_seksi?>" readonly></div>
                                    <div class="col-md-3"><span style="color:<?= $wn_kode?>;font-size:11px" id="warning_kode">* Harap lapor PIEA apabila KODE tidak tersedia.</span></div>
                                </div><br><br>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>STATUS :</label></div>
                                    <div class="col-md-6">
                                        <select id="statusbaru" name="status" class="form-control select2" style="width:100%" data-placeholder="Pilih status" >
                                            <option></option>
                                            <option value="P">P - Pendaftaran Baru</option>
                                            <option value="R">R - Revisi Item</option>
                                            <option value="I">I - Inactive Item</option>
                                        </select>
                                    </div>
                                </div><br><br>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>ITEM :</label></div>
                                    <input type="hidden" id="ketItem">
                                    <div class="col-md-6" id="gantiItem">
                                        <input id="item" name="item" class="form-control" value="" placeholder="Masukkan item" autocomplete="off">
                                    </div>
                                    <div class="col-md-3"><span style="color:red;font-size:13px;font-weight:bold" id="warning_item"></span></div>
                                </div><br><br>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>DESKRIPSI :</label></div>
                                    <div class="col-md-6" id="gantiDesc">
                                        <input id="desc" name="desc" class="form-control" value="" placeholder="Masukkan deskripsi" autocomplete="off">
                                    </div>
                                </div><br><br>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>UOM :</label></div>
                                    <div class="col-md-6" id="gantiUOM">
                                        <select id="uom" name="uom" class="form-control select2 kodeuom" data-placeholder="Masukkan UOM">
                                            <option></option>
                                        <select>
                                    </div>
                                    <div class="col-md-3"><span style="color:#333333;font-size:11px">* Harap lapor PIEA apabila UOM yang dimaksud tidak tersedia.</span></div>
                                </div>
                                <div class="col-md-12 inactive" id="dualUom">
                                    <div class="col-md-3 text-right"><label>DUAL UOM :</label></div>
                                    <div class="col-md-2">
                                        <input type="radio" name="dual_uom" class="dualuom" value="N"> No
                                    </div>
                                    <div class="col-md-1">
                                        <input type="radio" name="dual_uom" class="dualuom" value="Y"> Yes
                                    </div>
                                    <div class="col-md-3" id="dual_yes" style="display:none">
                                        <select id="isi_dual" name="isi_dual" class="form-control seletc2 kodeuom" style="width:100%"></select>
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive">
                                    <div class="col-md-3 text-right"><label>MAKE / BUY :</label></div>
                                    <div class="col-md-2">
                                        <input type="radio" name="make" class="makebuy" value="MAKE"> Make
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="make" class="makebuy" value="BUY"> Buy
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive">
                                    <div class="col-md-3 text-right"><label>STOCK :</label></div>
                                    <div class="col-md-2">
                                        <input type="radio" name="stock" class="stok" value="N"> No
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="stock" class="stok" value="Y"> Yes
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive">
                                    <div class="col-md-3 text-right"><label>NO. SERIAL :</label></div>
                                    <div class="col-md-2">
                                        <input type="radio" name="no_serial" class="noserial" value="N"> No
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="no_serial" class="noserial" value="Y"> Yes
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive">
                                    <div class="col-md-3 text-right"><label>INSPECT AT RECEIPT :</label></div>
                                    <div class="col-md-2">
                                        <input type="radio" name="inspect" class="inspek" value="N"> No
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="inspect" class="inspek" value="Y"> Yes
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive">
                                    <div class="col-md-3 text-right"><label>ORG. ASSIGN :</label></div>
                                    <div class="col-md-6">
                                        <select id="org_group" name="org_group[]" class="form-control seletc2 getorg_assign2" style="width:100%" data-placeholder="Pilih organization group">
                                            <option></option>
                                            <?php foreach ($org_group as $grup) { ?>
                                                <option value="<?= $grup['ORG_ASSIGN']?>"><?= $grup['GROUP_NAME']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive" id="tambahorg_assign">
                                    <div class="col-md-3 text-right"></div>
                                    <div class="col-md-6">
                                        <select id="org_assign1" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select>
                                    </div>
                                    <div class="col-md-1" style="text-align:left" id="tambahorg">
                                        <a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(6)" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                    </div>
                                <br><br></div>
                                <div class="col-md-12 inactive"><br>
                                    <div class="col-md-3 text-right"><label>PROSES LANJUT :</label></div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="odm" class="proses" value="ODM"> ODM
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="opm" class="proses" value="OPM"> OPM
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="jual" class="proses" value="JUAL"> JUAL
                                    </div>
                                <br><br></div>
                                <div class="col-md-12">
                                    <div class="col-md-3 text-right"><label>LATAR BELAKANG :</label></div>
                                    <div class="col-md-6">
                                        <input id="latar_belakang" name="latar_belakang" class="form-control" value="" placeholder="* Wajib diisi">
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="col-md-3 text-right"><label>KETERANGAN :</label></div>
                                    <div class="col-md-6">
                                        <textarea id="keterangan" name="keterangan" style="width:490px;height:100px"></textarea>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <button type="button" id="tambah_req" onclick="addrequest()" class="btn bg-orange"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                                </div>
                                <?php $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                                <div class="panel-body">
                                    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblongoingreq" style="width: 100%;">
                                        <thead style="background-color:#49D3F5">
                                            <tr class="text-nowrap">
                                                <th rowspan="2" style="vertical-align:middle">Status</th>
                                                <th rowspan="2" style="font-size:15px;vertical-align:middle"><?= $tambahan?>Kode Item<?= $tambahan?></th>
                                                <th rowspan="2" style="vertical-align:middle;"><?= $tambahan?>Deskripsi Item<?= $tambahan?></th>
                                                <th rowspan="2" style="vertical-align:middle">Uom</th>
                                                <th rowspan="2" style="vertical-align:middle">Dual Uom</th>
                                                <th rowspan="2" style="vertical-align:middle">Secondary UOM</th>
                                                <th rowspan="2" style="vertical-align:middle">Make/Buy</th>
                                                <th rowspan="2" style="vertical-align:middle">Stock</th>
                                                <th rowspan="2" style="vertical-align:middle">No. Serial</th>
                                                <th rowspan="2" style="vertical-align:middle">Inspect At Receipt</th>
                                                <th rowspan="2" style="vertical-align:middle">Org. Assign</th>
                                                <th colspan="3">Proses Lanjut</th>
                                                <th rowspan="2" style="vertical-align:middle">Keterangan</th>
                                                <th rowspan="2" style="vertical-align:middle">Action</th>
                                            </tr>
                                            <tr>
                                                <th>ODM</th>
                                                <th>OPM</th>
                                                <th>Jual</th>
                                            </tr>
                                        </thead>
                                        <tbody id="inirequest">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-body text-center">
                                <button type="button" id="submit_req" style="<?php echo $kode_seksi != '' ? '' : 'display:none'?>" onclick="submitrequest()" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>