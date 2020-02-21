var no = 1;
var id = 1;

$(document).ready(function(){
	$(".loader").fadeOut();
});
let jenisPm = $("#jenisapahayo").val();
$(document).ready(function(){
	if (jenisPm == 'punyapembelian') {

    $('.select2Pembelian').select2({
      // minimumInputLength: 3,
      placeholder: "Choose Option",
      allowClear: true,
      width: '100%',
      tags: true,
      ajax: {
        url: baseurl + "MonitoringPembelian/Monitoring/getCodeItem",
        dataType: "JSON",
        type: "POST",
        data: function(params) {
          return {
            term: params.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(obj) {
              return {
                id: obj.UPDATE_ID,
                text: obj.UPDATE_ID
              };
            })
          };
        }
      }
    });


    var tableqwe = $('.tblHistoryPembelian').DataTable({
      initComplete: function() {},
      processing: true,
      serverSide: true,
      "order": [],
      "ajax": {
        url: baseurl + 'MonitoringPembelian/Monitoring/getAjaxPembelian',
        type: "POST",
      },
      columnDefs: [{
        targets: "_all",
        orderable: false
      }],
    })

    $('#filterStatus0').change(function() {
      tableqwe.search($(this).val()).draw();
    })
    $('.select2Pembelian').change(function() {

      if ($(this).val() == null) {
        var final = ''
      } else {
        var final = $(this).val()
      }
      tableqwe.search(final).draw();
    })

  } else if (jenisPm == 'punyapembelianPE') {

    $('.select2PembelianPE').select2({
      // minimumInputLength: 3,
      placeholder: "Choose Option",
      allowClear: true,
      width: '100%',
      tags: true,
      ajax: {
        url: baseurl + "MonitoringPembelian/Monitoring/getCodeItem",
        dataType: "JSON",
        type: "POST",
        data: function(params) {
          return {
            term: params.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(obj) {
              return {
                id: obj.UPDATE_ID,
                text: obj.UPDATE_ID
              };
            })
          };
        }
      }
    });

    var tableqwe = $('#tblHistoryRequest').DataTable({
      processing: true,
      serverSide: true,
      "order": [],
      "ajax": {
        url: baseurl + 'MonitoringPembelian/HistoryRequest/getAjaxPembelianHistory',
        type: "POST",
      },
      columnDefs: [{
        targets: "_all",
        orderable: false
      }],
    })

    $('#filterStatus0').change(function() {
      tableqwe.search($(this).val()).draw();
    })
    $('.select2PembelianPE').change(function() {

      if ($(this).val() == null) {
        var final = ''
      } else {
        var final = $(this).val()
      }
      tableqwe.search(final).draw();
    })

  } else {
    console.log('none');
  }
})

$('#filterStatus').on('change', function() {
  var stat = $('#filterStatus').val();
  $('.tblHistoryPembelian2').DataTable({
    processing: true,
    serverSide: true,
    "order": [],
    "ajax": {
      url: baseurl + 'MonitoringPembelian/Monitoring/getAjaxPembelianfilter2',
      type: "POST",
      data: {
        status: stat,
      }
    },
    columnDefs: [{
      targets: "_all",
      orderable: false
    }],
  });
});
$(document).ready(function(){
    $("#submitPE").attr("disabled", "disabled");
    $("#EmailPembelian").change(function(){
        $("#submitPE").removeAttr("disabled");
    });
});
$(document).ready(function(){
    $("#submitPembelian").attr("disabled", "disabled");
    $("#EmailPE").change(function(){
        $("#submitPembelian").removeAttr("disabled");
    });
});

$(document).ready( function() {
	$(".saveall").hide();
});

// $(document).ready( function () {
//     $('#tblHistoryPembelian').DataTable(  {
//     	columnDefs: [
//     		{ targets: '_all', orderable: false}
//     	],
//         initComplete: function () {
//                	this.api().columns([19]).every( function () {
//                 var column = this;
//                 var select = $('<select style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
//                     .appendTo("#filter")
//                     .on( 'change', function () {
//                         var val = $.fn.dataTable.util.escapeRegex(
//                             $(this).val()
//                         ); 
//                         column
//                             .search( val ? '^'+val+'$' : '', true, false )
//                             .draw();
//                     } );
//                  	column.data().unique().sort().each( function ( d, j ) {
//                     select.append( '<option value="'+d+'">'+d+'</option>' )
//                 	} );
//             	} );
//             	this.api().columns([2]).every( function () {
// 	                var column1 = this;
// 	                var select1 = $('<select id="nodok" name="nodok" class="nodok" style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
// 	                    .appendTo("#filterid")
// 	                    .on( 'change', function () {
// 	                        var val1 = $.fn.dataTable.util.escapeRegex(
// 	                            $(this).val()
// 	                        ); 
// 	                        column1
// 	                            .search( val1 ? '^'+val1+'$' : '', true, false )
// 	                            .draw();
// 	                    } );
// 	                	column1.data().unique().sort().each( function ( d, j ) {
// 	                    select1.append( '<option value="'+d+'">'+d+'</option>' )
// 	                } );
//             	} );


//         }
//     });

// } );

// $(document).ready(function() {
//     $('#tblHistoryRequest').DataTable( {
//     	columnDefs: [
//     		{ targets: '_all', orderable: false}
//     	],
//         initComplete: function () {
//             	this.api().columns([18]).every( function () {
//                 var column = this;
//                 var select = $('<select style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
//                     .appendTo("#filter")
//                     .on( 'change', function () {
//                         var val = $.fn.dataTable.util.escapeRegex(
//                             $(this).val()
//                         );
 
//                         column
//                             .search( val ? '^'+val+'$' : '', true, false )
//                             .draw();
//                     } );
 
//                 	column.data().unique().sort().each( function ( d, j ) {
//                     select.append( '<option value="'+d+'">'+d+'</option>' )
//                 	} );
//             	} );
//             	this.api().columns([1]).every( function () {
// 	                var column1 = this;
// 	                var select1 = $('<select style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
// 	                    .appendTo("#filterid")
// 	                    .on( 'change', function () {
// 	                        var val1 = $.fn.dataTable.util.escapeRegex(
// 	                            $(this).val()
// 	                        ); 
// 	                        column1
// 	                            .search( val1 ? '^'+val1+'$' : '', true, false )
// 	                            .draw();
// 	                    } );
// 	                	column1.data().unique().sort().each( function ( d, j ) {
// 	                    select1.append( '<option value="'+d+'">'+d+'</option>' )
// 	                } );
//             	} );
//         }
//     } );
// } );

$(document).ready( function () {
    $('#tblMonitoringPembelianPE').DataTable({
    	columnDefs: [
    		{ targets: '_all', orderable: false}
    	], 
    	initComplete: function () {
    			this.api().columns([1]).every( function () {
	                var column1 = this;
	                var select1 = $('<select style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
	                    .appendTo("#filterid")
	                    .on( 'change', function () {
	                        var val1 = $.fn.dataTable.util.escapeRegex(
	                            $(this).val()
	                        ); 
	                        column1
	                            .search( val1 ? '^'+val1+'$' : '', true, false )
	                            .draw();
	                    } );
	                	column1.data().unique().sort().each( function ( d, j ) {
	                    select1.append( '<option value="'+d+'">'+d+'</option>' )
	                } );
            	} );
               	
         }
    });
} );


$(document).ready(function(){
	$("#search").select2({
		allowClear: false,
		placeholder: "Kode Item atau Description",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"MonitoringPembelian/EditData/suggestions",
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
					results: $.map(data, function(obj) {
						return { id:obj.SEGMENT1, text:obj.SEGMENT1+" - "+obj.DESCRIPTION};
					})
				};
			}
		}
	});
});

// $('.pro-time').on('change',function(){
// 	var preProc = Number($('#preProc').val()); 
// 	// console.log(preProc);
//     var postProc = Number($('#postProc').val());
//     // console.log(postProc);
//     var preparation = Number($('#preparation').val()); 
//     // console.log(preparation);
//     var delivery = Number($('#delivery').val());
//     console.log(delivery);
//     var totProc1 = (preparation*100 + delivery*100)/100;
//     // var totProc = (parseFloat(totProc1) + 0.01).toFixed(2);
//   	var totProc = parseFloat(totProc1.toPrecision(2));
//     console.log(totProc);

//     $('#totProc').val(totProc);

//     var hasil1 = (preProc*100 + totProc*100 + postProc*100)/100;
//     // var hasil = hasil1.toFixed(2);
//     var hasil = Math.round(hasil1 * 100)/100;

//     // var hasil = parseFloat(hasil.toPrecision(2));
//     console.log(hasil);
//     $('#totLead').val(hasil);
// });

function tambahJadi(th){	
	var preProc = parseFloat($(th).closest('tr').find('input.preProc').val());
	var ppo = parseFloat($(th).closest('tr').find('input.ppo').val());
	var deliver = parseFloat($(th).closest('tr').find('input.deliver').val());
	var totProc = parseFloat($(th).closest('tr').find('input.totProc').val());
	var postProc = parseFloat($(th).closest('tr').find('input.postProc').val());
	var totLead = parseFloat($(th).closest('tr').find('input.totLead').val());
	// alert('iki')

	var hasilnya = (ppo + deliver);
	var hasil1 = (parseFloat(hasilnya)).toFixed(2);
	$(th).closest('tr').find('input.totProc').val(hasil1); // totProc

	var hasiltu = (preProc +  ppo + deliver + postProc);
	var hasil2 = (parseFloat(hasiltu)).toFixed(2);
	$(th).closest('tr').find('input.totLead').val(hasil2); // totLead	

	console.log(hasil1);
	console.log(hasil2);
}

function changeBackground(th){
	if( $(th).val()  == "REJECTED"){
		$(".stat").css({"background-color": "#ff4a4a"});
	} else if ($(th).val()  == "APPROVED"){
		$(".stat").css({"background-color": "#6bff4a"});	
	} else {
		$(".stat").css({"background-color": "#ffc313"});
	}
}


$(document).ready(function(){
    $('.stat').on('change', function() {
      $(".SettingEmailPembelian").hide();
    });
});

$(document).ready(function(){
	$("#submitPDF").hide();
    $('#filterid').on('change', function() {
      $("#submitPDF").show();
    });
});

$("#search").change(function () {
  	 $.ajax({
        url:baseurl+'MonitoringPembelian/EditData/getItemDetail',
        dataType:'json',
        type:'POST',
        data:{params: $(this).val() },
        success:function(result){
            console.log(result);
            var html = '';
            $.each(result,function(i,data){
            	 if(data.SECONDARY_UOM_CODE == null) { data.SECONDARY_UOM_CODE = '';}
            	 if(data.PRIMARY_UOM_CODE == null) { data.PRIMARY_UOM_CODE = '';}
            	 	var today = new Date();
					var dd = today.getDate();
					var mmm = today.getMonth() + 1; //January is 0!
					var yyyy = today.getFullYear();

					if (dd < 10) {
					  dd = '0' + dd;
					}

					if (mmm  == 1) {
					  mmm = 'JAN';
					} else if (mmm == 2) {
						mmm = 'FEB';
					} else if (mmm == 3) {
						mmm = 'MAR';
					}else if (mmm == 4) {
						mmm = 'APR';
					}else if (mmm == 5) {
						mmm = 'MAY';
					}else if (mmm == 6) {
						mmm = 'JUN';
					}else if (mmm == 7) {
						mmm = 'JUL';
					}else if (mmm == 8) {
						mmm = 'AUG';
					}else if (mmm == 9) {
						mmm = 'SEP';
					}else if (mmm == 10) {
						mmm = 'OCT';
					}else if (mmm == 11) {
						mmm = 'NOV';
					}else if (mmm == 12) {
						mmm = 'DEC';
					}

					today = dd + '-' + mmm + '-' + yyyy;
                html +=  '<tr row-id="'+ (id++) +'">'+
							'<td>'+ (no++) +'</td>'+
							'<input type="hidden" name="date[]" id="date" value="'+ today +'">'+
							'<input type="hidden" name="stat[]" id="stat" value="UNAPPROVED">'+
							'<input type="hidden" name="textId" value="<?php echo $regen ?>">'+
							'<td><input type="hidden" name="itemCode[]" id="itemCode" value="'+ data.SEGMENT1 +'">'+ data.SEGMENT1 +'</td>'+
							'<td><input type="hidden" name="desc[]" id="description" value="'+ data.DESCRIPTION +'">'+ data.DESCRIPTION +'</td>'+
							'<td><input type="hidden" name="uom1[]" id="uom1" value="'+ data.PRIMARY_UOM_CODE +'">'+ data.PRIMARY_UOM_CODE +'</td>'+
							'<td><input type="hidden" name="uom2[]" id="uom2" value="'+ data.SECONDARY_UOM_CODE +'">'+ data.SECONDARY_UOM_CODE +'</td>'+
							'<td><select style="background-color: bisque;" name="per1[]" id="per1"><option selected="selected">'+ data.FULL_NAME +'</option>'+data.buyer +'</select></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext preProc" name="preProc[]" id="preProc" value="'+ data.PREPROCESSING_LEAD_TIME +'" onchange="tambahJadi(this)" ></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext ppo" name="ppo[]" id="ppo" value="'+ data.ATTRIBUTE6 +'" onchange="tambahJadi(this)"></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext deliver" name="deliver[]" id="deliver" value="'+ data.ATTRIBUTE8 +'" onchange="tambahJadi(this)"></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="border: transparent; background-color: transparent;" class="form-control-plaintext totProc" name="totProc[]" id="totProc" value="'+ data.FULL_LEAD_TIME +'" readonly></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext postProc" name="postProc[]" id="postProc" value="'+ data.POSTPROCESSING_LEAD_TIME +'" onchange="tambahJadi(this)"></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="border: transparent; background-color: transparent;" class="form-control-plaintext totLead" name="totLead[]" id="totLead" value="'+ data.TOTAL_LEADTIME +'" readonly></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext" name="moq[]" id="moq" value="'+ data.MINIMUM_ORDER_QUANTITY +'"></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext" name="flm[]" id="flm" value="'+ data.FIXED_LOT_MULTIPLIER +'" ></td>'+
							'<td><select style="background-color: bisque;" name="attr18[]" id="attr18">'+ data.select +'</select></td>'+
							'<td><input type="text" style="background-color: bisque;" class="form-control-plaintext" name="keterangan[]" id="keterangan"></td>'+
							'<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext receive_close_tolerance" name="receive_close_tolerance[]" id="receive_close_tolerance" value="' + data.RECEIVE_CLOSE_TOLERANCE + '" ></td>' +
          '<td><input type="number"  step="0.01" title="Input dengan 2 angka dibelakang koma" style="background-color: bisque;" class="form-control-plaintext qty_rcv_tolerance" name="qty_rcv_tolerance[]" id="qty_rcv_tolerance" value="' + data.QTY_RCV_TOLERANCE + '" ></td>' +
          '<td><center><button type="button" onclick="deleteRowThisHehe(this)" class="btn btn-danger btn-xs hapus'+id+'" title="Delete" >'+
							'<span class="icon-trash"> Delete</span>'
							'</button></center></td>'+
						'</tr>';
            });
            console.log(html);
            $("#body-file").append(html);
            $(".import").hide();
            $(".saveall").show();
        },
        error:function(error,status){
            console.log(error);
        }
    });
});


function deleteRowThisHehe(th){
	$(th).parents("tr").remove();
}

$("#ApprAll").click(function () {
		
	$(".stat").val("APPROVED");

});

$("#RejAll").click(function () {
		
	$(".stat").val("REJECTED");

});