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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h4>Monitoring Site Management</h4>   
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('SiteManagement/Monitoring/prosesdata');?>" enctype="multipart/form-data">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input id="sm_tglmonitoring" class="form-control sm_tglmonitoring"  data-date-format="d M Y" autocomplete="off" type="text" name="sm_tglmonitoring" style="width: 170px" placeholder="Masukkan Periode" value="" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select class="form-control sm_select2" name="sm_selectkategori" id="sm_selectkategori">
                                                <option value=""></option>
                                                <?php foreach($listkategori as $lk){;?>
                                                <option value="<?php echo $lk['id_kategori'];?>"><?php echo $lk['kategori']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <select class="form-control sm_select2" name="sm_periode" id="sm_periode" style="width: 100%">
                                                <option value=""></option>
                                                <option value="1">1 Minggu</option>
                                                <option value="2">2 Minggu</option>
                                                <option value="3">3 Minggu</option>
                                                <option value="4">1 Bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <select class="form-control sm_select2" name="sm_hari" id="sm_hari" style="width: 100%">
                                                <option value=""></option>
                                                <option value="1">Senin</option>
                                                <option value="2">Selasa</option>
                                                <option value="3">Rabu</option>
                                                <option value="4">Kamis</option>
                                                <option value="5">Jumat</option>
                                                <option value="6">Sabtu</option>
                                                <option value="7">Minggu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-success pull-right">Proses</button>
                                        </div>
                                    </div>
                                </form>
                                <br></br>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>    
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-6">
    <?php if(!empty($bathroom)):?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Penjadwalan Kamar Mandi</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div>
              <table class="table table-striped table-bordered table-hover text-left sm_table2" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th>Date</th>
                        <th>Nama PU</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $no=1;foreach ($bathroom as $key):?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                            <td><?php echo $key['pic'];?></td>
                            <td><?php echo $key['kategori'];?></td>
                            <td align="center"><a href="<?php echo base_url('SiteManagement/RecordData/CeilingFan');?>"><?php if ($key['overdue']=='1') {
                                    echo "<span class='label label-danger'>Overdue</span>";
                                }else{echo "<span class='label label-warning'>Pending</span>";};?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                            
              </table>
            </div>
        </div>
      </div>
    <?php endif; ?>
      <!-- /.box -->
    <?php if(!empty($floorparking)):?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Penjadwalan Lantai Parkir</h3>
        </div>
        <!-- /.box-header -->
         <div class="box-body">
            <div>
              <table class="table table-striped table-bordered table-hover text-left sm_table2" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th>Date</th>
                        <th>Nama PU</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $no=1;foreach ($floorparking as $key):?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                            <td><?php echo $key['pic'];?></td>
                            <td><?php echo $key['kategori'];?></td>
                            <td align="center"><a href="<?php echo base_url('SiteManagement/RecordData/LPMaintenance');?>"><?php if ($key['overdue']=='1') {
                                    echo "<span class='label label-danger'>Overdue</span>";
                                }else{echo "<span class='label label-warning'>Pending</span>";};?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                            
              </table>
            </div>
        </div>
      </div>
    <?php endif;?>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
    <?php if(!empty($trashcan)):?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Penjadwalan Pencucian Tong Sampah</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div>
              <table class="table table-striped table-bordered table-hover text-left sm_table2" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th>Date</th>
                        <th>Nama PU</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $no=1;foreach ($trashcan as $key):?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                            <td><?php echo $key['pic'];?></td>
                            <td><?php echo $key['kategori'];?></td>
                            <td align="center"><a href="<?php echo base_url('SiteManagement/RecordData/TongSampah');?>"><?php if ($key['overdue']=='1') {
                                    echo "<span class='label label-danger'>Overdue</span>";
                                }else{echo "<span class='label label-warning'>Pending</span>";};?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                            
              </table>
            </div>
        </div>
      </div>
    <?php endif;?>
      <!-- /.box -->

    <?php if(!empty($land)):?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Penjadwalan Lahan</h3>
        </div>
        <!-- /.box-header -->
         <div class="box-body">
            <div>
              <table class="table table-striped table-bordered table-hover text-left sm_table2" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th>Date</th>
                        <th>Nama PU</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $no=1;foreach ($land as $key):?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                            <td><?php echo $key['pic'];?></td>
                            <td><?php echo $key['kategori'];?></td>
                            <td align="center"><a href="<?php echo base_url('SiteManagement/RecordData/LahanKarangwaru');?>"><?php if ($key['overdue']=='1') {
                                    echo "<span class='label label-danger'>Overdue</span>";
                                }else{echo "<span class='label label-warning'>Pending</span>";};?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                            
              </table>
            </div>
        </div>
      </div>
    <?php endif;?>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
    <?php if(!empty($sajadah)):?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Penjadwalan Pembersihan Karpet Sajadah Mushola</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div>
              <table class="table table-striped table-bordered table-hover text-left sm_table2" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th>Date</th>
                        <th>Nama PU</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $no=1;foreach ($sajadah as $key):?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                            <td><?php echo $key['pic'];?></td>
                            <td><?php echo $key['kategori'];?></td>
                            <td align="center"><a href="<?php echo base_url('SiteManagement/RecordData/TongSampah');?>"><?php if ($key['overdue']=='1') {
                                    echo "<span class='label label-danger'>Overdue</span>";
                                }else{echo "<span class='label label-warning'>Pending</span>";};?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                            
              </table>
            </div>
        </div>
      </div>
    <?php endif;?>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->  