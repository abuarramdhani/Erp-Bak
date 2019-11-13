function getMPG(th) {
    $(document).ready(function(){
    var noDokumen       = $('input[name="noDokumen"]').val();
    var jenis_dokumen   = $('#jenis_dokumen').val();
    // console.log(jenis_dokumen);
    
    var request = $.ajax({
        url: baseurl+'MonitoringGdSparepart/Input/input',
        data: {
            noDokumen       : noDokumen, 
            jenis_dokumen   : jenis_dokumen
        },
        type: "POST",
        datatype: 'html'
    });
    
    $('#tb_GudangSparepart').html('');
	$('#tb_GudangSparepart').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
    
    request.done(function(result){
        $('#tb_GudangSparepart').html('');
        $('#tb_GudangSparepart').html(result);
        // $('#tb_monitorGudang').dataTable({
        //     "retrieve": true,
        //     "paging" : false,
        //     "scrollX": true,
        //     "scrollCollapse": true,
        //     "fixedHeader":true
        //     });
        })
    });
}
// no dokumen otomatis INPUT
$('#noDokumen').change(function(){
    getAutoFillDocument()
});
$('#noDokumen').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
     {
        getAutoFillDocument()
     }
});   
// jenis dokumen otomatis INPUT
function getAutoFillDocument(){
    var no_document = $('input[name="noDokumen"]').val();

    $('input[name="no_document"]').val(no_document)

    var length = no_document.length
    
    if(length == 12){
        $('#jenis_dokumen').val('IO').trigger('change')
    }else if(length == 5){
        $('#jenis_dokumen').val('LPPB').trigger('change')
    }else {
        $('#jenis_dokumen').val('KIB').trigger('change')
    }
}

function getMGS(th) {
    // $(document).ready(function(){
    var search_by       = $('#search_by').val();
    var jenis_dokumen   = $('#jenis_dokumen').val();
    var no_document     = $('input[name="no_document"]').val();
    var tglAwal         = $('input[name="tglAwal"]').val();
    var tglAkhir        = $('input[name="tglAkhir"]').val();
    var pic             = $('input[name="pic"]').val();
    var item            = $('input[name="item"]').val();
    console.log(search_by,jenis_dokumen,no_document,tglAwal,tglAkhir,pic,item);
if( search_by == 'export'){
    $('#btnExMGS').css('display', '')
}else{
    $('#btnExMGS').css('display', 'none')
}
    var request = $.ajax({
        url: baseurl+'MonitoringGdSparepart/Monitoring/search',
        data: {
            search_by       : search_by,
            jenis_dokumen   : jenis_dokumen, 
            no_document     : no_document, 
            tglAwal         : tglAwal, 
            tglAkhir        : tglAkhir, 
            pic             : pic, 
            item            : item
        },
        type: "POST",
        datatype: 'html'
    });
    
    $('#tblMGS').html('');
    $('#tblMGS').html('<center><img style="width:150px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"></center>' );
        
    request.done(function(result){
        $('#tblMGS').html('');
        $('#tblMGS').html(result);
        // $('#myTable').dataTable({
        //     "paging": false,
        //     "scrollX": true,
        //     "scrollCollapse": true,
        //     "fixedHeader":true,
        //     "ordering": false,
        //     });
        });
    // });
}

function addDetailMGS(th, no){
	var title = $(th).text();
	$('#detail'+no).slideToggle('slow');
}

function btnEditMGS(th, no, nomor){
	var title = $(th).text();
	$('#edit'+no+nomor).slideToggle('slow');
}


$('#search_by').change(function(){
    var value = $('#search_by').val()

    if(value == "dokumen"){
        $('#slcnodoc').css('display', '')
        $('#slcjenis').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="pic"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('input[name="item"]').val('');
    }else if(value == "tanggal"){
        $('#slcTgl').css('display', '')
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="pic"]').val('');
        $('input[name="no_document"]').val('');
        $('#jenis_dokumen').val('');
        $('input[name="item"]').val('');
    }else if(value == "pic"){
        $('#slcPIC').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#jenis_dokumen').val('');
        $('input[name="item"]').val('');
    }else if(value == "item"){
        $('#slcItem').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('input[name="pic"]').val('');
        $('#jenis_dokumen').val('');
    }else if(value == "export"){
        $('#slcjenis').css('display', '')
        $('#slcTgl').css('display', '');
        $('#slcDokumen').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#jenis_dokumen').val('');
        $('input[name="item"]').val('');
        $('input[name="pic"]').val('');
    }
});

$("#frmMGS").keypress(function(e) {   //Enter key   
    if (e.which == 13) {     
        return false;   
    } });


    function saveJmlOk(no, nomor, doc) {
        // var ket = 'kirim_qc';
        var jml_ok = $('#jml_ok'+no+nomor).val();
        var item = $('#item'+no+nomor).val();
        console.log(no , jml_ok, item);
        if(!jml_ok){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveJmlOk",
            data: {no: no, nomor : nomor, doc : doc, jml_ok : jml_ok, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    function saveNotOk(no , nomor , doc) {
        // var ket = 'kirim_qc';
        var jml_not_ok = $('#jml_not_ok'+no+nomor).val();
         var item = $('#item'+no+nomor).val();
        console.log(no , jml_not_ok, item);
        if(!jml_not_ok){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveNotOk",
            data: {no: no, nomor : nomor, doc : doc, jml_not_ok : jml_not_ok, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    function saveKetr(no , nomor , doc) {
        // var ket = 'kirim_qc';
        var ket = $('#keterangan'+no+nomor).val();
         var item = $('#item'+no+nomor).val();
        // console.log(number , itemid , recnum , po, kirimqc)
        if(!ket){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveKetr",
            data: {no: no, nomor : nomor, doc : doc, ket : ket, item : item  },
            type : "POST",
            dataType: "html"
        });

    }
