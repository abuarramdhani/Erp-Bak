<style type="text/css">

#btnSaveKodeSeksi {
    border-radius: 25px; 
}

#blnDeleteKode {
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
                                <a class="btn btn-default btn-lg" href="">
                                    <i aria-hidden="true" class="fa fa-ticket fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Input Kode Seksi</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/C_Orderlist/saveMasterKodeSeksi/'); ?>" method="post">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                            <div class="form-group">
                                                <label for="nm_spr" class="control-label">Nama Seksi</label>
                                                <select style="height: 35px;" class="form-control select2 kodeNamaSeksi" id="kodeNamaSeksi" name="nm_seksi" data-placeholder="Pilih Nama Seksi" tabindex="-1" aria-hidden="true">
                                                </select>
                                            </div><br />
                                            <div class="form-group">
                                                <label for="spek_spr" class="control-label">Kode Seksi</label>
                                                <input type="text" name="kode_seksi" class="form-control kodeSeksi" placeholder="Buat Kode Seksi" maxlength="3" oninput="this.value = this.value.toUpperCase()" required>
                                            </div><br />
                                        </div>
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-12" style="padding-top: 8px;" >
                                            <div style="text-align: center;">
                                                <button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-success btn-md" id="btnSaveKodeSeksi"><i class="fa fa-save fa-md"></i>  SAVE</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    <!-- </div> -->
                                    </div>
                                </div>
                                <!--TABEL SPAREPART-->
                                <br>
                                <div class="box-header with-border">
                                    <b>Daftar Kode Seksi</b>
                                </div>
                                <div class="" id="pg_3" aria-labelledby="#pg_3">
                                                <div class="col-lg-12">
                                                    <br />
                                                    <table class="datatable table table-striped table-bordered table-hover text-left tblKodeSeksi" id="tblKodeSeksi" style="">
                                                        <thead class="bg-primary">
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Nama Seksi</th>
                                                            <th class="text-center">Kode Seksi</th>
                                                            <th class="text-center">Action</th>
                                                            <th class="text-center" style="display:none">ID</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no = 1;
                                                            if (empty($selectKodeSeksi)) {
                                                            }else{
                                                            foreach ($selectKodeSeksi as $ks) {
                                                                $id = $ks['id_seksi'];
                                                                $nama_seksi = $ks['nama_seksi'];
                                                                $kode_seksi = $ks['kode_seksi'];
                                                            ?>
                                                            <tr>
                                                            <td class="text-center posisi"> <?php echo $no; ?></td>
                                                            <td><?php echo $nama_seksi; ?></td>
                                                            <td class="text-center"><?php echo $kode_seksi; ?></td>
                                                            <td style="text-align:center; width:10%;"><a class="btn btn-danger btn-sm" id="blnDeleteKode" onclick="deleteMasterKodeSeksi(this)"> <i class="fa fa-trash"> HAPUS</i></a></td>                                                          
                                                            <td style="display:none"><input type="hidden" class="id_kode" value="<?php echo $id;?>" name="idKodeSeksi"></td>
                                                            </tr> 
                                                            <?php $no++; } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                <!--TABEL SPAREPART-->
                                <div class="box-footer">
                                </div>
                                <div class="row" style="margin-left:90%;">
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
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<!-- MODAL EDIT SPAREPART END -->