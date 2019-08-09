function getMLPB(th) {
    $(document).ready(function(){
    var noLpAw = $('input[name="noLpAw"]').val();
    var noLpAk = $('input[name="noLpAk"]').val();
    var tgAw = $('input[name="tgAw"]').val();
    var tgAk = $('input[name="tgAk"]').val();
    var io = $('.io').val();
    // console.log(noLpAw, noLpAk, tgAw, tgAk, io, 'okas');
    
    var request = $.ajax({
        url: baseurl+'MonitoringLppbPenerimaan/Khusus/search/',
        data: {
            noLpAw : noLpAw,
            noLpAk : noLpAk,
            tgAw : tgAw,
            tgAk : tgAk,
            io : io
        },
        type: "POST",
        datatype: 'html'
    });
    
    
        $('#ResultLppb').html('');
        $('#ResultLppb').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
        
        // if (noLpAw == '' || noLpAk == ''){
        //  console.log("Masih ada yg kosong cuk 1");
        // }
        // else if(tglAw == '' || tglAk == ''){
        //  console.log("Masih ada yg kosong cuk 2");
        // }

        // $('#myModal').on('shown.bs.modal', function () {
        // 	$('#myInput').focus();
        //   })
    request.done(function(result){
        // console.log("sukses2");
        $('#ResultLppb').html(result);
        $('#tbl_khususDt').DataTable({
            // columnDefs: [
            //     { targets: '_all', orderable: false }
            //   ], 
            //   initComplete: function () {
            //       this.api().columns([3]).every( function () {
            //               var column1 = this;
            //               //console.log('sudah dijalankan bos');
            //               var select1 = $('<select class="form-control"><option selected disabled>NO LPPB</option></select>')
            //                   .appendTo("#filterKhusus")
            //                   .on( 'change', function () {
            //                       var val1 = $.fn.dataTable.util.escapeRegex(
            //                           $(this).val()
            //                       ); 
            //                       column1
            //                           .search( val1 ? '^'+val1+'$' : '', true, false )
            //                           .draw();
            //                   } );
            //                 column1.data().unique().sort().each( function ( d, j ) {
            //                   select1.append( '<option value="'+d+'">'+d+'</option>' )
            //               } );
            //           } );
            //     },
                scrollX: true,
                scrollY:  400,
                scrollCollapse: true,
                paging:true,
                info:false,
                fixedColumns: {
                    leftColumns: 2
                }
            });
        })
    });
    
}