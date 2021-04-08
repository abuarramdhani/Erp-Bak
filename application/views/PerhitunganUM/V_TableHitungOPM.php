<div class="box box-solid">
    <div class="box-body">
        <div>
            <form action="<?php echo base_url('PerhitunganUM/HitungOPM/hitungan'); ?>" method="post">
                <table id="tblsatuopm" class="datatable table table-striped table-bordered table-hover" style="font-size: 13px;">
                    <thead class="bg-info">
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" width="4%">NO.</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">COST CENTER</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">RESOURCE CODE</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESCRIPTION</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">NO MESIN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">TAG NUMBER</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">KODE KOMPONEN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESKRIPSI KOMPONEN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">CYCLE TIME</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">STOK AWAL</th>
                            <th colspan="3" style="text-align: center; vertical-align: middle;">PLANNED ORDER DEMAND AND FORECAST</th>

                        </tr>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['BLN1']?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['BLN2']?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['BLN3']?></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $p=0; $no=1; foreach($hasil as $v){ ?> 
                        <tr style="text-align: center; vertical-align: middle;">
                            <td>
                                <?= $no; ?>
                                <input type="hidden" name="username_opm[]" id="username_opm" value="<?= $usernameopm?>"/>
                                <input type="hidden" name="jenis_mesin[]" id="jenis_mesin" value="<?= $v['JENIS_MESIN']?>"/>  
                                <input type="hidden" name="routclass[]" id="routclass" value="<?= $routclass?>"/>                      
                                <input type="hidden" name="planopm[]" id="planopm" value="<?= $planopm?>"/>                      
                                <input type="hidden" name="bln1[]" id="bln1" value="<?= $v['BLN1']?>"/>     
                                <input type="hidden" name="bln2[]" id="bln2" value="<?= $v['BLN2']?>"/>     
                                <input type="hidden" name="bln3[]" id="bln3" value="<?= $v['BLN3']?>"/>     
                                <input type="hidden" name="periode[]" id="periode" value="<?= $v['PERIODE1']?> - <?= $v['PERIODE2']?> <?= date('Y')?>"/>  
                            </td>
                            <td><input type="hidden" name="cost_center_opm[]" id="cost_center_opm" value="<?= $v['COST_CENTER']?>"><?= $v['COST_CENTER']?></td>
                            <td class="text-nowrap"><input type="hidden" name="resource_code_opm[]" id="resource_code_opm" value="<?= $v['RESOURCES']?>"><?= $v['RESOURCES']?></td>
                            <td><input type="hidden" name="deskripsi_opm[]" id="deskripsi_opm" value="<?= $v['RESOURCE_DESC']?>"><?= $v['RESOURCE_DESC']?></td>
                            <td><input type="hidden" name="mesin_opm[]" id="mesin_opm" value="<?= $v['NO_MESIN']?>"><?= $v['NO_MESIN']?></td>
                            <td><input type="hidden" name="tag_number_opm[]" id="tag_number_opm" value="<?= $v['TAG_NUMBER']?>"><?= $v['TAG_NUMBER']?></td>
                            <td class="text-nowrap"><input type="hidden" name="item_code_opm[]" id="item_code_opm" value="<?= $v['KODE_KOMPONEN']?>"><?= $v['KODE_KOMPONEN']?></td>
                            <td><input type="hidden" name="item_desc_opm[]" id="item_desc_opm" value="<?= $v['DESCRIPTION']?>"><?= $v['DESCRIPTION']?></td>
                            <td><input type="hidden" name="cycle_time_opm[]" id="cycle_time_opm" value="<?= sprintf("%f",$v['RESOURCE_USAGE'])?>"/><?= sprintf("%f",$v['RESOURCE_USAGE'])?></td>
                            <td><input type="hidden" name="stock_opm[]" id="stock_opm" value="<?= $v['STOK_AWAL']?>"><?= $v['STOK_AWAL']?></td>
                            <td><input type="hidden" name="qty1_opm[]" id="qty1_opm" value="<?= $v['POD1']?>"/><?= $v['POD1']?></td>
                            <td><input type="hidden" name="qty2_opm[]" id="qty2_opm" value="<?= $v['POD2']?>"/><?= $v['POD2']?></td>
                            <td><input type="hidden" name="qty3_opm[]" id="qty3_opm" value="<?= $v['POD3']?>"/><?= $v['POD3']?></td>
                        </tr>
                    <?php $no++; $p++; } ?> 
                    </tbody>
                </table>
                <div class="row text-center" style="padding-right: 10px">
                    <button type="submit" title="next" class="btn btn-success">
                        <i class="fa fa-arrow-right"></i><b> Next</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>