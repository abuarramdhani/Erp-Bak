<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tbltrack').dataTable({
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Tracking/');?>">
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
                            <div class="box-header with-border"><b>Arsip</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tbltrack" style="width: 100%;">
                                            <thead style="background-color:#44e3d0; color:black">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Tanggal Input</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>Mulai Pelayanan</th>
                                                    <th>Selesai Pelayanan</th>
                                                    <th>Waktu Pelayanan</th>
                                                    <th>PIC Pengeluaran</th>
                                                    <th>Mulai Pengeluaran</th>
                                                    <th>Selesai Pengeluaran</th>
                                                    <th>Waktu Pengeluaran</th>
                                                    <th>PIC Pengeluaran</th>
                                                    <th>Mulai Packing</th>
                                                    <th>Selesai Packing</th>
                                                    <th>Waktu Packing</th>
                                                    <th>PIC Packing</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal Cancel</th>
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
                                                    <tr id="baris<?= $no?>">
                                                        <td class="<?= $td?>" ><?= $no; ?></td>
                                                        <td class="<?= $td?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><?= $val['JAM_INPUT']?></td>
                                                        <td class="<?= $td?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>"><?= $val['MULAI_PELAYANAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['SELESAI_PELAYANAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['WAKTU_PELAYANAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PELAYAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['MULAI_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['SELESAI_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['WAKTU_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PENGELUARAN'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['MULAI_PACKING'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['SELESAI_PACKING'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['WAKTU_PACKING'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['PIC_PACKING'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['URGENT'] ?>  <?= $val['BON'] ?></td>
                                                        <td class="<?= $td?>"><?= $val['CANCEL'] ?></td>
                                                    </tr>
                                                <?php $no++; $i++;  }?>
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
    </div>
</section>
