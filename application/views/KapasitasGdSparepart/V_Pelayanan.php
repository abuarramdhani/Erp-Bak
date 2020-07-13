<script>
    $(document).ready(function () {
        $('.tblpelayanan').dataTable({
            "scrollX": true,
            scrollY: 500,
            ordering: false,
            paging:false,
        });

        $('.tblpelayanan2').dataTable({
            "scrollX": true,
            ordering: false
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
                                    href="<?php echo site_url('KapasitasGdSparepart/Pelayanan/');?>">
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
                            <div class="box-header with-border"><b>Pelayanan</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <center><label>DAFTAR KERJAAN BELUM RAMPUNG</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan" style="width: 100%;table-layout:fixed">
                                        <thead class="bg-primary">
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
                                            <?php $i=0; $no=1; foreach($value as $val) {
                                                if ($val['URGENT'] != '') {
                                                    $td = 'bg-danger';
                                                }else{
                                                    $td = '';
                                                }
                                            ?>
                                                <tr id="baris<?= $no?>">
                                                    <td class="<?= $td?>" width="20px"><input type="hidden" id="no<?= $no?>" value="<?= $no?>"><?= $no; ?></td>
                                                    <td class="<?= $td?>"><span class="btn check_semua2" style="background-color:inherit" id="cek<?= $no?>" onclick="checkdata(<?= $no?>)" ><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka"></i></span>
                                                        <input type="hidden" class="tandasemua" name="tandacek[]" id="tandacek<?= $no?>" value="cek"></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jenis<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                    <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="nodoc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                    <td class="<?= $td?>">
                                                        <?php if (!empty($val['PIC_PELAYAN'])) { ?>
                                                            <select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" disabled>
                                                            <option value="<?= $val['PIC_PELAYAN']?>"><?= $val['PIC_PELAYAN']?></option>
                                                        </select></td>
                                                        <?php }else{?>
                                                            <select id="pic<?= $no?>" name="picSPB" class="form-control select2 select2-hidden-accessible picSPB" style="width:100%;" required>
                                                            <option></option>
                                                        </select></td>
                                                        <?php }?>
                                                    <td class="<?= $td?>"><?= $val['URGENT']?>  <?= $val['BON'] ?>
                                                        <?php if (!empty($val['MULAI_PELAYANAN'])) { ?>
                                                            <input type="hidden" id="mulai<?= $no?>" value="<?= $val['JAM_PELAYANAN']?>">
                                                        <?php }else{?><input type="hidden" id="mulai<?= $no?>" value=""> <?php }?>
                                                    </td>
                                                    <td class="<?= $td?>">
                                                        <?php if (!empty($val['MULAI_PELAYANAN']) && empty($val['WAKTU_PELAYANAN'])) { ?>
                                                            <p id="timer<?= $no?>" style="">
                                                                Mulai <?= $val['MULAI_PELAYANAN'] ?>
                                                            </p>
                                                            <input type="button" class="btn btn-md btn-danger" id="btnPelayanan<?= $no?>" onclick="btnPelayananSPB(<?= $no?>)" value="Selesai">
                                                        <?php }else{?>
                                                            <p id="timer<?= $no?>" style="">
                                                                <label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label>
                                                            </p>
                                                            <input type="button" class="btn btn-md btn-success" id="btnPelayanan<?= $no?>" onclick="btnPelayananSPB(<?= $no?>)" value="Mulai"> 
                                                        <?php }?><br><br>
                                                        <button type="button" class="btn btn-xs btn-info" id="btnrestartSPB<?= $no?>" onclick="btnRestartPelayanan(<?= $no?>)"><i class="fa fa-refresh"></i></button>
                                                        <button type="button" class="btn btn-xs btn-primary" id="btnpauseSPB<?= $no?>" onclick="btnPausePelayanan(<?= $no?>)"><i class="fa fa-pause"></i></button>
                                                    </td>
                                                </tr>
                                            <?php $no++; $i++; } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-warning" onclick="startselectedPelayanan()"><i class="fa fa-play"></i> Start Selected</button>
                                        <button class="btn btn-danger" onclick="startselectedPelayanan()"><i class="fa fa-stop"></i> Stop Selected</button>
                                    </div>
                                </div>

                                <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan2" style="width: 100%;">
                                            <thead class="bg-primary">
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
                                                <?php $i= 0 ;$no=1; foreach($data as $val) { 
                                                    if ($val['URGENT'] != '') {
                                                        $td = 'bg-danger';
                                                    }else{
                                                        $td = '';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="<?= $td?>" style="width: 5px"><?= $no; ?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="mulai_pelayanan<?= $no?>" value="<?= $val['MULAI_PELAYANAN']?>"><?= $val['MULAI_PELAYANAN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="selesai_pelayanan<?= $no?>" value="<?= $val['SELESAI_PELAYANAN']?>"><?= $val['SELESAI_PELAYANAN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="waktu_pelayanan<?= $no?>" value="<?= $val['WAKTU_PELAYANAN'] ?>"><?= $val['WAKTU_PELAYANAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PELAYAN']?></td>
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
