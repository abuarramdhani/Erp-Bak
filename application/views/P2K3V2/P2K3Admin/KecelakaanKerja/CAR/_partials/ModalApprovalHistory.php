<div class="modal" data-current-fetch-time="" id="modal-approval-history">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Riwayat Approval</h4>
      </div>
      <div class="modal-body">
        Aku modal history
      </div>
    </div>
  </div>
</div>

<script>
  $(() => {
    const $modal = $('#modal-approval-history');
    $('.js-approval-history').on('click', function(e) {
      e.preventDefault()

      const car_id = $(this).data('id')
      const fetchTime = new Date().getTime();

      $modal.attr('data-current-fetch-time', fetchTime);

      // Get history
      $.ajax({
        method: 'GET',
        url: baseurl + 'p2k3adm_V2/Admin/Car/Approval/History',
        data: {
          car_id
        },
        beforeSend() {
          $modal.find('.modal-body').html(`
            <div class="row">
              <div class="col-md-12 text-center">
                <span>Memuat riwayat ...</span>
              </div>
            </div>
          `);
        },
        success(response) {
          const lastFetchTime = $modal.attr('data-current-fetch-time');
          if (lastFetchTime == fetchTime) {
            // update data to DOM
            $modal.find('.modal-body').html(response.html);
          }
        },
        error(err) {
          const lastFetchTime = $modal.attr('data-current-fetch-time');

          if (lastFetchTime == fetchTime) {
            // update data to DOM
            $modal.find('.modal-body').html(`
              Terjadi kesalahan saat mengambil data ...
            `);
          }
        }
      })
    })
  })
</script>