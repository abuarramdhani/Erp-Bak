
    <!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <h1>
        Selamat Datang
        <small> Dashboard</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section> -->

<section class="content">
    <div class="row">
        <div class="col-lg-12">
                <!-- <h1 class="center">
                    Dashboard
                </h1> -->
            <div class="col-sm-6 col-xl-6" style="margin-bottom:10px;">
                <a href="<?php echo site_url('PurchaseManagementGudang/NonConformity/insert') ?>" class="btn btn-primary btn-block"><img src="<?php echo base_url('assets/img/Submit.png');?>" width="50%" height="50%" style="opacity: 0.3;"><br><span style="color: #0000005c;"><strong>SUBMIT</strong></span></a>
            </div>
            <div class="col-sm-6 col-xl-6" style="margin-bottom:10px;">
                <a href="<?php echo site_url('PurchaseManagementGudang/NonConformity/listData') ?>" class="btn btn-danger btn-block"><img src="<?php echo base_url('assets/img/history2.png');?>" width="50%" height="50%" style="opacity: 0.3;"><br><span style="color: #0000005c;"><strong>PENDING ASSIGN</strong></span></a>
            </div>
            <div class="col-sm-6 col-xl-6" style="margin-bottom:10px;">
                <a href="<?php echo site_url('PurchaseManagementGudang/NonConformity/listSupplier') ?>" class="btn btn-info btn-block"><img src="<?php echo base_url('assets/img/lst.png');?>" width="50%" height="50%" style="opacity: 0.3;"><br><span style="color: #0000005c;"><strong>LIST DATA</strong></span></a>
            </div>
            <div class="col-sm-6 col-xl-6" style="margin-bottom:10px;">
                <a href="<?php echo site_url('PurchaseManagementGudang/NonConformity/PendingExecuteSupplier') ?>" class="btn btn-warning btn-block"><img src="<?php echo base_url('assets/img/hourglass.png');?>" width="50%" height="50%" style="opacity: 0.3;"><br><span style="color: #0000005c;"><strong>PENDING EXECUTE</strong></span></a>
            </div>
            <div class="col-sm-6 col-xl-6" style="margin-bottom:10px;">
                <a href="<?php echo site_url('PurchaseManagementGudang/NonConformity/FinishedOrderSupplier') ?>" class="btn btn-success btn-block"><img src="<?php echo base_url('assets/img/chck.png');?>" width="50%" height="50%" style="opacity: 0.3;"><br><span style="color: #0000005c;"><strong>FINISHED ORDER</strong></span></a>
            </div>
        </div>
    </div>
</section>
