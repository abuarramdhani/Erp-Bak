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
                        <form class="form-horizontal" action="<?php echo base_url('MonitoringBarangGudang/Pengeluaran/Filter'); ?>" method="post">
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
                                                     <option value="<?php echo base_url('MonitoringBarangGudang/Pengeluaran/'); ?>">Pilih Semua</option>
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
                                                <div class="table" style="overflow-x:scroll;">
                                                    <table class="table table-bordered table-hover text-center"  style="width: 1900px;padding-bottom: 0" name="tblOutPart1" id="tblOutPart1">
                                                       <thead>
                                                            <tr class="bg-primary">
                                                                <th width="30px" rowspan="2">No</th>
                                                                <th width="250px" rowspan="2">Nama Subkont</th>
                                                                <th width="100px" rowspan="2">No Mobil</th>
                                                                <th width="70px" rowspan="2">No SPBS</th>
                                                                <th width="100px" rowspan="2">No Job</th>
                                                                <th width="100px" rowspan="2">Tgl SPBS Dibuat</th>
                                                                <th width="100px" rowspan="2">Tgl Diterima PPB</th>
                                                                <th width="100px" rowspan="2">Tgl Kirim</th>
                                                                <th width="150px" rowspan="2">Kode Komponen</th>
                                                                <th width="300px" rowspan="2">Nama Komponen</th>
                                                                <th width="100px" colspan="2">QTY</th>
                                                                <th width="40px" rowspan="2">UOM</th>
                                                                <th width="100px" rowspan="2">Subinventory</th>
                                                                <th width="100px" colspan="2">Jam</th>
                                                                <th width="60px" rowspan="2">Lama (m : s)</th>
                                                                <th width="200px" rowspan="2">Tanggal Transact</th>
                                                            </tr>
                                                            <tr class="bg-primary">
                                                                <th>Minta</th>
                                                                <th>Kirim</th>
                                                                <th>Mulai</th>
                                                                <th>Selesai</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                            $qty_kirim = 0;
                                                            $qty_minta = 0;
                                                            $lama = 0;

                                                            $subinv = '';

                                                            $no = 1; foreach($outpartAll as $all){

                                                                $qty_kirim += $all['QTY_KIRIM'];

                                                                $qty_minta += $all['QTY_DIMINTA'];

                                                                

                                                                if (empty($all['TRANSACTION_DATE'])) {
                                                                    $style = 'background-color:#f71c0c;color:white';
                                                                }else{
                                                                    $style = 'background-color:#51f922 ;color:black';
                                                                }

                                                                if($subinv != $all['SUBINV']){
                                                                    $lama += $all['LAMA'];
                                                                    $subinv = $all['SUBINV'];
                                                                }

                                                        ?>
                                                        <tbody>
                                                            <tr style="<?php echo $style; ?>">
                                                                <td><?php echo $no++; ?></td>
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
                                                                <td><?php echo $all['LAMA']; ?></td>
    <!-- <td><?php echo empty($all['TRANSACTION_DATE']) ? '' : date_format(date_create($all['TRANSACTION_DATE']),'M-d-Y h:i:s'); ?></td> -->
                                                                <td><?php echo $all['TRANSACTION_DATE']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                        <?php } ?>
                                                    </table>
                                                    <table class="table text-center" style="width: 1700px;padding: 0">
                                                            <tr class="bg-default">
                                                                <td width="1100px"></td>
                                                                <td width="500px" style="text-align: left;"><b>TOTAL</b></td>
                                                                <td width="75px"><b><?php echo $qty_minta; ?></b></td>
                                                                <td width="75px"><b><?php echo $qty_kirim; ?></b></td>
                                                                <td width="400px"></td>
                                                                <td width="60px"><b><?php echo gmdate('i:s', $lama); ?></b></td>
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
</div>
</section>