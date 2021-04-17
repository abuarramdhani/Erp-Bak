<?php
  if ($plan == 5) {
    $plan = 1;
  }elseif ($plan == 4) {
    $plan = 3;
  }elseif ($plan == 1) {
    $plan = 2;
  }else {
    $plan = '-';
  }
 ?>

 <style media="screen">
   .btn-group{
     margin-bottom: -45px;
   }
 </style>

<p class="label label-success" style="font-size:13px;margin-bottom:5px;">
 Department Class <strong style="color:#ffe492"><?php echo $dept ?></strong>, Plan <strong style="color:#ffe492"><?php echo $plan ?></strong>, Time <strong style="color:#ffe492"><?php echo $jam ?></strong> Hours
</p>
<div class="table-responsive">
    <form action="" method="post">
    <table class="table table-stripped table-bordered table-hover tb-monloadprod" style="font-size:12px;width:100%">
        <thead>
            <tr class="bg-primary">
                <th rowspan="2" style="text-align:center; vertical-align:middle;" width="4%">NO.</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;" class="text-nowrap">NAMA LINE</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;">NO MESIN</th>
                <th colspan="3" style="text-align:center; vertical-align:middle;border-bottom:0px;">KOMPONEN YANG DIKERJAKAN</th>
                <th colspan="3" style="text-align:center; vertical-align:middle;border-bottom:0px;">TARGET</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;">POD</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;">NEED SHIFT</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;"> SHIFT</th>
                <th rowspan="2" style="text-align:center; vertical-align:middle;">NEED HOURS</th>
            </tr>
            <tr class="bg-primary">
                <th style="text-align: center; vertical-align: middle;" class="text-nowrap">KODE KOMPONEN</th>
                <th style="text-align: center; vertical-align: middle;">NAMA KOMPONEN</th>
                <th style="text-align: center; vertical-align: middle;">KODE PROSES</th>
                <th style="text-align: center; vertical-align: middle;">S-K</th>
                <th style="text-align: center; vertical-align: middle;">J-S</th>
                <th style="text-align: center; vertical-align: middle;border-right:1px solid white;">AVERAGE</th>
            </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($master as $key => $value): ?>
            <?php if ($key >= 1): ?>
              <tr>
                <td class="stext-center"><?php echo $no ?></td>
                <td style="<?php echo $value['DESKRIPSI'] != $master[$key-1]['DESKRIPSI'] ? 'font-weight:bold' : 'color:#9e9e9e' ?>"><?php echo $value['DESKRIPSI'] ?></td>
                <td><?php echo $value['NO_MESIN'] ?></td>
                <td><?php echo $value['KODE_KOMPONEN'] ?></td>
                <td><?php echo $value['DESKRIPSI_KOMPONEN'] ?></td>
                <td><?php echo $value['KODE_PROSES'] ?></td>
                <td><?php echo $value['SENIN_KAMIS'] ?></td>
                <td><?php echo $value['JUMAT_SABTU'] ?></td>
                <td><?php echo $value['AVERAGE'] ?></td>
                <td><?php echo $value['QTY'] ?></td>
                <td><?php echo abs($value['NEED_SHIFT']) ?></td>
                <td><?php echo abs($value['SIGMA_SHIFT']) ?></td>
                <td><?php echo abs($value['NEED_HOUR']) ?></td>
              </tr>
            <?php $no++; endif; ?>
          <?php endforeach; ?>
        </tbody>
    </table>
    </form>
    <div class="row mt-2 mb-4" hidden>
      <center><button type="button" title="next" style="width:13%" class="btn btn-success"><i class="fa fa-arrow-right"></i><b> Next</b></button></center>
    </div>
</div>

<script type="text/javascript">
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!

var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
var today = dd + '_' + mm + '_' + yyyy;

$('.tb-monloadprod').DataTable({
  scrollX: true,
  scrollY:  500,
  scrollCollapse: true,
  paging:false,
  info:true,
  ordering:false,
  buttons: true,
  dom: 'Bfrtpi',
  buttons: [
    'pageLength',
    {
      extend: 'excelHtml5',
      title: 'KHS_Loading_Produksi_' + today,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
      }
    }
   ],
});
</script>
