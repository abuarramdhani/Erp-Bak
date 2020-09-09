<style>
    .dataTables_filter{
        float: right;
    }
    .buttons-excel{
        background-color: green;
        color: white;
    }
    .setPointer{
        cursor: pointer;
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
                            <div class="box-header with-border">
                                <div class="col-md-12 text-right">
                                    <a href="<?= base_url('civil-maintenance-order/order/create_order') ?>" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-pills nav-justified" role="tablist" id="mco_tablistorder">
                                            <li role="presentation" class="active">
                                                <a href="#all" aria-controls="all" role="tab" data-toggle="tab">Semua Pekerjaan</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#pedo" aria-controls="pedo" role="tab" data-toggle="tab">Pekerjaan Eksternal Dengan Order</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#peto" aria-controls="peto" role="tab" data-toggle="tab">Pekerjaan Eksternal Tanpa Order</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#pip" aria-controls="pip" role="tab" data-toggle="tab">Pekerjaan Internal & Perawatan</a>
                                            </li>
                                        </ul>
                                        <hr>
                                        <div class="tab-content">
                                            <style type="text/css">
                                                .dt-buttons, .dataTables_info {
                                                    float: left;
                                                }
                                                .dataTables_filter, .dataTables_paginate {
                                                    float: right;
                                                }
                                            </style>
                                            <div role="tabpanel" class="tab-pane fade in active" id="all">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                                        <table class="table table-bordered table-hover table-striped" id="cmo_tbllistorder">
                                                            <thead class="bg-primary">
                                                                <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                                                <th class="bg-primary" style="text-align: center;">No Log</th>
                                                                <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Status Order</th>
                                                                <th style="text-align: center;">Order Tanggal</th>
                                                                <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                                                <th style="text-align: center;">Approval Pengorder</th>
                                                                <th style="text-align: center;">Approval Penerima Order</th>
                                                                <th style="text-align: center; width: 130px;">Action</th>
                                                                <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                                                <th style="text-align: center;">Pemberi Order</th>
                                                                <th style="text-align: center;">Voip</th>
                                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                                <th style="text-align: center;">Total Pekerjaan</th>
                                                                <th class="bg-primary" style="text-align: center;">Status</th>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php $x = 1; foreach ($list as $key): ?>
                                                                <tr>
                                                                    <td><?= $x ?></td>
                                                                    <td><?= $key['order_id'] ?></td>
                                                                    <td><?= $key['jenis_order'] ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_order'])) ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_dibutuhkan'])) ?></td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 1) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 2) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/'.$key['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                                                        <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/'.$key['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $key['order_id'] ?>">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $key['section_name'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['pengorder'].' - '.$key['dari'] ?></td>
                                                                    <td><?= $key['voip'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['jenis_pekerjaan'] ?></td>
                                                                    <td><?= $key['total_order'] ?></td>
                                                                    <td><?= $key['status'] ?></td>
                                                                </tr>
                                                                <?php $x++; endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="pedo">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                                        <table class="table table-bordered table-hover table-striped" id="cmo_tbllistorder_pedo">
                                                            <thead class="bg-primary">
                                                                <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                                                <th class="bg-primary" style="text-align: center;">No Log</th>
                                                                <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Status Order</th>
                                                                <th style="text-align: center;">Order Tanggal</th>
                                                                <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                                                <th style="text-align: center;">Approval Pengorder</th>
                                                                <th style="text-align: center;">Approval Penerima Order</th>
                                                                <th style="text-align: center; width: 130px;">Action</th>
                                                                <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                                                <th style="text-align: center;">Pemberi Order</th>
                                                                <th style="text-align: center;">Voip</th>
                                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                                <th style="text-align: center;">Total Pekerjaan</th>
                                                                <th class="bg-primary" style="text-align: center;">Status</th>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php 
                                                                    $x = 1; 
                                                                    foreach ($list as $key){ 
                                                                        if($key['jenis_order'] == "Pekerjaan Eksternal dengan Order"){
                                                                        ?>
                                                                <tr>
                                                                    <td><?= $x ?></td>
                                                                    <td><?= $key['order_id'] ?></td>
                                                                    <td><?= $key['jenis_order'] ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_order'])) ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_dibutuhkan'])) ?></td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 1) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 2) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/'.$key['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                                                        <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/'.$key['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $key['order_id'] ?>">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $key['section_name'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['pengorder'].' - '.$key['dari'] ?></td>
                                                                    <td><?= $key['voip'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['jenis_pekerjaan'] ?></td>
                                                                    <td><?= $key['total_order'] ?></td>
                                                                    <td><?= $key['status'] ?></td>
                                                                </tr>
                                                                <?php $x++;
                                                                        } 
                                                                    } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="peto">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                                        <table class="table table-bordered table-hover table-striped" id="cmo_tbllistorder_peto">
                                                            <thead class="bg-primary">
                                                                <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                                                <th class="bg-primary" style="text-align: center;">No Log</th>
                                                                <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Status Order</th>
                                                                <th style="text-align: center;">Order Tanggal</th>
                                                                <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                                                <th style="text-align: center;">Approval Pengorder</th>
                                                                <th style="text-align: center;">Approval Penerima Order</th>
                                                                <th style="text-align: center; width: 130px;">Action</th>
                                                                <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                                                <th style="text-align: center;">Pemberi Order</th>
                                                                <th style="text-align: center;">Voip</th>
                                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                                <th style="text-align: center;">Total Pekerjaan</th>
                                                                <th class="bg-primary" style="text-align: center;">Status</th>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php 
                                                                    $x = 1; 
                                                                    foreach ($list as $key){ 
                                                                        if($key['jenis_order'] == "Pekerjaan Eksternal Tanpa Order"){ ?>
                                                                <tr>
                                                                    <td><?= $x ?></td>
                                                                    <td><?= $key['order_id'] ?></td>
                                                                    <td><?= $key['jenis_order'] ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_order'])) ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_dibutuhkan'])) ?></td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 1) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 2) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/'.$key['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                                                        <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/'.$key['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $key['order_id'] ?>">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $key['section_name'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['pengorder'].' - '.$key['dari'] ?></td>
                                                                    <td><?= $key['voip'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['jenis_pekerjaan'] ?></td>
                                                                    <td><?= $key['total_order'] ?></td>
                                                                    <td><?= $key['status'] ?></td>
                                                                </tr>
                                                                <?php $x++; 
                                                                        }
                                                                    } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="pip">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                                        <table class="table table-bordered table-hover table-striped" id="cmo_tbllistorder_pip">
                                                            <thead class="bg-primary">
                                                                <th class="bg-primary" width="10%" style="text-align: center;">No</th>
                                                                <th class="bg-primary" style="text-align: center;">No Log</th>
                                                                <th class="bg-primary" width="15%" style="text-align: center; width: 80px;">Status Order</th>
                                                                <th style="text-align: center;">Order Tanggal</th>
                                                                <th style="text-align: center;">Tanggal Dibutuhkan</th>
                                                                <th style="text-align: center;">Approval Pengorder</th>
                                                                <th style="text-align: center;">Approval Penerima Order</th>
                                                                <th style="text-align: center; width: 130px;">Action</th>
                                                                <th style="text-align: center; width: 150px;">Seksi Pengorder</th>
                                                                <th style="text-align: center;">Pemberi Order</th>
                                                                <th style="text-align: center;">Voip</th>
                                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                                <th style="text-align: center;">Total Pekerjaan</th>
                                                                <th class="bg-primary" style="text-align: center;">Status</th>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php $x = 1; foreach ($list as $key){ 
                                                                        if($key['jenis_order'] == "Pekerjaan Internal & Perawatan"){ ?>
                                                                <tr>
                                                                    <td><?= $x ?></td>
                                                                    <td><?= $key['order_id'] ?></td>
                                                                    <td><?= $key['jenis_order'] ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_order'])) ?></td>
                                                                    <td><?= date('d-M-Y', strtotime($key['tgl_dibutuhkan'])) ?></td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 1) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td style="text-align: left; white-space: nowrap;">
                                                                        <?php
                                                                        foreach ($approve as $app) {
                                                                            if ($app['order_id'] == $key['order_id'] && $app['jenis_approver'] == 2) {
                                                                                if ($app['status_approval'] == 1) {
                                                                                    echo '<p style="color: green">- '.$app['employee_name'];
                                                                                }elseif ($app['status_approval'] == 2) {
                                                                                    echo '<p style="color: red">- '.$app['employee_name'];
                                                                                }else{
                                                                                    echo '<p style="color: grey">- '.$app['employee_name'];
                                                                                }
                                                                                if ($app['status_approval'] == 0) {
                                                                                    echo ' <i style="color:#1fa2ff" class="fa fa-check setPointer cmo_setApprove" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    <i style="color:red" class="fa fa-times setPointer cmo_setReject" data-id="'.$app['order_approver_id'].'"></i>
                                                                                    </p>';
                                                                                }else{
                                                                                    echo "</p>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="Lihat Data" href="<?= base_url('civil-maintenance-order/order/view_order/'.$key['order_id']); ?>" class="btn-sm btn btn-primary cmo_upJnsOrder">
                                                                        <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a title="Edit Data" href="<?= base_url('civil-maintenance-order/order/edit_order/'.$key['order_id']); ?>" class="btn-sm btn btn-warning cmo_upJnsOrder">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a title="Delete Data" class="btn-sm btn btn-danger cmo_delOrder" hapus="<?= $key['order_id'] ?>">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $key['section_name'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['pengorder'].' - '.$key['dari'] ?></td>
                                                                    <td><?= $key['voip'] ?></td>
                                                                    <td style="white-space: nowrap; text-align: left"><?= $key['jenis_pekerjaan'] ?></td>
                                                                    <td><?= $key['total_order'] ?></td>
                                                                    <td><?= $key['status'] ?></td>
                                                                </tr>
                                                                <?php $x++; 
                                                                        }
                                                                    } ?>
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
            </div>
        </div>
    </div>
</section>
<?php
if (isset($order_id) && !empty($order_id)) {
    ?>
<script type="text/javascript">
    $(document).ready(function(){
        cetakOrderCM(<?php echo $order_id ?>)
    })
</script>
    <?php
}
 ?>