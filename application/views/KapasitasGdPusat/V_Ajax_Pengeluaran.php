<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_pglr_kgp" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>Check</th>
                <th>No. Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Gudang</th>
                <th>Jumlah Item</th>
                <th>PIC</th>
                <th>Timer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($get_data as $i) { ?>
            <tr>
                <td><input type="hidden" id="no<?= $no?>" value="<?= $no?>"><?= $no; ?></td>
                <td><span class="btn" style="background-color:inherit" id="check<?= $no?>" onclick="checkdokumenKGP(<?= $no?>)" >
                        <i id="checka<?= $no?>" class="fa fa-square-o checka"></i>
                    </span>
                    <input type="hidden" name="tandacheck[]" id="tandacheck<?= $no?>" value="check">
                </td>
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
                <td>
                    <a class="btn btn-danger btn-sm" onclick="btnDeleteKGP(<?= $no?>)"><i class="fa fa-trash"></i>&nbsp; Hapus</a>
                </td>
            </tr>
        <?php $no++; }?>
        </tbody>
    </table>
</div>

<div class="text-right">
    <button class="btn btn-warning" onclick="startselectedKGP()"><i class="fa fa-play"></i> Start Selected</button>
    <button class="btn btn-danger" onclick="finishselectedKGP()"><i class="fa fa-stop"></i> Stop Selected</button>
</div>

<div class="modal fade" id="modalfinishKGP" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top:200px;width:40%">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body">
                <h3 class="modal-title" style="text-align:center;"><b>Masukan PIC Finish</b></h3>
                <select id="picfinish" name="picfinish" class="form-control select2 picKGP2" style="width:100%;">
                    <option></option>
                </select>
                <br>
                <br>
                <center><button class="btn btn-danger" onclick="SaveFinishKGP()">FINISH</button></center>
		    </div>
		</div>
	</div>
</div>