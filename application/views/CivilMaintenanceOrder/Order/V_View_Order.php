<style>
    .dataTables_filter{
        float: right;
    }
    .buttons-excel{
        background-color: green;
        color: white;
    }
    .lblmt label{
        margin-top: 5px;
    }
    .ellipse{
        white-space: nowrap; 
        text-overflow: ellipsis; 
        overflow: hidden;
    }
    .succes-update{
        border: 1px solid green;
    }
    .headPost{
        border: 1px solid #aaa; 
        background-color: #FFE0B3;
        padding-left: 10px;
        padding-right: 10px;
    }
    .headPost2{
        border: 1px solid #aaa; 
        background-color: #C3D9FF;
        padding-left: 10px;
        padding-right: 10px;
    }
    .bodyPost{
        padding: 10px;
        border: 1px solid #aaa;
        background-color: #fafafa;
        font-size: 15px;
    }
    .izi{
        margin-top: 5px;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body lblmt cmo_ifchange">
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label>Order Dari</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= $order['pengorder'].' - '.$order['dari'] ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Tanggal Order</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= date('d-M-Y', strtotime($order['tgl_order'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Penerima Order</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                           : <?= $order['penerima_order'].' - '.$order['ke'] ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Tanggal Terima</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= date('d-M-Y', strtotime($order['tgl_terima'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Jenis Pekerjaan</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= $order['jenis_pekerjaan'] ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Jenis Order</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= $order['jenis_order'] ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Judul Order</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= $order['judul'] ?> <?= (!empty($order['ket'])) ? '('.$order['ket'].')':'' ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label>Ex : Penambahan wastafel di Area X, Pemangkasan pohon di depan Gedung, Reparasi urinoir mampet</label>
                                            </div>
                                        </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <label>Keterangan</label>
                                                <br>
                                                <label>Aktivitas Detail Pekerjaan yang dilakukan, misal : bongkar galian, perataan tanah, dan pekerjaan lain yang diminta dalam order tersebut. </label>
                                            </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="mco_tblPekerjaan">
                                                <thead class="bg-info">
                                                    <th>No</th>
                                                    <th>Pekerjaan</th>
                                                    <th width="15%">Qty</th>
                                                    <th width="15%">Satuan</th>
                                                    <th>Keterangan</th>
                                                </thead>
                                                <tbody class="mco_daftarPek_Append">
                                                    <?php if (empty($ket)): ?>
                                                        <tr class="text-center">
                                                            <td colspan="5">No Data</td>
                                                        </tr>
                                                    <?php endif ?>
                                                    <?php $x=1; foreach ($ket as $k): ?>
                                                    <tr class="mco_daftarPek">
                                                        <td class="mco_daftarnoPek"><?= $x; ?></td>
                                                        <td>
                                                            <?= $k['pekerjaan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $k['qty'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $k['satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $k['keterangan'] ?>
                                                        </td>
                                                    </tr>
                                                    <?php $x++; endforeach ?>
                                                </tbody>
                                            </table>
                                            <a href="<?= base_url('civil-maintenance-order/order/edit_keterangan/'.$order['order_id']); ?>" class="btn btn-primary" onclick="return confirm('Anda yakin ingin Meningalkan Halaman ini?');">
                                                <i class="fa fa-edit"></i>
                                                Update Pekerjaan
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Tanggal Dibutuhkan</label>
                                        </div>
                                        <div class="col-md-8 izi">
                                            : <?= date('d-M-Y', strtotime($order['tgl_dibutuhkan'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <label>Approval</label>
                                            <table class="table table-bordered" id="mco_tbl_approver">
                                                <thead class="bg-info">
                                                    <th>No</th>
                                                    <th>Jenis Approve</th>
                                                    <th>Apprver</th>
                                                    <th>Status</th>
                                                </thead>
                                                <tbody class="mco_daftarApp_Append">
                                                    <?php if (empty($approve)): ?>
                                                        <tr class="text-center">
                                                        <td colspan="4">No Data</td>
                                                        </tr>
                                                    <?php endif ?>
                                                    <?php $x=1; foreach ($approve as $app): ?>
                                                    <tr class="mco_daftarApp">
                                                        <td class="mco_daftarnoPek"><?= $x ?></td>
                                                        <td>
                                                            <?= ($app['jenis_approver']==1) ? 'Pengorder':'Civil' ?>
                                                        </td>
                                                        <td>
                                                            <?= $app['approver'].' - '.$app['employee_name'] ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if ($app['status_approval'] == 1) echo "Approve";
                                                            elseif ($app['status_approval'] == 2) echo "Reject";
                                                            else  echo "Belum Approve";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php $x++; endforeach ?>
                                                </tbody>
                                            </table>
                                            <?php if ($order['jenis_order_id'] == 1): ?>
                                                <a onclick="return confirm('Anda yakin ingin Meningalkan Halaman ini?');" href="<?= base_url('civil-maintenance-order/order/edit_approval/'.$order['order_id']) ?>" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                    Update Approval
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-4">
                                            <label>Status Order</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control mco_slc" id="mco_changestatus" data-id="<?= $order['order_id'] ?>" data-kolom="status_id">
                                                <option></option>
                                                <?php foreach ($status_order as $so): ?>
                                                    <option <?= ($so['status_id'] == $order['status_id']) ? 'selected':'' ?> value="<?= $so['status_id'] ?>"><?= $so['status'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1" style="padding-left: 0px;" hidden="">
                                            <i style="margin-top: 5px; color: green" class="fa fa-check fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                    <label style="font-size: 14px;" class="mco_isiData ellipse" title="<?= trim($order['section_name']) ?>">
                                            Seksi : <?= empty(trim($order['section_name'])) ? '-':trim($order['section_name']) ?>
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label style="font-size: 14px;" class="mco_isiData">Lokasi : <?= empty(trim($order['location_name'])) ? '-':trim($order['location_name']) ?></label>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 10px;">
                                        <h3 style="font-weight: bold;">Lampiran</h3>
                                    </div>
                                    <?php $x=1; foreach ($lampiran as $key): 
                                        $file = explode('/', $key['path']);
                                    ?>
                                        <div class="col-md-12 mco_insertafter" style="margin-top: 10px;">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mco_lampiranFile" value="<?= end($file); ?>">
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <a target="_blank" href="<?= base_url('civil-maintenance-order/order/download_file/'.$key['attachment_id']) ?>" class="btn btn-success">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php $x++; endforeach ?>
                                    <div class="col-md-12 text-center" style="margin-top: 30px;">
                                        <a title="Edit Lampiran" href="<?= base_url('civil-maintenance-order/order/edit_lampiran/'.$key['order_id']); ?>" class="btn-md btn btn-info cmo_upJnsOrder">
                                            <i class="fa fa-file-o"></i> 
                                            Edit Lampiran
                                        </a>
                                    </div>
                                </div>
                                
                                <div style="margin-top: 30px;" class="col-md-12 text-left">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <a href="<?= base_url('civil-maintenance-order/order/list_order');?>" class="btn btn-warning btn-md"> <<< Kembali</a>
                                            <a href="<?= base_url('civil-maintenance-order/order/cetak_order/'.$id);?>" class="btn btn-info btn-md" target="_blank">
                                            <i class="fa fa-file"></i> Cetak Order
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: 50px;">
                                    <div class="col-md-12">
                                        <form method="post" action="<?= base_url('civil-maintenance-order/order/post_chat') ?>">
                                        <h3 style="font-weight: bold;">Thread</h3>
                                        <textarea class="textareaMCO" name="txtIsi" id="txtUsulan" placeholder="Start writing your response here. Use canned responses from the drop-down above" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                                            <button type="submit" style="margin-top: 30px;" class="btn btn-success" name="id" value="<?=$id?>">Post Reply</button>
                                            <button type="button" style="margin-top: 30px;" onclick="window.location.reload()" class="btn btn-danger">Reset</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-info box-solid">
                            <div class="box-header with-border" style="font-weight: bold;">
                                <i class="fa fa-file-o"></i> Order Thread (<?= count($chat) ?>)
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                <?php foreach ($chat as $ct): ?>
                                    <table style="width: 100%; margin-top: 10px;">
                                        <tbody>
                                            <tr>
                                                <th class="<?= ($ct['post_by']==$order['pengorder'])? 'headPost2':'headPost' ?>">
                                                    <span class="pull-left"><?= date('Y/m/d H:i', strtotime($ct['post_date'])) ?></span>
                                                    <span class="pull-right"><?= $ct['post_by'].' - '.$ct['nama'] ?></span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="bodyPost">
                                                    <?= $ct['post_body'] ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('input').attr('disabled', true);
    });
</script>