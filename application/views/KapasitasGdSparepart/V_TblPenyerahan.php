<div class="panel-body">
    <div class="col-md-3">
        <input type="text" class="form-control" style="margin-left:-25px" id="noscan" placeholder="Masukkan No SPB" onkeyup="upnostttpenyerahan(event,this)">
    </div>
    <br>
</div>
<form action="<?php echo base_url('KapasitasGdSparepart/Penyerahan/cetakData'); ?>" method="post" target="_blank">
<div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tbserah" style="width: 100%;">
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
                    <tr data-row="<?= $spb[$i]['MO_NUMBER']?>" data-id="<?= $spb[$i]['ITEM_COLY']?>">
                        <td class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="berat[]" value="<?= $spb[$i]['SUM_WEIGHT']?>"><?= $spb[$i]['SUM_WEIGHT']?></td>  
                        <input type="hidden" name="nospb[]" value="<?= $spb[$i]['MO_NUMBER']?>">       
                        <input type="hidden" name="ekspedisi[]" value="<?= $spb[$i]['EXPEDITION_CODE'] ?>">
                        <input type="hidden" name="tujuan[]" value="<?= $spb[$i]['TUJUAN']?>">
                        <input type="hidden" name="qty[]" value="<?= $spb[$i]['SUM_PACKING_QTY']?>">
                        <input type="hidden" name="item[]" value="<?= $spb[$i]['ITEM_COLY']?>">
                        <input type="hidden" name="jmlscan[]" value="0">
                    </tr>  
                <?php }else{ ?>
            <tr data-row="<?= $spb[$i]['MO_NUMBER']?>" data-id="<?= $spb[$i]['ITEM_COLY']?>">
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="jmlscan[]" value="0"><?= $no?></td>           
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="nospb[]" value="<?= $spb[$i]['MO_NUMBER']?>"><?= $spb[$i]['MO_NUMBER']?></td>           
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="ekspedisi[]" value="<?= $spb[$i]['EXPEDITION_CODE'] ?>"><?= $spb[$i]['EXPEDITION_CODE']?></td>    
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="tujuan[]" value="<?= $spb[$i]['TUJUAN']?>"><?= $spb[$i]['TUJUAN']?></td>       
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="qty[]" value="<?= $spb[$i]['SUM_PACKING_QTY']?>"><?= $spb[$i]['SUM_PACKING_QTY']?></td>        
                <td rowspan="<?= $spb[$i]['ITEM_COLY']?>" class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="item[]" value="<?= $spb[$i]['ITEM_COLY']?>"><?= $spb[$i]['ITEM_COLY']?></td>             
                <td class="<?= $spb[$i]['MO_NUMBER']?>"><input type="hidden" name="berat[]" value="<?= $spb[$i]['SUM_WEIGHT']?>"><?= $spb[$i]['SUM_WEIGHT']?></td>      
            </tr>  
        <?php $no++; } } ?>    
        </tbody>
    </table>
</div>
<div class="text-right">
    <button  type="submit" class="btn btn-lg btn-warning"><i class="fa fa-print"></i> CETAK</button>
</div>
</form>