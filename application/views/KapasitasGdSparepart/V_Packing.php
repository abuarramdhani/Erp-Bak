<script>
        $(document).ready(function () {
        $('.tblpacking').dataTable({
            "scrollX": true,
            paging:false,
            scrollY: 500,
            ordering: false,
        });
        $('.tblpacking2').dataTable({
            "scrollX": true,
        });
        
        });
</script>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('KapasitasGdSparepart/Packing/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Packing</b></div>
                            <div class="box-body">
                            <div class="col-md-12 text-right">
                                      <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                            </div>
                            <br>
                            <form method="post" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Packing/')?>">
                                    <center><label>DAFTAR KERJAAN BELUM RAMPUNG</label></center>
                                    <div class="panel-body">
                                        <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblpacking" style="width: 100%;table-layout:fixed">
                                            <thead style="background-color:#ffbd73;color:black">
                                                <tr>
                                                    <th width="20px">No</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>PIC</th>
                                                    <th>Keterangan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($value as $val){
                                                    if ($val['URGENT'] != '') {
                                                        $td = 'bg-danger';
                                                    }else{
                                                        $td = '';
                                                    }
                                                    ?>
                                                    <tr id="baris<?= $no?>">
                                                        <td width="20px" class="<?= $td?>"><?= $no; ?>
                                                        <?php if (!empty($val['MULAI_PACKING'])) { ?>
                                                            <input type="hidden" id="mulai<?= $no?>" value="<?= $val['MULAI_PACKING']?>">
                                                        <?php }else{?><input type="hidden" id="mulai<?= $no?>" value=""> <?php }?>
                                                        </td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="nodoc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>">
                                                        <?php if (!empty($val['PIC_PACKING'])) { ?>
                                                            <select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" disabled>
                                                            <option><?= $val['PIC_PACKING']?></option>
                                                        </select></td>
                                                        <?php }else{?>
                                                        <select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible picSPB" style="width:100%;" required>
                                                            <option></option>
                                                        </select><?php }?>
                                                        </td>
                                                        <td class="<?= $td?>"><?= $val['URGENT']?>  <?= $val['BON'] ?></td>
                                                        <td class="<?= $td?>">
                                                            <?php if (!empty($val['MULAI_PACKING']) && empty($val['WAKTU_PACKING'])) { ?>
                                                                <p id="timer<?= $no?>" style="">Mulai <?= $val['MULAI_PACKING']?></p>
                                                                <input type="button" class="btn btn-md btn-danger" id="btnPacking<?= $no?>" onclick="btnPackingSPB(<?= $no?>)" value="Selesai"><br>
                                                                <button type="button" id="btnPack<?= $no?>" class="btn btn-warning" onclick="modalPacking(<?= $no?>)" style="margin-top:7px">Pack</button>
                                                            <?php }else{?>
                                                                <p id="timer<?= $no?>" style=""><label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label></p>
                                                                <input type="button" class="btn btn-md btn-success" id="btnPacking<?= $no?>" onclick="btnPackingSPB(<?= $no?>)" value="Mulai"><br>
                                                                <button type="button" id="btnPack<?= $no?>" class="btn btn-warning" style="display:none;margin-top:7px" onclick="modalPacking(<?= $no?>)">Pack</button>
                                                            <?php }?><br>
                                                            <button type="button" class="btn btn-xs btn-info" id="btnrestartSPB<?= $no?>" onclick="btnRestartPacking(<?= $no?>)" style="margin-top:7px"><i class="fa fa-refresh"></i></button>
                                                            <button type="button" class="btn btn-xs btn-primary" id="btnpauseSPB<?= $no?>" onclick="btnPausePacking(<?= $no?>)" style="margin-top:7px"><i class="fa fa-pause"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php $no++; }?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </form>

                                <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpacking2" style="width: 100%;table-layout:fixed">
                                            <thead style="background-color:#ffbd73;color:black">
                                                <tr>
                                                    <th width="20px">No</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Selesai</th>
                                                    <th>Waktu</th>
                                                    <th>PIC</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; $no=1; foreach($data as $val){ 
                                                    if ($val['URGENT'] != '') {
                                                        $td = 'bg-danger';
                                                    }else{
                                                        $td = '';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="<?= $td?>" width="20px"><?= $no; ?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="mulai_packing<?= $no?>" value="<?= $val['MULAI_PACKING']?>"><?= $val['MULAI_PACKING']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="selesai_packing<?= $no?>" value="<?= $val['SELESAI_PACKING']?>"><?= $val['SELESAI_PACKING']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="waktu_packing<?= $no?>" value="<?= $val['WAKTU_PACKING'] ?>"><?= $val['WAKTU_PACKING'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PACKING']?></td>
                                                        <td class="<?= $td?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                    </tr>
                                                <?php $no++; $i++; }?>
                                            </tbody>
                                        </table>
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


<div class="modal fade" id="mdlcolly" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div id="datahidden"></div>
			</div>
			<div class="modal-body">
            <div class="panel-body">
                <div class="col-md-4 text-right">
                    <label>Pilih Kemasan</label>
                </div>
                <div class="col-md-5">
                    <select class="form-control select2" id="jenis_kemasan" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan">
                    <option></option>
                    <option value="1">KARDUS KECIL</option>
                    <option value="2">KARDUS SEDANG</option>
                    <option value="3">KARDUS PANJANG</option>
                    <option value="4">KARUNG</option>
                    <option value="5">PETI</option>
                    </select>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-4 text-right">
                    <label>Berat</label>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="berat" name="berat" placeholder="masukkan berat (KG)">
                    <span style="text-align:center;font-size:12px">*Gunakan titik (.) bukan koma (,) jika dibutuhkan saat menulis berat.</span>
                </div>
            </div>
            <center><span id="peringatan" style="color:red;"></span></center>
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger" onclick="savePacking(this)">SAVE</button>
                </div>
            </div>
		    </div>
            <div class="modal-footer">
		</div>
		</div>
	</div>
</div>