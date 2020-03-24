<section class="content">
<!-- <form method="POST" class="form-horizontal" action="<?php echo base_url('TicketingMaintenance/Agent/OrderList/save_laporan/'.$id[0]['no_order']); ?>"> -->
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
                                    <b style="margin-right:700px; margin-left:0px;"><?= 'No Order : '.$id[0]['no_order']?></b>
                                    <b>Input Form Laporan Perbaikan</b>
                            </div>
                            <div class="box-body">
                            <!-- <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/save_laporan/'.$id[0]['no_order']); ?>" method="post"> -->
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name="no_order" class="idLaporan" value="<?= $id[0]['no_order'] ?>"> <br />
                                        <div class="form-group">
                                            <label for="" class="control-label">Kerusakan</label>
                                            <input type="text" name="txtKerusakan" class="form-control kerusakan" placeholder="Input Kerusakan" required>
                                        </div> 
                                        <br/>
                                        <div class="form-group">
                                            <label for="" class="control-label">Penyebab</label>
                                            <input type="text" name="txtPenyebab" class="form-control penyebab" placeholder="Input Penyebab" required>
                                        </div>
                                        <br/>
                                        <div class="form-group perbaikan">
                                            <!-- <label for="" class="control-label"><a class="btn btn-primary btn-sm"><i class="fa fa-plus fa-lg" title="Tambah Langkah Perbaikan" onclick="addRowTabelPerbaikan(this)"></i></a></label> -->
                                            <label for="" class="control-label">  Langkah yang dilakukan</label> 
                                            <br />
                                            <div class="col-lg-12">
                                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="" style="">
                                                        <thead class="bg-primary">
                                                            <th width="5%" class="text-center">No</th>
                                                            <th width="60%" class="text-center">Langkah</th>
                                                            <th width="35%" class="text-center">Action</th>
                                                        </thead>
                                                        <tbody id="tbodyLangkahPerbaikan">
                                                            <tr class="nomor_1">
                                                            <td class="text-center langkahTabel">1</td>
                                                            <td class="text-center">
                                                            <input type="text" style="width:420px" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required>
                                                            </td>
                                                            <td class="text-center">
                                                            <a class="btn btn-primary btn-md"><i class="fa fa-plus fa-md" title="Tambah Langkah Perbaikan" onclick="addRowTabelPerbaikan(this)"></i></a>
                                                            <a class="btn btn-danger btn-md" title="Hapus Langkah Perbaikan" onclick="onClickDeleteLpB(this)"><span class="fa fa-times fa-md"></span></a> 
                                                            </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <!-- <div class="col-lg-2">
                                            <input type="text" style="text-align:center; margin-left=0%;" name="txtUrutan[]" class="form-control urutan" value="1" readonly>                                            
                                            </div>
                                            <div class="col-lg-10">
                                            <input type="text" style="width:490px" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required>
                                            </div>   -->
                                            <br/>
                                        </div> <br/>
                                        <br/>
                                        <div class="form-group">
                                            <label for="" class="control-label">Langkah Pencegahan</label>
                                            <input type="text" name="txtPencegahan" class="form-control langkahPencegahan" placeholder="Input Langkah Pencegahan" required>
                                        </div> 
                                        <br/>
                                        <div class="form-group">
                                            <label for="" class="control-label">Verifikasi Perbaikan</label>
                                            <input type="text" name="txtVerPerbaikan" class="form-control verPerbaikan" placeholder="Input Verifikasi Perbaikan" required>
                                        </div> <br />
                                    </div>
                                    <div class="col-lg-3"></div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row text-right" style="margin:1px;">
                                    <button type="button" onclick="saveLaporanPerbaikan(this)" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                    <a href="<?php echo site_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
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

<script>
    const base_url = '<?= base_url() ?>';
</script>

<!--LOADING-->
<!-- <div id="loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="<?= base_url(); ?>/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div> -->