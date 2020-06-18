// -------------------- SELECT 2 -----------------------------//
$(document).ready(function () {
  $("#kodeitem").select2({
    allowClear: true,
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "RKHKasie/Bom/getKodbar",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        }
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.KODE_BARANG,
              text: obj.ITEM
            };
          })
        };
      }
    }
  });
});
// ---------------------------GET DATA ------------------------//

function getBom(th) {
  $('#bom_ada').css("display","none");
  $('#bom_tdk').css("display","none");
  $('#bom_result').css("display","block");

    var kodeitem = $('input[name="kodeitem"]').val();

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/getBom',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'html'
    });
    
      $('#bom_result').html('');
      $('#bom_result').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      

    request.done(function(result){
      // console.log("sukses2");
      $('#bom_result').html(result);
        // $('#result_bom').DataTable({
        //   scrollX: true,
        //   scrollY:  400,
        //   scrollCollapse: true,
        //   paging:true,
        //             info:false,
        //             searching : true,
        // });
      });
}
function getBomada(th) {
  $('#bom_result').css("display","none");
  $('#bom_tdk').css("display","none");
  $('#bom_ada').css("display","block");

    var kodeitem = $('input[name="kodeitem"]').val();

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/getadaBom',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'html'
    });
    
      $('#bom_ada').html('');
      $('#bom_ada').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      

    request.done(function(result){
      // console.log("sukses2");
      $('#bom_ada').html(result);
        // $('#ada_bom').DataTable({
        //   scrollX: true,
        //   scrollY:  400,
        //   scrollCollapse: true,
        //   paging:true,
        //             info:false,
        //             searching : true,
        // });
      });
}
function getBomtdkada(th) {
  $('#bom_result').css("display","none");
  $('#bom_ada').css("display","none");
  $('#bom_tdk').css("display","block");

    var kodeitem = $('input[name="kodeitem"]').val();

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/gettdkBom',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'html'
    });
    
      $('#bom_tdk').html('');
      $('#bom_tdk').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      

    request.done(function(result){
      // console.log("sukses2");
      $('#bom_tdk').html(result);
        // $('#tdk_bom').DataTable({
        //   scrollX: true,
        //   scrollY:  400,
        //   scrollCollapse: true,
        //   paging:true,
        //             info:false,
        //             searching : true,
        // });
      });
}
function getdesckomp(no) {
    var kodeitem = $('#kodebomedit'+no).val();
    var namabom = $('#namabomedit'+no).val();


    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/getDescCode',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'json'
    });
      // $('#namabomedit'+no+u).val('<center><img style="width:10px; height:auto" src="'+baseurl+'assets/img/gif/loading99.gif"></center>' );
    
    request.done(function(result){
        var str = result
        $('#namabomedit'+no). val(str.replace(/"/g, ""));
   
      });
}

function getdesckompp(no,u) {
    var kodeitem = $('#kodebomedit'+no+u).val();
    var namabom = $('#namabomedit'+no+u).val();
    console.log(kodeitem)
    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/getDescCode',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'json'
    });
      // $('#namabomedit'+no+u).val('<center><img style="width:10px; height:auto" src="'+baseurl+'assets/img/gif/loading99.gif"></center>' );
    
    request.done(function(result){
        var str = result
        $('#namabomedit'+no+u). val(str.replace(/"/g, ""));
   
      });
}

function lihatbomm(th, no) {
    var kodeitem = $('#codeitem'+no).val();

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/getlihatbom',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'html'
    });
    
      $('#teerlihat'+no).html('');
      // $('#teerlihat'+no).html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      

    request.done(function(result){
      // console.log(result);
        // var title = $(th).text();   
        $('#lalalala').html(result);
        $('#modalakuaku').modal('show');
      });
}
function editbomm(th, no)
{   
       var kodeitem = $('#codeitem'+no).val();

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'RKHKasie/Bom/geteditbom',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'html'
    });
    
      $('#teerlihat'+no).html('');
      // $('#teerlihat'+no).html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      

    request.done(function(result){
      // console.log(result);
        // var title = $(th).text();   
        $('#lalalala').html(result);
        $('#modalakuaku').modal('show');
      });

}


// ------------------------- GET TIME ------------------------------//
// $(document).ready(function() {
//     var d    = new Date();
//     // var buka_aplikasi  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//     // console.log(buka_aplikasi);

//     var button   = document.getElementById("btnstart"+no);
//     var button2   = document.getElementById("btnlanjut"+no);
//     var hoursLabel   = document.getElementById("hours"+no);
//     var minutesLabel = document.getElementById("minutes"+no);
//     var secondsLabel = document.getElementById("seconds"+no);
//     var startButton = document.getElementById('btnstart'+no);
//     var stopButton = document.getElementById('btnstop'+no); 
//     var restartButton = document.getElementById('btnrestart'+no); 
//     var lanjutButton = document.getElementById('btnlanjut'+no); 


//     var totalSeconds = 0;
//     var timer = null;

//     button.onclick = function() {
//         var value = $('#btnstart'+no).val();

//         if (value == 'Mulai') {

//              if (!timer) {
//                   timer = setInterval(setTime, 1000);
//                 }
//         var d    = new Date();
//         var mulai  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//         console.log (mulai);

//         $('#btnstart'+no).val('Selesai');
//         $('#btnlanjut'+no).removeAttr("disabled");
//         $('#btnrestart'+no).removeAttr("disabled");


//         } else if (value == 'Selesai') {

//              if (timer) {
//                   clearInterval(timer);
//                   timer = null;
//                 }
//         $('#btnlanjut'+no).attr("disabled", "disabled");
//         $('#btnrestart'+no).attr("disabled", "disabled");  
//         var d    = new Date();
//         var selesai  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//         console.log (selesai);

//         }
//     };
//        button2.onclick = function() {
//         var value = $('#btnlanjut'+no).val();

//         if (value == 'Jeda') {

//             if (timer) {
//                   clearInterval(timer);
//                   timer = null;
//                 }
//          var d    = new Date();
//         var jeda  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//         console.log (jeda);

//         $('#btnlanjut'+no).val('Lanjut');
//         $('#btnrestart'+no).attr("disabled","disabled");
//         // $('#btnrestart'+no).removeAttr("disabled");


//         } else if (value == 'Lanjut') {

//              if (!timer) {
//                  timer = setInterval(setTime, 1000);
//              }
//          var d    = new Date();
//         var lanjut  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//         console.log (lanjut);

//         $('#btnlanjut'+no).val('Jeda');
//         $('#btnrestart'+no).removeAttr("disabled");
//         // $('#btnrestart'+no).attr("disabled","disabled");


//         }
//     };
//       restartButton.onclick = function() {
//         if (timer) {
//           clearInterval(timer);
//           timer = setInterval(setTime, 1000);
//           totalSeconds = 0;
//         }
//          var d    = new Date();
//         var mulai_lagi  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//         console.log (mulai_lagi);
//         $('#btnlanjut'+no).val('Jeda');

//     };

//     function setTime() {
//         totalSeconds++;
//         secondsLabel.innerHTML = pad(totalSeconds % 60);
//         minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
//         hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600));
        
//     }
    
//     function pad(val) {
//         var valString = val + "";
//         if (valString.length < 2) {
//         return "0" + valString;
//         } else {
//         return valString;
//         }
//     }
// });
// ------------------------ APPEND INPUT ------------------------//
var i = 2;
function nambahteros() {
    $('#tambahisi').append('<tr class="rowbaru" ><td class="text-center"><input type="text" class="form-control" name="code[]"></td><td class="text-center"><input type="text" class="form-control" name="namabar[]" readonly="readonly"></td><td class="text-center"><input type="text" class="form-control" name="quantity[]"></td><td class="text-center"><a class="btn btn-danger btn-sm  btnhps'+i+'"><i class="fa fa-minus"></i></a></td></tr>');

      $(document).on('click', '.btnhps'+i,  function() {
        $(this).parents('.rowbaru').remove()
    });

    i++; 
}

function tambahpack(no) {
    // var par = $('input[name="urutan'+no+'[]"]').map(function(){return $(this).val();}).get();
    // var p = par.length;
    // console.log(jml);
    no++;

  $('#tambahpack').append('<tr class="trbaru"><td class="text-center"><input type="text" class="form-control" me="kodebomedit[]" id="kodebomedit'+no+'" onkeyup="getdesckomp('+no+')"></td><td class="text-center"><input type="text" class="form-control" name="namabomedit[]"  id="namabomedit'+no+'" readonly="readonly"></td><td class="text-center"><input onkeypress="return angkasaja(event, false)" type="text" class="form-control"  id="qtybom'+no+'" name ="qtybomedit[]"> </td><td class="text-center"><button class="btn btn-sm btn-danger hpspack'+no+'"><i class="fa fa-minus"></i></button> </td></tr>');
  console.log('tambahpackoke')

    $(document).on('click', '.hpspack'+no,  function() {
        $(this).parents('.trbaru').remove()
    });

    // p++; 
}
function tambahpackk(no,p) {
    var par = $('input[name="urutan'+no+'[]"]').map(function(){return $(this).val();}).get();
    var p = par.length;
    // console.log(jml);
    p++;
  $('#tambahpack'+no).append('<tr class="trbaru"><input type="hidden" value="'+p+'"name="urutan'+no+'[]"><td class="text-center"><input type="text" class="form-control"  id="kodebomedit'+no+''+p+'" onkeyup="getdesckompp('+no+','+p+')"></td><td class="text-center"><input type="text" class="form-control"  id="namabomedit'+no+''+p+'" readonly="readonly"></td><td class="text-center"><input onkeypress="return angkasaja(event, false)" type="text" class="form-control"  id="qtybom'+no+''+p+'"> </td><td class="text-center"><button class="btn btn-sm btn-danger hpspack'+p+'"><i class="fa fa-minus"></i></button> </td></tr>');
  console.log('tambahpackoke')
    $(document).on('click', '.hpspack'+p,  function() {
        $(this).parents('.trbaru').remove()
    });
    // p++; 
}

// ---------------------------- HAPUS  JOB -------------------//
function hapusdata(no) {

      const { value: alasan } = Swal.fire({
          title: 'Masukan Alasan',
          input: 'text',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'Masukan Alasan!'
            }
             if (value) {
                 console.log(value)
            }
          }
        }) .then((result) => {
          if (result.value) {
            Swal.fire(
              'Job Sudah Terhapus',
              '',
              'success'
            )
            window.location.reload();
          }
        })
       
        console.log('inifunctionhapusdata')
}

// ------------------------- SLIDE TOOGLE ----------------- //
function lihatdong(th, no)
{   
    var title = $(th).text();   
    $('#lihat'+no).slideToggle('slow'); 
}
function lihatbom(th, no)
{   
    var title = $(th).text();   
    $('#lihatbom'+no).slideToggle('slow'); 
    $('#editbom'+no).css("display","none"); 
}
function editbom(th, no)
{   
    var title = $(th).text();   
    $('#editbom'+no).slideToggle('slow'); 
    $('#lihatbom'+no).css("display","none"); 
}

function hapuspack(no) {
   $(document).on('click', '.hpspack'+no,  function() {
        $(this).parents('.trlama'+no).remove()
    });
}
function angkasaja(e, decimal) {
  var key;
  var keychar;
  if (window.event) {
    key = window.event.keyCode;
  } else
  if (e) {
    key = e.which;
  } else return true;
  keychar = String.fromCharCode(key);
  if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
    return true;
  } else
  if ((("0123456789.").indexOf(keychar) > -1)) {
    return true;
  } else
  if (decimal && (keychar == ".")) {
    return true;
  } else return false;
}
