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
                                <form method="post" action="<?= base_url('civil-maintenance-order/order/update_order') ?>" enctype="multipart/form-data">
                                    <div class="col-md-12 cmo_pengorderCivil">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Order Dari</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcPkj mco_itcanchange" name="dari" change="1">
                                                    <option selected="" value="<?= $order['pengorder'] ?>"><?= $order['pengorder'].' - '.$order['dari'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-7">
                                                <label style="font-size: 14px;" class="mco_isiData">Seksi : <?= trim($order['section_name']) ?></label>
                                            </div>
                                            <input hidden="" name="kodesie" class="mco_inputData" value="<?= $order['kodesie_pengorder'] ?>">
                                            <input hidden="" name="lokasi" class="mco_inputData" value="<?= $order['lokasi_pengorder'] ?>">
                                            <div class="col-md-5">
                                                <label style="font-size: 14px;" class="mco_isiData">Lokasi : <?= trim($order['location_name']) ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input value="<?= $order['tgl_order'] ?>" required class="form-control mco_tglpick" name="tglorder">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Penerima Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control" name="penerima">
                                                    <option selected="" value="<?= $order['penerima_order'] ?>"><?= $order['penerima_order'].' - '.$order['ke'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Terima</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input value="<?= $order['tgl_terima'] ?>" required class="form-control mco_tglpick" name="tglterima">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Jenis Pekerjaan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcJnsPkj" name="jnsPekerjaan">
                                                    <option selected="" value="<?= $order['jenis_pekerjaan_id'] ?>"><?= $order['jenis_pekerjaan'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 setjnsPkjhere" style="padding-left: 0px; padding-top: 5px;">

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Jenis Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcJnsOrder" name="jnsOrder">
                                                    <option selected="" value="<?= $order['jenis_order_id'] ?>"><?= $order['jenis_order'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Judul Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input value="<?= $order['judul'] ?>" required oninput="this.value = this.value.toUpperCase()" class="form-control" name="judul">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label>Ex : Penambahan wastafel di Area X, Pemangkasan pohon di depan Gedung, Reparasi urinoir mampet</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Keterangan</label>
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <a href="<?= base_url('civil-maintenance-order/order/edit_keterangan/'.$order['order_id']); ?>" class="btn btn-primary" onclick="return confirm('Anda yakin ingin Meningalkan Halaman ini?');">
                                                    <i class="fa fa-edit"></i>
                                                    Update Pekerjaan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                            <label>Aktivitas Detail Pekerjaan yang dilakukan, misal : bongkar galian, perataan tanah, dan pekerjaan lain yang diminta dalam order tersebut. </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Dibutuhkan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input value="<?= $order['tgl_dibutuhkan'] ?>" required class="form-control mco_tglpick" name="tglbutuh">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Approval</label>
                                            </div>
                                            <div class="col-md-8 text-left">
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
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Status Order</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control mco_slc" id="mco_changestatus" data-id="<?= $order['order_id'] ?>" data-kolom="status_id" name="status">
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
                                    <div style="margin-top: 30px;" class="col-md-12 text-center">
                                        <a href="<?= base_url('civil-maintenance-order/order/list_order');?>" class="btn btn-warning btn-lg">Kembali</a>
                                        <button disabled="" value="<?= $order['order_id'] ?>" name="id" type="submit" class="btn btn-success btn-lg" id="cmo_btnSaveUp">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.addEventListener('load', function () {
        $('.cmo_slcJnsOrder').trigger('change');
        $('.cmo_slcJnsPkj').trigger('change');
        $('#cmo_btnSaveUp').attr('disabled', true);
    });
</script>