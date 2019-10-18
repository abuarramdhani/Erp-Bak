<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        Master Item UP2L
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/InputMasterItem');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Master Item UP2L
                            </div>
                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#1by1">Insert 1 by 1</a></li>
                                    <li><a data-toggle="tab" href="#InsMasIt">Insert Master Item</a></li>
                                </ul>
                                <div class="col-md-12 tab-content" style="padding-top:2em">
                                    <div id="InsMasIt" class="tab-pane fade in">
                                        <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperationUP2L/InputMasterItem/CreateSubmit'); ?>">
                                        <?php echo form_open_multipart(base_url('ManufacturingOperationUP2L/InputMasterItem/CreateSubmit'));?>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h2>
                                                        <b>
                                                        Upload file Excel
                                                        </b>
                                                    </h2>
                                                    <p>
                                                    -- Klick button 'DOWNLOAD SAMPLE' to download sample format item data list --
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="control-label col-md-offset-2 col-md-2">Master Item File (.xls)</label>
                                                    <div class="col-lg-6">
                                                        <input type="file" name="item" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <a class="btn btn-default" href="<?php echo site_url('ManufacturingOperationUP2L/InputMasterItem');?>">CANCEL</a>
                                                    <a class="btn btn-warning" href="<?php echo base_url('assets/download/ManufacturingOperationUP2L/masterItem/example(input-item).xlsx');?>">
                                                        <i aria-hidden="true" class="fa fa-download"></i> 
                                                    DOWNLOAD SAMPLE
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
                                                    <i aria-hidden="true" class="fa fa-upload"></i> UPLOAD
                                                    </button>
                                                </div>
                                            </div>
                                            <?php echo form_close();?>
                                        </form>
                                    </div>
                                    <div id="1by1" class="tab-pane fade in active">
                                        <div class="row">
                                            <form method="post" action="<?php echo base_url('ManufacturingOperationUP2L/InputMasterItem/insertMasIt')?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Type:</label>
                                                        <input class="form-control" type="text" name="tType" placeholder="Type" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Kode Barang:</label>
                                                        <input type="text" class="form-control" name="tKodeBarang" placeholder="Kode Barang" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Nama Barang:</label>
                                                        <input type="text" class="form-control" name="tNamaBarang" placeholder="Nama Barang" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Proses:</label>
                                                        <input type="text" class="form-control" name="tProses" placeholder="Proses" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Kode Proses:</label>
                                                        <input type="text" class="form-control" name="tKodeProses" placeholder="Kode Proses" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Berat:</label>
                                                        <input type="text" class="form-control" name="tBerat" placeholder="Berat" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">Target</div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label for="usr">Senin-Kamis</label>
                                                                <input type="number" class="form-control" name="tSK" placeholder="Target Senin-Kamis" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="usr">Jumat-Sabtu:</label>
                                                                <input type="number" class="form-control" name="tJS" placeholder="Target Jumat-Sabtu" required>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="usr">Tanggal Berlaku</label>
                                                        <input id="tglBerlaku" type="date" class="form-control" name="tBerlaku" required>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label for="usr">Jenis</label>
                                                        <input id="txtJenis" type="text" class="form-control" name="tJenis" placeholder="Jenis Item" required>
                                                    </div> 
                                                    <button type="submit" class="btn btn-default" style="float:right" >Submit</button>                                  
                                                </div>
                                            </form>
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