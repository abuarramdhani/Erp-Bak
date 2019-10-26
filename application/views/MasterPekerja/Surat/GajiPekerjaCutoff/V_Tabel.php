<div class="row">
  <div class="form-group">
    <div class="box box-body box-solid box-warning" style="width: 94%; margin-left: 30px">
      <h1 class="bg-info text-center">Input Atasan</h1>
      <div class="table-responsive">
        <table class="table table-bordered table-hover" style="width: 100%">
          <thead style="background-color: #e6e6e6; font-size: 15px">
            <tr>
              <th style="width: 5%; padding-left: 12px">No</th>
              <th style="width: 20%; text-align: center">Seksi</th>
              <th style="width: 30%; text-align: center">Atasan</th>
            </tr>
          </thead>
          <tbody id="tbodyatasan">
            <?php
            $no = 1;
            foreach ($new as $y) { ?>
              <tr class="clone">
                <td style="text-align: center; padding-top: 15px"><?php echo $no++; ?></td>
                <td style="text-align: center;" class="namaSeksi"><?php echo $y ?></td>
                <td style="text-align: center;">
                  <select class="form-control classkuhehe" name="atasan[]" style="width: 80%;" required>
                    <option></option>
                    <?php foreach ($head as $l){
                      if ($y == $l['seksi']) {
                        $atasan = str_replace('{"','',$l['atasan_langsung']);
                        $atasan = str_replace('"}','',$atasan);
                        $atasan = str_replace('","' , ' , ',$atasan);
                        $atasan = explode(' , ',$atasan);
                        $n = 0;
                        foreach ($atasan as $val) {
                      ?>
                      <option value="<?php echo $atasan[$n] ?>" required><?php echo $atasan[$n] ?></option>
                    <?php $n++; } } } ?>
                  </select>
                </td>
              </tr>
            <?php }  ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
