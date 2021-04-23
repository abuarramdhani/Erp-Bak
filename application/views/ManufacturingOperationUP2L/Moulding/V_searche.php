<section class="content">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/view_create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="box box-default box-solid">
                                    <div class="box-header with-border">Search</div>
                                    <div class="box-body">
                                        <div class="form-group">
                                        <div class="col-lg-2"></div>
                                            <div class="col-lg-6">
                                                <form autocomplete="off" method="POST" action="<?= base_url('ManufacturingOperationUP2L/Moulding/search')?>">
                                                <input type="text" required="" name="bulan" id="sea_month" class="form-control selectM" placeholder="Pilih Bulan" />
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i></button>
                                                <a href="<?= base_url('ManufacturingOperationUP2L/Moulding')?>" class="btn btn-success"> <i class="fa fa-refresh"></i></a>
                                                </form>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMoulding2021" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th style="text-align:center">Component Code</th>
                                                <th style="text-align:center">Component Description</th>
                                                <th style="text-align:center">Production Date</th>
                                                <th style="text-align:center">Kode Cetak</th>
                                                <th style="text-align:center">Shift</th>
                                                <th style="text-align:center">Komponen (pcs)</th>
                                                <th style="text-align:center">Kode</th>
                                                <th style="text-align:center">Jumlah Pekerja</th>
                                                <th style="text-align:center">Bongkar Qty</th>
                                                <th style="text-align:center">Scrap Qty</th>
                                                <th style="text-align:center">Hasil Baik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php
                                            $no = 1;
                                            foreach ($Moulding as $row) :
                                                $encrypted_string = $this->encrypt->encode($row['moulding_id']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                ?>
                                                <tr>
                                                    <td align='center'><?php echo $no++; ?></td>
                                                    <td align='center'>
                                                        <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/read/' . $encrypted_string . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                        <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/edit/' . $row['moulding_id'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                        <a href="<?php echo base_url('ManufacturingOperationUP2L/Moulding/delete/' . $encrypted_string . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                    </td>
                                                    <td><?php echo $row['component_code'] ?></td>
                                                    <td><?php echo $row['component_description'] ?></td>
                                                    <td><?php echo $row['production_date'] ?></td>
                                                    <td><?php echo $row['print_code'] ?></td>
                                                    <td><?php echo $row['shift'] ?></td>
                                                    <td><?php echo $row['moulding_quantity'] ?></td>
                                                    <td><?php echo $row['kode'] ?></td>
                                                    <td><?php echo $row['jumlah_pekerja'] ?></td>
                                                    <td><?php echo $row['bongkar_qty'] ?></td>
                                                    <td><?php echo $row['scrap_qty'] ?></td>
                                                    <td><?php echo $row['bongkar_qty'] - $row['scrap_qty'] ?></td>
                                                </tr>
                                            <?php endforeach; ?> -->
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
</section>
