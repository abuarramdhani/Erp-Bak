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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterItem');?>">
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
                                    <table class="table table-bordered table-hover" id="masterItem">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">✓</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Type</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Kode Barang</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama Barang</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Proses</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Kode Proses</th>
                                                <th colspan="2" style="text-align: center;vertical-align: middle;">Target</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Berlaku</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Jenis</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Berat</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Id</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Action</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;">Senin-Kamis</th>
                                                <th style="text-align: center;vertical-align: middle;">Jumat-Sabtu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $x=1; foreach ($master as $mi) {?>
                                            <tr row-id="<?php echo $x;?>">
                                                <td><?php echo $x; ?></td>
                                                <td></td>
                                                <td><?php echo $mi['type'];?></td>
                                                <td><?php echo $mi['kode_barang'];?></td>
                                                <td><?php echo $mi['nama_barang'];?></td>
                                                <td><?php echo $mi['proses'];?></td>
                                                <td><?php echo $mi['kode_proses'];?></td>
                                                <td><?php echo $mi['target_sk'];?></td>
                                                <td><?php echo $mi['target_js'];?></td>
                                                <td><?php echo $mi['tanggal_berlaku'];?></td>
                                                <td><?php echo $mi['jenis'];?></td>
                                                <td><?php echo $mi['berat'];?></td>
                                                <td><?php echo $mi['id'];?></td>
                                                <td>
                                                    <button class="btn btn-default edit" data-toggle="modal" data-target="#modalEdit" onclick="editMasterItem('<?php echo $mi['id']?>')"><i class="fa fa-pencil"></i></button>
                                                    <button class="hapus btn btn-default" onclick="deleteMasterItem('<?php echo $mi['id']?>','<?php echo $x;?>')"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php $x++;} ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="modal fade" id="modalEdit" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Item</h4>
                                        </div>
                                        <div class="modal-body" id="editMasterItem">
                                        </div>
                                        <div class="modal-footer">
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