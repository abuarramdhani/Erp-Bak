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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/AllDoc');?>">
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
<!--                                 <a href="<?php echo site_url('DocumentStandarization/BP/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a> -->
                              <div class="navbar-custom-menu" style="float: right; margin-right: 1%" alt="Notification" title="Notification">
                                <ul class="nav navbar-nav">
                                  <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-bell-o fa-lg"></i>
                                      <span class="label label-warning"><?php echo $jumlahNotifikasiBaru[0]['jumlah_notifikasi'];?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li class="header">Anda memiliki <b><?php echo $jumlahNotifikasiBaru[0]['jumlah_notifikasi'];?></b> notifikasi.</li>
                                      <li>
                                        <!-- inner menu: contains the actual data -->

                                        <ul class="menu">
                                        <?php
                                            foreach ($ambilNotifikasiBaru as $notifikasiBaru) 
                                            {
                                                $encrypted_string = $this->encrypt->encode($notifikasiBaru['id_dokumen']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                echo '  <li>
                                                            <a href="'.base_url("DocumentStandarization/".$notifikasiBaru['jenis_dokumen'].'/read/'.$encrypted_string.'').'" data-apsa="" target="_blank">
                                                                <b>'.$notifikasiBaru['dokumen'].'</b> dibuat oleh '.$notifikasiBaru['pengelola'].'
                                                                <h6 style="text-align: right;">'.$notifikasiBaru['jenis_dokumen'].' | <b>'.$notifikasiBaru['waktu_notifikasi'].'</b></h6>
                                                            </a>
                                                        </li>';
                                            }
                                        ?>
                                        </ul>
                                      </li>
                                      <?php
                                        if($jumlahNotifikasiBaru[0]['jumlah_notifikasi']>0)
                                        {
                                            echo '<li class="footer"><a href="#">View all</a></li>';
                                        }
                                      ?>
                                    </ul>
                                  </li>
                                </ul>
                              </div>                                       
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-allDocument" style="font-size:12px; overflow-x: auto;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px; white-space: nowrap;">Action</th>
                                                <th style="text-align: center; white-space: nowrap;">Jenis Dokumen</th>
												<th style="white-space: nowrap;">Nama</th>
												<th style="white-space: nowrap;">Nomor Kontrol</th>
												<th style="white-space: nowrap;">Nomor Revisi</th>
												<th style="white-space: nowrap;">Tanggal Revisi</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($AllDocument as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['kode_dokumen']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/'.$row['inisial_jenis_dokumen'].'/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                </td>
                                                <td style="white-space: nowrap;"><?php echo $row['jenis_dokumen'];?></td>
												<td style="white-space: nowrap;"><?php echo $row['nama_dokumen'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['nomor_dokumen'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['nomor_revisi'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['tanggal_revisi'] ?></td>
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