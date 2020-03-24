<style type="text/css">

# {
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
                        <!---->
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?= base_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b style="margin-right:700px; margin-left:50px;"><?= 'No Order : '.$id[0]['no_order']?></b>
                                <b>Edit Form Sparepart</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/saveSparepart/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                            <input type="hidden" class="no_order" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <div class="form-group">
                                                <label for="nm_spr" class="control-label">Nama Spare Part</label>
                                                <!-- <input type="text" name="nm_spr" id="sparepartAgent" class="form-control" placeholder="Nama Sparepart" required> -->
                                                <select style="height: 35px;" class="form-control select2 sparepart" id="sparepartAgent" name="nm_spr" data-placeholder="Nama Sparepart" tabindex="-1" aria-hidden="true">
												</select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="spek_spr" class="control-label">Spesifikasi</label>
                                                <input type="text" name="spek_spr" class="form-control" placeholder="Spesifikasi" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="jml_spr" class="control-label">Jumlah</label>
                                                <input type="number" name="jml_spr" class="form-control" placeholder="Jumlah" required>
                                            </div> <br />
                                            <div class="col-lg-12" style="padding-top: 8px;">
                                            <div style="text-align: center;">
                                                <button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-info" id="btnShow"><i class="fa fa-floppy-o"></i> SAVE</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    <!-- </div> -->
                                    </div>
                                </div>
                                <!--TABEL SPAREPART-->
                                <br>
                                <div class="" id="pg_3" aria-labelledby="#pg_3">
                                                <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblSparepart" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Nama Sparepart Yang Digunakan</th>
                                                            <th class="text-center">Spesifikasi</th>
                                                            <th class="text-center">Jumlah</th>
                                                            <th class="text-center">Action</th>
                                                            <th style="display:none">id</th>
                                                            <th style="display:none">no_order</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no = 1;
                                                            if (empty($viewSparepart)) {
                                                                // echo "<pre>";print_r($viewSparepart);exit();
                                                                echo 'Data Sparepart Belum Diisi';
                                                                $nama_sparepart = null;
                                                                $spesifikasi = null;
                                                                $jumlah = null;
                                                            }else{
                                                            foreach ($viewSparepart as $sp) {
                                                                $id = $sp['id_sparepart'];
                                                                $no_order = $sp['no_order'];
                                                                $nama_sparepart = $sp['nama_sparepart'];
                                                                $spesifikasi = $sp['spesifikasi'];                                                                
                                                                $jumlah = $sp['jumlah'];                                                                
                                                            ?>
                                                            <tr>
                                                            <td class="text-center posisi"><?php echo $no; ?></td>
                                                            <td><?php echo $nama_sparepart; ?></td>
                                                            <td><?php echo $spesifikasi; ?></td>
                                                            <td class="text-center"><?php echo $jumlah; ?></td>
                                                            <!-- href="<?php echo base_url('TicketingMaintenance/C_OrderList/deleteSparepart/'.$id)?>" -->
                                                            <td style="text-align:center;"><a class="btn btn-danger btn-sm" onclick="deleteSparepart(this)"> <i class="fa fa-trash"> Hapus</i></a></td>
                                                            <td style="display:none"><input type="hidden" class="id_sparepart" value="<?php echo $id;?>" name="idSparepart"></td>
                                                            <td style="display:none"><input type="hidden" name="no_order" value="<?php echo $no_order;?>"></td>
                                                            </tr> 
                                                            <?php
                                                                $no++; } }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                <!--TABEL SPAREPART-->
                                <div class="box-footer">
                                </div>
                                <div class="row" style="margin-left:90%;">
                                        <!-- <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button> -->
                                        <a href="<?php echo site_url('TicketingMaintenance/Agent/OrderList/detail/'.$no_order); ?>" class="btn btn-success btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                </div> 
                                <br/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL EDIT SPAREPART -->
<div class="modal fade" id="ModalEditSparepart" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
        	<section class="content">
			<?php //echo $nganggur['no_order'];//?>
				<form method="post" action="<?= base_url('TicketingMaintenance/Agent/OrderList/savePerkiraanSelesai/'); ?>">
					<input type="hidden" name="no_Order" id="no_Order" class="form-control" style="width: 350px">
					<div class="inner" style="padding-top: 20px">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h2><b><center>EDIT FORM SPAREPART</center></b></h2>
							</div>
							<div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/saveSparepart/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="col-lg-12">
                                            <input type="hidden" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <?php foreach ($viewSparepart as $sp) {
                                                $nama_sparepart = $sp['nama_sparepart'];
                                                $spesifikasi = $sp['spesifikasi'];                                                                
                                                $jumlah = $sp['jumlah'];                                                                
                                            } ?>
                                            <div class="form-group">
                                                <label for="nm_spr" class="control-label">Nama Spare Part</label>
                                                <input type="text" id="modalSparepart" name="nm_spr" class="form-control" placeholder="Nama Sparepart" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="spek_spr" class="control-label">Spesifikasi</label>
                                                <input type="text" id="modalSpesifikasi" name="spek_spr" class="form-control" placeholder="Spesifikasi" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="jml_spr" class="control-label">Jumlah</label>
                                                <input type="text" id="modalJumlah" name="jml_spr" class="form-control" placeholder="Jumlah" required>
                                            </div> <br />
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
										<div class="col-lg-12" style="padding-top: 8px;" >
											<div style="text-align: center;">
												<button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-success btn-md" id="btnSaveApprove"><i class="fa fa-save"></i> SAVE</button>
											</div>
										</div>
				                    	</div>
				             		</div>
				         		</div>
							</div>
							<!-- <div class="box box-warning"></div> -->
							</div>
						</div>
					</div>
				</form>
			</section>
        </div>
    </div>
</div>
<!-- MODAL EDIT SPAREPART END -->