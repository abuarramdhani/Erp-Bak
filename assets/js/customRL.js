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
        var io = $('#io'+number).val();
        console.log(number , itemid , recnum , po, kirimqc);
        if(!kirimqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKirimQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kirimqc : kirimqc, ket : ket, io : io  },
            type : "POST",
            dataType: "html"
        });

    }

    function SaveTerimaQC(number , itemid , recnum , po) {
        var ket = 'terima_qc';
        var terimaqc = $('#dateTerimaQC'+number).val();
        var io = $('#io'+number).val();
        // console.log(number , itemid , recnum , po, terimaqc)
        if(!terimaqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveTerimaQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , terimaqc : terimaqc, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveKembaliQC(number , itemid , recnum , po) {
        var ket = 'kembali_qc';
        var kembaliqc = $('#dateKembaliQC'+number).val();
        var io = $('#io'+number).val();
        // console.log(number , itemid , recnum , po, kembaliqc)
        if(!kembaliqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKembaliQC",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kembaliqc : kembaliqc, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveKirimGudang(number , itemid , recnum , po) {
        var ket = 'kirim_gudang';
        var kirimgudang = $('#dateKirimGudang'+number).val();
        var io = $('#io'+number).val();
        // console.log(number , itemid , recnum , po, kirimgudang)
        if(!kirimgudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveKirimGudang",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , kirimgudang : kirimgudang, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
    }

    function SaveTerimaGudang(number , itemid , recnum , po) {
        var ket = 'terima_gudang';
        var terimagudang = $('#dateTerimaGudang'+number).val();
        var io = $('#io'+number).val();
        // console.log(number , itemid , recnum , po, terimagudang);
        if(!terimagudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/SaveTerimaGudang",
            data: {number: number, itemid: itemid, recnum : recnum, po : po , terimagudang : terimagudang, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
    }


    function searchBlnLppb(th) {
        $(document).ready(function(){
        // var bulan = $('#bln').val();
        var id_org = $('#id_org').val();
        var lppbAwl = $('#LppbAwl').val();
        var lppbAkh = $('#LppbAkh').val();
        // console.log();
        var request = $.ajax({
                url: baseurl+'RekapLppb/Input/searchBulan',
                data: {	id_org : id_org, lppbAwl : lppbAwl, lppbAkh : lppbAkh},
                type: "POST",
                datatype: 'html'
        });
        $('#tb_inputLPPB').html('');
        $('#tb_inputLPPB').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        request.done(function(result){
                $('#tb_inputLPPB').html('');
                $('#tb_inputLPPB').html(result);
                // $('#myTable').dataTable({
                //     "scrollX": false,
                //     "scrollY": 500,
                //     "scrollCollapse": true,
                //     "paging":false
                //     });
                })
        });
    }

    $(document).ready(function(){
        $("#id_org").select2({
            allowClear: true,
            placeholder: "Pilih IO",
            minimumInputLength: 0,
            ajax: {		
                url:baseurl+"RekapLppb/Perbaikan/searchIO",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(obj) {
                            return { id:obj.ORGANIZATION_ID, text:obj.ORGANIZATION_CODE};
                        })
                    };
                }
            }
        });
    });

    function schPerbaikan(th) {
        $(document).ready(function(){
        var no_recipt = $('#no_recipt').val();
        var no_po = $('#no_po').val();
        var item = $('#item').val();
        var id_org = $('#id_org').val();
        console.log(id_org);
        var request = $.ajax({
                url: baseurl+'RekapLppb/Perbaikan/searchPerbaikan',
                data: {	no_recipt : no_recipt, no_po : no_po, id_org : id_org, item : item },
                type: "POST",
                datatype: 'html'
        });
        $('#tb_LPPB').html('');
        $('#tb_LPPB').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        request.done(function(result){
                $('#tb_LPPB').html('');
                $('#tb_LPPB').html(result);
                // $('#myTable').dataTable({
                //     "scrollX": false,
                //     "scrollY": 500,
                //     "scrollCollapse": true,
                //     "paging":false
                //     });
                })
        });
    }


    function searchTahunLppb(th) {
        $(document).ready(function(){
        var tahun = $('#tahun').val();
        var id_org = $('#id_org').val();
        console.log(tahun);
        var request = $.ajax({
                url: baseurl+'RekapLppb/RekapTahunan/searchTahunan',
                data: {	tahun : tahun, id_org : id_org },
                type: "POST",
                datatype: 'html'
        });
        $('#tb_rekapTh').html('');
        $('#tb_rekapTh').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        request.done(function(result){
                $('#tb_rekapTh').html('');
                $('#tb_rekapTh').html(result);
                // $('#myTable').dataTable({
                //     "scrollX": false,
                //     "scrollY": 500,
                //     "scrollCollapse": true,
                //     "paging":false
                //     });
                })
        });
    }

    function schOverdueLppb(th) {
        $(document).ready(function(){
        var tahun = $('#tahun').val();
        var id_org = $('#id_org').val();
        console.log(tahun);
        var request = $.ajax({
                url: baseurl+'RekapLppb/Overdue/searchOverdue',
                data: {	tahun : tahun, id_org : id_org },
                type: "POST",
                datatype: 'html'
        });
        $('#tb_overLPPB').html('');
        $('#tb_overLPPB').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        request.done(function(result){
                $('#tb_overLPPB').html('');
                $('#tb_overLPPB').html(result);
                // $('#myTable').dataTable({
                //     "scrollX": false,
                //     "scrollY": 500,
                //     "scrollCollapse": true,
                //     "paging":false
                //     });
                })
        });
    }

    function schRekapLppb(th) { 
        $(document).ready(function(){
        var bulan = $('#bulan').val();
        var id_org = $('#id_org').val();
        console.log(bulan);
        var request = $.ajax({
                url: baseurl+'RekapLppb/Rekap/schRekapLppb',
                data: {	bulan : bulan, id_org : id_org },
                type: "POST",
                datatype: 'html'
        });
        $('#tb_rekapLppb').html('');
        $('#tb_rekapLppb').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        request.done(function(result){
            // console.log(result)
                $('#tb_rekapLppb').html('');
                $('#tb_rekapLppb').html(result);
                // $('#myTable').dataTable({
                //     "scrollX": false,
                //     "scrollY": 500,
                //     "scrollCollapse": true,
                //     "paging":false
                //     });
                })
        });
    }
 

function SaveKirimQC1(number , recnum ) {
        var ket = 'kirim_qc';
        var io = $('#io'+number).val();
        var d = new Date();
        var kirimqc = d.getDate()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        console.log(recnum);
        if(!kirimqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/Input/SaveKirimQC",
            data: {number: number, recnum : recnum , kirimqc : kirimqc, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
        $('#dateKirimQC'+number).each(function() {
            $('#dateKirimQC'+number).val(kirimqc); 
            // console.log(datepack);
        })

    }

    function SaveTerimaQC1(number , recnum ) {
        var ket = 'terima_qc';
        var io = $('#io'+number).val();
        var d = new Date();
        var terimaqc = d.getDate()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        console.log(terimaqc);
        if(!terimaqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/Input/SaveTerimaQC",
            data: {number: number, recnum : recnum , terimaqc : terimaqc, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
        $('#dateTerimaQC'+number).each(function() {
            $('#dateTerimaQC'+number).val(terimaqc); 
            // console.log(datepack);
        })
    }

    function SaveKembaliQC1(number , recnum ) {
        var ket = 'kembali_qc';
        var io = $('#io'+number).val();
        var d = new Date();
        var kembaliqc = d.getDate()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        // console.log(number , itemid , recnum , kembaliqc)
        if(!kembaliqc){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/Input/SaveKembaliQC",
            data: {number: number, recnum : recnum , kembaliqc : kembaliqc, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
        $('#dateKembaliQC'+number).each(function() {
            $('#dateKembaliQC'+number).val(kembaliqc); 
            // console.log(datepack);
        })
    }

    function SaveKirimGudang1(number , recnum ) {
        var ket = 'kirim_gudang';
        var io = $('#io'+number).val();
        var d = new Date();
        var kirimgudang = d.getDate()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        // console.log(number , itemid , recnum , kirimgudang)
        if(!kirimgudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/Input/SaveKirimGudang",
            data: {number: number, recnum : recnum , kirimgudang : kirimgudang, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
        $('#dateKirimGudang'+number).each(function() {
            $('#dateKirimGudang'+number).val(kirimgudang); 
            // console.log(datepack);
        })
    }

    function SaveTerimaGudang1(number , recnum ) {
        var ket = 'terima_gudang';
        var io = $('#io'+number).val();
        var d = new Date();
        var terimagudang = d.getDate()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        // console.log(number , itemid , recnum , terimagudang)
        if(!terimagudang){
            return;
        }
        $.ajax ({
            url : baseurl + "RekapLppb/Input/SaveTerimaGudang",
            data: {number: number, recnum : recnum , terimagudang : terimagudang, ket : ket, io : io },
            type : "POST",
            dataType: "html"
        });
         $('#dateTerimaGudang'+number).each(function() {
            $('#dateTerimaGudang'+number).val(terimagudang); 
            // console.log(datepack);
        })
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


   
function schMonView(th) { 
    $(document).ready(function(){
    var bulan = $('#bulan').val();
    var id_org = $('#id_org').val();
    console.log(bulan);
    var request = $.ajax({
            url: baseurl+'RekapLppbView/Monitoring/searchMonitoring',
            data: {	bulan : bulan, id_org : id_org },
            type: "POST",
            datatype: 'html'
    });
    $('#tb_monLppb').html('');
    $('#tb_monLppb').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
    request.done(function(result){
        // console.log(result)
            $('#tb_monLppb').html('');
            $('#tb_monLppb').html(result);
            // $('#myTable').dataTable({
            //     "scrollX": false,
            //     "scrollY": 500,
            //     "scrollCollapse": true,
            //     "paging":false
            //     });
            })
    });
}

function schUndeliverView(th) { 
    $(document).ready(function(){
    var bulan = $('#bulan').val();
    var id_org = $('#id_org').val();
    console.log(bulan);
    var request = $.ajax({
            url: baseurl+'RekapLppbView/Undeliver/searchData',
            data: {	bulan : bulan, id_org : id_org },
            type: "POST",
            datatype: 'html'
    });
    $('#tb_Undeliver').html('');
    $('#tb_Undeliver').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
    request.done(function(result){
        // console.log(result)
            $('#tb_Undeliver').html('');
            $('#tb_Undeliver').html(result);
            // $('#myTable').dataTable({
            //     "scrollX": false,
            //     "scrollY": 500,
            //     "scrollCollapse": true,
            //     "paging":false
            //     });
            })
    });
}

function schRekapThView(th) { 
    $(document).ready(function(){
    var tahun = $('#tahun').val();
    var id_org = $('#id_org').val();
    console.log(tahun);
    var request = $.ajax({
            url: baseurl+'RekapLppbView/RekapTahunan/searchTahunan',
            data: {	tahun : tahun, id_org : id_org },
            type: "POST",
            datatype: 'html'
    });
    $('#tb_rekapThView').html('');
    $('#tb_rekapThView').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
    request.done(function(result){
        // console.log(result)
            $('#tb_rekapThView').html('');
            $('#tb_rekapThView').html(result);
            // $('#myTable').dataTable({
            //     "scrollX": false,
            //     "scrollY": 500,
            //     "scrollCollapse": true,
            //     "paging":false
            //     });
            })
    });
}
