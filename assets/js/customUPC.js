function tambahfile() {
  var i = $('input[name ="gambarCov[]"]').length + 1;
  $("#tambahfile").append(
    '<div class="panel-body"><div class="col-md-4" style="text-align: right;"><label>Gambar</label></div><div class="col-md-4"><input required type="file" class="form-control" name="gambarCov[]" accept=".jpg,.png,.jpeg"></div><div class="col-md-2"><a class="btn btn-danger" id="btn_h' +
      i +
      '" onclick="hpshps(' +
      i +
      ')"><i class="fa fa-minus"></i></a></div></div>'
  );
}

function hpshps(i) {
  $("#btn_h" + i)
    .parents(".panel-body")
    .remove();
}
$(".carousel").carousel({
  interval: 10000,
  pause: "false",
});
function InactiveSlide(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Slide Show ini akan Inactive",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/Inactive",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Inactive",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function ActiveSlide(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Slide Show ini akan Active",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/Active",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Active",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function AddingImg(id) {
  console.log(id);
  var i = $('input[name = "urutan_imgnya[]"]').length + 1;

  $("#tambah_img").append(
    '<tr><input type="hidden" value="' +
      i +
      '" name="urutanImgbaru' +
      i +
      '"/><input type="hidden" value="' +
      i +
      '" name="urutan_imgnya[]"><td class="text-center">' +
      i +
      '</td><td class="text-center"><input type="file" class="form-control" name="edImg' +
      i +
      '" accept=".png,.jpg,.jpeg"></td><td class="text-center"><button class="btn btn-success" formaction="' +
      baseurl +
      "Slideshow/EditData/SaveImgEdit/" +
      id +
      "-" +
      i +
      '">Save</button></td></tr>'
  );
}
function UpdateGambar(a, i) {
  var request = $.ajax({
    url: baseurl + "Slideshow/EditData/ModalUpImg",
    data: {
      line_id: a,
      urutan: i,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    $("#update_img").html(result);
    $("#UpImg").modal("show");
  });
}
function InactiveGambar(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Gambar ini akan Inactive",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/InactiveImg",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Inactive",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function ActiveGambar(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Gambar ini akan Active",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/ActiveImg",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Active",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function DeleteGambar(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Gambar ini akan di hapus",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/HapusImg",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Hapus Gambar",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function DeleteSlide(i) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Slide Show ini akan di hapus",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "Slideshow/EditData/HapusSlideShow",
        data: {
          i: i,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Hapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
