$(document).ready(function(){

$('#slcNoDocOR').select2({
  tags: true,
  placeholder: "Masukkan Nomor Dokumen .. ",
  createTag: function (params) {
    return {
      id: params.term,
      text: params.term,
      newOption: true
    }
  },
  templateResult: function (data) {
    var $result = $("<span></span>");

    $result.text(data.text);

    // if (data.newOption) {
    //   $result.append(" <em>(new)</em>");
    // }

    return $result;
  }
});

});

