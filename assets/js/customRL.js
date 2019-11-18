// ------------------------------------------------- Rekap LPPB ---------------------------------------------//
$(document).ready(function(){
    $('a[name="anav"]').click(function(){
        var anav = $(this).data("value");
        // console.log(anav);
        var request = $.ajax ({
            url : baseurl + "RekapLppb/SearchData",
            data : "&bulan="+anav,
            type : "GET",
            dataType: "html"
        });
        
        $('#Rekap').html('');
        $('#loadingRL').html("<center><img id='loadingRL' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
        request.done(function(output) {
            window.setTimeout(function(){
                $('#loadingRL').html('');
                $('#Rekap').html(output);  
                
            }, 1000);
        })
    })

    $('.datepickRekap').datepicker({
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'yy-mm-dd',
    });

    $('.tblRekapLppb').DataTable({
        "scrollX": true,
        "columnDefs": [
            { "width": "30%", "targets": 2, "visible" : false }],
        "orderable": false,
    });


});


    function SaveKirimQC(number , itemid , recnum , po) {
        var ket = 'kirim_qc';
        var kirimqc = $('#dateKirimQC'+number).val();
        // console.log(number , itemid , recnum , po, kirimqc)
        if(!kirimqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKirimQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kirimqc : kirimqc, ket : ket  },
            type : "POST",
            dataType: "html"
        });

    }

    function SaveTerimaQC(number , itemid , recnum , po) {
        var ket = 'terima_qc';
        var terimaqc = $('#dateTerimaQC'+number).val();
        // console.log(number , itemid , recnum , po, terimaqc)
        if(!terimaqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveTerimaQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , terimaqc : terimaqc, ket : ket },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveKembaliQC(number , itemid , recnum , po) {
        var ket = 'kembali_qc';
        var kembaliqc = $('#dateKembaliQC'+number).val();
        // console.log(number , itemid , recnum , po, kembaliqc)
        if(!kembaliqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKembaliQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kembaliqc : kembaliqc, ket : ket },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveKirimGudang(number , itemid , recnum , po) {
        var ket = 'kirim_gudang';
        var kirimgudang = $('#dateKirimGudang'+number).val();
        // console.log(number , itemid , recnum , po, kirimgudang)
        if(!kirimgudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKirimGudang",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kirimgudang : kirimgudang, ket : ket },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveTerimaGudang(number , itemid , recnum , po) {
        var ket = 'terima_gudang';
        var terimagudang = $('#dateTerimaGudang'+number).val();
        // console.log(number , itemid , recnum , po, terimagudang)
        if(!terimagudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveTerimaGudang",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , terimagudang : terimagudang, ket : ket },
            type : "POST",
            dataType: "html"
        });
    }

// ------------------------------------------------- Rekap LPPB View ---------------------------------------------//


$(document).ready(function(){
    $('a[name="anaview"]').click(function(){
    var anaview = $(this).data("value");
    console.log(anaview);

    var request = $.ajax ({
        url : baseurl + "RekapLppbView/SearchData",
        data : "&bulan="+anaview,
        type : "GET",
        dataType: "html"
    });
    $('#RekapView').html('');
    $('#loadingRLView').html("<center><img id='loadingRL' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");

    request.done(function(output) {

        window.setTimeout(function(){
            $('#loadingRLView').html(''); 
            $('#RekapView').html(output);    
            
        }, 1000);
    })
})


$('.tblRekapLppbview').DataTable({
    "scrollX": true,
    "columnDefs": [
        { "width": "20%", "targets": 2 }]
    });

});