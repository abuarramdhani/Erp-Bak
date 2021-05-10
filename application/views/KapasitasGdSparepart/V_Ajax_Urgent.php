<center><label>SPB/DOSP (URGENT) BELUM DILAYANI</label></center>
<div class="table-responsive">
  <div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan" id="tblUrgent" style="width: 100%;table-layout:fixed">
        <thead class="bg-primary">
            <tr>
                <th style="width:5%">No</th>
                <th style="width:7%">Check</th>
                <th>Tanggal</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Jumlah Item</th>
                <th>Jumlah Pcs</th>
                <th>Catatan Marketing</th>
                <th style="width: 200px;">PIC</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; $no=1; foreach($value as $val) {
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
                    <td class="<?= $td?>" width="20px">
                        <input type="hidden" id="no<?= $val['NO_DOKUMEN']?>" value="<?= $no?>">
                        <?= $no; ?>
                    </td>
                    <td class="<?= $td?>">
                        <span class="btn check_semua2" style="background-color:inherit" id="cek<?= $val['NO_DOKUMEN']?>" onclick="checkdata(`<?= $val['NO_DOKUMEN']?>`)" ><i id="ceka<?= $val['NO_DOKUMEN']?>" class="fa fa-square-o bisacek ceka"></i></span>
                        <input type="hidden" class="tandasemua" name="tandacek[]" id="tandacek<?= $val['NO_DOKUMEN']?>" value="cek">
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
                        <br>
                        <button class="btn btn-primary btn-xs" onclick="detailDOSP(`<?= $val['NO_DOKUMEN']?>`)" type="button" data-toggle="modal" data-target="#modalDetailDOSP">
                            <i class="fa fa-cube"></i> Detail
                        </button>
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
                        <?= $val['KETERANGAN']?>
                    </td>
                    <td class="<?= $td?>">
                    <?php if (!empty($val['PIC_PELAYAN'])) { 
                        foreach($noind as $n) {
                            if ($n['noind'] == $val['PIC_PELAYAN']) {
                                $nama = $val['PIC_PELAYAN'].'<br>'.$n['nama'];
                            }
                        }
                    ?>
                        <input type="hidden" id="pic<?= $val['NO_DOKUMEN']?>" name="picspb" class="form-control text-center" style="width:100%" value="<?= $val['PIC_PELAYAN']?>" readonly><?= $nama ?>
                    </td>
                    <?php } else { ?>
                        <select id="pic<?= $val['NO_DOKUMEN']?>" name="picspb" class="form-control select2 select2-hidden-accessible picSPBUrgent" style="width:100%;" required>
                            <option></option>
                        </select>
                    </td>
                    <?php }?>
                    <!-- <td class="<?= $td?>"><?= $val['URGENT']?>  <?= $val['BON'] ?> -->
                    <?php if (!empty($val['MULAI_PELAYANAN'])) { ?>
                        <input type="hidden" id="mulai<?= $val['NO_DOKUMEN']?>" value="<?= $val['JAM_PELAYANAN']?>">
                    <?php } else { ?>
                        <input type="hidden" id="mulai<?= $val['NO_DOKUMEN']?>" value="">
                    <?php } ?>
                    <!-- </td> -->
                    <td class="<?= $td?>">
                    <?php if (!empty($val['MULAI_PELAYANAN']) ) { ?> <!-- && empty($val['WAKTU_PELAYANAN']) -->
                        <p id="timer<?= $val['NO_DOKUMEN']?>" style="">
                            Mulai <?= $val['MULAI_PELAYANAN'] ?>
                        </p>
                        <input type="button" class="btn btn-md btn-danger" id="btnPelayanan<?= $val['NO_DOKUMEN']?>" onclick="btnPelayananSPB(`<?= $val['NO_DOKUMEN']?>`)" value="Selesai">
                    <?php } else { ?>
                        <p id="timer<?= $val['NO_DOKUMEN']?>" style="">
                            <label id="hours<?= $val['NO_DOKUMEN']?>" >00</label>:<label id="minutes<?= $val['NO_DOKUMEN']?>">00</label>:<label id="seconds<?= $val['NO_DOKUMEN']?>">00</label>
                        </p>
                        <input type="button" class="btn btn-md btn-success" id="btnPelayanan<?= $val['NO_DOKUMEN']?>" onclick="btnPelayananSPB(`<?= $val['NO_DOKUMEN']?>`)" value="Mulai"> 
                    <?php } ?>
                        <br><br>
                        <button type="button" class="btn btn-xs btn-info" id="btnrestartSPB<?= $val['NO_DOKUMEN']?>" onclick="btnRestartPelayanan(`<?= $val['NO_DOKUMEN']?>`)"><i class="fa fa-refresh"></i></button>
                        <button type="button" class="btn btn-xs btn-primary" id="btnpauseSPB<?= $val['NO_DOKUMEN']?>" onclick="btnPausePelayanan(`<?= $val['NO_DOKUMEN']?>`)"><i class="fa fa-pause"></i></button>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
    </div>
    <div class="text-right">
        <button class="btn btn-warning" onclick="startselectedPelayanan()"><i class="fa fa-play"></i> Start Selected</button>
        <button class="btn btn-danger" onclick="finishselectedPelayanan()"><i class="fa fa-stop"></i> Stop Selected</button>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#tblUrgent').DataTable({
    drawCallback: function(dt) {
      $(".picSPBUrgent").select2({
        allowClear: false,
        placeholder: "Pilih PIC",
        minimumInputLength: 2,
        ajax: {
            url: baseurl + "KapasitasGdSparepart/Pelayanan/getPIC",
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