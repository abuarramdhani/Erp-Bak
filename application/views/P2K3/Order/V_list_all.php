<style type="text/css">
    .ui-datepicker-calendar {
    display: none;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>List Order Kebutuhan APD</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">
                        <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3/Order/list_order');?>">
                            <i class="icon-wrench icon-2x"></i>
                            <span><br/></span>  
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b></b></h1></div>
                        </div>

                        <div hidden class="panel panel-primary" style="height: 80px;">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <table class="text-left">
                                                <div class="col-md-3" align="right">
                                                    <label class="control-label">Pilih Seksi : </label>
                                                </div>

                                                <div class="col-md-5">
                                                    <select class="form-control" id="TampilSeksi" data-id="1">
                                                        <!-- <option><?php echo $key['item']?></option> -->
                                                    </select>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary" type="button">Tampil</button>
                                                </div>

                                            </table>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="height: 60px;">
                                <a href="<?php echo site_url('P2K3/Order/input')?>">
                                    <div hidden style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                        <button hidden type="button" class="btn btn-default btn-sm"><i hidden class="icon-plus icon-2x"></i></button>
                                    </div>
                                </a>
                                <div>
                                    <h4>Export Data</h4>
                                </div>
                            </div>

                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('p2k3adm/datamasuk/cek');?>">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div>
                                                <input autocomplete="off" id="tanggal" name="txtTanggalex" class="form-control p2k3-dateexport" placeholder="Tanggal" value="<?php echo $tanggalnow; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary btn-rect">Export</button>
                                        </div>
                                    </div>
                                </form>
                                <div hidden class="row text-right" style="margin-right: 3px;">
                                    <a hidden class="btn btn-primary" id="bt_export" href="<?php echo site_url('P2K3/Order/export')?>">Export &nbsp<span class="glyphicon glyphicon-arrow-up"></a>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th width="5%" style="text-align: center; vertical-align: middle;">NO</th>
                                                <th width="80%" style="text-align: center; vertical-align: middle;">Seksi</th>
                                                <th style="text-align: center; width: 105px; vertical-align: middle;">ACTION</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no=1;
                                            foreach ($namaSeksi as $row) {
                                                $kode_seksi = $row['kodesie']     
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['section_name']; echo "<br/>"; echo '('.$row['kodesie'].')'; ?></td>
                                                    <td style="text-align: center;">
                                                     <center>
                                                        <a methode class="btn btn-default" href="<?php echo site_url('P2K3/Order/listPerSie/'.$kode_seksi); ?>">Lihat</a>
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
