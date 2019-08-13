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
                                    SparePart Barang Gudang
                                 </b>
                             </h1>
                         </div>
                     </div>
                     <div class="col-lg-1 ">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="">
                                <i aria-hidden="true" class="fa fa-user fa-2x">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                           Monitoring
                       </div>
                       <div class="box-body">
                        <form class="form-horizontal" action="<?php echo base_url('MonitoringBarangGudang/SparePart/filter'); ?>" method="post">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>Tanggal SPB/ DOSP</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="tanggalSPBSawal" id="tanggal_spbs_1_sp" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
                                            <input type="text" name="tanggalSPBSakhir" id="tanggal_spbs_2_sp" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>Tanggal Kirim</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="tanggalKirimAwal" id="tanggal_kirim_1_sp" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
                                            <input type="text" name="tanggalKirimAkhir" id="tanggal_kirim_2_sp" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>No SPB / DOSP </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="no_SPB" id="nama_sub_spbs_sp" class="form-control" style="width: 300px" placeholder="Input Nama Subkont" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SubmitBarangTua">
                                    <span class="fa fa-search" style="padding-right: 5px"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-12" >
                                        <!-- <div class="panel panel-default">
                                            <div class="panel-body">
 -->                                                <div class="table-responsive" >
                                    <table class="datatable table table-striped table-bordered table-responsive table-hover hasiltablemumet">
                                                       <thead >
                                                            <tr class="text-center bg-primary">
                                                    <th style="text-align:center;" width="5%">No</th>
                                                    <th style="text-align:center;" width="20%">No SPB / DOSP</th>
                                                    <th style="text-align:center;" width="20%">Tanggal SPB / DOSP</th>
                                                    <th style="text-align:center;" width="20%">Tanggal Kirim</th>
                                                    <th style="text-align:center;" width="15%">Ekspedisi</th>
                                                    <th style="text-align:center;" width="15%">Jumlah Colly</th>
                                                    <th style="text-align:center;" width="15%">Jumlah Item</th>
                                                    <th style="text-align:center;" width="15%">Jumlah Qty Diminta</th>
                                                    <th style="text-align:center;" width="15%">Jumlah Qty Dikirim</th>
                                                    <th style="text-align:center;" width="15%">Mulai</th>
                                                    <th style="text-align:center;" width="15%">Selesai</th>
                                                    <th style="text-align:center;" width="15%">Lama</th>
                                                    <th style="text-align:center;" width="15%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                <?php 
                                                $no = 1;
                                                foreach ($show as $key => $value): 
                                                    
                                                    $jml_item = 0;
                                                    $jml_diminta = 0;
                                                    $jml_dikirim = 0;
                                                 foreach ($line as $valoe){ 
                                                       if($valoe['NO_SPB'] == $value['NO_SPB']){   
                                                                $jml_item++;
                                                                $jml_diminta += $valoe['QTY_DIMINTA'];
                                                                $jml_dikirim += $valoe['QTY_DIKIRIM'];
                                                            
                                                        }
                                                    }
                                                ?>

                                                    <tr class="text-center">
                                                        <td><?php echo $no; ?></td>
                                                        <td><?php echo $value['NO_SPB']; ?></td>
                                                        <td><?php echo $value['TGL_SPB']; ?></td>
                                                        <td><?php echo $value['TGL_MULAI']; ?></td>
                                                        <td><?php echo $value['EKSPEDISI']; ?></td>
                                                        <td><?php echo $value['JML_COLLY']; ?></td>
                                                        <td><?php echo $jml_item; ?></td>
                                                        <td><?php echo $jml_diminta; ?></td>
                                                        <td><?php echo $jml_dikirim; ?></td>
                                                        <td><?php echo $value['JAM_MULAI']; ?></td>
                                                        <td><?php echo $value['JAM_SELESAI']; ?></td>
                                                        <td><?php echo round($value['LAMA'] / 60); ?> Menit</td>
                                                        <td><a style="float: center;" data-toggle="modal" data-target="#Modalku<?=$value['NO_SPB'];?>"  class="btn-xs btn btn-primary"> Show Detail</a></td>
                                                    </tr>



            <!--    <tr class="text-left">
                    <td colspan="10">
                    <span style="margin-left:20px" onclick="seeDetailMPO(this,'<?php echo $no; ?>')" class="btn btn-xs btn-primary"> 
                        see detail >>
                    </span>
            <div style="margin-top: 5px ; display: none; " id="detail<?php echo $no; ?>" >
                <table class="table table-sm table-bordered table-hover table-striped table-responsive"  style="border: 2px solid #ddd">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Kode Komponen</th>
                            <th>Nama Komponen</th>
                            <th>Qty Diminta</th>
                            <th>Qty Dikirim</th>
                            <th>UOM</th>
        
                        </tr>
                    </thead>
                    <tbody>
                   <?php foreach ($line as $key => $valoe): ?>
                        <?php if($valoe['NO_SPB'] == $value['NO_SPB']): ?>
                        <tr>
                            <td><?php echo $valoe['LINE_NUMBER']; ?></td>
                            <td><?php echo $valoe['ITEM_CODE']; ?></td>
                            <td><?php echo $valoe['DESCRIPTION']; ?></td>
                            <td><?php echo $valoe['QTY_DIMINTA']; ?></td>
                            <td><?php echo $valoe['QTY_DIKIRIM']; ?></td>
                            <td><?php echo $valoe['UOM']; ?></td>
                        </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
                    </td>
                </tr> --> 
                                        <?php 
                                            $no++;
                                            endforeach; 
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</section>
<?php $no=1; foreach ($detail as $key => $val){ ?>
    <!-- <p><?= $key;?></p> -->


<div class="modal fade" id="Modalku<?=$key;?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 100%" >
            <div class="modal-header">
                <h3 class="box-header with border" id="formModalLabel" align="center" >Data Detail</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            
           
             <div style="margin-top: 5px ; width: 100% " id="detail<?php echo $no; ?>" >
                <table class="table table-sm table-bordered table-hover table-striped table-responsive"  style="border: 2px solid #ddd">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Kode Komponen</th>
                            <th>Nama Komponen</th>
                            <th>Qty Diminta</th>
                            <th>Qty Dikirim</th>
                            <th>UOM</th>
        
                        </tr>
                    </thead>
                    <tbody>
              
                        <?php
                        $no=1;
                         foreach ($val['body'] as $row => $valoe){ ?>
                       
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $valoe['ITEM_CODE']; ?></td>
                            <td><?php echo $valoe['DESCRIPTION']; ?></td>
                            <td><?php echo $valoe['QTY_DIMINTA']; ?></td>
                            <td><?php echo $valoe['QTY_DIKIRIM']; ?></td>
                            <td><?php echo $valoe['UOM']; ?></td>
                        </tr>
                    <?php
                    $no++;
                     } ?>
                 
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $no++;
} ?>

    