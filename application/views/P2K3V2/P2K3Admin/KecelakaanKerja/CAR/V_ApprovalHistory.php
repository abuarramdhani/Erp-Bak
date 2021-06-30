<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table">
        <thead class="bg-primary">
          <tr>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Oleh</th>
            <!-- <th>Catatan</th> maybe will used on future -->
          </tr>
        </thead>
        <tbody>
          <?php
          $openState = 0;
          ?>
          <?php foreach ($data as $h) : ?>
            <?php
            if ($h->approval_status == CAR_STATUS::OPEN) {
              $openState += 1;
            }
            ?>
            <tr>
              <td>
                <span style="display: block;"><?= strftime('%Y-%B-%d, %A', strtotime($h->created_at)) ?></span>
                <span style="color: #8d8d8d;"><?= date('H:i:s', strtotime($h->created_at)) ?></span>
              </td>
              <td style="display: flex; align-items: center;">
                <span class="status <?= $h->approval_status ?>">
                  <?php
                  if ($h->approval_status == CAR_STATUS::OPEN && $openState > 1) {
                    echo CAR_STATUS::getStatus($h->approval_status) . " $openState";
                  } else {
                    echo CAR_STATUS::getStatus($h->approval_status);
                  }
                  ?>
                </span>
              </td>
              <td><?= $h->approval_by . " - " . $h->employee_name ?></td>
              <!-- <td><?= $h->catatan ?></td> maybe will used on future -->
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

      <div class="text-center">
        <?php if (empty($data)) : ?>
          <span>Tidak ada riwayat</span>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>