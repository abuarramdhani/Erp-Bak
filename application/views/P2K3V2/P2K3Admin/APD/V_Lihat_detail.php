<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/datamasuk/ApproveTIM');?>" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Approve Standar</b></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11"></div>
                            <div class="col-lg-1 "></div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Approval</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                            <b style="font-size: 24px;"><?php echo $seksi[0]['section_name']; ?></b>
                                                <br>
                                                <b>Permintaan update Standar Kebutuhan</b>
                                            <table style="width: 100%" class="table table-striped table-bordered table-hover text-center <?php echo (count($daftar_pekerjaan) < 4) ? 'p2k3_tbl_frezz_nos':'p2k3_tbl_frezz'; ?>">
                                                <thead>
                                                    <tr class="bg-info">
                                                        <th class="bg-info"><input type="checkbox" class="p2k3_chkAll"></th>
                                                        <th class="bg-info">No</th>
                                                        <th class="bg-info" style="min-width: 200px;">Nama APD</th>
                                                        <th class="bg-info" style="white-space: nowrap;">Kode Barang</th>
                                                        <th>Kebutuhan Umum</th>
                                                        <th>Staff</th>
                                                        <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                        <th><?php echo $key['pekerjaan'];?></th>
                                                        <?php } ?>
                                                        <th>Keterangan</th>
                                                        <th>Lampiran</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="DetailInputKebutuhanAPD">
                                                    <?php $a=1; foreach ($listToApprove as $key) { ?>
                                                    <tr style="color: #000;">
                                                        <td>
                                                            <input type="checkbox" class="p2k3_chk" name="id[]" value="<?php echo $key['id']; ?>">
                                                        </td>
                                                        <td id="nomor">
                                                            <?php echo $a; ?>
                                                        </td>
                                                        <td>
                                                            <a style="cursor:pointer; min-width: 200px;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
                                                        </td>
                                                        <td>
                                                            <a style="cursor:pointer;" class="p2k3_to_input"><?php echo $key['kode_item']; ?></a>
                                                            <input hidden="" value="<?php echo $key['kode_item']; ?>" class="p2k3_see_apd">
                                                        </td>
                                                        <td><?php echo $key['jml_kebutuhan_umum']; ?></td>
                                                        <td><?php echo $key['jml_kebutuhan_staff']; ?></td>
                                                        <?php $jml = explode(',', $key['jml_item']);
                                                        foreach ($jml as $row) { ?>
                                                        <td><?php echo $row; ?></td>
                                                        <?php  } ?>
                                                        <td><?=$key['keterangan']?></td>
                                                        <td>
                                                            <?php if (empty($key['lampiran'])): ?>
                                                                -   
                                                            <?php else: ?>
                                                                <a href="<?php echo base_url('assets/upload/P2K3DocumentApproval/'.$key['lampiran']); ?>" target="_blank" class="btn btn-danger">
                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                </a>
                                                            <?php endif ?>
                                                        </td>
                                                        <!-- <input name="id[]" hidden value="<?php echo $key['id']; ?>"> -->
                                                    </tr>
                                                    <?php $a++; } ?>
                                                </tbody>
                                            </table>
                                        <div class="panel-footer">
                                            <div class="row text-right" style="margin-right: 12px">
                                                <button onclick="return confirm('Apa anda yakin ingin Reject Data ini?')" class="btn btn-danger" type="submit" name="p2k3_action" value="reject">Reject</button>
                                                <button onclick="return confirm('Apa anda yakin ingin Approve Data ini?')" class="btn btn-success" type="submit" name="p2k3_action" value="approve">Approve</button>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div>                                            
                                           <h5 style="color: #000; font-weight: bold;">Standar kebutuhan Terakhir</h5>
                                           <table style="width: 100%" class="table table-striped table-bordered table-hover text-center <?php echo (count($daftar_pekerjaan) < 4) ? 'p2k3_tbl_frezz_nos':'p2k3_tbl_frezz'; ?>">
                                            <thead>
                                                <tr class="bg-info">
                                                     <th class="bg-info"><input type="checkbox" disabled=""></th>
                                                    <th class="bg-info">No</th>
                                                    <th class="bg-info" style="min-width: 200px;">Nama APD</th>
                                                    <th class="bg-info">Kode Barang</th>
                                                    <th>Kebutuhan Umum</th>
                                                    <th>Staff</th>
                                                    <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                    <th><?php echo $key['pekerjaan'];?></th>
                                                    <?php } ?>
                                                    <th>Keterangan</th>
                                                    <th>Lampiran</th>
                                                    <th>Tanggal Approve TIM</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DetailInputKebutuhanAPD">
                                                <?php $a=1; foreach ($listDahApprove as $key) { ?>
                                                <?php if (in_array($key['kode_item'], $idnya)): ?>
                                                    <tr style="color: #000; background-color: #c3ffb6">
                                                <?php else: ?>
                                                    <tr style="color: #000;">
                                                <?php endif ?>
                                                    <td>
                                                        <input type="checkbox" disabled="" style="cursor: not-allowed">
                                                    </td>
                                                        <td id="nomor"><?php echo $a; ?></td>
                                                        <td>
                                                            <a style="cursor:pointer; min-width: 200px;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
                                                        </td>
                                                        <td>
                                                            <a style="cursor:pointer;" class="p2k3_to_input"><?php echo $key['kode_item']; ?></a>
                                                            <input hidden="" value="<?php echo $key['kode_item']; ?>" class="p2k3_see_apd">
                                                        </td>
                                                        <td><?php echo $key['jml_kebutuhan_umum']; ?></td>
                                                        <td><?php echo $key['jml_kebutuhan_staff']; ?></td>
                                                        <?php 
                                                        $jml = explode(',', $key['jml_item']);
                                                        $ks = explode(',', $key['kd_pekerjaan']);
                                                        $arrItem = array_combine($ks, $jml);
                                                        foreach ($daftar_pekerjaan as $row) { ?>
                                                            <?php if (in_array($row['kdpekerjaan'], $ks)): ?>
                                                                <td><?= $arrItem[$row['kdpekerjaan']] ?></td>
                                                            <?php else: ?>
                                                                <td>0</td>
                                                            <?php endif ?>
                                                        <?php  } ?>
                                                        <td><?=$key['keterangan']?></td>
                                                        <td>
                                                            <?php if (empty($key['lampiran'])): ?>
                                                                -   
                                                            <?php else: ?>
                                                                <a href="<?php echo base_url('assets/upload/P2K3DocumentApproval/'.$key['lampiran']); ?>" target="_blank" class="btn btn-danger">
                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                </a>
                                                            <?php endif ?>
                                                        </td>
                                                        <td><?php echo $key['tgl_approve_tim']; ?></td>
                                                        <!-- <input name="id[]" hidden value="<?php echo $key['id']; ?>"> -->
                                                    </tr>
                                                    <?php $a++; } ?>
                                                </tbody>
                                            </table>
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    window.addEventListener('load', function () {
        $('.iCheck-helper').each(function(){
            if($(this).prev().is('div')){
                $(this).remove();
            }
        });
    });
</script>