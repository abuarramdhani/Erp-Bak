<?php // judul berdasarkan resp yg dibuka user
$judul = $siapa == 'Kasie Pengorder' ? 'Monitoring Order' : 
        ($siapa == 'Ass Ka Nit Pengorder' ? 'Approval Ass. Ka. Unit Pengorder' :
        ($siapa == 'Kasie PE' ? 'Approval Kepala Seksi PE' : 
        ($siapa == 'Ass Ka Nit PE' ? 'Approval Ass. Ka. Unit PE' :
        ($siapa == 'Designer Produk' ? 'Approval Designer Produk' :
        ($siapa == 'Unit QA/QC' ? 'Approval Unit QC/QA' :
        ($siapa == 'KaDep Produksi' ? 'Approval Kepala Department' :
        ($siapa == 'Ass Ka Nit TM' ? 'Approval Ass. Ka. Unit Tool Making' :
        ($siapa == 'Kasie PPC TM' ? 'Approval Kepala Seksi PPC Tool Making' : 'Monitoring Admin PPC'))))))));

$order = $siapa == 'Kasie Pengorder' ? '' : 'display:none'; // style button order baru
$batas = $siapa == 'KaDep Produksi' ? 'display:none' : ''; // kadep cuma nampilin data tabel baru
// $search = $siapa != 'Kasie PPC TM' ? 'display:none' : ''; // search cuma muncul di Resp. OTM - Tool Making

// echo "<pre>";print_r($siapa);exit();
?>
<section class="content" id="ordertoolmaking">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <div class="col-md-6 text-left"><h4 style="font-size:20px;font-weight:bold"><?= $judul?></h4></div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success" style="<?= $order?>" formaction="<?php echo base_url("OrderToolMaking/MonitoringOrder/OrderBaru")?>"><i class="fa fa-plus"></i> Order Baru</button>
                                    <input type="hidden" id="siapa" name="siapa" value="<?= $siapa?>"></th>
                                </div>
                            </div>
                            <div class="box-body" >
                                <div class="col-md-3">
                                    <input id="search_otm" class="form-control" placeholder="cari dokumen..." autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="box-body" id="view_otm">
                                <h3 style="<?= $batas?>">MODIFIKASI</h3>
                                <div class="panel-body text-nowrap" id="tb_modifikasiorder" style="<?= $batas?>"></div>

                                <h3 style="<?= $batas?>">REKONDISI</h3>
                                <div class="panel-body text-nowrap" id="tb_rekondisiorder" style="<?= $batas?>"></div>

                                <h3>BARU</h3>
                                <div class="panel-body text-nowrap" id="tb_baruorder"></div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<form method="post" enctype="multipart/form-data">
<div class="modal fade" id="mdlOrderMonitoring" role="dialog">
    <div class="modal-dialog" style="width:90%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div id="datamodifrekon"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>
