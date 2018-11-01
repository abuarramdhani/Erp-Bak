<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
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
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMoulding" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Component Code</th>
												<th>Component Description</th>
                                                <th>Production Date</th>
												<th>Kode Cetak</th>
												<th>Moulding Quantity</th>
												<th>Jumlah Pekerja</th>
                                                <th>Scrap Qty</th>
												<th>Hasil Baik</th>
                                                <th>Keterangan</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($Moulding as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['moulding_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['component_code'] ?></td>
												<td><?php echo $row['component_description'] ?></td>
                                                <td><?php echo $row['production_date'] ?></td>
												<td><?php echo $row['print_code'] ?></td>
												<td><?php echo $row['moulding_quantity'] ?></td>
                                                <td><?php echo $row['jumlah_pekerja'] ?></td>
												<td><?php echo $row['scrap_qty'] ?></td>
                                                <td><?php echo $row['moulding_quantity']-$row['scrap_qty']?></td>
                                                <td><?php echo$row['keterangan'] ?></td>
											</tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                 <div class="row">
                        <div class="col-lg-6">
                         <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/createLaporan1'); ?>" method="POST">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Monitoring Produksi</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                <div class="col-lg-6">
                                                   <input class="form-control" type="date" name="tanggal_awal"  required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="date" name="tanggal_akhir" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                         <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/createLaporan2'); ?>" method="POST">
                        <div class="col-lg-6">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Evaluasi Produksi</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                <div class="col-lg-6">
                                                   <input class="form-control" type="date" name="tanggal_awal" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="date" name="tanggal_akhir" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/createLaporan3'); ?>" method="POST">
                        <div class="col-lg-6">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Laporan AKT</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                <div class="col-lg-6">
                                                   <input class="form-control" type="date" name="tanggal_awal" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="date" name="tanggal_akhir" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/createLaporan4'); ?>" method="POST">
                        <div class="col-lg-6">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Laporan BPKEKAT</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                <div class="col-lg-6">
                                                   <input class="form-control" type="date" name="tanggal_awal" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="date" name="tanggal_akhir" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/createLaporan5'); ?>" method="POST">
                        <div class="col-lg-6">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Laporan IND_TRAN</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                <div class="col-lg-6">
                                                   <input class="form-control" type="date" name="tanggal_awal" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="date" name="tanggal_akhir" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>