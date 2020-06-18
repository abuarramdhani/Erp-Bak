<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" class="form-horizontal" action="<?php echo site_url('P2K3_V2/Order/submitStandar');?>" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Approve Standar</b></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary" style="">
                                <div class="panel-body">
                                    <div class="row">
                                        <div style="margin-left: 10px;" class="col-lg-1">
                                            <div class="form-group">
                                                <label class="control-label">Departement</label> <br>
                                                <label class="control-label">Bidang</label> <br>
                                                <label class="control-label">Unit</label> <br>
                                                <label class="control-label">Seksi</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="control-label">: <?php echo $seksi[0]["dept"] ?></label> <br>
                                                <label class="control-label">: <?php echo $seksi[0]["bidang"] ?></label> <br>
                                                <label class="control-label">: <?php echo $seksi[0]["unit"] ?></label> <br>
                                                <?php foreach ($listKs as $key): ?>
                                                <label class="control-label">: <?php echo $key['seksi'] ?></label> <button type="button" class="btn btn-xs p2k3_detail_seksi" value="<?php echo $key['kodesie'] ?>">Details</button><br/>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Approval</div>
                                <div class="box-body">
                                    <div class="panel-body" style="overflow-x: scroll;">
                                        <?php foreach ($refseksi as $rs): ?>
                                        <div class="col-md-12 p2k3_cektable">
                                            <h3 style="text-align: center;"><?= $rs['seksi'].'('.$rs['kodesie'].')' ?></h3>
                                            <table class="table table-striped table-bordered table-hover text-center">
                                                <thead>
                                                    <tr class="bg-info">
                                                        <th><input type="checkbox" class="p2k3_chkAll"></th>
                                                        <th>Nama APD</th>
                                                        <th>Kode Barang</th>
                                                        <th>Kebutuhan Umum</th>
                                                        <th>Staff</th>
                                                        <?php foreach ($daftar_pekerjaan as $dp) {
                                                            if(substr($dp['kdpekerjaan'], 0, 7) != $rs['kodesie']) continue;
                                                         ?>
                                                        <th><?php echo $dp['pekerjaan'];?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="DetailInputKebutuhanAPD">
                                                    <?php $a=1; foreach ($inputStandar as $key) {
                                                        if($key['kodesie'] != $rs['kodesie']) continue;
                                                    ?>
                                                    <tr style="color: #000;">
                                                        <td id="nomor"><input type="checkbox" class="p2k3_chk" name="p2k3_idStandar[]" value="<?php echo $key['id']; ?>"></td>
                                                        <td>
                                                            <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
                                                        </td>
                                                        <td>
                                                            <a style="cursor:pointer;" class="p2k3_to_input"><?php echo $key['kode_item']; ?></a>
                                                            <input hidden="" value="<?php echo $key['kode_item']; ?>" class="p2k3_see_apd">
                                                        </td>
                                                        <td><?php echo $key['jml_kebutuhan_umum']; ?></td>
                                                        <td><?php echo $key['jml_kebutuhan_staff']; ?></td>
                                                        <?php $jml = explode(',', $key['jml_item']);
                                                        foreach ($jml as $key) { ?>
                                                        <td><?php echo $key; ?></td>
                                                        <?php  } ?>
                                                    </tr>
                                                    <?php $a++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endforeach ?>
                                        <div class="panel-footer">
                                            <div class="row text-right" style="margin-right: 12px">
                                                <button onclick="return confirm('Apa anda yakin ingin Reject Data yang dipilih?')" class="btn btn-danger p2k3_btn_approve" type="submit" name="p2k3_action" value="reject">Reject</button>
                                                <button onclick="return confirm('Apa anda yakin ingin Approve Data yang dipilih?')" class="btn btn-success p2k3_btn_approve" type="submit" name="p2k3_action" value="approve">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div class="modal fade" id="p2k3_detail_pekerja" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Pekerja</h4>
            </div>
            <div class="modal-body">
                <!-- Place to print the fetched phone -->
                <div id="phone_result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>