<script>
        $(document).ready(function () {
        $('.tblpengeluaran').dataTable({
            "scrollX": true,
            scrollY: 500,
            ordering: false,
            paging:false,
        });

        $('.tblpengeluaran2').dataTable({
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
                                    href="<?php echo site_url('KapasitasGdSparepart/Pengeluaran/');?>">
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
                            <div class="box-header with-border"><b>Pengeluaran</b></div>
                            <div class="box-body">
                            <div class="col-md-12 text-right">
                                      <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                            </div>
                            <br>
                            <!-- <form method="post" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Pengeluaran/')?>"> -->
                                    <center><label>DAFTAR KERJAAN BELUM RAMPUNG</label></center>
                                    <div class="panel-body">
                                        <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblpengeluaran" style="width: 100%;table-layout:fixed">
                                            <thead class="btn-success">
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th style="width:7%">Check</th>
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
                                                        <td class="<?= $td?>" width="20px"><input type="hidden" id="no<?= $no?>" value="<?= $no?>"><?= $no; ?>
                                                        <?php if (!empty($val['MULAI_PENGELUARAN'])) { ?>
                                                            <input type="hidden" id="mulai<?= $no?>" value="<?= $val['JAM_PENGELUARAN']?>">
                                                        <?php }else{?><input type="hidden" id="mulai<?= $no?>" value=""> <?php }?>
                                                        </td>
                                                        <td class="<?= $td?>"><span class="btn check_semua2" style="background-color:inherit" id="cek<?= $no?>" onclick="checkdata(<?= $no?>)" ><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka"></i></span>
                                                        <input type="hidden" class="tandasemua" name="tandacek[]" id="tandacek<?= $no?>" value="cek"></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="nodoc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>">
                                                        <?php if (!empty($val['PIC_PENGELUARAN'])) { ?>
                                                            <!-- <select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" disabled>
                                                            <option value="<?= $val['PIC_PENGELUARAN']?>"><?= $val['PIC_PENGELUARAN']?></option>
                                                        </select> -->
                                                        <input id="pic<?= $no?>" name="pic" class="form-control text-center" style="width:100px" value="<?= $val['PIC_PENGELUARAN']?>" readonly>
                                                        <?php }else{?><select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible picSPB3" style="width:100%;">
                                                            <option></option>
                                                        </select> <?php }?>
                                                        </td>
                                                        <td class="<?= $td?>"><?= $val['URGENT']?>  <?= $val['BON'] ?></td>
                                                        <td class="<?= $td?>">
                                                            <?php if (!empty($val['MULAI_PENGELUARAN']) && empty($val['WAKTU_PENGELUARAN'])){ ?>
                                                                <p id="timer<?= $no?>" style="">Mulai <?= $val['MULAI_PENGELUARAN']?></p>
                                                                <input type="button" class="btn btn-md btn-danger" id="btnPengeluaran<?= $no?>" onclick="btnPengeluaranSPB(<?= $no?>)" value="Selesai">
                                                            <?php }else{?>
                                                                <p id="timer<?= $no?>" style=""><label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label></p>
                                                                <input type="button" class="btn btn-md btn-success" id="btnPengeluaran<?= $no?>" onclick="btnPengeluaranSPB(<?= $no?>)" value="Mulai"> 
                                                            <?php }?><br><br>
                                                            <button type="button" class="btn btn-xs btn-info" id="btnrestartSPB<?= $no?>" onclick="btnRestartPengeluaran(<?= $no?>)"><i class="fa fa-refresh"></i></button>
                                                            <button type="button" class="btn btn-xs btn-primary" id="btnpauseSPB<?= $no?>" onclick="btnPausePengeluaran(<?= $no?>)"><i class="fa fa-pause"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-warning" onclick="startselectedPengeluaran()"><i class="fa fa-play"></i> Start Selected</button>
                                            <button class="btn btn-danger" onclick="finishselectedPengeluaran()"><i class="fa fa-stop"></i> Stop Selected</button>
                                        </div>
                                    </div>
                                <!-- </form> -->

                                <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpengeluaran2" style="width: 100%;">
                                            <thead class="btn-success">
                                                <tr>
                                                    <th>No</th>
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
                                                        <td class="<?= $td?>" ><?= $no; ?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="mulai_pengeluaran<?= $no?>" value="<?= $val['MULAI_PENGELUARAN']?>"><?= $val['MULAI_PENGELUARAN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="selesai_pengeluaran<?= $no?>" value="<?= $val['SELESAI_PENGELUARAN']?>"><?= $val['SELESAI_PENGELUARAN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="waktu_pengeluaran<?= $no?>" value="<?= $val['WAKTU_PENGELUARAN'] ?>"><?= $val['WAKTU_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['URGENT'] ?> <?= $val['BON'] ?></td>
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

<div class="modal fade" id="mdlfinishpglr" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top:200px;width:40%">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Masukan PIC Finish</b></h3>
            <select id="picfinish" name="picfinish" class="form-control select2 picSPB3" style="width:100%;">
                <option></option>
            </select>
            <br>
            <br>
                <center><button class="btn btn-danger" onclick="savefinish2()">FINISH</button></center>
		    </div>
		</div>
	</div>
</div>