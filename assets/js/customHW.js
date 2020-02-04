$(document).ready(function(){
  $(".noInduk").select2({
    ajax: {
      url: baseurl+'hardware/input-data/getDataUser',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind,
              title: item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Masukan No Induk User'
  });
  
  
  $(document).on('change', '.noInduk', function(){
    var noInduk = $(this).val();
    $.ajax({
      method: "GET",
      url: baseurl+'hardware/input-data/getDescriptionUser/',
      dataType: 'json',
      data: { noind: noInduk} 
    }).done(function (data) {
      console.log(data);
      $('.nama').val(data[0]['nama']);
      $('.seksi').val(data[0]['seksi']);
      $('.Email_Pekerja').val(data[0]['email_internal']);
      $('.akun_pidgin').val(data[0]['pidgin_account']);

    });
  });

  $('.lokasi').select2({
    placeholder: 'Pilih Lokasi'
  });

  // $('.input_ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {translation: {'Z': {pattern: /[0-9]/, optional: true}}});
  // $('.input_ip').change(function(){
  //   var v = $(this).val().replace(/_/g, '');
  //   $(this).val(v);
  // });

  $('.slcOs').select2({
    tags: true
  });
  $('.slcProcie').select2({
    tags: true
  });
  $('.slcTypeRam').select2({
    tags: true
  });
  $('.slcCdRom').select2({
    tags: false
  });


  $('[data-mask]').inputmask();
  $('#tbl_sweeping').DataTable();

  $('#form-update').keypress(
    function(event){
      if (event.which == '13') {
        event.preventDefault();
      }
    });

  $(".apk_bjk").select2({
   tags: true
 });
});