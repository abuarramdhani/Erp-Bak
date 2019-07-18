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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi');?>">
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
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" target="_blank" method="POST" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/doDownload') ?>">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Server
                                        </label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" id="txtServer" name="txtServer" value="database.quick.com" class="form-control" placeholder="database.quick.com" readonly>
                                                <span class="input-group-btn">
                                                    <button id="btnCheckServer" class="btn btn-primary" type="button">Check Server</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-1" id="server-status">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-8 col-lg-offset-2">
                                            <table class="table table-bordered table-triped">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center bg-default"></th>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Periode</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $angka = 1; 
                                                        $bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

                                                        foreach ($data as $key) { ?>
                                                        <tr>
                                                            <td class="text-center"><input type="checkbox" name="checkPenggajian[]" value="<?php echo $key['bln_gaji']."-".$key['thn_gaji']."-".$key['ket'] ?>"></td>
                                                            <td class="text-center"><?php echo $angka; ?></td>
                                                            <td class="text-center"><a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/getDetailData?bulan='.$key['bln_gaji'].'&tahun='.$key['thn_gaji'].'&ket='.$key['ket']) ?>" target="_blank"><?php echo $bulan[$key['bln_gaji']].' '.$key['thn_gaji'] ?></a></td>
                                                            <td class="text-center"><?php echo $key['ket'] ?></td>
                                                            <td class="text-center"><?php echo $key['jumlah'] ?> Orang</td>
                                                        </tr>
                                                    <?php 
                                                            $angka++; 
                                                        } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-8">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="progressDownload">
                                                    0 %
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-6 col-sm-2">
                                            <a href="javascript:history.back()" class="btn btn-info">Back</a>
                                            <button type="submit" class="btn btn-primary" style="float: right;">Download</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        setInterval(function(){
             $.ajax({
              type:'get',
              data: {user: '<?php echo $user; ?>', type: 'Download Absensi'},
              dataType: 'json',
              url: baseurl + 'PayrollManagementNonStaff/ProsesGaji/DataAbsensi/getProgressData',
              success: function(data){
                $('#progressDownload').attr('aria-valuenow',data);
                $('#progressDownload').css('width',data+'%');
                $('#progressDownload').text(data+' %');
              }
            });
        },5000);
    });
</script>