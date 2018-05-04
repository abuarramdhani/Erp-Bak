$('#tablekomponen').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#tabletipe').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#table_report').DataTable({
    dom: ''
});

$('#table_detail').DataTable({
    dom: 'frtip'

});



function UpdateDetail(e,th,tipe,col){
    if (e.keyCode === 13) {
    HasilCat = $(th).val();
    no_cbo =  $('#inp_cbo').val();

     $.ajax({
            type:'post',
            url: baseurl+'/MonitoringCBO/C_MonitoringCBO/UpdateDetail',
            data:{type:tipe,
                  HasilCat:HasilCat,
                  inp_cbo:no_cbo,
                  col:col},
             success:function(results){
                $(th).parent().prev().html(results);
             }
            
        })
}
}

function DeleteKomponen(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.busak').prop('disabled',true);
        $.ajax({
            url: baseurl+'/MonitoringCBO/C_MonitoringCBO/deleteKomponen/'+id,
            success:function(results){
               
                $('table#tablekomponen tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.busak').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}



function DeleteTipe(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.busak').prop('disabled',true);
        $.ajax({
            url: baseurl+'/CBOPainting/Setup/Tipe/Delete//'+id,
            success:function(results){
               
                $('table#tabletipe tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.busak').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}

$('#save_cbo').click(function(){
tgl = $('#tgl_cbo').val();
shift = $('#shift_cbo').val();
line = $('#line_cbo').val();
komp = $('#komp_cbo').val();
$.ajax({
    type:'POST',
    data:{
            tgl:tgl,
            shift:shift,
            line:line,
            komp:komp
        },
    url:baseurl+'CBOPainting/CBO/cek_cbo',
    success: function(results){

        if (results=='') {
            // alert('data not found');
            $('#table_cbo').find('input').val('');
            $('#table_cbo').find('input').parent().prev().html('0');
            $.ajax({
                type:'POST',
                data:{
                    tgl:tgl,
                    shift:shift,
                    line:line,
                    komp:komp
                },
                url: baseurl+'CBOPainting/CBO/Regen',
                success:function(result){
                   $('#table_cbo').show();
                   $('#table-detail').find('tbody').html(result);
                   no_cbo = $('#table-detail').find('input#no_cbo').val();
                   $('span#no_cbo').html(no_cbo);
                   $('input#inp_cbo').val(no_cbo);

                }
            })
        }else{
              $.ajax({
                type:'POST',
                data:{
                    tgl:tgl,
                    shift:shift,
                    line:line,
                    komp:komp
                },
                url: baseurl+'CBOPainting/CBO/Edit',
                success:function(result){
                   $('#table_cbo').show();
                   $('#table-detail').find('tbody').html(result);
                   no_cbo = $('#table-detail').find('input#no_cbo').val();
                   $('span#no_cbo').html(no_cbo);
                   $('input#inp_cbo').val(no_cbo);

                }
            })

        }
    }
})
})
$(document).ready(function() {
    // var table = $('#table_cbo').DataTable( {
    //     scrollY:        "300px",
    //     scrollX:        true,
    //     scrollCollapse: true,
    //     paging:         false,
    //     fixedColumns:   {
    //         leftColumns: 1
    //     }
    // } );
} );

$('#report_cbo').click(function(){
    tgl = $('#tgl_report').val();
    shift = $('#shift_report').val();
    line = $('#line_report').val();
    komp = $('#komp_report').val();

     $.ajax({
        type:'POST',
        data:{
            tgl:tgl,
            shift:shift,
            line:line,
            komp:komp
        },
        url: baseurl+'CBOPainting/CBO/SearchReport',
         beforeSend: function() {
                $('#table_report').DataTable().destroy();
                $('#table_report tbody').empty();
            },
        success:function(results){
            console.log(results);
           $('#table_report').find('tbody').html(results);
        }
    })
})


$(function() {
    $('input[name="daterange"]').daterangepicker();
});

$('.datepicker_mc').datepicker({
    dateFormat: 'mm-dd-yy'
});

function buatPDF() {
    tgl = $('#tgl_report').val();
    shift = $('#shift_report').val();
    line = $('#line_report').val();
    komp = $('#komp_report').val();
    window.open(baseurl+'MonitoringCBO/C_MonitoringCBO/buatPDF/'+tgl+'/'+shift+'/'+line+'/'+komp, '_blank');
}

// $('#komp_cbo').select2({
//     ajax:{
//     type:'POST',
//     dataType:'json',
//     data:function(params){
//     var queryParameters={   
//     term:params.term
//     }
//     return queryParameters;
//     },
//     url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2Induk',
//     processResults:function(data){
//     return {    
//     results: $.map(data, function(obj) {
//     return { id:obj.id, text:obj.induk};
//     })
//     }
//     }
//     }
//     });

function getCBOGrafik() {
    var tanggal1 = $('#tanggal_awal').val();
    var tanggal2 = $('#tanggal_akhir').val();
    var shift = $('#shift_cbo').val();
    var line = $('#line_cbo').val();
    var komponen = $('#komp_cbo').val();
    $.ajax({
        url: baseurl + 'CBOPainting/CBO/getGrafik',
        data: {
            tanggal1: tanggal1,
            tanggal2: tanggal2,
            shift: shift,
            line: line,
            komponen: komponen
        },
        type: 'POST',

    }).done(function(data) {
        var data = JSON.parse(data);
        var array = $.map(data['cbo'], function(value, index) {
            return [value];
        });
        console.log(data);
        console.log(array);
        var value = [];
        var labels = [];
        var belang = [];
        var dlewer = [];
        var kasar_cat = [];
        var kasar_mat = [];
        var kasar_spat = [];
        var kropos = [];
        var lain_lain = [];
        var ok = [];
        var reject = [];
        for (var i = 0; i < 1; i++) {
            for (var n = 0; n < array.length; n++) {
                labels.push(array[n]['tanggal']);
                belang.push(Number(array[n]['belang']));
                dlewer.push(Number(array[n]['dlewer']));
                kasar_cat.push(Number(array[n]['kasar_cat']));
                kasar_mat.push(Number(array[n]['kasar_mat']));
                kasar_spat.push(Number(array[n]['kasar_spat']));
                kropos.push(Number(array[n]['kropos']));
                lain_lain.push(Number(array[n]['lain_lain']));
                ok.push(Number(array[n]['ok']));
                reject.push(Number(array[n]['reject']));
            }
            value.push(belang);
            value.push(dlewer);
            value.push(kasar_cat);
            value.push(kasar_mat);
            value.push(kasar_spat);
            value.push(kropos);
            value.push(lain_lain);
            value.push(ok);
            value.push(reject);
        }
        console.log(labels);
        var color1 = ['rgba(231, 76, 60, 1)', 'rgba(51, 122, 183, 1)', 'rgba(94, 169, 134, 1)', 'rgba(226, 139, 64, 1)', 'rgba(105, 70, 191, 1)', 'rgba(70, 191, 191, 1)', 'rgba(189, 191, 70, 1)', 'rgba(117, 117, 101, 1)', 'rgba(98, 121, 76, 1)'];
        var color2 = ['rgba(231, 76, 60, 1)', 'rgba(51, 122, 183, 1)', 'rgba(94, 169, 134, 1)', 'rgba(226, 139, 64, 1)', 'rgba(105, 70, 191, 1)', 'rgba(70, 191, 191, 1)', 'rgba(189, 191, 70, 1)', 'rgba(117, 117, 101, 1)', 'rgba(98, 121, 76, 1)'];
        var nama    = ['belang', 'dlewer', 'kasar cat', 'kasar mat', 'kasar spat', 'kropos', 'lain lain', 'ok', 'reject'];
        chartCBOGrafik(labels, value, color1, color2, nama);
    });
}

function chartCBOGrafik(labels, value, color, color2, label) {
    var ctx = document.getElementById('grafik_cbo');
    var chartMF = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: []
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        fontWeight: "bold",
                        labelString: "DATE"
                    },
                    gridLines: {
                        display: false,
                        color: "#c6c6c6"
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 100,
                        fontSize: 14,
                        fontColor: "black",
                        fontWeight: "bold"
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "QTY"
                    },
                    display: true,
                    gridLines: {
                        color: "#c6c6c6"
                    }
                }]
            },
            maintainAspectRatio: false,
        }
    });
    Chart.defaults.global.defaultFontColor = '#000';
    var count = label.length;
    console.log(count);
    for (var i = 0; i < count; i++) {
        chartMF.data.datasets.push({
            borderWidth: 2,
            fill: false,
            label: label[i],
            backgroundColor: color[i],
            borderColor: color2[i],
            data: []
        });
        for (var j = 0; j < value[i].length; j++) {
            chartMF.data.datasets[i].data.push(value[i][j]);
        }
        chartMF.update();
    }
    $('canvas#' + canvasid).height("400px");
}