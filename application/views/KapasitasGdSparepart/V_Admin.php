<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tblAdmin').dataTable({
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
                                    href="<?php echo site_url('KapasitasGdSparepart/Admin/');?>">
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
                            <div class="box-header with-border"><b>Admin</b></div>
                            <div class="box-body">
                            <div class="col-md-12 text-center">
                                      <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                      <br>
                                      <br>
                                      <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
                            </div>
                            <br>
                                <div class="panel-body">
                                    <div class="col-md-12" align="center">
                                        <input type="button" id="btnAdmin" class="btn btn-lg btn-success" onclick="btnAdminSPB(this)" value="Mulai Allocate">
                                        <br><br>
                                        <div class="col-md-3" align="center" style="float:none; margin: 0 auto">
                                            <label class="control-label">Jumlah SPB/DOSP</label>
                                            <input id="jml_spb" name="jml_spb[]" class="form-control pull-right text-center inputQTY">
                                            <!-- <p style="font-size:10px">*masukan jumlah lalu tekan enter untuk menghidupkan tombol Finish</p> -->
                                            <input type="hidden" id="idunix" value="">
                                            <input type="hidden" id="mulai" value="">
                                        </div>
                                    </div>
                                </div>
                                <br><br>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblAdmin" style="width: 100%; table-layout:fixed">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th width="10px">No</th>
                                                    <th>Jumlah SPB/DOSP</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Selesai</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i= 0; $no=1; foreach($tampil as $val){ ?>
                                                    <tr>
                                                        <td style="width: 10px"><?= $no; ?></td>
                                                        <td><input type="hidden" id="jml_spb" value="<?= $val['JUMLAH_SPB']?>"><?= $val['JUMLAH_SPB']?></td>
                                                        <td><input type="hidden" id="mulai_allocate" value="<?= $val['MULAI_ALLOCATE']?>"><?= $val['MULAI_ALLOCATE']?></td>
                                                        <td><input type="hidden" id="selesai_allocate" value="<?= $val['SELESAI_ALLOCATE']?>"><?= $val['SELESAI_ALLOCATE']?></td>
                                                        <td><input type="hidden" id="waktu_allocate" value="<?= $val['WAKTU_ALLOCATE']; ?>"><?= $val['WAKTU_ALLOCATE']; ?></td>
                                                    </tr>
                                                <?php $no++; $i++; } ?>
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
