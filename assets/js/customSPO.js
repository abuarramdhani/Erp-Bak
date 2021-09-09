$(document).ready(function () {
  // Sort date datatables format
  $.fn.dataTable.moment("DD-MMM-YY");

  if ($(".PurchaseManagementSendPOTitle").html() == "WEB SEND PO BDL") {
    var IndonesiaMessageFormat =
      '\
        <div style="  font-family: Times New Roman, Times, serif;">\
          <p>Dengan hormat,</p>\
              <br>\
          <p>\
              Terlampir Purchase Order (PO) dari kami, dimohon konfirmasi kesanggupan <b>\
              dengan menyalin template balasan dibawah ini kemudian mengirim balik</b> ke alamat email ini \
              selambat-lambatnya <b>1x24 jam </b>sejak email ini diterima.\
          </p>\
          <p>Template Balasan (disalin dari <b>"PO Confirmation"</b> hingga <b>"Sign Name")</b> : </p>\
          <p>\
              <b>PO CONFIRMATION</b> : <em>(diisi dengan nomor PO terkait)</em><br>\
              <b>UNIT PRICE </b>: <em>(diisi OK/NOT OK)</em><br>\
              <b>QUANTITY</b> : <em>(diisi OK/NOT OK)</em><br>\
              <b>RECEIVED DATE</b> : <em>(diisi OK/NOT OK)</em><br>\
              <b>SHIP TO LOCATION</b> : <em>(diisi OK/NOT OK)</em><br>\
              <b>VENDOR DATA</b> : <em>(diisi OK/NOT OK)</em><br>\
              <b>SIGN NAME</b> : <em>(diisi Nama dan Jabatan penerima dan konfirmasi PO)<br></em>\
          </p>\
          <p>\
              Mohon perhatiannya, bahwa tanggal yang tercantum sebagai <b>"Received Date" </b>pada Purchase Order \
              (PO) adalah <b>tanggal diterimanya barang/jasa terkait di alamat tujuan </b>(Gudang Tujuan) yang ditentukan/\
              dituliskan pada masing-masing Purchase Order.\
          </p>\
              <br>\
          <p>Terima kasih atas kerjasamanya</p>\
              <br>\
          <p>\
              Salam,<br>\
              Ms. Astri<br>\
              Admin Purchasing<br>\
              <b>CV Karya Hidup Sentosa (QUICK)</b><br>\
              Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
              Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 204<br>\
              Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>\
              Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>\
          </p>\
        </div>\
        ';
  } else if (window.location.href.includes("po_number=")) {
    var po_number = $("#txtPMSPONoPO").val().split("-")[0];
    var po_number_rev = $("#txtPMSPONoPO").val();
    var IndonesiaMessageFormat =
      `
      <div style="  font-family: Times New Roman, Times, serif;">\
      <p>Dengan hormat,</p>\
      <br>\
      <p>\
        Sehubungan dengan belum adanya konfirmasi atas Purchase Order No <b>` +
      po_number +
      `</b> yang sudah \
        kami kirimkan sebelumnya, mohon agar memberikan konfirmasi <b>dengan membalas email \
        ini, menyalin dan mengisi template konfirmasi dibawah ini</b>.\
      </p>\
      <p>Template Balasan (disalin dari <b>"PO Confirmation"</b> hingga <b>"Sign Name"</b>) :</p>\
      <p>\
        <b>PO CONFIRMATION</b> : <em>(diisi dengan nomor PO terkait)</em><br>\
        <b>UNIT PRICE</b> : <em>(diisi OK/NOT OK)</em><br>\
        <b>QUANTITY</b> : <em>(diisi OK/NOT OK)</em><br>\
        <b>RECEIVED DATE</b> : <em>(diisi OK/NOT OK)</em><br>\
        <b>SHIP TO LOCATION</b> : <em>(diisi OK/NOT OK)</em><br>\
        <b>VENDOR DATA</b> : <em>(diisi OK/NOT OK)</em><br>\
        <b>SIGN NAME</b> : <em>(diisi Nama dan Jabatan penerima dan konfirmasi PO)</em><br>\
      </p>\
      <br>\
      <p>\
        Mohon perhatiannya, bahwa tanggal yang tercantum sebagai <b>"Received Date"</b> pada \
        Purchase Order (PO) adalah <b>tanggal diterimanya barang/jasa terkait di alamat \
        tujuan</b> (Gudang Tujuan) yang ditentukan/ dituliskan pada masing-masing Purchase Order.\
        Dengan memberikan persetujuan baik melalui email maupun kolom konfirmasi di lembar PO,
        maka Vendor telah <b>menyetujui hal-hal yang dicantumkan pada PO dan/atau Pedoman Kerjasama
        Vendor</b> yang dilampirkan pada setiap pengiriman email PO.
      </p>\
      <p><b>Mohon abaikan pesan ini apabila sudah memberikan konfirmasi.</b></p>
      <br>\
      <p>Terima kasih atas kerjasamanya</p>\
      <br>\
      <p>\
        Salam,<br>\
        Ms. Rika<br>\
        Admin Purchasing<br>\
        CV Karya Hidup Sentosa (QUICK)<br>\
        Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
        Telp. +62-274-512095 ext 211<br>\
        Fax. +62-274-563523<br>\
        Website : www.quick.co.id<br>\
      </p>\
      </div>\
      `;
  } else {
    var IndonesiaMessageFormat = `<div style="  font-family: Times New Roman, Times, serif;">
            <p>Dengan hormat,</p>
                <br>
            <p>
                Berikut kami sampaikan Purchase Order (PO) dan Pedoman Kerjasama Vendor dari CV. Karya Hidup Sentosa,
                mohon dapat diberikan konfirmasi kesanggupan <b>dengan menyalin template balasan dibawah ini kemudian mengirim balik</b>
                ke alamat email ini selambat-lambatnya <b>1x24 jam</b> sejak email ini diterima.
            </p>
            <p>Template Balasan (disalin dari <b>"PO Confirmation"</b> hingga <b>"Sign Name")</b> : </p>
            <p>
                <b>PO CONFIRMATION</b> : <em>(diisi dengan nomor PO terkait)</em><br>
                <b>UNIT PRICE</b>: <em>(diisi OK/NOT OK)</em><br>
                <b>QUANTITY</b> : <em>(diisi OK/NOT OK)</em><br>
                <b>RECEIVED DATE</b> : <em>(diisi OK/NOT OK)</em><br>
                <b>SHIP TO LOCATION</b> : <em>(diisi OK/NOT OK)</em><br>
                <b>VENDOR DATA</b> : <em>(diisi OK/NOT OK)</em><br>
                <b>SIGN NAME</b> : <em>(diisi Nama dan Jabatan penerima dan konfirmasi PO)<br></em>
            </p>
            <p>
                Mohon perhatiannya, bahwa tanggal yang tercantum sebagai <b>"Received Date" </b>pada Purchase Order 
                (PO) adalah <b>tanggal diterimanya barang/jasa terkait di alamat tujuan </b>(Gudang Tujuan) yang ditentukan/
                dituliskan pada masing-masing Purchase Order. Dengan memberikan persetujuan baik melalui email maupun kolom
                konfirmasi di lembar PO, maka Vendor telah <b>menyetujui hal-hal yang dicantumkan pada PO dan/atau Pedoman Kerjasama
                Vendor</b> yang dilampirkan pada setiap pengiriman email PO.
            </p>
                <br>
            <p>Terima kasih atas kerjasamanya</p>
                <br>
            <p>
                Salam,<br>
                Rika (Ms)<br>
                Admin Purchasing<br>
                <b>CV Karya Hidup Sentosa (QUICK)</b><br>
                Jalan Magelang No 144 Yogyakarta - Indonesia<br>
                Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 211<br>
                Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>
                Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>
            </p>
        </div>
        `;
  }

  var EnglishMessageFormat =
    '\
                <div style="  font-family: Times New Roman, Times, serif;">\
                    <p>Dear Mr./Ms.,</p>\
                        <br>\
                    <p>\
                        Hereby we attached our Purchase Order (PO), please confirm your abilty to supply <b> by copying the template\
                        below as a reply</b> to this email no later than <b>1x24 hours </b>and please provide invoice to process the\
                        payment.\
                    </p>\
                    <p>Templates (copied from <b>"PO Confirmation"</b> to <b>"Signature Name")</b> : </p>\
                    <p>\
                        <b>PO CONFIRMATION</b> : <em>(Corresponding PO number)</em><br>\
                        <b>UNIT PRICE </b>: <em>(OK / NOT OK)</em><br>\
                        <b>QUANTITY</b> : <em>(OK / NOT OK)</em><br>\
                        <b>RECEIVED DATE</b> : <em>(OK / NOT OK)</em><br>\
                        <b>SHIP TO LOCATION</b> : <em>(OK / NOT OK)</em><br>\
                        <b>VENDOR DATA</b> : <em>(OK / NOT OK)</em><br>\
                        <b>SIGNATURE NAME</b> : <em>(Name and Position of PIC of Vendor)<br></em>\
                    </p>\
                    <p>\
                        Please notice that the date that is filled as <b>"Date Received" </b>in the Purchase Order (PO) is <b>\
                        Estmated Arrival Time date</b> at specified destination as written in Purchase Order.\
                    </p>\
                        <br>\
                    <p>Thank you for your cooperation.</p>\
                        <br>\
                    <p>\
                        Regards,<br>\
                        Ms. Rika<br>\
                        Admin Purchasing<br>\
                        <b>CV Karya Hidup Sentosa (QUICK)</b><br>\
                        Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
                        Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 211<br>\
                        Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>\
                        Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>\
                    </p>\
                </div>\
            ';

  $("#txaPMSPOEmailBody").redactor({
    //   imageUpload: baseurl,
    //   imageUploadErrorCallback: function(json)
    //   {
    //       alert(json.error);
    //   }
  });

  // $('#txtPMSPONoPO').inputFilter(function(value) {
  //     return /^\d*$/.test(value);
  // });

  $("#txtPMSPONoPO").on("blur", function () {
    var PONumber = $(this).val();
    // console.log(PONumber);
    if ($(this).val().length > 0) {
      $(".PMSPOimgLoadAddr").show();
      $(this).removeAttr("style", "background-color:#ffa8a8");
      $.ajax({
        url:
          baseurl + "PurchaseManagementSendPO/SendPO/getUserEmail/" + PONumber,
        dataType: "json",
        success: function (result) {
          // console.log(result);
          if (result.email != null) {
            $(".divPMSPOWarnAddrNotFound").fadeOut();
            $("#txtPMSPOToEmailAddr").val(result.email);
            $(".PMSPOimgLoadAddr").hide();
            setTimeout(function () {
              if (window.location.href.includes("po_number=")) {
                $("#txtPMSPOSubject").val(
                  "Konfirmasi PO " + po_number_rev + " CV. KHS"
                );
              } else {
                $("#txtPMSPOSubject").val("KHS PURCHASE ORDER " + PONumber);
              }
            }, 500);
          } else {
            $(".spnPMSPOWarnAddrNotFound").html(
              " Tidak ditemukan Email Address dengan PO Number " +
                PONumber +
                ". "
            );
            $(".divPMSPOWarnAddrNotFound").fadeIn();
            $("#txtPMSPOToEmailAddr").val("");
            $(".PMSPOimgLoadAddr").hide();
            setTimeout(function () {
              if (window.location.href.includes("po_number=")) {
                $("#txtPMSPOSubject").val(
                  "Konfirmasi PO " + po_number_rev + " CV. KHS"
                );
              } else {
                $("#txtPMSPOSubject").val("KHS PURCHASE ORDER " + PONumber);
              }
            }, 500);
          }
          if (result.status != null) {
            $("#txtPMSPOStatusPo").val(result.status);
          }
          if (result.cc_address != null) {
            $("#txtPMSPOCCEmailAddr").val(result.cc_address);
          } else {
            $("#txtPMSPOCCEmailAddr").val(null);
          }
          if (result.site != null) {
            $(".divPMSPOSite").fadeIn();
            $("#txtPMSPONoPOSite").val(result.site);
          } else {
            $(".divPMSPOSite").fadeOut();
          }
        },
      });
    } else {
      $(".PMSPOimgLoadAddr").hide();
      $("#txtPMSPOSubject").val("");
      $("#txtPMSPOToEmailAddr").val("");
      $("#txtPMSPOCCEmailAddr").val("");
      $(".divPMSPOSite").fadeOut();
    }
  });

  $("#txtPMSPOToEmailAddr").on({
    click: function () {
      $(".divPMSPOEmailAddrWarn").fadeIn();
    },
    blur: function () {
      $(".divPMSPOEmailAddrWarn").fadeOut();
      if ($(this).val().length > 0) {
        $(this).removeAttr("style", "background-color:#ffa8a8");
      }
    },
  });

  $("#txtPMSPOCCEmailAddr").on({
    click: function () {
      $(".divPMSPOCCEmailAddrWarn").fadeIn();
    },
    blur: function () {
      $(".divPMSPOCCEmailAddrWarn").fadeOut();
    },
  });

  $("#txtPMSPOBCCEmailAddr")
    .val("purchasingsec12.quick1@gmail.com")
    .on({
      click: function () {
        $(".divPMSPOBCCEmailAddrWarn").fadeIn();
      },
      blur: function () {
        $(".divPMSPOBCCEmailAddrWarn").fadeOut();
      },
    });

  $("#slcPMSPOFormatMessage").on("change", function () {
    // console.log($(this).val());
    if ($(this).val() == "Indonesia") {
      $("#txaPMSPOEmailBody").redactor("set", IndonesiaMessageFormat);
    } else if ($(this).val() == "English") {
      $("#txaPMSPOEmailBody").redactor("set", EnglishMessageFormat);
    }
  });

  $("#txaPMSPOEmailBody").redactor("set", IndonesiaMessageFormat);

  $(".btnConfirmDiscard").on("click", function () {
    Swal.fire({
      title: "Batalkan penulisan pesan?",
      text: "Anda tidak dapat mengembalikan pesan yang anda tulis",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
    }).then((result) => {
      if (result.value) {
        // console.log('Hello World!');
        $(".divPMSPOWarnAddrNotFound").fadeOut();
        $(".btnPMSPODiscard").click();
        $("#txaPMSPOEmailBody").redactor("set", "");
        $("#slcPMSPOFormatMessage").select2("val", "");
      }
    });
  });

  $(".btnPMSPOcheckSend").on("click", function () {
    if (
      $("#txtPMSPOToEmailAddr").val().length < 1 &&
      $("#txtPMSPONoPO").val().length < 1
    ) {
      // console.log('EMAIL DAN PO KOSONG');
      $(".pPMSPOwarningDetails").html(
        "Nomor PO dan alamat email tujuan anda belum terisi."
      );
      $(".divPMSPOcalloutWarning").fadeIn();
      $(".divPMSPOcalloutWarning").fadeOut(10000);
      $("#txtPMSPOToEmailAddr").attr("style", "background-color:#ffa8a8");
      $("#txtPMSPONoPO").attr("style", "background-color:#ffa8a8");
    } else if ($("#txtPMSPOToEmailAddr").val().length < 1) {
      // console.log('EMAIL KOSONG');
      $(".pPMSPOwarningDetails").html("Alamat email tujuan anda belum terisi.");
      $(".divPMSPOcalloutWarning").fadeIn();
      $(".divPMSPOcalloutWarning").fadeOut(10000);
      $("#txtPMSPOToEmailAddr").attr("style", "background-color:#ffa8a8");
    } else if ($("#txtPMSPONoPO").val().length < 1) {
      // console.log('PO KOSONG');
      $(".pPMSPOwarningDetails").html("Nomor PO anda belum terisi.");
      $(".divPMSPOcalloutWarning").fadeIn();
      $(".divPMSPOcalloutWarning").fadeOut(10000);
      $("#txtPMSPONoPO").attr("style", "background-color:#ffa8a8");
    } else if ($("#txtPMSPOStatusPo").val() !== "APPROVED") {
      Swal.fire({
        type: "error",
        title: "Oops...",
        text: "Pesan gagal terkirim :(",
        footer:
          '<span class="text-center" style="color:#3c8dbc">' +
          "PO TIDAK DAPAT DIKIRIM, MOHON CEK STATUS APPROVAL PO/ALAMAT EMAIL" +
          "</span>",
      });
    } else {
      // Disable form from user interaction
      Swal.fire({
        allowOutsideClick: false,
        title: "Mohon menunggu",
        html: "Sedang mengirim pesan ...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });

      // Ajax Send Email
      var form_data = new FormData(),
        po_number = $("#txtPMSPONoPO").val(),
        subject = $("#txtPMSPOSubject").val(),
        toEmail = $("#txtPMSPOToEmailAddr").val();
      (ccEmail = $("#txtPMSPOCCEmailAddr").val()),
        (bccEmail = $("#txtPMSPOBCCEmailAddr").val()),
        (file_attach1 = $("#inpPMSPOAttachment1").prop("files")[0]),
        (file_attach2 = $("#inpPMSPOAttachment2").prop("files")[0]),
        (format_message = $("#slcPMSPOFormatMessage").val()),
        (body = $("#txaPMSPOEmailBody").val());
      form_data.append("po_number", po_number);
      form_data.append("toEmail", toEmail);
      form_data.append("ccEmail", ccEmail);
      form_data.append("bccEmail", bccEmail);
      form_data.append("subject", subject);
      form_data.append("file_attach1", file_attach1);
      form_data.append("file_attach2", file_attach2);
      form_data.append("format_message", format_message);
      form_data.append("body", body);

      if (window.location.href.includes("po_number=")) {
        form_data.append("type", "resend");
      } else {
        form_data.append("type", "send");
      }
      $.ajax({
        type: "post",
        url: baseurl + "PurchaseManagementSendPO/SendPO/SendEmail",
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        success: function () {
          Swal.fire(
            "Success!",
            `PO ${po_number} <br> Pesan telah terkirim dan terarsip`,
            "success"
          ).then(() => {
            if (window.location.href.includes("po_number=")) {
              window.location.href = baseurl + "PurchaseManagementSendPO/PoLog";
            } else {
              window.location.href =
                baseurl + "PurchaseManagementSendPO/SendPO";
            }
          });
        },
        error: function (result) {
          globalresult = result;
          console.log(result.responseJSON);
          var message = result.responseJSON
            ? result.responseJSON.message
            : "Terjadi kesalahan saat mengirim pesan";
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: "Pesan gagal terkirim :(",
            footer: '<span style="color:#3c8dbc">' + message + "</span>",
          });
        },
      });
    }
  });

  // Tabel SPO Log horizontal scroll
  $("#tbl-PoLog").DataTable({
    scrollX: true,
    fixedColumns: {
      leftColumns: 10,
    },
  });

  $("[title]").tooltip();

  const dataTablePoLogbook = $("#tbl-PoLogbook").DataTable({
    scrollX: true,
    fixedColumns: {
      leftColumns: 10,
    },
    dom: `
      <'row'
        <'col-sm-12 col-md-2'l>
        <'col-sm-12 col-md-8'>
        <'col-sm-12 col-md-2'f>
      >
      <'row'
        <'col-sm-12'tr>
      >
      <'row'
        <'col-sm-12'ip>
      >`,
  });

  $(".tbl-PoLogbook_filter_by-date").html(/* html */ `
    <div class="box box-solid">
      <div class="box-body text-center">
        <span>Filter By Date: &nbsp;</span>
        <input type="text" class="input-sm form-control txtPoLogbookFilterDateStart" style="width: 30%" placeholder="Dari Tanggal">
        <span>&nbsp; - &nbsp;</span>
        <input type="text" class="input-sm form-control txtPoLogbookFilterDateEnd" style="width: 30%" placeholder="Hingga Tanggal">
        <button class="btn-sm btn btn-primary btnPoLogbookApplyFilterDate">Apply</button>
        <button class="btn-sm btn btn-danger btnPoLogbookClearFilterDate">Clear</button>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  `);

  $(".btnPoLogbookApplyFilterDate").on("click", () => {
    const startDate = moment($(".txtPoLogbookFilterDateStart").val(), "MMM-YY");
    const endDate = moment($(".txtPoLogbookFilterDateEnd").val(), "MMM-YY");
    const diffMonthsLength = endDate.diff(startDate, "months");
    const monthsRange = Array.from({
      length: diffMonthsLength + 1,
    }).map((_, k) => startDate.clone().add(k, "months").format("MMM-YY"));
    const regexMonthsRange = monthsRange.join("|");

    $(".txtPoLogbookGlobalSearch").val(null);

    dataTablePoLogbook.column(8).search(regexMonthsRange, true, false).draw();
  });

  $(".txtPoLogbookGlobalSearch").on("keyup", (e) => {
    $(".btnPoLogbookClearFilterDate").trigger("click");

    dataTablePoLogbook.column(8).search("");
    dataTablePoLogbook.search($(e.currentTarget).val()).draw();
  });

  $(".btnPoLogbookClearFilterDate").on("click", () => {
    $(".txtPoLogbookFilterDateStart, .txtPoLogbookFilterDateEnd").val(null);
  });

  $(".txtPoLogbookFilterDateStart, .txtPoLogbookFilterDateEnd")
    .daterangepicker({
      autoUpdateInput: false,
      showDropdowns: true,
      singleDatePicker: true,
      minDate: moment("01/01/2010"),
      maxYear: 2030,
      locale: {
        format: "MMM-YY",
        cancelLabel: "Clear",
      },
    })
    .on("hide.daterangepicker", (_, picker) => {
      const selectedMonth = $(picker.container).find(".monthselect").val();
      const selectedYear = $(picker.container).find(".yearselect").val();
      const formatedDate = moment(
        `${Number(selectedMonth) + 1} ${selectedYear}`,
        "M YYYY"
      ).format("MMM-YY");

      $(picker.element).val(formatedDate);
    })
    .on("show.daterangepicker", (_, picker) => {
      const inputDate = $(picker.element).val();
      const formatedInputMonth = moment(inputDate, "MMM-YY").format("M") - 1;
      const formatedInputYear = moment(inputDate, "MMM-YY").format("YYYY");

      $(picker.container).find(".monthselect").val(formatedInputMonth);
      $(picker.container).find(".yearselect").val(formatedInputYear);
      $(picker.container).find(".monthselect, .yearselect").trigger("change");
    });

  if (window.location.href.includes("po_number=")) {
    $("#txtPMSPONoPO").trigger("blur");
  }

  // Date Picker edit data
  $("#vendor_confirm_date").datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    autoclose: true,
  });
  $("#purchasing_approve_date").datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    autoclose: true,
  });
  $("#management_approve_date").datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    autoclose: true,
  });
  $("#send_date_1").datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    autoclose: true,
  });
  $("#send_date_2").datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    autoclose: true,
  });

  $("#editPoLog").on("click", ".btnVendorConfirm", function () {
    // Ajax edit Data Po Log
    let epl_form_data = new FormData(),
      po_number = $('[name="po_number"]').val(),
      vendor_confirm_date = $('[name="vendor_confirm_date"]').val(),
      vendor_confirm_method = $('[name="vendor_confirm_method"]').val(),
      vendor_confirm_pic = $('[name="vendor_confirm_pic"]').val(),
      vendor_confirm_note = $('[name="vendor_confirm_note"]').val(),
      lampiran_po = $('[name="lampiranPO"]').prop("files")[0];
    epl_form_data.append("po_number", po_number);
    epl_form_data.append("vendor_confirm_date", vendor_confirm_date);
    epl_form_data.append("vendor_confirm_method", vendor_confirm_method);
    epl_form_data.append("vendor_confirm_pic", vendor_confirm_pic);
    epl_form_data.append("vendor_confirm_note", vendor_confirm_note);
    epl_form_data.append("lampiran_po", lampiran_po);

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
      .fire({
        title: "Apakah anda yakin?",
        text: "Data akan di Update!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, update!",
        cancelButtonText: "Tidak, batalkan!",
        reverseButtons: true,
      })
      .then((result) => {
        if (result.value) {
          if (
            $("#editPoLog")
              .find('[required=""]')
              .map((i, v) => $(v).val())
              .toArray()
              .includes("")
          ) {
            alert("Silahkan lengkapi data");
          } else {
            $.ajax({
              type: "POST",
              url: baseurl + "PurchaseManagementSendPO/PoLog/save",
              processData: false,
              contentType: false,
              data: epl_form_data,
              dataType: "JSON",
            })
              .done(() => {
                swalWithBootstrapButtons
                  .fire("Updated!", "Data berhasi diupdate.", "success")
                  .then(() => {
                    window.location.href =
                      baseurl + "PurchaseManagementSendPO/PoLog";
                  });
              })
              .fail(() => [
                swalWithBootstrapButtons.fire(
                  "Error!",
                  "Data gagal diupdate.",
                  "warning"
                ),
              ]);
          }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Data tidak diupdate :)",
            "error"
          );
        }
      });
  });

  let distributionMethod = $("#select_distribution_method").val();
  if (distributionMethod === "email") {
    $(".send_date_row").hide();
    $(".vendor_confirm_row").show();
    $(".attachment_flag_row").show();
    $(".attachment_row").show();
    // $(".input_send_date").prop("required", false);
    // $(".input_attachment_flag").prop("required", true);
    // if ($('[name="vendor_confirm_date"]').prop("disabled")) {
    //   $(".input_vendor_confirm").prop("required", false);
    // $(".input_attachment").prop("required", false);
    // } else {
    //   $(".input_vendor_confirm").prop("required", true);
    // $(".input_attachment").prop("required", true);
    // }
  } else if (distributionMethod === "none") {
    $(".send_date_row").hide();
    $(".vendor_confirm_row").hide();
    $(".attachment_flag_row").hide();
    $(".attachment_row").hide();
    // $(".input_send_date").prop("required", false);
    // $(".input_vendor_confirm").prop("required", false);
    // $(".input_attachment_flag").prop("required", false);
    // $(".input_attachment").prop("required", false);
  } else if (distributionMethod !== "email" && distributionMethod !== "none") {
    $(".send_date_row").show();
    $(".vendor_confirm_row").show();
    $(".attachment_flag_row").show();
    $(".attachment_row").show();
    // $(".input_send_date").prop("required", true);
    // $(".input_attachment_flag").prop("required", true);
    // if ($('[name="vendor_confirm_date"]').prop("disabled")) {
    //   $(".input_vendor_confirm").prop("required", false);
    // $(".input_attachment").prop("required", false);
    // } else {
    //   $(".input_vendor_confirm").prop("required", true);
    // $(".input_attachment").prop("required", true);
    // }
  }
  $("#select_distribution_method").on("change", function (e) {
    e.preventDefault();
    distributionMethod = $(this).val();
    if (distributionMethod !== "email" && distributionMethod !== "none") {
      $(".send_date_row").show();
      $(".vendor_confirm_row").show();
      $(".attachment_flag_row").show();
      $(".attachment_row").show();
      // $(".input_send_date").prop("required", true);
      // $(".input_attachment_flag").prop("required", true);
      // if ($('[name="vendor_confirm_date"]').prop("disabled")) {
      //   $(".input_vendor_confirm").prop("required", false);
      // $(".input_attachment").prop("required", false);
      // } else {
      //   $(".input_vendor_confirm").prop("required", true);
      // $(".input_attachment").prop("required", true);
      // }
    } else if (distributionMethod === "email") {
      $(".send_date_row").hide();
      $(".vendor_confirm_row").show();
      $(".attachment_flag_row").show();
      $(".attachment_row").show();
      // $(".input_send_date").prop("required", false);
      // $(".input_attachment_flag").prop("required", true);
      // if ($('[name="vendor_confirm_date"]').prop("disabled")) {
      //   $(".input_vendor_confirm").prop("required", false);
      // $(".input_attachment").prop("required", false);
      // } else {
      //   $(".input_vendor_confirm").prop("required", true);
      // $(".input_attachment").prop("required", true);
      // }
    } else if (distributionMethod === "none") {
      $(".send_date_row").hide();
      $(".vendor_confirm_row").hide();
      $(".attachment_flag_row").hide();
      $(".attachment_row").hide();
      // $(".input_send_date").prop("required", false);
      // $(".input_vendor_confirm").prop("required", false);
      // $(".input_attachment_flag").prop("required", false);
      // $(".input_attachment").prop("required", false);
    }
  });

  $("#editPoLogbook").on("click", ".btnEditPoLogbook", function () {
    // Ajax edit Data di Menu POLogbook
    let eplb_form_data = new FormData(),
      po_number = $('[name="po_number"]').val(),
      vendor_confirm_date = $('[name="vendor_confirm_date"]').val(),
      distribution_method = $('[name="distribution_method"]').val(),
      vendor_confirm_method = $('[name="vendor_confirm_method"]').val(),
      send_date_1 = $('[name="send_date_1"]').val(),
      send_date_2 = $('[name="send_date_2"]').val(),
      vendor_confirm_pic = $('[name="vendor_confirm_pic"]').val(),
      vendor_confirm_note = $('[name="vendor_confirm_note"]').val(),
      attachment_flag = $('[name="attachment_flag"]').val(),
      lampiran_po = $('[name="lampiranPO"]').prop("files")[0];
    eplb_form_data.append("po_number", po_number);
    eplb_form_data.append("distribution_method", distribution_method);
    if (distribution_method == "email") {
      eplb_form_data.append("attachment_flag", attachment_flag);
    }
    if (distribution_method !== "email" && distribution_method !== "none") {
      eplb_form_data.append("attachment_flag", attachment_flag);
      eplb_form_data.append("send_date_1", send_date_1);
      eplb_form_data.append("send_date_2", send_date_2);
    }

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
      .fire({
        title: "Apakah anda yakin?",
        text: "Data akan di Update!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, update!",
        cancelButtonText: "Tidak, batalkan!",
        reverseButtons: true,
      })
      .then((result) => {
        console.log(result);
        if (result.value) {
          if (
            $("#editPoLogbook")
              .find('[required=""]')
              .map((i, v) => $(v).val())
              .toArray()
              .includes("")
          ) {
            alert("Silahkan lengkapi data");
          } else {
            if (
              !$("#vendor_confirm_date").prop("disabled") &&
              distribution_method !== "none"
            ) {
              eplb_form_data.append("vendor_confirm_date", vendor_confirm_date);
              eplb_form_data.append(
                "vendor_confirm_method",
                vendor_confirm_method
              );
              eplb_form_data.append("vendor_confirm_pic", vendor_confirm_pic);
              eplb_form_data.append("vendor_confirm_note", vendor_confirm_note);
              eplb_form_data.append("lampiran_po", lampiran_po);
            }
            $.ajax({
              type: "POST",
              url: baseurl + "PurchaseManagementSendPO/POLogbook/save",
              processData: false,
              contentType: false,
              data: eplb_form_data,
              dataType: "JSON",
            })
              .done(() => {
                swalWithBootstrapButtons
                  .fire("Updated!", "Data berhasi diupdate.", "success")
                  .then(() => {
                    window.location.href =
                      baseurl + "PurchaseManagementSendPO/POLogbook";
                  });
              })
              .fail(() => [
                swalWithBootstrapButtons.fire(
                  "Error!",
                  "Data gagal diupdate.",
                  "warning"
                ),
              ]);
          }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Data tidak diupdate :)",
            "error"
          );
        }
      });
  });

  $("#editPoSpecial").on("click", ".btnEditPoSpecial", function () {
    // Ajax edit Data Special Account
    let epls_form_data = new FormData(),
      po_number = $('[name="po_number"]').val(),
      vendor_confirm_date = $('[name="vendor_confirm_date"]').val(),
      distribution_method = $('[name="distribution_method"]').val(),
      vendor_confirm_method = $('[name="vendor_confirm_method"]').val(),
      purchasing_approve_date = $('[name="purchasing_approve_date"]').val(),
      management_approve_date = $('[name="management_approve_date"]').val(),
      send_date_1 = $('[name="send_date_1"]').val(),
      send_date_2 = $('[name="send_date_2"]').val(),
      vendor_confirm_pic = $('[name="vendor_confirm_pic"]').val(),
      vendor_confirm_note = $('[name="vendor_confirm_note"]').val(),
      attachment_flag = $('[name="attachment_flag"]').val(),
      lampiran_po = $('[name="lampiranPO"]').prop("files")[0];
    epls_form_data.append("po_number", po_number);
    epls_form_data.append("distribution_method", distribution_method);
    epls_form_data.append("purchasing_approve_date", purchasing_approve_date);
    epls_form_data.append("management_approve_date", management_approve_date);
    if (distribution_method == "email") {
      epls_form_data.append("attachment_flag", attachment_flag);
    }
    if (distribution_method !== "email" && distribution_method !== "none") {
      epls_form_data.append("attachment_flag", attachment_flag);
      epls_form_data.append("send_date_1", send_date_1);
      epls_form_data.append("send_date_2", send_date_2);
    }

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
      .fire({
        title: "Apakah anda yakin?",
        text: "Data akan di Update!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, update!",
        cancelButtonText: "Tidak, batalkan!",
        reverseButtons: true,
      })
      .then((result) => {
        console.log(result);
        if (result.value) {
          if (
            $("#editPoSpecial")
              .find('[required=""]')
              .map((i, v) => $(v).val())
              .toArray()
              .includes("")
          ) {
            alert("Silahkan lengkapi data");
          } else {
            if (distribution_method !== "none") {
              epls_form_data.append("vendor_confirm_date", vendor_confirm_date);
              epls_form_data.append(
                "vendor_confirm_method",
                vendor_confirm_method
              );
              epls_form_data.append("vendor_confirm_pic", vendor_confirm_pic);
              epls_form_data.append("vendor_confirm_note", vendor_confirm_note);
              epls_form_data.append("lampiran_po", lampiran_po);
            }
            $.ajax({
              type: "POST",
              url: baseurl + "PurchaseManagementSendPO/PoLog/saveEditSpecial",
              processData: false,
              contentType: false,
              data: epls_form_data,
              dataType: "JSON",
            })
              .done(() => {
                swalWithBootstrapButtons
                  .fire("Updated!", "Data berhasi diupdate.", "success")
                  .then(() => {
                    window.location.href =
                      baseurl + "PurchaseManagementSendPO/PoLog";
                  });
              })
              .fail(() => [
                swalWithBootstrapButtons.fire(
                  "Error!",
                  "Data gagal diupdate.",
                  "warning"
                ),
              ]);
          }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Data tidak diupdate :)",
            "error"
          );
        }
      });
  });

  // View file attachment PO
  $("#tbl-PoLog tbody").on("click", ".view-attachment-polog", function () {
    let fileName = $(this).attr("file-name");
    if (fileName !== "") {
      let poNumber = $(this).attr("data-po");
      let extensionFile = fileName.split(".")[1];
      let extensionToLower = extensionFile.toLowerCase();

      if (extensionToLower == "pdf") {
        window.open(
          baseurl +
            "assets/upload/PurchaseManagementSendPO/LampiranPO/" +
            poNumber +
            "/" +
            fileName,
          "_blank"
        );
      } else if (
        extensionToLower == "jpg" ||
        extensionToLower == "jpeg" ||
        extensionToLower == "png"
      ) {
        window.open(
          baseurl +
            "PurchaseManagementSendPO/PoLog/viewImageAttachmentPO?noPo=" +
            poNumber,
          "_blank"
        );
      } else {
        window.open(
          baseurl +
            "PurchaseManagementSendPO/PoLog/downloadFileAttachment?noPo=" +
            poNumber,
          "_blank"
        );
      }
    }
  });

  $("#tbl-PoLogbook tbody").on(
    "click",
    ".view-attachment-pologbook",
    function () {
      let fileName = $(this).attr("file-name");
      if (fileName !== "") {
        let poNumber = $(this).attr("data-po");
        let extensionFile = fileName.split(".")[1];
        let extensionToLower = extensionFile.toLowerCase();

        if (extensionToLower == "pdf") {
          window.open(
            baseurl +
              "assets/upload/PurchaseManagementSendPO/LampiranPO/" +
              poNumber +
              "/" +
              fileName,
            "_blank"
          );
        } else if (
          extensionToLower == "jpg" ||
          extensionToLower == "jpeg" ||
          extensionToLower == "png"
        ) {
          window.open(
            baseurl +
              "PurchaseManagementSendPO/POLogbook/viewImageAttachmentPO?noPo=" +
              poNumber,
            "_blank"
          );
        } else {
          window.open(
            baseurl +
              "PurchaseManagementSendPO/POLogbook/downloadFileAttachment?noPo=" +
              poNumber,
            "_blank"
          );
        }
      }
    }
  );

  $("#tbl-PoLog tbody").hover(function () {
    $(".name-attachment").css({ cursor: "pointer", color: "#0000ff" });
  });
  $("#tbl-PoLogbook tbody").hover(function () {
    $(".name-attachment").css({ cursor: "pointer", color: "#0000ff" });
  });
});
