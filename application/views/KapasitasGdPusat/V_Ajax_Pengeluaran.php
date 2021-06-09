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
                <td><input type="hidden" id="no<?= $i['NO_DOKUMEN']?>" value="<?= $no?>"><?= $no; ?></td>
                <td>
                    <span class="btn" style="background-color:inherit" id="check<?= $i['NO_DOKUMEN']?>" onclick="checkdokumenKGP(`<?= $i['NO_DOKUMEN']?>`)" >
                        <i id="checka<?= $i['NO_DOKUMEN']?>" class="fa fa-square-o checka"></i>
                    </span>
                    <input type="hidden" name="tandacheck[]" id="tandacheck<?= $i['NO_DOKUMEN']?>" value="check">
                </td>
                <td>
                    <input type="hidden" id="no_dokumen<?= $i['NO_DOKUMEN']?>" value="<?= $i['NO_DOKUMEN']?>"><?= $i['NO_DOKUMEN'] ?>
                    <!-- <br>
                    <button class="btn btn-primary btn-xs" onclick="detailDOK(`<?= $i['NO_DOKUMEN']?>`)" type="button" data-toggle="modal" data-target="#modalDetailDOK">
                        <i class="fa fa-cube"></i> Detail
                    </button> -->
                </td>
                <td><input type="hidden" id="jenis_dokumen<?= $i['NO_DOKUMEN']?>" value="<?= $i['JENIS_DOKUMEN']?>"><?= $i['JENIS_DOKUMEN']?></td>
                <td><input type="hidden" id="gudang<?= $i['NO_DOKUMEN']?>" value="<?= $i['GUDANG']?>"><?= $i['GUDANG'] ?></td>
                <td>
                    <input type="hidden" id="jumlah_item<?= $i['NO_DOKUMEN']?>" value="<?= $i['JUMLAH_ITEM']?>"><?= $i['JUMLAH_ITEM'] ?>
                    <?php if (!empty($i['MULAI'])) { ?>
                        <input type="hidden" id="mulai<?= $i['NO_DOKUMEN']?>" value="<?= $i['MULAI']?>">
                    <?php }else{?>
                        <input type="hidden" id="mulai<?= $i['NO_DOKUMEN']?>" value=""> 
                    <?php }?>
                </td>
                <td>
                <?php if (!empty($i['PIC'])) { ?>
                    <input id="pic<?= $i['NO_DOKUMEN']?>" name="pic[]" class="form-control text-center" style="width:100px" value="<?= $i['PIC']?>" readonly></td>
                <?php }else{?>
                    <select id="pic<?= $i['NO_DOKUMEN']?>" name="pic[]" class="form-control select2 picKGP" style="width:100%;" required>
                        <option></option>
                    </select> 
                <?php }?>
                </td>
                <td>
                <?php if (!empty($i['MULAI']) && empty($i['WAKTU'])) { ?>
                    <p id="timer<?= $i['NO_DOKUMEN']?>">
                        Mulai <?= $i['JAM_MULAI'] ?>
                    </p>
                    <input type="button" class="btn btn-md btn-danger" id="btnTimerKGP<?= $i['NO_DOKUMEN']?>" onclick="btnTimerKGP(`<?= $i['NO_DOKUMEN']?>`)" value="Selesai">
                <?php }else{?>
                    <p id="timer<?= $i['NO_DOKUMEN']?>" style="">
                        <label id="hours<?= $i['NO_DOKUMEN']?>" >00</label>:<label id="minutes<?= $i['NO_DOKUMEN']?>">00</label>:<label id="seconds<?= $i['NO_DOKUMEN']?>">00</label>
                    </p>
                    <input type="button" class="btn btn-md btn-success" id="btnTimerKGP<?= $i['NO_DOKUMEN']?>" onclick="btnTimerKGP(`<?= $i['NO_DOKUMEN']?>`)" value="Mulai"> 
                <?php }?>
                </td>
                <td>
                    <a class="btn btn-danger btn-sm" onclick="btnDeleteKGP(`<?= $i['NO_DOKUMEN']?>`)"><i class="fa fa-trash"></i>&nbsp; Hapus</a>
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

<!-- <div class="modal fade" id="modalfinishKGP" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="width:40%">
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
</div> -->

<div class="modal fade" id="modalDetailDOK" role="dialog" aria-labelledby="myModalLoading">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <b>
                    <span style="font-size: large;">Cek Item dan Quantity Terlebih Dahulu</span>
                    <!-- <span style="font-size: large;" id="nospbdetail"></span> -->
                </b>
            </div>
            <div class="modal-body">
                <div id="loadingAreaDetail" style="display: none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                </div>
                <div class="table_detail">
                    
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <h3 class="modal-title" style="text-align:center;"><b>Pilih PIC Finish</b></h3>
                    <select id="picfinish" name="picfinish" class="form-control select2 picKGP2" style="width:40%;">
                        <option></option>
                    </select>
                    <br><br>
                    <center>
                    <button class="btn btn-md btn-success" onclick="selesaikan()">FINISH</button>
                    </center>
                </div>
                <!-- <br>
                <br>
                <input type="button" class="btn btn-md btn-success" id="" onclick="selesaikan(this)" value="Selesaikan"> -->
            </div>
        </div>
    </div>
</div>