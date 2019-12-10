<script>
        $(document).ready(function () {
        $('.tblpengeluaran').dataTable({
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
                            <form method="post" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Pengeluaran/')?>">
                                    <center><label>DAFTAR KERJAAN BELUM RAMPUNG</label></center>
                                    <div class="panel-body">
                                        <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblpengeluaran" style="width: 100%;table-layout:fixed">
                                            <thead class="btn-success" style="color:yellow">
                                                <tr>
                                                    <th width="5px">No</th>
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
                                                <?php $no=1; foreach($value as $val){?>
                                                    <tr>
                                                        <td width="5px"><input type="hidden" id="mulai<?= $no?>" value=""><?= $no; ?></td>
                                                        <td><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td><select id="pic<?= $no?>" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" required>
                                                            <option></option>
                                                            <option value="ADI">ADI</option>
                                                            <option value="SANDRA">SANDRA</option>
                                                            <option value="RIZAL">RIZAL</option>
                                                            <option value="WAHYU">WAHYU</option>
                                                            <option value="DIKA">DIKA</option>
                                                        </select></td>
                                                        <td><?= $val['URGENT']?></td>
                                                        <td>
                                                            <p id="timer<?= $no?>" style=""><label id="hours<?= $no?>" >00</label>:<label id="minutes<?= $no?>">00</label>:<label id="seconds<?= $no?>">00</label></p>
                                                            <input type="button" class="btn btn-md btn-success" id="btnPengeluaran<?= $no?>" onclick="btnPengeluaranSPB(<?= $no?>)" value="Mulai">
                                                        </td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </form>

                                <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center>
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                    <table class="datatable table table-bordered table-hover table-striped text-center tblpengeluaran" style="width: 100%;">
                                            <thead class="btn-success" style="color:yellow">
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
                                                <?php $i=0; $no=1; foreach($data as $val){ ?>
                                                    <tr>
                                                        <td style="width: 5px"><?= $no; ?></td>
                                                        <td><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td><input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td style="font-size:17px; font-weight: bold"><input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td><input type="hidden" id="mulai_pengeluaran<?= $no?>" value="<?= $val['MULAI_PENGELUARAN']?>"><?= $val['MULAI_PENGELUARAN']?></td>
                                                        <td><input type="hidden" id="selesai_pengeluaran<?= $no?>" value="<?= $val['SELESAI_PENGELUARAN']?>"><?= $val['SELESAI_PENGELUARAN']?></td>
                                                        <td><input type="hidden" id="waktu_pengeluaran<?= $no?>" value="<?= $val['WAKTU_PENGELUARAN'] ?>"><?= $val['WAKTU_PENGELUARAN'] ?></td>
                                                        <td><?= $val['PIC_PENGELUARAN'] ?></td>
                                                        <td><?= $val['URGENT'] ?></td>
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
