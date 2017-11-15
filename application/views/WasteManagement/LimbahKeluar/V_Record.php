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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahKeluar/Record');?>">
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
                                <form action="<?php echo site_url('WasteManagement/LimbahKeluar/FilterDataRecord/');?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-2">
                                        <div class="input-group">
                                        <select id="jenis_limbah" name="jenis_limbah" class="select select2" data-placeholder="Pilih Jenis Limbah " style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($jenis_limbah as $limbah) { ?>
                                                        <option value="<?php echo $limbah['id_jenis_limbah']; ?>"><?php echo $limbah['jenis_limbah']; ?></option>
                                                        <?php }?> 
                                        </select>
                                        </div>
                                </div>
                                <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                <input id="periode" class="form-control"  data-date-format="d M Y" autocomplete="off" type="text" name="periode" style="width:170px" placeholder="Masukkan Periode" value="" />
                                        </div>
                                </div>
                                <div class="col-md-1">
                                        <div class="input-group">
                                                <input type="submit"  class="btn btn-ms btn-warning pull-left" value="SEARCH">
                                        </div>
                                </div>
                                </form> 
                                        
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>Jenis Limbah</th>
												<th>Tanggal Keluar</th>
												<th>Jumlah Keluar</th>
												<th>Tujuan Limbah</th>
												<th>Nomor Dok</th>
												<th>Sisa Limbah</th>
                                                <th style="text-align:center">Status</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1;
                                                if(!isset($data)){
                                                    $data_item = $filter_data;
                                                }else{
                                                    $data_item = $data;
                                                }  
                                            	foreach($data_item as $row):
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td><?php echo $row['jenis'] ?></td>
												<td><?php echo date('d M Y',strtotime($row['tanggal_keluar'])); ?></td>
												<td><?php echo $row['jumlah_keluar'] ?></td>
												<td><?php echo $row['tujuan_limbah'] ?></td>
												<td><?php echo $row['nomor_dok'] ?></td>
												<td><?php echo $row['sisa_limbah'] ?></td>
                                                <td align="center"><?php if($row['konfirmasi_status']==0) {
                                                                echo "<h4><span class='label label-warning'>Waiting</span></h4>";
                                                            }elseif ($row['konfirmasi_status']==1) {
                                                                echo "<h4><span class='label label-success'>Confirmed</span></h4>";
                                                            }elseif ($row['konfirmasi_status']==2) {
                                                                echo "<h4><span class='label label-danger'>Not Confirmed</span></h4>";
                                                            } ;?>
                                                </td>
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