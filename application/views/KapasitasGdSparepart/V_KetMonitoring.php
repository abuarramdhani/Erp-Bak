<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><h4><b>Monitoring <?= $data['tanggal']?></b></h4></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <form method="post" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Monitoring/exportSPB')?>">
                                    <div class="panel-body">
                                        <h3>A. MASUK</h3>
                                        <table class="table table-bordered table-hover table-striped text-center" style="width: 100%;">
                                            <thead class="btn-info">
                                                <tr>
                                                    <th rowspan="2" width="5px">No</th>
                                                    <th rowspan="2">Keterangan</th>
                                                    <th colspan="3">DO</th>
                                                    <th colspan="3">SPB</th>
                                                    <th colspan="3">Jumlah</th>
                                                </tr>
                                                <tr>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                $no=1; foreach($data['masuk'] as $val){ 
                                                if ($no == 1) { $ket = 'URGENT';
                                                }elseif ($no == 2) { $ket = 'TIDAK URGENT';
                                                }elseif ($no == 3) { $ket = 'BON';
                                                }elseif ($no == 4) { $ket = 'LANGSUNG';
                                                }elseif ($no == 5) { $ket = 'BEST'; }

                                                $lembar1[$i] = $val['lembar1']; $item1[$i] = $val['item1']; $pcs1[$i] = $val['pcs1'];
                                                $lembar2[$i] = $val['lembar2']; $item2[$i] = $val['item2']; $pcs2[$i] = $val['pcs2'];
                                                $jumlah1[$i] = $val['lembar1'] + $val['lembar2']; 
                                                $jumlah2[$i] = $val['item1'] + $val['item2']; 
                                                $jumlah3[$i] = $val['pcs1'] + $val['pcs2']; 
                                                ?>
                                                    <tr>
                                                        <td style="width:5%"><?= $no; ?>
                                                            <input type="hidden" name="tglAwal[]" value="<?= $data['tglawal']?>">
                                                            <input type="hidden" name="tglAkhir[]" value="<?= $data['tglakhir']?>"></td>
                                                        <td style="text-align:left"><?= $ket?></td>
                                                        <td><?= $val['lembar1']?></td>
                                                        <td><?= $val['item1']?></td>
                                                        <td><?= $val['pcs1']?></td>
                                                        <td><?= $val['lembar2']?></td>
                                                        <td><?= $val['item2']?></td>
                                                        <td><?= $val['pcs2']?></td>
                                                        <td><?= $val['lembar1'] + $val['lembar2']?></td>
                                                        <td><?= $val['item1'] + $val['item2']?></td>
                                                        <td><?= $val['pcs1'] + $val['pcs2']?></td>
                                                    </tr>
                                                <?php $no++; $i++;}?>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2">JUMLAH</td>
                                                <td><?= array_sum($lembar1)?></td>
                                                <td><?= array_sum($item1)?></td>
                                                <td><?= array_sum($pcs1)?></td>
                                                <td><?= array_sum($lembar2)?></td>
                                                <td><?= array_sum($item2)?></td>
                                                <td><?= array_sum($pcs2)?></td>
                                                <td><?= array_sum($jumlah1)?></td>
                                                <td><?= array_sum($jumlah2)?></td>
                                                <td><?= array_sum($jumlah3)?></td>
                                            </tfoot>
                                        </table>
                                    </div>

                                    
                                    <div class="panel-body">
                                        <h3>B. CANCEL</h3>
                                        <table class="table table-bordered table-hover table-striped text-center" style="width: 100%;">
                                            <thead class="btn-danger">
                                                <tr>
                                                    <th rowspan="2" width="5px">No</th>
                                                    <th rowspan="2">Keterangan</th>
                                                    <th colspan="3">DO</th>
                                                    <th colspan="3">SPB</th>
                                                    <th colspan="3">Jumlah</th>
                                                </tr>
                                                <tr>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                $no=1; foreach($data['cancel'] as $val){ 
                                                    if ($no == 1) { $ket = 'URGENT';
                                                    }elseif ($no == 2) { $ket = 'TIDAK URGENT';
                                                    }elseif ($no == 3) { $ket = 'BON';
                                                    }elseif ($no == 4) { $ket = 'LANGSUNG';
                                                    }elseif ($no == 5) { $ket = 'BEST'; }
    
                                                    $lembar1[$i] = $val['lembar1']; $item1[$i] = $val['item1']; $pcs1[$i] = $val['pcs1'];
                                                    $lembar2[$i] = $val['lembar2']; $item2[$i] = $val['item2']; $pcs2[$i] = $val['pcs2'];
                                                    $jumlah1[$i] = $val['lembar1'] + $val['lembar2']; 
                                                    $jumlah2[$i] = $val['item1'] + $val['item2']; 
                                                    $jumlah3[$i] = $val['pcs1'] + $val['pcs2']; 
                                                ?>
                                                    <tr>
                                                        <td style="width:5%"><?= $no; ?></td>
                                                        <td style="text-align:left"><?= $ket?></td>
                                                        <td><?= $val['lembar1']?></td>
                                                        <td><?= $val['item1']?></td>
                                                        <td><?= $val['pcs1']?></td>
                                                        <td><?= $val['lembar2']?></td>
                                                        <td><?= $val['item2']?></td>
                                                        <td><?= $val['pcs2']?></td>
                                                        <td><?= $val['lembar1'] + $val['lembar2']?></td>
                                                        <td><?= $val['item1'] + $val['item2']?></td>
                                                        <td><?= $val['pcs1'] + $val['pcs2']?></td>
                                                    </tr>
                                                <?php $no++; $i++;}?>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2">JUMLAH</td>
                                                <td><?= array_sum($lembar1)?></td>
                                                <td><?= array_sum($item1)?></td>
                                                <td><?= array_sum($pcs1)?></td>
                                                <td><?= array_sum($lembar2)?></td>
                                                <td><?= array_sum($item2)?></td>
                                                <td><?= array_sum($pcs2)?></td>
                                                <td><?= array_sum($jumlah1)?></td>
                                                <td><?= array_sum($jumlah2)?></td>
                                                <td><?= array_sum($jumlah3)?></td>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="panel-body">
                                        <h3>C. PACKING</h3>
                                        <table class="table table-bordered table-hover table-striped text-center" style="width: 100%;">
                                            <thead class="bg-orange">
                                                <tr>
                                                    <th rowspan="2" width="5px">No</th>
                                                    <th rowspan="2">Keterangan</th>
                                                    <th colspan="3">DO</th>
                                                    <th colspan="3">SPB</th>
                                                    <th colspan="3">Jumlah</th>
                                                </tr>
                                                <tr>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                $no=1; foreach ($data['packing'] as $val) {
                                                if ($no == 1) { $ket = 'DIKERJAKAN';
                                                }elseif ($no == 2) { $ket = 'KURANG'; 
                                                }elseif ($no == 3) { $ket = 'SELESAI'; }
                                                
                                                $lembar1[$i] = $val['lembar1']; $item1[$i] = $val['item1']; $pcs1[$i] = $val['pcs1'];
                                                $lembar2[$i] = $val['lembar2']; $item2[$i] = $val['item2']; $pcs2[$i] = $val['pcs2'];
                                                $jumlah1[$i] = $val['lembar1'] + $val['lembar2']; 
                                                $jumlah2[$i] = $val['item1'] + $val['item2']; 
                                                $jumlah3[$i] = $val['pcs1'] + $val['pcs2']; 
                                                ?>
                                                    <tr>
                                                        <td style="width:5%"><?= $no; ?></td>
                                                        <td style="text-align:left"><?= $ket?></td>
                                                        <td><?= $val['lembar1']?></td>
                                                        <td><?= $val['item1']?></td>
                                                        <td><?= $val['pcs1']?></td>
                                                        <td><?= $val['lembar2']?></td>
                                                        <td><?= $val['item2']?></td>
                                                        <td><?= $val['pcs2']?></td>
                                                        <td><?= $val['lembar1'] + $val['lembar2']?></td>
                                                        <td><?= $val['item1'] + $val['item2']?></td>
                                                        <td><?= $val['pcs1'] + $val['pcs2']?></td>
                                                    </tr>
                                                <?php $no++; $i++;}?>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2">JUMLAH</td>
                                                <td><?= array_sum($lembar1)?></td>
                                                <td><?= array_sum($item1)?></td>
                                                <td><?= array_sum($pcs1)?></td>
                                                <td><?= array_sum($lembar2)?></td>
                                                <td><?= array_sum($item2)?></td>
                                                <td><?= array_sum($pcs2)?></td>
                                                <td><?= array_sum($jumlah1)?></td>
                                                <td><?= array_sum($jumlah2)?></td>
                                                <td><?= array_sum($jumlah3)?></td>
                                            </tfoot>
                                        </table>
                                    </div>

                                    
                                    <div class="panel-body">
                                        <h3>D. PACKING DALAM COLY</h3>
                                        <table class="table table-bordered table-hover table-striped text-center" style="width: 30%;">
                                            <thead class="btn-warning">
                                                <tr>
                                                    <th width="5px">No</th>
                                                    <th>Jenis Coly</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $no=1; foreach ($data['coly'] as $val) {  
                                                if ($no == 1) { $ket = 'Kardus Kecil';
                                                }elseif ($no == 2) { $ket = 'Kardus Sedang';
                                                }elseif ($no == 3) { $ket = 'Kardus Panjang'; 
                                                }elseif ($no == 4) { $ket = 'Karung'; 
                                                }elseif ($no == 5) { $ket = 'Peti'; }?>
                                                    <tr>
                                                        <td style="width:5%"><?= $no; ?></td>
                                                        <td style="text-align:left"><?= $ket?></td>
                                                        <td><input type="hidden" name="coly[]" value="<?= $data['coly'][$ket]?>"><?= $data['coly'][$ket]?></td>
                                                    </tr>
                                                <?php $no++;}?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="panel-body">
                                        <h3>E. DOSP/SPB BELUM DIKERJAKAN</h3>
                                        <table class="table table-bordered table-hover table-striped text-center" style="width: 100%;">
                                            <thead class="btn-success">
                                                <tr>
                                                    <th rowspan="2" width="5px">No</th>
                                                    <th rowspan="2">Keterangan</th>
                                                    <th colspan="3">DO</th>
                                                    <th colspan="3">SPB</th>
                                                    <th colspan="3">Jumlah</th>
                                                </tr>
                                                <tr>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                    <th>Lembar</th>
                                                    <th>Item</th>
                                                    <th>Pcs</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                $no=1; foreach ($data['belum'] as $val) { 
                                                if ($no == 1) { $ket = 'PENDING';
                                                }elseif ($no == 2) { $ket = 'PELAYANAN'; 
                                                }elseif ($no == 3) { $ket = 'PENGELUARAN';
                                                }elseif ($no == 4) { $ket = 'PACKING'; }
                                                
                                                $lembar1[$i] = $val['lembar1']; $item1[$i] = $val['item1']; $pcs1[$i] = $val['pcs1'];
                                                $lembar2[$i] = $val['lembar2']; $item2[$i] = $val['item2']; $pcs2[$i] = $val['pcs2'];
                                                $jumlah1[$i] = $val['lembar1'] + $val['lembar2']; 
                                                $jumlah2[$i] = $val['item1'] + $val['item2']; 
                                                $jumlah3[$i] = $val['pcs1'] + $val['pcs2']; 
                                                ?>
                                                    <tr>
                                                        <td style="width:5%"><?= $no; ?></td>
                                                        <td style="text-align:left"><?= $ket?></td>
                                                        <td><?= $val['lembar1']?></td>
                                                        <td><?= $val['item1']?></td>
                                                        <td><?= $val['pcs1']?></td>
                                                        <td><?= $val['lembar2']?></td>
                                                        <td><?= $val['item2']?></td>
                                                        <td><?= $val['pcs2']?></td>
                                                        <td><?= $val['lembar1'] + $val['lembar2']?></td>
                                                        <td><?= $val['item1'] + $val['item2']?></td>
                                                        <td><?= $val['pcs1'] + $val['pcs2']?></td>
                                                    </tr>
                                                <?php $no++; $i++; }?>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2">JUMLAH</td>
                                                <td><?= array_sum($lembar1)?></td>
                                                <td><?= array_sum($item1)?></td>
                                                <td><?= array_sum($pcs1)?></td>
                                                <td><?= array_sum($lembar2)?></td>
                                                <td><?= array_sum($item2)?></td>
                                                <td><?= array_sum($pcs2)?></td>
                                                <td><?= array_sum($jumlah1)?></td>
                                                <td><?= array_sum($jumlah2)?></td>
                                                <td><?= array_sum($jumlah3)?></td>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <?php for ($i=0; $i < count($data['ket']['tgl']); $i++) { ?>
                                        <input type="hidden" name="tanggalnya[]" value="<?= $data['ket']['tgl'][$i]?>">
                                        <input type="hidden" name="jml_selesai[]" value="<?= $data['ket']['jml'][$i]?>">
                                        <input type="hidden" name="krg_selesai[]" value="<?= $data['ket']['krg'][$i]?>">
                                    <?php }?>

                                    <div class="panel-body">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-download"> Download</i></button>
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