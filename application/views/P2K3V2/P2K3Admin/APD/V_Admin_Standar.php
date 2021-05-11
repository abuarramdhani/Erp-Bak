<style type="text/css">
    .dataTables_filter {
        float: right;
    }

    .apd-pekerja,
    .apd-staff {
        cursor: pointer;
    }

    .apd-wrapper {
        display: grid;
        align-self: center;
        grid-template-columns: repeat(3, 1fr);
        justify-items: center;
        align-content: center;
    }

    .apd-wrapper>.apd-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
</style>
<?php var_dump(base_url()); ?>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Kebutuhan Standar</b></h1>
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-1 text-left" align="right">
                                        <label for="lb_periode" class="control-label">Seksi : </label>
                                    </div>
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/standar'); ?>" enctype="multipart/form-data">
                                        <div class="col-md-5">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_standar" name="k3_adm_ks" placeholder="Masukkan Periode">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-md">Tampilkan</button>
                                        </div>
                                    </form>
                                    <div style="margin-top: 20px;" class="col-md-12 text-center">
                                        <h4 style="color: #000; font-weight: bold;">
                                            <?php if (!empty($seksi) || !isset($seksi)) {
                                                echo $seksi[0]['section_name'];
                                            } ?>
                                        </h4>
                                    </div>
                                    <table style="margin-top: 50px;" class="table table-striped table-bordered table-hover text-center dataTable-p2k3Frezz">
                                        <thead>
                                            <tr class="bg-info">
                                                <th class="bg-info">No</th>
                                                <th class="bg-info" style="min-width: 200px;">APD</th>
                                                <th class="bg-info">Kode Barang</th>
                                                <th>Kebutuhan Umum</th>
                                                <th class="apd-staff" data-ks="<?= $ks; ?>">STAFF</th>
                                                <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                    <th data-ks="<?= $ks; ?>" data-kp="<?= $key['kdpekerjaan']; ?>" class=" apd-pekerja"><?= $key['pekerjaan']; ?></th>
                                                <?php } ?>
                                                <th>Keterangan</th>
                                                <th>Lampiran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                            <?php $index = 1; ?>
                                            <?php foreach ($get_list_approve_new as $glan) : ?>
                                                <tr style="color: #000;">
                                                    <td><?= $index; ?></td>
                                                    <td>
                                                        <a style=" cursor:pointer;" class="p2k3_see_apd_text"><?= $glan['item']; ?></a>
                                                    </td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_to_input"><?= $glan['kode_item']; ?></a>
                                                        <input hidden="" value="<?= $glan['kode_item']; ?>" class="p2k3_see_apd">
                                                    </td>
                                                    <td><?= $glan['jml_kebutuhan_umum']; ?></td>
                                                    <td data-kebstaff="<?= $glan['jml_kebutuhan_staff']; ?>" class="data-staff"><?= $glan['jml_kebutuhan_staff']; ?></td>
                                                    <?php foreach ($glan['list_item'] as $li) : ?>
                                                        <td><?= $li; ?></td>
                                                    <?php endforeach; ?>
                                                    <td><?= $glan['keterangan']; ?></td>
                                                    <td>
                                                        <?php if ($glan['lampiran'] === '-' || ' ') : ?>
                                                            <?= '-' ?>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('assets/upload/P2K3DocumentApproval/' . $glan['lampiran']); ?>" target="_blank" class="btn btn-danger">
                                                                <i class="fa fa-file-pdf-o"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php $index++ ?>
                                            <?php endforeach; ?>
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
</section>