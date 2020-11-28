<?php
function day($date)
{
  if (date('Ymd') == date('Ymd', strtotime($date))) return "Hari ini";
  // if created at == (today - 1) a.k.a yesterday
  if (date('Ymd', strtotime("-1 days")) == date('Ymd', strtotime($date))) return "Kemarin";

  // if not today or yesterday, show created day with format
  return date('d/m/Y', strtotime($date));
}
?>
<section style="margin-top: 4em; margin-bottom: 2em;">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-6" style="margin: 0 auto; max-width: 100%; width: 600px;">
        <div class="card">
          <div class="card-header skin-red-light sidebar-mini fixed nimbus-is-editor" style="padding: 1em 0.7em; background: #3c8dbc; color: white;">
            <h4 class="bold" style="margin-top: 10px; font-weight: bold;">Notifikasi</h4>
          </div>
          <div class="card-body">
            <ul class="nav" id="notification-list">
              <?php foreach ($allNotifications as $item) : ?>
                <li class="nav-item notification-item <?= !$item->readed_at ? 'unread' : '' ?>">
                  <div class="row">
                    <div class="col-lg-2" style="padding-top: 1em;">
                      <div style="width: 10px; height: 10px; margin: auto; background-color: red; border-radius: 50%;"></div>
                    </div>
                    <div class="col-lg-7">
                      <span style="font-weight: bold; font-size: 1.8rem;"><?= $item->title ?></span>
                      <p><?= $item->message ?></p>
                    </div>
                    <div class="col-lg-2">
                      <span style="font-size: 1.2rem;"><?= day($item->created_at) ?></span>
                      <span style="font-size: 1.2rem;"><?= $item->created_at ? date('H:m:s', strtotime($item->created_at)) : '' ?></span>
                    </div>
                    <a data-id="<?= $item->user_notification_id ?>" class="stretched-link" href="<?= $item->url ? base_url('/notification/' . $item->user_notification_id) : "#" ?>"></a>
                  </div>
                </li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(() => {
    $('#notification-list')
      .find("a")
      .click(function(e) {
        if ($(this).attr('href') == '#') {
          e.preventDefault()
        } else {
          // if has an url, dont execute code below
          return false;
        }

        const self = this;
        const id = $(this).data("id");
        const url = $(this).data("url");
        // do something
        $.ajax({
          method: "POST",
          url: '<?= base_url('/api/services/notification/read') ?>',
          data: {
            id: id,
          },
          success() {
            console.log("Ok");
            $(self).closest("li").removeClass("unread");
          },
          error() {
            console.error("Error to set read of notification");
          },
        });
      });
  })
</script>