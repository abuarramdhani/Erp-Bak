<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Data Masuk</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">
                        <a class="btn btn-default btn-lg" href="#">
                            <i class="icon-wrench icon-2x"></i>
                            <span><br/></span>  
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <br>
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th width="5%" style="text-align: center; vertical-align: middle;">NO</th>
                                                <th width="50%" style="text-align: center; vertical-align: middle;">Seksi</th>
                                                <th style="text-align: center; vertical-align: middle;">Periode</th>
                                                <th style="text-align: center; width: 105px; vertical-align: middle;">ACTION</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no=1;
                                            foreach ($namaSeksi as $row) {
                                                $kode_seksi = $row['kodesie'];
                                                $pr = $row['periode'];
                                                $peri = explode('-', $pr);
                                                $plus = ($peri[1]+1);
                                                if (count($plus) == '1') {
                                                    $plus = '0'.$plus;
                                                }
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['section_name']; ?></td>
                                                    <td style="text-align: center;"><?php echo $peri[0].'-'.$plus; ?></td>
                                                    <td style="text-align: center;">
                                                        <center>
                                                            <a methode class="btn btn-default" href="<?php echo site_url('p2k3adm_V2/datamasuk/lihat/'.$kode_seksi.'/'.$pr); ?>">Lihat</a>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                            ?>                                                
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