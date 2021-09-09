<center>
    <b>
        <span style="font-size: large;">
            Detail Dokumen
            <input type="hidden" id="no_dok<?= $detail[0]['NO_DOKUMEN']?>" value="<?= $detail[0]['NO_DOKUMEN']?>" class="no_dok_selesai">
            <input type="hidden" id="pic<?= $detail[0]['PIC']?>" value="<?= $detail[0]['PIC']?>" class="pic_selesai">
            <?= $detail[0]['NO_DOKUMEN']?>
        </span>
    </b>
</center>
<div id="loadingAreaDetail2" style="display: none;">
    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
</div>
<div class="table_detail_item_<?= $detail[0]['NO_DOKUMEN']?>">
    
</div>