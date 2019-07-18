<script type="text/javascript">
function getNomorCar(){
    console.log('Deskripsi Error');
    $.ajax({
        url: baseurl + "MonitoringBarangGudang/Pengeluaran/Car",
        dataType:'json',
        beforeSend: function(){

        },
        success: function(result){
            console.log(result);

            $('#"nomorMobil').val(result);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}
</script>

<style type="text/css">
body { height: 1000px; }
#header-fixed { 
    position: fixed; 
    padding-top: 0px; display:none;
    background-color:white;
}

</style>
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
                                    Pengeluaran Barang Gudang
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
                        <form class="form-horizontal" action="<?php 
echo isset($compile) ? base_url('MonitoringBarangGudang/Pengeluaran/Filter/'.$compile) : base_url('MonitoringBarangGudang/Pengeluaran/Filter');
                                            ?>" method="post">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-md-1 " style="text-align: right;">
                                            <label>Gudang</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select  name="compile" id="compileOutPart" class="form-control select4" style="width: 150px" data-placeholder="Pilih Gudang" id="routing_class"  onchange="location=this.value;">
                                                     <option><?php echo isset($compile) ? $compile : ''; ?></option>
                                                     <option value="<?php echo base_url('MonitoringBarangGudang/Pengeluaran/SEMUA'); ?>">Pilih Semua</option>
                                                      <?php foreach($warehouse as $value): ?>
                                                         <option value="<?php echo base_url('MonitoringBarangGudang/Pengeluaran/'.$value['SUBINV']); ?>">
                                                          <?php echo $value['SUBINV']; ?>
                                                        </option>
                                                      <?php endforeach; ?>
                                                </select>

                                                <!-- <select  onchange="compileWarehouse(this)">
                                                    <option></option>
                                                    <?php foreach ($warehouse as $warehouse) { ?>
                                                    <option><?php echo $warehouse['SUBINV']; ?></option>
                                                    <?php } ?>
                                                </select> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 " style="text-align: center;padding-bottom: 10px">
                                            <label><H2><b>FILTER PENGELUARAN BARANG GUDANG</b></H2></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>Tanggal SPBS</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
<input type="text" value="<?php echo isset($spbs_awal) ? $spbs_awal : ''; ?>" name="txtSpbsAwal" id="tanggal_spbs_1" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
<input type="text" value="<?php echo isset($spbs_akhir) ? $spbs_akhir : ''; ?>"  name="txtSpbsAkhir" id="tanggal_spbs_2" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>Tanggal Kirim</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
<input type="text" value="<?php echo isset($kirim_awal) ? $kirim_awal : ''; ?>"  name="txtKirimAwal" id="tanggal_kirim_1" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
<input type="text" value="<?php echo isset($kirim_akhir) ? $kirim_akhir : ''; ?>"  name="txtKirimAkhir" id="tanggal_kirim_2" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" style="text-align: right;">
                                            <label>No SPBS</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
 <input type="text" name="txtSpbsNum" id="spbs_number" class="form-control" style="width: 300px" placeholder="Input Nomor SPBS" value="<?php echo isset($spbs_num) ? $spbs_num : ''; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 " style="text-align: right;">
                                            <label>Nama Sub</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control select4" style="width: 300px" name="txtSubName" id="nama_sub_spbs" data-placeholder="Pilih Gudang">
                                                    <option></option>
                                                    <?php foreach ($subkont as $subkont) { ?>
                                                    <option><?php echo $subkont['VENDOR_NAME']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" style="text-align: right;">
                                            <label>No Job</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
 <input type="text" value="<?php echo isset($job) ? $job : ''; ?>" name="txtJob" id="job_spbs" class="form-control" style="width: 300px" placeholder="Input Job"  />
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
                                    <div class="table">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="table" style="overflow-x:scroll;max-width:100%;max-height: 80vh;">
                                                    <table class="table table-bordered table-hover text-center"  style="width: 1900px;padding-bottom: 0" name="tblOutPart1" id="tblOutPart1">
                                                       <thead style="position:sticky;top:0;">
                                                            <tr class="bg-primary">
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="30px" rowspan="2">No</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Edit</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="250px" rowspan="2">Nama Subkont</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Mobil</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">No SPBS</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Job</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl SPBS Dibuat</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Diterima PPB</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Kirim</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="150px" rowspan="2">Kode Komponen</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="300px" rowspan="2">Nama Komponen</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">QTY</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="40px" rowspan="2">UOM</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Subinventory</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">Jam</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="60px" rowspan="2">Lama (m : s)</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Tanggal Transact</th>
                                                                <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Keterangan</th>
                                                            </tr>
                                                            <tr class="bg-primary">
                                                                <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Minta</th>
                                                                <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Kirim</th>
                                                                <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Mulai</th>
                                                                <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Selesai</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $qty_kirim = 0;
                                                            $qty_minta = 0;
                                                            $lama = 0;

                                                            $subinv = '';
                                                            $no_spbs = 0;

                                                            $no = 1; foreach($outpartAll as $all){

                                                                $qty_kirim += $all['QTY_KIRIM'];

                                                                $qty_minta += $all['QTY_DIMINTA'];

                                                                if (empty($all['TRANSACTION_DATE'])) {
                                                                    $style = 'background-color:#c1382e;color:white';
                                                                }else{
                                                                    $style = 'background-color:#69dd49 ;color:black';
                                                                }

                                                                if($all['KETERANGAN'] == 'B'){
                                                                    $style = 'background-color:#f39c12 ;color:black';
                                                                }

                                                    if($subinv != $all['SUBINV'] && $no_spbs != $all['NO_SPBS']){
                                                                    $lama += $all['LAMA'];
                                                                    $subinv = $all['SUBINV'];
                                                                    $no_spbs = $all['NO_SPBS'];
                                                    }

                                                        ?>
                                                            <tr style="<?php echo $style; ?>">
                                                                <td><?php echo $no++; ?></td>
                                                                <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Modalku<?php echo $all['NO_SPBS']; ?>">Edit</button></td>
                                                                <td style="text-align: left;"><?php echo $all['NAMA_SUBKON']; ?></td>
                                                                <td><?php echo $all['NO_MOBIL']; ?></td>
                                                                <td><?php echo $all['NO_SPBS']; ?></td>
                                                                <td><?php echo $all['NO_JOB']; ?></td>
                                                                <td><?php echo $all['TGL_SPBS']; ?></td>
                                                                <td><?php echo $all['TGL_TERIMA']; ?></td>
                                                                <td><?php echo $all['TGL_KIRIM']; ?></td>
                                                                <td><?php echo $all['ITEM_CODE']; ?></td>
                                                                <td style="text-align: left;"><?php echo $all['ITEM_DESC']; ?></td>
                                                                <td><?php echo $all['QTY_DIMINTA']; ?></td>
                                                                <td><?php echo $all['QTY_KIRIM']; ?></td>
                                                                <td><?php echo $all['UOM']; ?></td>
                                                                <td><?php echo $all['SUBINV']; ?> </td>
                                                                <td><?php echo $all['JAM_MULAI']; ?></td>
                                                                <td><?php echo $all['JAM_SELESAI']; ?></td>
    <td><?php echo sprintf('%02d:%02d', (int) $all['LAMA'], fmod($all['LAMA'], 1) * 60); ?></td>
    <!-- <td><?php echo empty($all['TRANSACTION_DATE']) ? '' : date_format(date_create($all['TRANSACTION_DATE']),'M-d-Y h:i:s'); ?></td> -->
                                                                <td><?php echo $all['TRANSACTION_DATE']; ?></td>
                                                                <td><?php echo $all['KETERANGAN']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <table class="table text-center" style="width: 1700px;padding: 0">
                                                            <tr class="bg-default">
                                                                <td width="1200px"></td>
                                                                <td width="750px" style="text-align: left;"><b>TOTAL</b></td>
                                                                <td width="75px"><b><?php echo $qty_minta; ?></b></td>
                                                                <td width="75px"><b><?php echo $qty_kirim; ?></b></td>
                                                                <td width="400px"></td>
                                                                <!-- <td width="60px"><b><?php echo sprintf('%02d:%02d', (int) $lama, fmod($lama, 1) * 60); ?></b></td> -->
                                                            </tr>
                                                    </table>
                                                    <table class="table text-center" style="width: 1700px;padding: 0">
                                                            <tr class="bg-default">
                                                                <td width="1200px"></td>
                                                                <td width="750px" style="text-align: left;"><b>RERATA</b></td>
                                                                <!-- <td width="75px"><b><?php echo $qty_minta; ?></b></td>
                                                                <td width="75px"><b><?php echo $qty_kirim; ?></b></td> -->
                                                                <td width="400px"></td>
                                                                <!-- <td width="60px"><b><?php echo sprintf('%02d:%02d', (int) $lama, fmod($lama, 1) * 60); ?></b></td> -->
                                                            </tr>
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
        </div>
    </div>

<!-- Modal -->
<?php foreach ($outpartAll as $all) : ?>
<div class="modal fade" id="Modalku<?php echo $all['NO_SPBS']; ?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="box-header with border" id="formModalLabel">Ubah Data</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
       <!-- <form action="<?=base_url('MonitoringBarangGudang/Pengeluaran/Update')?>" method="post"> -->
        <form action="<?=base_url('MonitoringBarangGudang/Pengeluaran/insertData')?>" method="post">
            <input type="hidden" name="spbs" id="spbs" value="<?= $all['NO_SPBS']?>">
            <div class="form-group">
                <label for="kirimDate">Tangal Kirim</label>
                <input type="date" class="form-control" id="kirimDate" name="kirimDate" placeholder="<?php echo $all['TGL_KIRIM']; ?>">
            </div>
            <div class="form-group">
                <label for="nomorMobil">Nomor Mobil</label>
                <select>
                    <?php foreach ($NO_MOBIL as $key => $nm) { ?>
                         <option><?=$nm['NO_MOBIL']?></option>
                    <?php } ?>
                   
                </select>
                <!-- <option id="nomorMobil" name="nomorMobil" onchange="getNomorCar();"></option> -->
                <!--input type="text" class="form-control" id="nomorMobil" name="nomorMobil" placeholder="<?php echo $all['NO_MOBIL']; ?>"-->

            </div>
            <div class="form-group">
                <label for="jamMulai">Jam Mulai</label>
                <input type="number" class="form-control" id="jamMulai" name="jamMulai" placeholder="<?php echo $all['JAM_MULAI']; ?>">
            </div>
            <div class="form-group">
                <label for="jamAkhir">Jam Selesai</label>
                <input type="number" class="form-control" id="jamAkhir" name="jamAkhir" placeholder="<?php echo $all['JAM_SELESAI']; ?>">
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php endforeach;?>



</div>
</section>