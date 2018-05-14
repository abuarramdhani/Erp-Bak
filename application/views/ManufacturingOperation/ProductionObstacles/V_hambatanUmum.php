<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        Hambatan Umum
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/MasterItem');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
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
                               Hambatan Umum
                            </div>
                            <div class="panel-body">
     
                            <ul class="nav nav-tabs">
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                
                                <h3>Data Hambatan Mesin (Umum)</h3>
                                <button class="btn btn-warning" data-toggle="collapse" data-target="#container-collapse">Report</button>
                                <div id="container-collapse" class="collapse">
                                <div id="1" class="tab-pane fade in active">
                                    <form method="post" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/ajax/exportHamMesin') ?>">
                                        <div class="col-md-6" style="padding-bottom: 20px;padding-left: 0px">
                                             <div class="form-group">
                                                  <label>Periode Hambatan</label>
                                                  <input id="tgl_hambatan1" class="form-control date-picker" type="text" name="tgl_hambatan1"> 
                                                  <input id="kategoriHambatan" value="umum" type="hidden" name="kategoriHambatan">   

                                             </div>
                                             <div class="form-group">
                                                  <label>Sampai Tanggal</label>
                                                  <input id="tgl_hambatan2" class="form-control date-picker" type="text" name="tgl_hambatan2">
                                             </div>  
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cetak :</label> <br>
                                                <select id="type" class="form-control select2" data-placeholder="Pilih Cetak" name="typeCetak" required>
                                                    <option></option>
                                                    <option value="logam">Logam</option>
                                                    <option value="inti">Inti</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="padding-top: 25px">
                                                <a id="btn-searchHam" class="btn btn-warning">Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i></a>
                                                <button type="submit" id="exportHamb" class="btn btn-default" style="display: none">Export &nbsp;&nbsp;&nbsp;<i class="fa fa-download"></i></button>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                                    
                                </div>

                                <div id="tableHam" class="col-md-12" style="padding-top: 30px;border-top: 1px solid #eee">
                                        <table class="table table-bordered table-striped table-hover" id="HamMesinUmum">
                                            <thead>
                                                 <tr>
                                                    <th>No</th>
                                                    <th>Induk</th>
                                                    <th>Cabang</th>
                                                    <th>Mulai</th>
                                                    <th>Selesai</th>
                                                    <th>Cetak</th>
                                                    <th>Action</th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            <?php $x=1; foreach ($HambatanUmum as $hu) { ?>
                                                    <tr>
                                                        <td><?php echo $x ?></td>
                                                        <td><?php echo $hu['induk'] ?></td>
                                                        <td><?php echo $hu['cabang'] ?></td>
                                                        <td><?php echo $hu['mulai'] ?></td>
                                                        <td><?php echo $hu['selesai'] ?></td>
                                                        <td><?php echo $hu['cetak']?></td>
                                                        <td>
                                                        <form method="post" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/updateHambatanUmum')?>">
                                                            <input type="hidden" name="id_hambatanUmum" value="<?php echo $hu['id'] ?>">
                                                            <button type="submit" class="btn btn-warning">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                        </form>
                                                            <button class="btn btn-danger delHam" onclick="deleteHambatan(this,<?php echo $hu['id'] ?>)"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php $x++; } ?>
                                        
                                            </tbody>
                                        </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/addHambatanUmum')?>">Add Data&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
                                   </div>
                                    <div id="tableSearchHam" class="col-md-12" style="padding-top: 30px;border-top: 1px solid #eee;display: none">
                                    <h3 style="padding-bottom: 20px">Review Data Hambatan Mesin (umum) Cetakan <span id="headCetakan"></span></h3>
                                        <table class="table table-bordered table-striped table-hover text-center" id="HamMesinUmum">
                                            <thead>
                                                 <tr>
                                                    <th rowspan="2">No</th>
                                                    <th colspan="2">Hambatan</th>
                                                    <th rowspan="2">Total</th>
                                                    <th rowspan="2">Frekuensi</th>
                                                 </tr>
                                                 <tr>
                                                     <th>Induk</th>
                                                     <th>Cabang</th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            <?php $x=1; foreach ($HambatanUmum as $hu) { ?>
                                                    <tr>
                                                        <td><?php echo $x ?></td>
                                                        <td><?php echo $hu['induk'] ?></td>
                                                        <td><?php echo $hu['cabang'] ?></td>
                                                        <td><?php echo $hu['total'] ?></td>
                                                        <td><?php echo $hu['frekuensi'] ?></td>
                                                    </tr>
                                            <?php $x++; } ?>
                                        
                                            </tbody>
                                        </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/addHambatanUmum')?>">Add Data&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
                                   
                                    
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