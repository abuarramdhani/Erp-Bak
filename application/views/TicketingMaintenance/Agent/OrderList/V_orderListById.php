<style type="text/css">

#btnCetakOPPM {
    border-radius: 25px; 
}

#btnDoneOrder{
    border-radius: 25px;
}

</style>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('TicketingMaintenance/Agent/OrderList'); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <?php foreach ($orderById as $yoKuduDetail) { 
                        // echo "<pre>";print_r($yoKuduDetail);exit();
                    ?>
                    <?php 
                        if (empty($viewLaporanPerbaikan)) { //Checking Data Laporan Perbaikan
                            $lppb = null;
                        }else{
                            foreach ($viewLaporanPerbaikan as $lppb) { } 
                        }
                    ?>
                    <?php 
                        if (empty($viewDataReparasi)) { //Checking Data Reparasi    
                            $rprs = null;
                        }else{
                            foreach ($viewDataReparasi as $rprs) { }  
                    }?>
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-lg-4">
                                    <b><?= 'No Order : '.$yoKuduDetail['no_order']?></b>
                                </div>
                                <div class="col-lg-2">
                                    <b style="font-size:20px;">
                                        <?php if ($yoKuduDetail['perkiraan_selesai'] < date('Y-m-d') && $yoKuduDetail['status_order'] !== 'open' && $yoKuduDetail['status_order'] !== 'done' && $yoKuduDetail['status_order'] !== 'close') {
                                            echo "OVERDUE";
                                        }else{
                                            echo strtoupper($yoKuduDetail['status_order']);
                                        }
                                        ?>
                                    </b>
                                </div>
                                <div class="col-lg-6">
                                    <?php if ($yoKuduDetail['perkiraan_selesai'] <= date('Y-m-d') && $yoKuduDetail['status_order'] !== 'close' && $yoKuduDetail['status_order'] !== 'done' ) { ?> 
                                        <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiKeterlambatan/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Keterlambatan</a>
                                    <?php } elseif ($lppb == null && $rprs == null && $yoKuduDetail['status_order'] == 'acc' && $yoKuduDetail['status_order'] !== 'close') { ?>
                                        <?php if ($lppb !== null) { ?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporanEdit/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php }else{?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporan/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php } ?>
                                    <?php } elseif ($yoKuduDetail['status_order'] == 'done') { ?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiSparepartEdit/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Sparepart</a>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporanEdit/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                    <?php } elseif ($yoKuduDetail['status_order'] == 'action') { ?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiSparepart/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Sparepart</a>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiReparasi/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Riwayat Reparasi</a>
                                        <?php if ($lppb !== null) { ?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporanEdit/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm buttonIsiLaporan" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php }else{?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporan/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php } ?>
                                    <?php } elseif ($yoKuduDetail['status_order'] == 'reviewed' && $yoKuduDetail['status_order'] !== 'close') { ?>
                                        <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiSparepart/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Sparepart</a>
                                        <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiReparasi/'. $yoKuduDetail['no_order']) ?>" class="btn btn-default btn-sm" style="float:right;" type="button" onclick="#"><i class="fa fa-pencil"></i> Isi Riwayat Reparasi</a>   
                                        <?php if ($lppb !== null) { ?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporanEdit/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm buttonIsiLaporan" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php }else{?>
                                            <a href="<?= base_url('TicketingMaintenance/Agent/OrderList/isiLaporan/'. $yoKuduDetail['no_order']) ?>"  class="btn btn-default btn-sm" style="float:right;"><i class="fa fa-pencil"></i> Isi Laporan Perbaikan</a>
                                        <?php } ?>
                                    <?php } elseif ($yoKuduDetail['status_order'] == 'close') { ?>
                                        <span class="btn btn-danger" id="peringatan" style="color: white; margin-left:285px;" ><b>ORDER CLOSED</b></span>  
                                    <?php } else {} ?>
                                </div>
                            </div>
                            <div class="box-body">  
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-8">
                                    <!--BUTTON DONE-->
                                    <?php if (($yoKuduDetail['status_order'] == 'action') && $yoKuduDetail['perkiraan_selesai'] > date('Y-m-d')) { ?>
                                    <div class="col-lg-12" style="padding-top: 8px;">
                                        <div style="text-align:center;margin-left:780px;">
                                            <a type="button" onclick="AreYouSureWantToDoneYourOrder(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-success btn-3x" id="btnDoneOrder"><i class="fa fa-check"></i>  DONE</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <input type="hidden" name="no_order" class="idLaporan" value="<?= $yoKuduDetail['no_order'] ?>"> <br />
                                    <input type="hidden" name="no_order" class="noInduk" value="<?= $noInduk ?>"> <br />
                                        <table class="datatable table table-bordered text-left" style="">
                                            <tr>
                                                <td class="title">Nama Mesin</td>
                                                <td>: <?= $yoKuduDetail['nama_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">No Mesin</td>
                                                <td>: <?= $yoKuduDetail['nomor_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Line</td>
                                                <td>:  <?= $yoKuduDetail['line']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Analisis Kerusakan awal</td>
                                                <td>: <?= $yoKuduDetail['kerusakan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Due Date</td>
                                                <td>:  <?= $yoKuduDetail['perkiraan_selesai'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Reason Need by Date</td>
                                                <td>:  <?= $yoKuduDetail['reason_need_by_date'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Kondisi Mesin saat Order</td>
                                                <td>: <?= $yoKuduDetail['kondisi_mesin']?></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Running Hour</td>
                                                <td>: <?= $yoKuduDetail['running_hour']?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                                <!--NAVIGATION TAB AT THE BOTTOM-->
                            <?php if ($yoKuduDetail['status_order'] !== 'acc') { ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item active">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pg_1" role="tab" aria-controls="pg_1" aria-selected="true">Laporan Perbaikan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#pg_2" role="tab" aria-controls="pg_2" aria-selected="false">Riwayat Reparasi</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#pg_3" role="tab" aria-controls="pg_3" aria-selected="false">Sparepart</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#pg_4" role="tab" aria-controls="pg_4" aria-selected="false">Keterlambatan</a>
                                            </li>                            
                                        </ul>
                                        <!--TAB LAPORAN PERBAIKAN-->
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade active in" id="pg_1" role="tabpanel" aria-labelledby="#pg_1">
                                                <div class="col-lg-12"> <br />
                                                <table class="datatable table table-bordered text-left" style="">
                                                <?php
                                                if (empty($viewLaporanPerbaikan)){
                                                    echo 'Laporan Perbaikan Belum Diisi';
                                                        $kerusakan = null;
                                                        $penyebab_kerusakan = null;
                                                        $langkah_pencegahan = null;
                                                        $verifikasi_perbaikan = null;
                                                }else{
                                                    foreach ($viewLaporanPerbaikan as $pb) {
                                                        $kerusakan = $pb['kerusakan'];
                                                        $penyebab_kerusakan = $pb['penyebab_kerusakan'];
                                                        $langkah_pencegahan = $pb['langkah_pencegahan'];
                                                        $verifikasi_perbaikan = $pb['verifikasi_perbaikan'];
                                                    // echo "<pre>";print_r($pb);
                                                    // exit();
                                                } }
                                                ?>
                                                        <tr>
                                                            <td class="title">Kerusakan</td>
                                                            <td> <?= $kerusakan ?> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Penyebab Kerusakan</td>
                                                            <td> <?= $penyebab_kerusakan?> </td>
                                                            <tr>
                                                            </tr>
                                                            <td class="title" style="width:250px;">Langkah yang dilakukan</td>
                                                            <td>
                                                                <?php                                                            
                                                                if (empty($viewLangkahPerbaikan)) { 
                                                                    $urutan = null;
                                                                    $langkah = null;
                                                                }else{
                                                                    foreach ($viewLangkahPerbaikan as $lp) {
                                                                    // echo "<pre>";print_r($viewLangkahPerbaikan);
                                                                        $urutan = $lp['urutan'];
                                                                        $langkah = $lp['langkah'];
                                                                        echo $urutan.". ".$langkah."<br>";
                                                                } } 
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Langkah Pencegahan</td>
                                                            <td> <?= $langkah_pencegahan?> </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="title">Verifikasi Perbaikan</td>
                                                            <td> <?= $verifikasi_perbaikan?> </td>
                                                        </tr>
                                                            <?php  ?>
                                                    </table>
                                                </div>
                                            </div>
                                        <!--TAB RIWAYAT REPARASI-->
                                            <div class="tab-pane fade" id="pg_2" role="tabpanel" aria-labelledby="#pg_2">
                                                <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblReparasi" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Jam Mulai</th>
                                                            <th class="text-center">Jam Selesai</th>
                                                            <th class="text-center">Pelaksana</th>
                                                            <th class="text-center">Hapus</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no = 1;
                                                            if (empty($viewReparasi)) {
                                                                echo 'Riwayat Reparasi Belum Diisi';
                                                                $tanggal = null;
                                                                $jamMulai = null;
                                                                $jamSelesai = null;
                                                                $nama = null;
                                                                $id_reparasi = null;
                                                            }else{
                                                            // echo "<pre>";echo"here";print_r($viewAllReparation);exit();
                                                            foreach ($viewAllReparation as $rp) {
                                                                $tanggal = $rp['tgl_reparasi'];
                                                                $jamMulai = $rp['jam_mulai_reparasi'];                                                                
                                                                $jamSelesai = $rp['jam_selesai_reparasi'];                                                                
                                                                $nama = $rp['nama'];          
                                                                $id_reparasi = $rp['id_reparasi'];   
                                                                // echo"<pre>";echo $id_reparasi;                                                  
                                                            ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td class="text-center"><?php echo $tanggal; ?></td>
                                                            <td class="text-center"><?php echo $jamMulai; ?></td>
                                                            <td class="text-center"><?php echo $jamSelesai; ?></td>
                                                            <td><?php echo $nama; ?></td>
                                                            <td>
                                                            <div style="text-align: center;">
                                                                <a class="fa fa-times fa-2x" href="<?= base_url('TicketingMaintenance/Agent/OrderList/deleteRiwayatReparasi/'.$rp['no_order'].'/'.$id_reparasi) ?>" style="color:red" title="Hapus Elemen"></a>
                                                                <!-- <input type="text" class="form-control idRiwayatReparasi" name="idReparasi" value="<?php echo $id_reparasi ?>"> -->
                                                            </div>
                                                            </td>
                                                            </tr>
                                                            <?php $no++; } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <!--TAB SPAREPART-->
                                            <div class="tab-pane fade" id="pg_3" role="tabpanel" aria-labelledby="#pg_3">
                                                <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblSparepart" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Nama Sparepart Yang Digunakan</th>
                                                            <th class="text-center">Spesifikasi</th>
                                                            <th class="text-center">Jumlah</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no = 1;
                                                            if (empty($viewSparepart)) {
                                                                echo 'Data Sparepart Belum Diisi';
                                                                $nama_sparepart = null;
                                                                $spesifikasi = null;
                                                                $jumlah = null;
                                                            }else{
                                                            foreach ($viewSparepart as $sp) {
                                                                $nama_sparepart = $sp['nama_sparepart'];
                                                                $spesifikasi = $sp['spesifikasi'];                                                                
                                                                $jumlah = $sp['jumlah'];                                                                
                                                            ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $nama_sparepart; ?></td>
                                                            <td><?php echo $spesifikasi; ?></td>
                                                            <td><?php echo $jumlah; ?></td>
                                                            </tr> 
                                                            <?php
                                                                $no++; } }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <!--TAB KETERLAMBATAN-->
                                            <div class="tab-pane fade" id="pg_4" role="tabpanel" aria-labelledby="#pg_4">
                                                <div class="col-lg-12">
                                                <table class="datatable table table-striped table-bordered table-hover text-left" id="tblKeterlambatan" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Alasan Keterlambatan</th>
                                                            <th class="text-center">Waktu Mulai</th>
                                                            <th class="text-center">Waktu Selesai</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                            $no = 1;
                                                            // echo "<pre>";print_r($viewKeterlambatan);exit();
                                                            if (empty($viewKeterlambatan)) {
                                                                echo 'Alasan Keterlambatan Belum Diisi';
                                                                    $alasan = null;
                                                                    $waktu_mulai = null;
                                                                    $waktu_selesai = null;
                                                            }else{
                                                                foreach ($viewKeterlambatan as $kt) {
                                                                    $alasan = $kt['alasan'];
                                                                    $waktu_mulai = $kt['waktu_mulai'];                                                                
                                                                    $waktu_selesai = $kt['waktu_selesai'];                                                                
                                                        ?>
                                                            <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $alasan; ?></td>
                                                            <td><?php echo $waktu_mulai; ?></td>
                                                            <td><?php echo $waktu_selesai; ?></td>
                                                            </tr>
                                                            <?php
                                                                $no++;
                                                            } }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--TAB DONE-->
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>
                            <!--NAVIGATION TAB AT THE BOTTOM-->
                                
                                <!--give the button for print OPPM-->
                                    <div class="col-lg-12" style="padding-top: 8px;">
                                        <div style="text-align:center;">
                                            <a type="button" href="<?= base_url('TicketingMaintenance/Agent/OrderList/cetakOPPM/'. $yoKuduDetail['no_order']) ?>"  style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary btn-3x" id="btnCetakOPPM"><i class="fa fa-print "></i>  CETAK OPPM</a>
                                        </div>
                                    </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <?php }?>
                </div>
        </div>
    </div>
</section>

<!-- Modal REJECT-->
<div class="modal fade" id="ModalReject" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
        	<section class="content">
			<?php //echo $nganggur['no_order'];?>
				<form method="post" action="<?= base_url("TicketingMaintenance/Agent/OrderList/updateOverdueDate/") ?>">
					<input type="hidden" name="modalEditOverdue" value="<?= $yoKuduDetail['no_order'] ?>" id="no_OrderReject" class="form-control" style="width: 350px">	
					<div class="inner" style="padding-top: 20px">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h2><b><center>EDIT OVERDUE DATE</center></b></h2>
							</div>
							<div class="box-body">
						<div class="row" style="padding-top: 20px">
				    	    <div class="col-md-12" > <div class="table">
				                    <div class="panel-body">
										<div class="row">
											<div class="col-md-3" style="text-align: right;">
													<label>Overdue Date</label>
											</div>
											<div class="col-md-9">
												<div class="form-group">
                                                    <input type="date" value="<?= $yoKuduDetail['perkiraan_selesai'] ?>" name="revOverdueDate" class="form-control revOverdueDate" id="revOverdueDate" placeholder="Edit Overdue Date" required>													
												</div>
											</div>
										</div>
											<div class="row col-md-12" style="padding-top: 10px;">
												<div class="col-md-10"><button type="button" style="float: right;" class="btn btn-default btn-lg" data-dismiss="modal">CANCEL</button></div>
												<div class="col-md-2"><button type="submit" class=" btn btn-success btn-lg">SAVE</button></div>
											</div>
				                    	</div>
				             		</div>
				         		</div>
							</div>
							    <div class="box box-warning"></div>
							</div>
						</div>
					</div>
				</form>
			</section>
        </div>
    </div>
</div>
<!-- MODAL REJECT END -->