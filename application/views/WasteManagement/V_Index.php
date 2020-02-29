<?php 
	$count = 0;
	foreach ($user as $us) {
        if ($us['user_name'] == $this->session->userdata['user']) {
        	$count++;
        }
	}

	if($count > 0):
?>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Waste Management</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">

                            <ul class="nav nav-pills nav-justified">
                                    <li class="active"><a data-toggle="pill" href="#masuk">Limbah Masuk</a></li>
                                    <li><a data-toggle="pill" href="#keluar">Limbah Keluar</a></li>
                            </ul>

                            <div class="tab-content"> 
                                <div id="masuk" class="tab-pane fade in active">
                                    <br/>
                                    <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah" style="font-size:12px;">
                                        <thead class="bg-primary">
                                        	<tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Jenis Limbah</th>
                                                <th>Sumber Limbah</th>
                                                <th>Status Approval</th>
                                                <th>Approve/Reject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($Transaksi as $row):
                                                $encrypted_string = $this->encrypt->encode($row['id_transaksi']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $no++;?></td>
                                                <td><?php echo date("d M Y", strtotime($row["tanggal_transaksi"])) ?></td>
                                                <td><?php echo $row["jenis_limbah"] ?></td>
                                                <td><?php echo $row["nama_seksi"] ?></td>
                                                <td align="center">
                                                	<a href="<?php echo base_url('WasteManagement/LimbahTransaksi/read/'.$encrypted_string.''); ?>" title="klik here"><h4><span class='label label-warning'>Waiting</span></h4></a></td>
                                                <td align="center">
                                                    <input type="checkbox" name="cekLimbahMasuk[]" class="cekLimbahMasuk" data-limbah-masuk="<?php echo $row['id_transaksi'];?>">
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                    <a href="" class="btn btn-success" style="margin-right: 20px" id="ApproveLimbahMasuk" disabled="">Approve</a>
                                    <a href="" class="btn btn-danger" id="RejectLimbahMasuk" disabled="">Reject</a>
                                </div>
                                </div>

                                
                                <div id="keluar" class="tab-pane fade">
                                    <br/>
                                    <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Jenis Limbah</th>
                                                <th>Nomor Dokumen</th>
                                                <th>Status Approval</th>
                                                <th>Approve/Reject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($keluar as $rows):
                                                $encrypted_string = $this->encrypt->encode($rows['id_limbah_keluar']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $no++;?></td>
                                                <td><?php echo date("d M Y", strtotime($rows["tanggal_keluar"])) ?></td>
                                                <td><?php echo $rows["jenis_limbah"] ?></td>
                                                <td><?php echo $rows["nomor_dok"] ?></td>
                                                <td align="center">
                                                	<a href="<?php echo base_url('WasteManagement/LimbahKeluar/read/'.$encrypted_string.''); ?>" title="klik here"><h4><span class='label label-warning'>Waiting</span></h4></a></td>
                                                <td align="center">
                                                    <input type="checkbox" name="cekLimbahKeluar[]" class="cekLimbahKeluar" data-limbah-keluar="<?php echo $rows['id_limbah_keluar'];?>">
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                    <a href="" class="btn btn-success" style="margin-right: 20px" id="ApproveLimbahKeluar" disabled="">Approve</a>
                                    <a href="" class="btn btn-danger" id="RejectLimbahKeluar" disabled="">Reject</a>
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
<?php else: ?>
<section id="content">
	<div class="inner" style="background: url("<?php echo base_url('assets/img/3.jpg');?>");background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-3">
							<br />
							<h1>Limbah B3 </h1>
						</div>
					</div>
			</section>
			<hr />
			<div class="row">
				<div class="col-lg-12">
				    <div class="col-lg-12 text-right reup">    
                        <h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
					</div>	
						
						<center> 
							
							<img  src="<?php echo base_url("assets/img/logo.png");?>" style="max-width:27%;" />
						
						</center>
						<br /><br />
						<center>
						<?php $load = microtime();
							echo '<p style="font: normal 15px courier">Halaman ini dimuat dalam ';
							echo round($load, 3);
							echo ' detik';
						?>
						</center>
                    
				</div>
			</div>
		</div>
		
</section>
<?php endif; ?>
