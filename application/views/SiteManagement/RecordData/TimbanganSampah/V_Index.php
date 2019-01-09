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
                            <b style="font-size: 20px;">Record Data Penggunaan Timbangan Sampah</b>
                                <a href="<?php echo site_url('SiteManagement/RecordData/TambahTimbanganSampah'); ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left sm_datatable text-center" id="sm_datatable" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>No Urut</th>
												<th>Tanggal Timbang</th>
												<th>No Kendaraan</th>
												<th>Asal Sampah</th>
												<th>Jenis Mobil</th>
												<th>Sopir</th>
												<th>Timbangan 1</th>
												<th>Timbangan 2</th>
												<th>Netto</th>
												<th>Jam Timbang</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($sampah as $row):
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('SiteManagement/RecordData/editSampah/'.$row['id_sampah']); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('SiteManagement/RecordData/deleteSampah/'.$row['id_sampah']); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['no_urut'] ?></td>
												<td><?php echo $row['tgl_timbangan']; ?></td>
												<td><?php echo $row['no_kendaraan'] ?></td>
												<td><?php echo $row['asal_sampah']; ?></td>
												<td><?php echo $row['jenis_mobil']; ?></td>
												<td><?php echo $row['nama_sopir']; ?></td>
												<td><?php echo $row['berat_timbangan_1']; ?> kg</td>
												<td><?php echo $row['berat_timbangan_2']; ?> kg</td>
												<td><?php echo $row['berat_netto']; ?> kg</td>
												<td><?php echo $row['waktu']; ?></td>
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