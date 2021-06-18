$(document).on("mainDashboardMenuOpened", () => {
  // Outstanding order Approver
  const approverResponsibilityName =
    "(Approver)Order Kebutuhan Barang dan Jasa";
  const $approverResponsibilityBoxContent = $(
    `.info-box .info-box-content:contains(${approverResponsibilityName})`
  );
  const hasApproverResponsibility =
    $approverResponsibilityBoxContent.length > 0;

  if (hasApproverResponsibility) {
    $(document).trigger("hasOkebajaResponsibility", [
      {
        responsibilityName: "Approver",
        $responsibilityBoxContent: $approverResponsibilityBoxContent,
      },
    ]);
  }

  // Outstanding order Pengelola
  const pengelolaResponsibilityName =
    "(Pengelola)Order Kebutuhan Barang dan Jasa";
  const $pengelolaResponsibilityBoxContent = $(
    `.info-box .info-box-content:contains(${pengelolaResponsibilityName})`
  );
  const hasPengelolaResponsibility =
    $pengelolaResponsibilityBoxContent.length > 0;

  if (hasPengelolaResponsibility) {
    $(document).trigger("hasOkebajaResponsibility", [
      {
        responsibilityName: "Pengelola",
        $responsibilityBoxContent: $pengelolaResponsibilityBoxContent,
      },
    ]);
  }

  // Outstanding order Puller
  const pullerResponsibilityName = "(Puller)Order Kebutuhan Barang dan Jasa";
  const $pullerResponsibilityBoxContent = $(
    `.info-box .info-box-content:contains(${pullerResponsibilityName})`
  );
  const hasPullerResponsibility = $pullerResponsibilityBoxContent.length > 0;

  if (hasPullerResponsibility) {
    $(document).trigger("hasOkebajaResponsibility", [
      {
        responsibilityName: "Puller",
        $responsibilityBoxContent: $pullerResponsibilityBoxContent,
      },
    ]);
  }

  // Outstanding order Purchasing
  const purchasingResponsibilityName =
    "(Purchasing)Order Kebutuhan Barang dan Jasa";
  const $purchasingResponsibilityBoxContent = $(
    `.info-box .info-box-content:contains(${purchasingResponsibilityName})`
  );
  const hasPurchasingResponsibility =
    $purchasingResponsibilityBoxContent.length > 0;

  if (hasPurchasingResponsibility) {
    $(document).trigger("hasOkebajaResponsibility", [
      {
        responsibilityName: "Purchasing",
        $responsibilityBoxContent: $purchasingResponsibilityBoxContent,
      },
    ]);
  }
});

$(document).on(
  "hasOkebajaResponsibility",
  (e, { responsibilityName, $responsibilityBoxContent }) => {
    const $badge = $(/* html */ `
        <span class="label"></span>
    `);

    $badge.addClass("bg-aqua").html(/* html */ `
        <i class="fa fa-spinner fa-spin"></i> Sedang Menghitung Total Order Anda
    `);

    $responsibilityBoxContent.append($badge);

    $.get(
      `${baseurl}OrderKebutuhanBarangDanJasa/${responsibilityName}/getUnapprovedOrderCount`
    )
      .done((orderCount) => {
        if (orderCount > 0) {
          $badge.removeClass("bg-aqua").addClass("bg-red").html(/* html */ `
                    <i class="fa fa-clock-o"></i> Terdapat ${orderCount} Order yang Belum Anda Approve
                `);
        } else {
          $badge.html(/* html */ `
                    <i class="fa fa-check"></i> Terdapat ${orderCount} Order yang Belum Anda Approve
                `);
        }
      })
      .fail(() => {
        $badge.html(/* html */ `
                <i class="fa fa-times"></i> Gagal Menghitung Total Order Anda
            `);
      });
  }
);

(() => {
  if (window.location.href === baseurl)
    $(document).trigger("mainDashboardMenuOpened");
})();
