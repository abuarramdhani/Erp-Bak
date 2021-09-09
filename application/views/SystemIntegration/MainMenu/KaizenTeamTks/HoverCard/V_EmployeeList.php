<div class="card" style="max-height: 500px;">
  <div class="card-header">
    <span>Daftar Pekerja</span>
  </div>
  <div class="card-body p-2" style="overflow-y: scroll;">
    <table class="table table-bordered">
      <thead class="bg-primary">
        <tr>
          <th>No</th>
          <th>Noind</th>
          <th>Nama</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $i => $employee) : ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $employee->noind ?></td>
            <td><?= $employee->nama ?></td>
          </tr>
        <?php endforeach ?>
        <?php if (empty($employees)) : ?>
          <tr>
            <td class="text-center" colspan="4">
              Tidak ada Pekerja
            </td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>