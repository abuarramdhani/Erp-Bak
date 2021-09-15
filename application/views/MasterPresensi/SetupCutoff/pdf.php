<h2 style="padding-top:3rem;text-align:left">DAFTAR CUTOFF CV.KARYA HIDUP SENTOSA</h1>
   <hr>
   <br>
   <table width="100%" border="1" cellspacing="0" cellpadding="4">
      <thead>
         <tr>
            <th>NO</th>
            <th>ID</th>
            <th>OS</th>
            <th>PERIODE</th>
            <th>TANGGAL AWAL</th>
            <th>TANGGAL AKHIR</th>
         </tr>
      </thead>
      <tbody>
         <?php $index = 1; ?>
         <?php foreach ($cutoff as $cutoff) : ?>
            <tr data-id="<?= $cutoff->id_cutoff ?>" id="<?= $index ?>">
               <td style="text-align:center;"><?= $index ?></td>
               <td style="text-align:center;"><?= $cutoff->id_cutoff ?></td>
               <td style="text-align:center;"><?= $cutoff->os == 0 ? 'Tidak' : 'Ya' ?></td>
               <td style="text-align:center;"><?= $cutoff->periode ?></td>
               <td style="text-align:center;"><?= $cutoff->tanggal_awal ?></td>
               <td style="text-align:center;"><?= $cutoff->tanggal_akhir ?></td>
            </tr>
            <?php $index++; ?>
         <?php endforeach; ?>
      </tbody>
   </table>