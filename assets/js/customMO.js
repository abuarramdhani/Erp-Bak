
$(document).ready(function() {
	
	$('#txtTags').focus();
	var screen = window.innerWidth;
    if ( screen <= 1250) {
		$(".txtNameMember").css('display','none');
		// $(".divSideMenu").removeAttr('class','col-md-3');
		// $(".divSideMenu").Attr('class','col-md-2');
	} else {
		// $(".divSideMenu").removeAttr('class','col-md-2');
		// $(".divSideMenu").Attr('class','col-md-3');
        $(".txtNameMember").css('display','block');
    }
	
	//DATATABLES !!!!!!!!!!!!!!!
	$('#tableorder-job').DataTable({
	   "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": true,
			  "scrollX": true,
			  "deferRender" : true,
			  "scroller": true,
			  "info": true,
			  "autoWidth": true,
			  "ajax": baseurl+'ManagementOrder/Order_In/PlottingTable/1',
			  "columnDefs": [
								{ width: "5%", className: "text-center", "targets": [ 0 ] },
								{ width: "10%", className: "text-center", "targets": [ 1 ] },
								{ width: "30%", "targets": [ 2 ] },
								{ width: "16%", className: "text-center", "targets": [ 3 ] },
								{ width: "17%", className: "text-center", "targets": [ 4 ] },
								{ width: "17%", className: "text-center", "targets": [ 5 ] }
							]
	});
	
	$('#table-class').DataTable({"lengthChange": false,"searching": false,"info": false});
	$('#table-class-group').DataTable({"lengthChange": false,"searching": false,"info": false});
	$('#table-schedule').DataTable({"lengthChange": false,"searching": true,"info": false});
		
	//SELECT2
	$(".select2-member").select2({
		allowClear: true,
		placeholder: "[Select Agent]",
		minimumInputLength: 0,
		minimumResultsForSearch: -1,
		ajax: {		
				url: baseurl+"ManagementOrder/Member/getMember",
				dataType: 'json',
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.staff_id, text:obj.firstname};
						})
					};
				}
			}
	});
	
	$(".select-classification").select2({
		allowClear: true,
		placeholder: "[Select Classification Project]",
		minimumInputLength: 0,
		minimumResultsForSearch: -1
	});
	
	$(".select-project").select2({
		allowClear: true,
		placeholder: "[Select Project]",
		tags : true,
		minimumInputLength: 0,
		ajax: {		
				url: baseurl+"ManagementOrder/Scheduler/getTicket",
				dataType: 'json',
				type: "POST",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.number, text:obj.subject};
						})
					};
				}
			}
	});
	
	$(".select2-classification").select2({
		allowClear: true,
		placeholder: "[ Select Classification ]",
		minimumInputLength: 0
	});
	
	
	// NOTIFICATION START
	// setInterval(function(){ 
		// $.ajax({
			// url :baseUrl+"/erp_mo/ManagementOrder/Order_In/checkDueDate",
			// success:function(result){ 
				// var partsOfStr = result.split('/');
				// var part = partsOfStr.slice(0, -1);
				// var row = part.length;
				// for(i=0;i<row;i++){
					// if (Notification.permission === "granted") {
						// var options = {
							  // icon: '/assets/img/logo/ERP.png',
						  // }
						// var notification = new Notification(part[i],options);
				  // }
				// }
			// }
		// });
	// }, 100000);
	// NOTIFICATION END
	
});
	


 window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Percentage Kaizen IT.PROD SQUAD"
      },
      animationEnabled: true,
      legend: {
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
          }
          else {
              e.dataSeries.visible = true;
          }
          chart.render();
        }
      },
      axisY: {
       title: "Record Kaizen"
      },
      toolTip: {
        shared: true,  
        content: function(e){
          var str = '';
          var total = 0 ;
          var str3;
          var str2 ;
          for (var i = 0; i < e.entries.length; i++){
            var  str1 = "<span style= 'color:"+e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ; 
            total = e.entries[i].dataPoint.y + total;
            str = str.concat(str1);
          }
          str2 = "<span style = 'color:DodgerBlue; '><strong>"+e.entries[0].dataPoint.label + "</strong></span><br/>";
          str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";
          
          return (str2.concat(str)).concat(str3);
        }

      },
       data: [
      {        
        type: "bar",
        showInLegend: true,
        name: "Approve",
        color: "gold",
        dataPoints: [
			{ y: 0, label: "Gilardi"},
			{ y: 0, label: "Paulus"},
			{ y: 1, label: "Alfian"},        
			{ y: 0, label: "Junawi"},        
			{ y: 0, label: "Rezaldi"},        
			{ y: 0, label: "Firman"},        
			{ y: 1, label: "Brian"},        
			{ y: 0, label: "Godeliva"},        
			{ y: 1, label: "Adnan"}   
        ]
      },
      {        
        type: "bar",
        showInLegend: true,
        name: "Waiting Approval",
        color: "silver",          
        dataPoints: [
			{ y: 1, label: "Gilardi"},
			{ y: 1, label: "Paulus"},
			{ y: 2, label: "Alfian"},        
			{ y: 0, label: "Junawi"},        
			{ y: 1, label: "Rezaldi"},        
			{ y: 0, label: "Firman"},        
			{ y: 1, label: "Brian"},        
			{ y: 1, label: "Godeliva"},        
			{ y: 1, label: "Adnan"}        
        ]
      }

      ]
    });

chart.render();
}

/***************************
	MODIFICATION TAGS
****************************/
function removeTag(base,id){
	$.ajax({
			type:'POST',
			data:{tag: id},
			url :base+"/ManagementOrder/Setting/removeTag",
			success:function(result){
				$('#table-taging tbody').html(result);
			}
		});
}

function editTag(tag,id,url){
	$('#txtTags').val(tag).focus();
	$('#txtId').val(id);
}

$(document).on("keyup", ".field-tag", function () {
	$('#field_tag').addClass('has-error');
	if(event.keyCode == 13){
		var tag = $('#txtTags').val();
		var id = $('#txtId').val();
		if(id.length == 0 && tag.length != 0){
			$.ajax({
				type:'POST',
				data:{tag: tag},
				url :baseurl+"ManagementOrder/Setting/saveTag",
				success:function(result){
					$('#table-taging tbody').html(result);
					$('#field_tag').removeClass('has-error');
					$('#txtTags').val('');
				}
			});
		}else{
			$.ajax({
				type:'POST',
				data:{tag:tag,id:id},
				url :baseurl+"ManagementOrder/Setting/updateTag",
				success:function(result){
					$('#txtTags').val('');
					$('#txtId').val('');
					$('#table-taging tbody').html(result);
					$('#field_tag').removeClass('has-error');
				}
			});
		}
	}else if(event.keyCode == 27){
		$('#txtTags').val('');
		$('#txtId').val('');
		$('#field_tag').removeClass('has-error');
	}
});

/***************************
	MODOFICATION CLASS
****************************/

function removeClass(base,id){
	$.ajax({
			type:'POST',
			data:{class_: id},
			url :base+"/ManagementOrder/Setting/removeClass",
			success:function(result){
				$('#table-class tbody').html(result);
			}
		});
}

function editClass(class_,id,url){
	$('#txtClass').val(class_).focus();
	$('#txtId').val(id);
}

$(document).on("keyup", ".field-class", function () {
	$('#field_class').addClass('has-error');
	if(event.keyCode == 13){
		var class_ = $('#txtClass').val();
		var id = $('#txtId').val();
		if(id.length == 0 && class_.length!=0){
			$.ajax({
				type:'POST',
				data:{class_: class_},
				url :baseurl+"ManagementOrder/Setting/saveClass",
				success:function(result){
					$('#table-class tbody').html(result);
					$('#field_class').removeClass('has-error');
					$('#txtClass').val('');
				}
			});
		}else{
			$.ajax({
				type:'POST',
				data:{class_:class_,id:id},
				url :baseurl+"ManagementOrder/Setting/updateClass",
				success:function(result){
					$('#txtClass').val('');
					$('#txtId').val('');
					$('#table-class tbody').html(result);
					$('#field_class').removeClass('has-error');
				}
			});
		}
	}else if(event.keyCode == 27){
		$('#txtClass').val('');
		$('#txtId').val('');
		$('#field_class').removeClass('has-error');
	}
});


//+++++++++++++++++++++++

	//: FUNCTION TAB :\\

//+++++++++++++++++++++++

$(document).on("click", ".js-panel", function () {

	var str = $(this).attr('id');
	var num = str.slice(-1);
	 $('#tableorder-job').DataTable().destroy();
	 $('#tableorder-job').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": true,
			  "scrollX": true,
			  "deferRender" : true,
			  "scroller": true,
			  "info": true,
			  "autoWidth": true,
			  "ajax": baseurl+'ManagementOrder/Order_In/PlottingTable/'+num+'',
			  "columnDefs": [
								{ width: "5%", className: "text-center", "targets": [ 0 ] },
								{ width: "8%", className: "text-center", "targets": [ 1 ] },
								{ width: "30%", "targets": [ 2 ] },
								{ width: "16%", className: "text-center", "targets": [ 3 ] },
								{ width: "17%", className: "text-center", "targets": [ 4 ] },
								{ width: "17%", className: "text-center", "targets": [ 5 ] }
							],
			"rowCallback": function( row, data, index ) {
				  var plot = data[4],
					  $node = this.api().row(row).nodes().to$();
					  
			  },
			"initComplete": function(settings, json) {
				$(".select-tags").select2({
						allowClear: true,
						minimumInputLength: 0,
						minimumResultsForSearch: -1
					});
			  }			  
        });
	$('body').on('focus',".duedate", function(){
		$(this).datepicker({
			autoclose: true,
		});
	});
});


//+++++++++++++++++++++++

	//: FUNCTION TODO :\\

//+++++++++++++++++++++++

$(document).on("keyup", ".field-todo", function () {
	var str   = $(this).attr("id"),
		id = str.substring(7, 9);
	$('#field_todo'+id+'').addClass('has-error');
	if(event.keyCode == 13){
		var ticket = $(this).attr("data-id");
		var todo   = $(this).val();
		$.ajax({
					type:'POST',
					data:{todo: todo,ticket: ticket},
					url : baseurl+"ManagementOrder/Order_In/saveTodo",
					success:function(result)
					{
					  // alert(todo);
					}
				  });
		$('#field_todo'+id+'').addClass('has-success');
		$('#field_todo'+id+'').removeClass('has-error');
		if(!todo){
			$('#txtDueDate'+id+'').prop('readonly', true);
			$('#txtDueDate'+id+'').removeClass('duedate');
			
		}else{
			$('#txtDueDate'+id+'').removeAttr('readonly');
			$('#txtDueDate'+id+'').addClass('duedate');
		}
		
	}
});

//+++++++++++++++++++++++

	//: FUNCTION ADD TAGING ORDER :\\

//+++++++++++++++++++++++

$(document).on("change", ".field-tags", function () {
	var str	= $(this).attr("id");
	var id	= str.substring(7, 9);
	var ticket = $(this).attr("data-id-index");
	var tags   = $(this).val();
		$.post(baseurl+"ManagementOrder/Order_In/CountTags", {ticket:ticket}, function(data){
			if(tags == null){
				$.ajax({
					type:'POST',
					data:{tags: null,ticket: ticket},
					url : baseurl+"ManagementOrder/Order_In/deleteTags"
				  });
			}else if(data > tags.length){
				$.ajax({
					type:'POST',
					data:{tags: tags,ticket: ticket},
					url : baseurl+"ManagementOrder/Order_In/deleteTags"
				  });
			}else{
				$.ajax({
					type:'POST',
					data:{tags: tags,ticket: ticket},
					url : baseurl+"ManagementOrder/Order_In/saveTags"
				  });
			}				
		});
});

//+++++++++++++++++++++++

	//: FUNCTION DELETE PLOTTING :\\

//+++++++++++++++++++++++

$(document).on("click", ".field-remove", function () {

	var ticket = $(this).attr("data-id");
	var r = confirm("Serius nih mau di hapus ?");
		if (r == true) {
			$.ajax({
				type:'POST',
				data:{ticket: ticket},
				url: baseurl+"ManagementOrder/Order_In/removePlotting",
				success:function(result)
				{
				  // alert(result);
				  // location.reload();
				}
			  });
		}
});

//+++++++++++++++++++++++

	//: FUNCTION SAVE CLAIM :\\

//+++++++++++++++++++++++

$(document).on("change", ".field-save", function () {

	var subject = $(this).attr("data-id");
	var ticket = $(this).attr("data-id-index");
	var member  = $('option:selected', this).attr('value');
		$.ajax({
			type:'POST',
			data:{member: member,ticket: ticket,subject:subject},
			url: baseurl+"ManagementOrder/Order_In/saveClaim",
			success:function(result)
			{
			  $('#plotting'+id+'').addClass('has-success');
			}
		  });
});

$(document).on("change", ".duedate", function () {

	var str   = $(this).attr("id");
	var id = str.substring(10, 12);
	var ticket = $(this).attr("data-id");
	var duedate  = $(this).val();
		$.ajax({
			type:'POST',
			data:{ticket: ticket,duedate: duedate},
			url: baseurl+"ManagementOrder/Order_In/duedateTodo",
			success:function(result)
			{
			  // $('#duedate'+id+'').addClass('has-success');
			}
		  });
});

function saveTodoModal(url){
	if(event.keyCode == 13){
		var ticket = $('#txtNoTicket').val();
		var todo = $('#txtComment').val();
		$.ajax({
			type:'POST',
			data:{todo: todo,ticket: ticket},
			url: url+"/ManagementOrder/Order_In/saveTodo",
			success:function(result)
			{
			  // alert(result);
			  $('#modalChat').modal('hide');
			}
		  });
	}
}

function savePriority(i,url,ticket){
	$('#field_priority'+i+'').addClass('has-error');
	if(event.keyCode == 13){
		var prior = $('#txtPriority'+i+'').val();
		$.ajax({
				type:'POST',
				data:{prior: prior,ticket: ticket},
				url: url+"/ManagementOrder/Order_In/setPriority",
				success:function(result)
				{
				  // alert(result);
				}
			  });
		$('#field_priority'+i+'').addClass('has-success');
		$('#field_priority'+i+'').removeClass('has-error');
	}
}

// function showName(i){
	 // $("#countJOb"+i+"").slideDown("fast");
// }

// function hideName(i){
	 // $("#countJOb"+i+"").slideUp("fast");
// }



// $(document).on("click", "#txsMember", function () {
		 // var member = $('#txsMember').attr("data-id");
		 // var host	= window.location.origin;
		 // $.ajax({url: host+"/it_prod/Plotting/ExistTicket/"+id+""});
		 // $('#tableorder-member').DataTable().destroy();
		 // $('#tableorder-member').DataTable({
			  // "paging": true,
			  // "lengthChange": false,
			  // "searching": false,
			  // "ordering": false,
			  // "info": true,
			  // "autoWidth": true,
			  // "ajax": host+'/it_prod/Plotting/AjaxPlotting/'+member+'',
			  // "columnDefs": [
								// { "orderable": false, width: "5%", className: "text-center", "targets": [ 0 ] },
							// { width: "5%", className: "text-center", "targets": [ 1 ] },
							// { width: "45%", "targets": [ 2 ] },
							// { width: "25%", className: "text-center", "targets": [ 3 ] },
							// { width: "5%", className: "text-center", "targets": [ 4 ] },
							// { width: "10%", className: "text-center", "targets": [ 5 ] },
							// { width: "5%", className: "text-center", "targets": [ 6 ] }
							// ]
        // });
		// $.post(host+'/it_prod/Plotting/CountJob', {member:member}, function(data){
			// $("#QtyTicket").val(data);	
		// });
	// });

function loadOrder(id,nama){
	 $.ajax({url: baseurl+"ManagementOrder/Order_In/ExistTicket/"+id+""});
	 $('#tableorder-member').DataTable().destroy();
	 $('#tableorder-member').DataTable({
		  "paging": true,
		  "lengthChange": false,
		  "searching": false,
		  "ordering": false,
		  "info": true,
		  "autoWidth": false,
		  "ajax": baseurl+'ManagementOrder/Member/AjaxPlotting/'+id+'',
		  "columnDefs": [
							{ "orderable": false, width: "5%", className: "text-center", "targets": [ 0 ] },
							{ width: "5%", className: "text-center", "targets": [ 1 ] },
							{ width: "45%", "targets ": [ 2 ] },
							{ width: "5%", className: "text-center", "targets": [ 3 ] },
							{ width: "25%", className: "text-center", "targets": [ 4 ] }
							
						]
	});
	$.post(baseurl+'ManagementOrder/Order_In/CountJob', {member:id}, function(data){
		$("#countJOb"+id+"").html("<strong><span style='color:green;'>( "+data+" )</span></strong>");
	});
	$('span#tgtMember').html(nama);
	$('#txtfrom').val(id);
	$('body').on('focus',".duedate", function(){
		$(this).datepicker({
			autoclose: true,
		});
	});
}

function showModal(){
	$('#modalChat').modal();
	var id = $('#showModal').data("id");
	$('#txtNoTicket').val(id);
	$('#txtComment').val("");
}

$(document).on("click", "#showModal", function () {
	$('#modalChange').modal();
	var id = $(this).attr("data-id");
	$('#txtNoTicket1').val(id);
});

function changePlotting(url){
	alert(url+"/ManagementOrder/Order_In/changePlotting");
	var ticket = $('#txtNoTicket1').val();
	var id = $('#txtfrom').val();								// member asal
	var member = $('#txsClaim option:selected').attr('value');	// member tujuan
	$.ajax({
			type:'POST',
			data:{id:id, ticket: ticket,member: member},
			url: url+"/ManagementOrder/Order_In/changePlotting",
			success:function(result)
			{
				  $('#modalChange').modal('hide');
				  $('#tableorder-member').DataTable().destroy();
				  $('#tableorder-member').DataTable({
					  "paging": true,
					  "lengthChange": false,
					  "searching": false,
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "ajax": url+'ManagementOrder/Member/AjaxPlotting/'+id+'',
					  "columnDefs": [
										{ "orderable": false, width: "5%", className: "text-center", "targets": [ 0 ] },
										{ width: "5%", className: "text-center", "targets": [ 1 ] },
										{ width: "45%", "targets ": [ 2 ] },
										{ width: "15%", className: "text-center", "targets": [ 3 ] },
										{ width: "15%", className: "text-center", "targets": [ 4 ] }
										
									]
				 });
				 $.post(url+'ManagementOrder/Order_In/CountJob', {member:id}, function(data){
						$("#countJOb"+id+"").html("<strong><span style='color:green;'>( "+data+" )</span></strong>");
					});
			}
		  });
}

function refresh(){
	$.post(url+'ManagementOrder/Order_In/CountJob', {member:id}, function(data){
		$("#countJOb"+id+"").html("<strong><span style='color:green;'>( "+data+" )</span></strong>");
	});
	$.post(url+'ManagementOrder/Order_In/CountJob', {member:member}, function(data){
		$("#countJOb"+member+"").html("<strong><span style='color:green;'>( "+data+" )</span></strong>");
	});
}

function addRowMenuManagement(base){
	var newgroup = $('<tr>').addClass('clone');
	var e = jQuery.Event( "click" );
	e.preventDefault();
	$("select#slcMenu:last").select2("destroy");
	
	$('.clone').last().clone().appendTo(newgroup).appendTo('#tblMenuGroup');

	$("select#slcMenu").select2({
		placeholder: "",
			allowClear : true,
	});
	
	$("select#slcMenu:last").select2({
		placeholder: "",
			allowClear : true,
	});
	
	$("select#slcMenu:last").val("").change();
	$("input#txtMenuSequence:last").val("");
	$("input#txtMenuPrompt:last").val("");
	$("input#hdnMenuGroupListId:last").val("");
}

function deleteRowManagement(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var i = rowCount-1;
		var lineID = $('#'+tableID+' tbody tr input.id').eq(rowCount-2).val();
		//alert(n);
		if(rowCount > 2){
			if(lineID > 0){
				alert('Baris sudah tersimpan tidak bisa dihapus');
			}else{
				table.deleteRow(i);
			}
		}else{
			alert('Minimal harus ada satu baris tersisa');
		}
	}catch(e) {
		alert(e);
	}
}

function changeClassificationProject(base){
	var cl = $('#txtClassification').val();
	$.ajax({
		url : base+"ManagementOrder/Scheduler/ChooseClassificationFormat",
		type : "POST",
		data : {id:cl},
		success : function(result){
			$('#table_add_classification tbody').html(result);
		}
	});
}





