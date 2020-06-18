<div class="box box-solid">
    <div class="box-body">
        <div>
        <form action="<?php echo base_url('PerhitunganUM/Hitung/hitungan'); ?>" method="post">
        <table id="tblsatu" class="datatable table table-striped table-bordered table-hover" style="font-size: 13px;">
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
                    <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['bln1']?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['bln2']?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $hasil[0]['bln3']?></td>
                </tr>
            </thead>
            <tbody>  

            <?php $p=0; $no=1;foreach($hasil as $v){ ?>     
                <tr style="text-align: center; vertical-align: middle;">                        
                    <td><?= $no; ?>
                        <input type="hidden" name="username[]" id="username" value="<?= $username?>"/>
                        <input type="hidden" name="jenis_mesin[]" id="jenis_mesin" value="<?= $v['jenis_mesin']?>"/>            
                        <input type="hidden" name="dept[]" id="dept" value="<?= $dept?>"/>                      
                        <input type="hidden" name="plan[]" id="plan" value="<?= $plan?>"/>                      
                        <input type="hidden" name="opr_seq[]" id="opr_seq" value="<?= $v['opr_seq']?>"/>     
                        <input type="hidden" name="bln1[]" id="bln1" value="<?= $v['bln1']?>"/>     
                        <input type="hidden" name="bln2[]" id="bln2" value="<?= $v['bln2']?>"/>     
                        <input type="hidden" name="bln3[]" id="bln3" value="<?= $v['bln3']?>"/>     
                        <input type="hidden" name="periode[]" id="periode" value="<?= $v['periode1']?> - <?= $v['periode2']?> <?= date('Y')?>"/>  
                    </td>   
                    <td><input type="hidden" name="cost_center[]" id="cost_center" value="<?= $v['cost_center']?>"><?= $v['cost_center']?></td>               
                    <td class="text-nowrap"><input type="hidden" name="resource_code[]" id="resource_code" value="<?= $v['resource_code']?>"><?= $v['resource_code']?></td>               
                    <td><input type="hidden" name="deskripsi[]" id="deskripsi" value="<?= $v['deskripsi']?>"><?= $v['deskripsi']?></td>               
                    <td style="text-align: left;"><input type="hidden" name="mesin[]" id="mesin" value="<?= $v['Mesin']?>"><?= $v['Mesin']?></td>               
                    <td><input type="hidden" name="tag_number[]" id="tag_number" value="<?= $v['tag_number']?>"><?= $v['tag_number']?></td>                    
                    <td  class="text-nowrap" ><input type="hidden" name="item_code[]" id="item_code" value="<?= $v['Item']?>"><?= $v['Item']?></td>               
                    <td style="text-align: left;"><input type="hidden" name="item_desc[]" id="item_desc" value="<?php echo $v['Description']?>"><?php echo $v['Description']?></td>                        
                    <td><input type="hidden" name="cycle_time[]" id="cycle_time" value="<?= $v['cycle_time']?>"/><?= $v['cycle_time']?></td>            
                    <td style="text-align: left;"><input type="hidden" name="stock[]" id="stock" value="<?= $v['stock']?>"><?= $v['stock']?></td>          
                    <td><input type="hidden" name="qty1[]" id="qty1" value="<?= $v['qty1']?>"/><?= $v['qty1']?></td>                        
                    <td><input type="hidden" name="qty2[]" id="qty2" value="<?= $v['qty2']?>"/><?= $v['qty2']?></td>                        
                    <td><input type="hidden" name="qty3[]" id="qty3" value="<?= $v['qty3']?>"/><?= $v['qty3']?></td>                      
                                       
                </tr>                    
                <?php $no++; $p++; } ?>
            </tbody>
        </table>
        <div class="row text-center" style="padding-right: 10px">
            <button type="submit" title="next" class="btn btn-success"><i class="fa fa-arrow-right"></i><b> next</b></button>
        </div>
        </form>
    </div>
</div>
</div>
