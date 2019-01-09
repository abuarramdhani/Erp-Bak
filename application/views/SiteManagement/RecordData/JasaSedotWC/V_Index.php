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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
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
                                <b style="font-size: 20px;">Record Data Penggunaan Jasa Sedot WC</b>
                                <a href="<?php echo site_url('SiteManagement/RecordData/TambahJasaSedotWC'); ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div>
                                <!-- <a class="btn btn-warning" href="<?php echo site_url('SiteManagement/RecordData/exportdata'); ?>">export</a> -->
                                    <table class="datatable table table-striped table-bordered table-hover text-center" id="sm_WC" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th class="text-center">Hari/Tanggal</th>
                                                <th>Lokasi</th>
												<th>Seksi Pemakai</th>
												<th>Jumlah Sedot WC</th>
												<th>Pemberi Order</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($wc as $row):
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('SiteManagement/RecordData/editJasa/'.$row['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('SiteManagement/RecordData/deleteJasa/'.$row['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td data-order="<?php echo $row['tanggal']; ?>">
                                                <?php echo $row['hari'].', '.$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($row['tanggal']))); ?>
                                                </td>
                                                <td><?php echo $row['lokasi']; ?></td>
												<td><?php echo $row['seksi']; ?></td>
												<td><?php echo $row['jumlah']; ?></td>
												<td><?php echo $row['pemberi_order']; ?></td>
											</tr>
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