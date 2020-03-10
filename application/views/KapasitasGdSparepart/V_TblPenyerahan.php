<form action="<?php echo base_url('KapasitasGdSparepart/Penyerahan/cetakData'); ?>" method="post" target="_blank">
<button class="btn btn-lg btn-warning text-right"><i class="fa fa-print"></i> CETAK</button>
<br><br>
<div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>No SPB</th>
                <th>Expedition Code</th>
                <th>Tujuan</th>
                <th>QTY Packing</th>
                <th>Item Coly</th>
                <th>Berat(KG)</th>
            </tr>
        </thead>
        <tbody>     
        <?php $no = 1; 
            for ($i=0; $i < count($spb) ; $i++) { 
                if ($i != 0 && $spb[$i]['MO_NUMBER'] == $spb[$i-1]['MO_NUMBER']) { ?>
                    <tr>
                        <td><input type="hidden" name="berat[]" value="<?= $spb[$i]['SUM_WEIGHT']?>"><?= $spb[$i]['SUM_WEIGHT']?></td>  
                        <input type="hidden" name="nospb[]" value="<?= $spb[$i]['MO_NUMBER']?>">       
                        <input type="hidden" name="ekspedisi[]" value="<?= $spb[$i]['EXPEDITION_CODE'] ?>">
                        <input type="hidden" name="tujuan[]" value="<?= $spb[$i]['TUJUAN']?>">
                        <input type="hidden" name="qty[]" value="<?= $spb[$i]['SUM_PACKING_QTY']?>">
                        <input type="hidden" name="item[]" value="<?= $spb[$i]['ITEM_COLY']?>">
                    </tr>  
                <?php }else{ ?>
            <tr>
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><?= $no?></td>           
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><input type="hidden" name="nospb[]" value="<?= $spb[$i]['MO_NUMBER']?>"><?= $spb[$i]['MO_NUMBER']?></td>           
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><input type="hidden" name="ekspedisi[]" value="<?= $spb[$i]['EXPEDITION_CODE'] ?>"><?= $spb[$i]['EXPEDITION_CODE']?></td>    
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><input type="hidden" name="tujuan[]" value="<?= $spb[$i]['TUJUAN']?>"><?= $spb[$i]['TUJUAN']?></td>       
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><input type="hidden" name="qty[]" value="<?= $spb[$i]['SUM_PACKING_QTY']?>"><?= $spb[$i]['SUM_PACKING_QTY']?></td>        
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>"><input type="hidden" name="item[]" value="<?= $spb[$i]['ITEM_COLY']?>"><?= $spb[$i]['ITEM_COLY']?></td>             
                <td><input type="hidden" name="berat[]" value="<?= $spb[$i]['SUM_WEIGHT']?>"><?= $spb[$i]['SUM_WEIGHT']?></td>      
            </tr>  
        <?php $no++; } } ?>    
        </tbody>
    </table>
</div>
</form>