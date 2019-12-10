<script>
    $(document).ready(function () {
        $('.tblpelayanan').dataTable({
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
                                                <th width="5px">No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis Dokumen</th>
                                                <th>No Dokumen</th>
                                                <th>Jumlah Item</th>
                                                <th>Jumlah Pcs</th>
                                                <th>PIC</th>
                                                <th>Status</th>
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
                                                <tr>
                                                    <td class="<?= $td?>" width="5px"><?= $no; ?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                    <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                    <td class="<?= $td?>"><select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" required>
                                                            <option></option>
                                                            <option value="SYAMSUL">SYAMSUL</option>
                                                            <option value="ALIF">ALIF</option>
                                                            <option value="IHSAN">IHSAN</option>
                                                            <option value="TRI">TRI</option>
                                                        </select></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="mulai<?= $no?>" value=""><?= $status[$i]?></td>
                                                    <td class="<?= $td?>"><?= $val['URGENT']?></td>
                                                    <td class="<?= $td?>">
                                                        <p id="timer<?= $no?>" style="">
                                                            <label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label>
                                                        </p>
                                                        <input type="button" class="btn btn-md btn-success" id="btnPelayanan<?= $no?>" disabled="disabled" onclick="btnPelayananSPB(<?= $no?>)" value="Mulai">
                                                    </td>
                                                </tr>
                                            <?php $no++; $i++; } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                                <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan" style="width: 100%;">
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
                                                        <td class="<?= $td?>"><?= $val['URGENT'] ?></td>
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
