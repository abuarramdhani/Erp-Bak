<form method="post" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Packing/')?>">
    <center><label>SPB/DOSP BELUM DIPACKING</label></center>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="datatable table table-bordered table-hover table-striped text-center tblpacking" id="tblPacking" style="width: 100%;table-layout:fixed">
                <thead style="background-color:#ffbd73;color:black">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Tanggal</th>
                        <th>Jenis Dokumen</th>
                        <th>No Dokumen</th>
                        <th>Jumlah Item</th>
                        <th>Jumlah Pcs</th>
                        <th>Ekspedisi</th>                        
                        <th style="width: 200px;">PIC</th>
                        <!-- <th>Keterangan</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($value as $val){
                        if ($val['TIPE'] == 'URGENT') {
                            $td = 'bg-danger';
                        } elseif ($val['TIPE'] == 'ECERAN') {
                            $td = 'bg-info';
                        } elseif ($val['TIPE'] == 'BEST AGRO') {
                            $td = 'bg-success';
                        } elseif ($val['TIPE'] == 'E-COMMERCE') {
                            $td = 'bg-warning';
                        } else {
                            $td = '';
                        }
                    ?>
                    <tr id="baris<?= $val['NO_DOKUMEN']?>">
                        <td width="20px" class="<?= $td?>"><?= $no; ?>
                        <?php if (!empty($val['MULAI_PACKING'])) { ?>
                            <input type="hidden" id="mulai<?= $val['NO_DOKUMEN']?>" value="<?= $val['JAM_PACKING']?>">
                        <?php } else { ?>
                            <input type="hidden" id="mulai<?= $val['NO_DOKUMEN']?>" value="">
                        <?php } ?>
                        </td>
                        <td class="<?= $td?>">
                            <input type="hidden" id="jam<?= $val['NO_DOKUMEN']?>" value="<?= $val['TGL_DIBUAT']?>">
                            <?= $val['TGL_DIBUAT']?>
                        </td>
                        <td class="<?= $td?>">
                            <input type="hidden" id="jenis<?= $val['NO_DOKUMEN']?>" value="<?= $val['JENIS_DOKUMEN']?>">
                            <?= $val['JENIS_DOKUMEN']?>
                        </td>
                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold">
                            <input type="hidden" id="nodoc<?= $val['NO_DOKUMEN']?>" value="<?= $val['NO_DOKUMEN']?>">
                            <?= $val['NO_DOKUMEN']?>
                        </td>
                        <td class="<?= $td?>">
                            <input type="hidden" id="jml_item<?= $val['NO_DOKUMEN']?>" value="<?= $val['JUMLAH_ITEM']?>">
                            <?= $val['JUMLAH_ITEM']?>
                        </td>
                        <td class="<?= $td?>">
                            <input type="hidden" id="jml_pcs<?= $val['NO_DOKUMEN']?>" value="<?= $val['JUMLAH_PCS']?>">
                            <?= $val['JUMLAH_PCS']?>
                        </td>
                        <td class="<?= $td?>">
                            <input type="hidden" id="eksp<?= $val['NO_DOKUMEN']?>" value="<?= $val['EKSPEDISI']?>">
                            <?= $val['EKSPEDISI']?>
                        </td>
                        <td class="<?= $td?>">
                        <?php if (!empty($val['PIC_PACKING'])) {
                            foreach($noind as $n) {
                                if ($n['noind'] == $val['PIC_PACKING']) {
                                    $nama = $val['PIC_PACKING'].'<br>'.$n['nama'];
                                }
                            }
                        ?>
                            <input type="hidden" id="pic<?= $val['NO_DOKUMEN']?>" name="pic" class="form-control text-center" style="width:100%" value="<?= $val['PIC_PACKING']?>" readonly><?= $nama ?>
                        </td>
                        <?php } else { ?>
                            <select id="pic<?= $val['NO_DOKUMEN']?>" name="pic" class="form-control select2 select2-hidden-accessible picSPBPacking" style="width:100%;" required>
                                <option></option>
                            </select>
                        <?php }?>
                        </td>
                        <!-- <td class="<?= $td?>">
                            <?= $val['TIPE']?>        
                        </td> -->
                        <td class="<?= $td?>">
                            <?php if (!empty($val['MULAI_PACKING']) && empty($val['WAKTU_PACKING'])) { ?>
                                <p id="timer<?= $val['NO_DOKUMEN']?>" style="">
                                    Mulai <?= $val['MULAI_PACKING']?>
                                </p>
                                <input type="button" class="btn btn-md btn-danger" id="btnPacking<?= $val['NO_DOKUMEN']?>" onclick="btnPackingSPB(`<?= $val['NO_DOKUMEN']?>`)" value="Selesaikan">
                                <br>
                                <!-- <button type="button" id="btnPack<?= $no?>" class="btn btn-warning" onclick="modalPacking(<?= $no?>)" style="margin-top:7px">Pack</button> -->
                            <?php } else { ?>
                                <p id="timer<?= $val['NO_DOKUMEN']?>" style="">
                                    <label id="hours<?= $val['NO_DOKUMEN']?>" >00</label>:<label id="minutes<?= $val['NO_DOKUMEN']?>">00</label>:<label id="seconds<?= $val['NO_DOKUMEN']?>">00</label>
                                </p>
                                <!-- <input type="button" class="btn btn-md btn-success" id="btnPacking<?= $val['NO_DOKUMEN']?>" onclick="btnPackingSPB(`<?= $val['NO_DOKUMEN']?>`)" value="Mulai"> -->
                                <input type="button" class="btn btn-md btn-success" id="btnPacking<?= $val['NO_DOKUMEN']?>" onclick="btnPackingSPB(`<?= $val['NO_DOKUMEN']?>`)" value="Mulai">
                                <br>
                                <!-- <button type="button" id="btnPack<?= $no?>" class="btn btn-warning" style="display:none;margin-top:7px" onclick="modalPacking(<?= $no?>)">Pack</button> -->
                            <?php } ?>
                            <br>
                            <button type="button" class="btn btn-xs btn-info" id="btnrestartSPB<?= $val['NO_DOKUMEN']?>" onclick="btnRestartPacking(`<?= $val['NO_DOKUMEN']?>`)" style="margin-top:7px">
                                <i class="fa fa-refresh"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-primary" id="btnpauseSPB<?= $val['NO_DOKUMEN']?>" onclick="btnPausePacking(`<?= $val['NO_DOKUMEN']?>`)" style="margin-top:7px">
                                <i class="fa fa-pause"></i>
                            </button>
                        </td>
                    </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
    $('#tblPacking').DataTable({
        drawCallback: function(dt) {
            $(".picSPBPacking").select2({
                allowClear: false,
                placeholder: "Pilih PIC",
                minimumInputLength: 2,
                ajax: {
                    url: baseurl + "KapasitasGdSparepart/Packing/getPIC",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term,
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        // console.log(data);
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.noind, text:obj.noind + ' - ' + obj.nama};
                            })
                        };
                    }
                }
            });
        }
    });        
</script>