$(document).ready(function(){

  $("#tbl_datapkjmasuk").DataTable();
  $("#tbl_datapkjkeluar").DataTable();

  $('.slc-lokasi-kerja-mp').select2({
    placeholder: 'Lokasi Kerja',
    searching: true,
    allowClear: true,
    ajax: 
    {
      url: baseurl+'MasterPekerja/CetakPekerjaMasuk/getLokasiKerja',
      dataType: 'json',
      type: 'GET',
      delay: 500,
      data: function (params){
        return {
          term: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj){
            return {id: obj.id_+" - "+obj.lokasi_kerja, text:obj.id_+" - "+obj.lokasi_kerja};
          })
        };
      }
    }
  });

  $('.slc-petugas-hubker').select2({
    placeholder: 'Petugas',
    searching: true,
    allowClear: true,
    ajax: 
    {
      url: baseurl+'MasterPekerja/CetakPekerjaMasuk/getPetugas',
      dataType: 'json',
      type: 'GET',
      delay: 500,
      data: function (params){
        return {
          term: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj){
            return {id: obj.noind+" - "+obj.nama, text:obj.noind+" - "+obj.nama};
          })
        };
      }
    }
  });
})
