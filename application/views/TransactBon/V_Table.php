<form action="<?=base_url('TransactBon/C_Transact/insertOracle'); ?>" method="post">
<div class="row">
    <div class="col-md-12" >
        <div class="table">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table" style="overflow-x:scroll;max-width:100%;max-height: 80vh;">
                        <table class="datatable table table-striped table-bordered table-hover text-center" id="tblDataStock" style="width: 100%;">
                           <thead style="position:sticky;top:0;">
                                <tr class="bg-primary">
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="30px" rowspan="2">No</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">Kode Barang</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Nama Barang</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Satuan</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Permintaan</th>
                                    <th style="display:none"  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Penyerahan Postgre</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Penyerahan</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Kurang</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">Tanggal</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">Tujuan Gudang</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">Cost Center</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="40px" rowspan="2">Lokasi</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Nomor ID</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Account</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Nama Barang</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Penyerahan</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Lokator</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >IP</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Produk</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Keterangan</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Satuan</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Kode Cabang</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Nomor Bon</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >Cost Center</th>
                                    <th style="display:none" class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2" >User ID</th>
                            </thead>
                            <tbody>
                                
                                <?php
											if (empty($datatabel)) {
												# code...
													}else{
														$no=1;
														foreach ($datatabel as $key) {
										?>
                                    <tr class="result">
                                    <td><?php echo $no; ?></td>
                                    <td>
                                    <?php echo $key['kode_barang']; ?>
                                    <input hidden name="tsc_kodeBarang[]" value="<?php echo $key['kode_barang']; ?>">
                                    <input hidden name="tsc_Account[]" value="<?php echo $key['account']; ?>">
                                    <input hidden name="tsc_noUrut[]" value="<?php echo $no; ?>">
                                    <input hidden name="tsc_NamaBarang[]" value="<?php echo $key['nama_barang']; ?>">
                                    <input hidden name="tsc_Penyerahan[]" value="<?php echo $key['penyerahan']; ?>">
                                    <input hidden name="tsc_Permintaan[]" value="<?php echo $key['permintaan']; ?>">
                                    <input hidden name="tsc_Give[]" id="final" value="<?php echo $key['penyerahan']; ?>">
                                    <input hidden name="tsc_tujuanGudang[]" value="<?php echo $key['tujuan_gudang']; ?>">
                                    <input hidden name="tsc_Lokator[]" value="<?php echo $key['lokator']; ?>">
                                    <input hidden name="tsc_IP[]" value="<?php echo $key['ip']; ?>">
                                    <input hidden name="tsc_Produk[]" value="<?php echo $key['produk']; ?>">
                                    <input hidden name="tsc_Keterangan[]" value="<?php echo $key['keterangan']; ?>">
                                    <input hidden name="tsc_Satuan[]" value="<?php echo $key['satuan']; ?>">
                                    <input hidden name="tsc_kodeCabang[]" value="<?php echo $key['kode_cabang']; ?>">
                                    <input hidden name="tsc_seksiBon[]" value="<?php echo $key['seksi_bon']; ?>">
                                    <input hidden name="tsc_noBon[]" value="<?php echo $key['no_bon']; ?>">
                                    <input hidden name="tsc_Flag[]" value="<?php echo $key['flag']; ?>">
                                    <input hidden name="tsc_noID[]" value="<?php echo $key['no_id']; ?>">
                                    <input hidden name="tsc_costCenter" value="<?php echo $key['cost_center']; ?>">
                                    <input hidden name="tsc_tjnGudang[]" value="<?php echo $key['tujuan_gudang']; ?>">
                                    <input hidden name="tsc_usr" value="<?php echo $usr_id; ?>">
                                    </td>
                                    <td><?php echo $key['nama_barang']; ?></td>
                                    <td><?php echo $key['satuan']; ?></td>
                                    <td id="minta"><?php echo $key['permintaan']; ?>
                                    <input hidden id="give2" value="<?php echo $key['penyerahan']; ?>"/></td>
                                    <td style="display:none" id="give" class="give">
                                        <?php echo $key['penyerahan']; ?>
                                    </td>
                                    <td><input style="height:22px; width:100%;" type="number" id="serah" name="penyerahan[]" class="serah"></td>
                                    <td id="kurang"></td>
                                    <td><?php echo $key['tanggal']; ?></td>
                                    <td><?php echo $key['tujuan_gudang']; ?></td>
                                    <td><?php echo $key['cost_center']; ?></td>
                                    <td><?php echo $key['lokasi']; ?></td> 
                                    <td class="trs_id" style="display:none" name="id-" + count><?php echo $key['no_id']; ?></td>
                                    <td style="display:none"><?php echo $key['account']; ?></td> 
                                    <td style="display:none"><?php echo $key['nama_barang']; ?></td> 
                                    <td style="display:none"><?php echo $key['penyerahan']; ?></td>
                                    <td style="display:none"><?php echo $key['tujuan_gudang']; ?></td>
                                    <td style="display:none"><?php echo $key['lokator']; ?></td> 
                                    <td style="display:none"><?php echo $key['ip']; ?></td> 
                                    <td style="display:none"><?php echo $key['produk']; ?></td> 
                                    <td style="display:none"><?php echo $key['keterangan']; ?></td> 
                                    <td style="display:none"><?php echo $key['satuan']; ?></td> 
                                    <td style="display:none"><?php echo $key['kode_cabang']; ?></td> 
                                    <td style="display:none"><?php echo $key['seksi_bon']; ?></td>   
                                    <td style="display:none"><?php echo $key['no_bon']; ?></td> 
                                    <td style="display:none"><?php echo $key['flag']; ?></td>
                                    <td style="display:none"><?php echo $usr_id; ?></td>
                                </tr>
                            <?php $no++; } } ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
        <div class="">
            <div class="col-md-12" style="padding-top: 5px">
                <button class="btn btn-primary" type="submit">TRANSACT</button>
            </div>
        </div>
        </div>
    </div>
</form>