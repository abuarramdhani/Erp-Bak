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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahKeluar/Report');?>">
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
                                <form action="<?php echo site_url('WasteManagement/LimbahKeluar/FilterDataReport/');?>" method="post" enctype="multipart/form-data">
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
                                                <input id="periode" class="form-control"  data-date-format="d M Y" autocomplete="off" type="text" name="periode" style="width:100%" placeholder="Masukkan Periode" value="" />
                                        </div>
                                </div>
                                <div class="col-md-5">
                                        <div class="input-group">
                                        <select name="user_name" class="form-control select2" data-placeholder="Pilih Kasie" style="width:250px">
                                            <option value=""></option>
                                            <?php foreach ($user_name as $user) { ?>
                                            <option value="<?php echo $user['nama']; ?>"><?php echo $user['nama']; ?></option>
                                            <?php }?> 
                                        </select>
                                        </div>
                                </div>
                                <div class="col-md-1">
                                        <div class="input-group">
                                                <input type="submit"  class="btn btn-ms btn-warning pull-left" value="SEARCH">
                                        </div>
                                </div>
                                </form> 
                                        <div class="col-md-1">
                                        <div class="input-group">
                                        <?php
                                                if(!empty($limbah_keluar) && !empty($limbah_masuk)){
                                                ?>
                                                <?php
                                                }else{
                                                    $tanggalawallink    =   str_replace('-', '.', $tanggalawalformatindo);
                                                    $tanggalakhirlink   =   str_replace('-', '.', $tanggalakhirformatindo);
                                                    ?>
                                                    <form method="POST" action="<?php echo site_url('WasteManagement/LimbahKeluar/cetakExcel/'.$tanggalawallink.'/'.$tanggalakhirlink) ?>";">
                                                    <input type="hidden" name="excelTglAwal" id="excelTglAwal" value="<?php echo $tanggalawal; ?>">
                                                    <input type="hidden" name="excelTglAkhir" id="excelTglAkhir" value="<?php echo $tanggalakhir; ?>">
                                                    <input type="hidden" name="exceljenislimbah" id="exceljenislimbah" value="<?php echo $jenislimbah; ?>">
                                                    <input type="hidden" name="excelusername" id="excelusername" value="<?php echo $NamaUser; ?>">

                                                    <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
                                                    </form>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        </div> 
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
                                                    <th>Tanggal Masuk</th>
                                                    <th>Jenis Limbah</th>
                                                    <th>Sumber Limbah</th>
                                                    <th>Jenis Sumber</th>
                                                    <th>Satuan</th>
                                                    <th>Jumlah</th>
                                                    <th>Perlakuan</th>
                                                    <th>Maks Penyimpanan</th>
                                                    <th>Konfirmasi Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $no = 1;
                                                    if(!isset($limbah_masuk)){
                                                        $data_item = $filterMasuk;
                                                    }else{
                                                        $data_item = $limbah_masuk;
                                                    } 
                                                    foreach($data_item as $row):
                                                    $encrypted_string = $this->encrypt->encode($row['id_transaksi']);
                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                ?>
                                                <tr>
                                                    <td align='center'><?php echo $no++;?></td>
                                                    <td><?php echo date('d M Y', strtotime($row['tanggal_transaksi'])) ;?></td>
                                                    <td><?php echo $row['jenis'] ?></td>
                                                    <td><?php echo $row['sumber'] ?></td>
                                                    <td><?php if($row['jenis_sumber']==1){
                                                                    echo "Proses Produksi";}
                                                                elseif ($row['jenis_sumber']==0) {
                                                                    echo "Diluar Proses Produksi";} ?>
                                                    </td>
                                                    <td><?php echo $row['satuan_limbah'] ?></td>
                                                    <td><?php echo $row['jumlah'] ?></td>
                                                    <td><?php echo $row['limbah_perlakuan'] ?></td>
                                                    <td><?php echo date('d M Y', strtotime($row['maks_penyimpanan'])) ;?></td>
                                                    <td align="center"><?php if(empty($row['konfirmasi'])) {
                                                                    echo "<h4><span class='label label-warning'>Waiting</span></h4>";
                                                                }elseif ($row['konfirmasi']==1) {
                                                                    echo "<h4><span class='label label-success'>Confirmed</span></h4>";
                                                                }elseif ($row['konfirmasi']==2) {
                                                                    echo "<h4><span class='label label-danger'>Not Confirmed</span></h4>";
                                                                } ;?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>                                      
                                        </table>
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
                                                    <th>Perlakuan</th> 
    												<th>Jumlah Keluar</th>
                                                    <th>Satuan</th>
    												<th>Tujuan Limbah</th>
    												<th>Nomor Dok</th>
    												<th>Sisa Limbah</th>
                                                    <th style="text-align:center">Status</th>
    											</tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                	$no = 1;
                                                    if(!isset($limbah_keluar)){
                                                        $data_item = $filterKeluar;
                                                    }else{
                                                        $data_item = $limbah_keluar;
                                                    }  
                                                	foreach($data_item as $row):
    											?>
                                                <tr>
                                                    <td align='center'><?php echo $no++;?></td>
                                                    <td><?php echo date('d M Y',strtotime($row['tanggal_keluar'])); ?></td>
                                                    <td><?php echo $row['jenis'] ?></td>
                                                    <td><?php echo $row['limbah_perlakuan'] ?></td>
    												<td><?php echo $row['jumlah_keluar'] ?></td>
                                                    <td><?php echo $row['satuan_limbah'] ?></td>
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
    </div>
</section>