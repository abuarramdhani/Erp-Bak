<div class="panel-body" >
    <div class="col-md-3"><label>Persiapan Material (set)</label></div>
    <div class="col-md-8">
        <input type="number" id="persiapan" name="persiapan" class="form-control" autocomplete="off" placeholder="*isi 0 jika persiapan kosong" value="<?= $inprogress['persiapan_qty']?>" <?= $qty <= $inprogress['persiapan_qty'] ? 'readonly' : '';?>>
        <input type="hidden" id="order_num" name="order_num" value="<?= $id_order?>">
        <input type="hidden" id="revisi_num" name="revisi_num" value="<?= $id_revisi?>">
        <input type="hidden" id="no" name="no" value="<?= $no?>">
        <input type="hidden" id="qty_order" name="qty_order" value="<?= $qty?>">
    </div>
</div>
<div class="panel-body" >
    <div class="col-md-3"><label>Pengelasan (set)</label></div>
    <div class="col-md-8">
        <input type="number" id="pengelasan" name="pengelasan" class="form-control" autocomplete="off" placeholder="*isi 0 jika pengelasan kosong" value="<?= $inprogress['pengelasan_qty']?>" <?= $qty <= $inprogress['pengelasan_qty'] ? 'readonly' : '';?>>
    </div>
</div>
<div class="panel-body" >
    <div class="col-md-3"><label>Pengecatan (set)</label></div>
    <div class="col-md-8">
        <input type="number" id="pengecatan" name="pengecatan" class="form-control" autocomplete="off" placeholder="*isi 0 jika pengecatan kosong" value="<?= $inprogress['pengecatan_qty']?>">
    </div>
</div>
<div class="panel-body text-center">
    <button id="button_selesai_progress<?=  $no?>" class="btn btn-success">Submit</button>
</div>