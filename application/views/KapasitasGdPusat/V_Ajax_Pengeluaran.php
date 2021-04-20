<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_pglr_kgp" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>No. Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Gudang</th>
                <th>Jumlah Item</th>
                <th>PIC</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($get_data as $i) { ?>
            <tr>
                <td><?= $no?></td>
                <td><input type="hidden" id="no_dokumen<?= $no?>" value="<?= $i['NO_DOKUMEN']?>"><?= $i['NO_DOKUMEN'] ?></td>
                <td><input type="hidden" id="jenis_dokumen<?= $no?>" value="<?= $i['JENIS_DOKUMEN']?>"><?= $i['JENIS_DOKUMEN']?></td>
                <td><input type="hidden" id="gudang<?= $no?>" value="<?= $i['GUDANG']?>"><?= $i['GUDANG'] ?></td>
                <td>
                    <input type="hidden" id="jumlah_item<?= $no?>" value="<?= $i['JUMLAH_ITEM']?>"><?= $i['JUMLAH_ITEM'] ?>
                    <?php if (!empty($i['MULAI'])) { ?>
                        <input type="hidden" id="mulai<?= $no?>" value="<?= $i['MULAI']?>">
                    <?php }else{?>
                        <input type="hidden" id="mulai<?= $no?>" value=""> 
                    <?php }?>
                </td>
                <td>
                <?php if (!empty($i['PIC'])) { ?>
                    <input id="pic<?= $no?>" name="pic[]" class="form-control text-center" style="width:100px" value="<?= $i['PIC']?>" readonly></td>
                <?php }else{?>
                    <select id="pic<?= $no?>" name="pic[]" class="form-control select2 picKGP" style="width:100%;" required>
                        <option></option>
                    </select> 
                <?php }?>
                </td>
                <td>
                <?php if (!empty($i['MULAI']) && empty($i['WAKTU'])) { ?>
                    <p id="timer<?= $no?>">
                        Mulai <?= $i['JAM_MULAI'] ?>
                    </p>
                    <input type="button" class="btn btn-md btn-danger" id="btnTimerKGP<?= $no?>" onclick="btnTimerKGP(<?= $no?>)" value="Selesai">
                <?php }else{?>
                    <p id="timer<?= $no?>" style="">
                        <label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label>
                    </p>
                    <input type="button" class="btn btn-md btn-success" id="btnTimerKGP<?= $no?>" onclick="btnTimerKGP(<?= $no?>)" value="Mulai"> 
                <?php }?>
                </td>
                <!-- <td><select id="pic<?= $no?>" name="pic[]" class="form-control select2 picKGP" style="width:100%"></select></td>
                <td class="text-center">
                    <p id="timer<?= $no?>" style="">
                        <label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label>
                        <input type="hidden" id="jam<?= $no?>" value="00">
                        <input type="hidden" id="menit<?= $no?>" value="00">
                        <input type="hidden" id="detik<?= $no?>" value="00">
                    </p>
                    <input type="button" class="btn btn-sm btn-success" id="button_mulai<?php echo $no ?>"  onclick="btnTimerKGP(<?= $no?>, 'mulai')" value="Mulai">
                    <input type="button" class="btn btn-sm btn-danger" id="button_selesai<?php echo $no ?>" style="display:none" onclick="btnTimerKGP(<?= $no?>,'')" value="Selesai">
                    <br><br>
                </td> -->
            </tr>
        <?php $no++; }?>
        </tbody>
    </table>
</div>