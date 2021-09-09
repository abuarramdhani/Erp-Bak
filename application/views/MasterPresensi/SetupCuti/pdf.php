<h1 style="padding-top:3rem;text-align:left">DAFTAR CUTI CV.KARYA HIDUP SENTOSA</h1>
<hr>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
   <thead>
      <tr>
         <th>No</th>
         <th>Kode Cuti</th>
         <th>Nama Cuti</th>
         <th>Maksimal Hari</th>
      </tr>
   </thead>
   <tbody>
      <?php $index = 1; ?>
      <?php foreach ($cuti as $cuti) : ?>
         <tr id="<?= $index ?>" class="cuti-item <?= str_replace(' ', '', $cuti->kd_cuti . $cuti->nama_cuti) ?>">
            <td class="no" style="text-align: center;"><?= $index; ?></td>
            <td style="text-align: center;"><?= $cuti->kd_cuti ?></td>
            <td><?= $cuti->nama_cuti ?></td>
            <td style="text-align: center;"><?= $cuti->hari_maks ?></td>
         </tr>
         <?php $index++; ?>
      <?php endforeach; ?>
   </tbody>
</table>