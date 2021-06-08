<div class="card" style="max-height: 500px;">
  <div class="card-header">
    <span><?= $title ?></span>
  </div>
  <div class="card-body p-2" style="overflow-y: scroll;">
    <table class="table table-bordered">
      <thead class="bg-primary">
        <tr>
          <th>No</th>
          <th>Noind</th>
          <th>Nama</th>
          <th>Judul Kaizen</th>
          <?php if ($withAttachment) : ?>
            <th>Lampiran</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $i => $kaizen) : ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $kaizen->no_ind ?></td>
            <td><?= $kaizen->name ?></td>
            <td><?= $kaizen->kaizen_title ?></td>
            <?php if ($withAttachment) : ?>
              <td>
                <?php if ($kaizen->kaizen_file) : ?>
                  <a href="<?= base_url('assets/upload/uploadKaizenTks/' . $kaizen->kaizen_file) ?>" target="_blank">Link</a>
                <?php else : ?>
                  -
                <?php endif ?>
              </td>
            <?php endif ?>
          </tr>
        <?php endforeach ?>
        <?php if (empty($data)) : ?>
          <tr>
            <td class="text-center" colspan="4">
              Tidak ada kaizen
            </td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>