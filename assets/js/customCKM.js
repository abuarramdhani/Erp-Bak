let dataRow = [];

 $(document).ready(function () {
    $('#tuanggal').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true
    });
});


$('#tuanggal').change(function(){
	var tuanggal = $('input[name="tuanggal"]').val();
	var deptclass = $('select[name="deptclass"]').val();
	var html = '<option></option>';
	$.ajax({
			url : baseurl+('CetakKanban/Cetak/getShift'),
			type : 'POST',
			data : {
				tuanggal : tuanggal
				},
			datatype : 'json',
			success: function(result) {
				$.each(JSON.parse(result), function(key, value) {
					html += '<option value="'+value.SHIFT_NUM+'">'+value.DESCRIPTION+'</option>';
					$('.inputShiftCKM').removeAttr("disabled");
				});
					$('.inputShiftCKM').html(html);
					$('.inputShiftCKM').val(null).trigger('change');
			}
		});
});

$('.tuanggal').focus(function(){
	$('.btncari').removeAttr("disabled");
})

$("#tuanggal, #shift").change(function(){
	var tuanggal = $('input[name="tuanggal"]').val();
	var shift = $('select[name="shift"]').val();

$('#jobfrom').select2({
			minimumInputLength: 0,
			ajax: {
				url:baseurl+('CetakKanban/Cetak/getJobFrom'),
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						tuanggal : tuanggal,
						shift : shift
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
						return { id:obj.JOB_NUMBER, text:obj.JOB_NUMBER};

						})
					};

				}
			}
		});

$('#jobto').select2({
			minimumInputLength: 0,
			ajax: {
				url:baseurl+('CetakKanban/Cetak/getJobFrom'),
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						tuanggal : tuanggal,
						shift : shift
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
						return { id:obj.JOB_NUMBER, text:obj.JOB_NUMBER};

						})
					};

				}
			}
		});
});


function getCKM(th) {
	$(document).ready(function(){
		var tuanggal 	= $('input[name="tuanggal"]').val();
		var shift 		= $('select[name="shift"]').val();
		var deptclass 	= $('select[name="deptclass"]').val();
		var jobfrom 	= $('select[name="jobfrom"]').val();
		var jobto 		= $('select[name="jobto"]').val();
		var status 		= $('select[name="status"]').val();

		console.log(tuanggal, shift, deptclass, jobfrom, jobto, status);

		var request = $.ajax({
			url: baseurl+'CetakKanban/Cetak/search',
			data: {
				tuanggal : tuanggal,
				shift : shift,
				deptclass : deptclass,
				jobfrom : jobfrom,
				jobto : jobto,
				status : status,
			},
			type: "POST",
			datatype: 'html'
		});
			$('#ResultCKM').html('');
			$('#ResultCKM').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading14.gif"></center>' );

		request.done(function(result){
			// console.log("sukses2");
			$('#ResultCKM').html(result);

				$('#myTable').DataTable({
					scrollX: true,
					scrollY:  400,
					scrollCollapse: true,
					paging:false,
					info:true,
					ordering:false,
				});

			});
		});
}

function getRow(th){
	var checked = $('tr[data="' + th +'"] td.chkCtk input').prop('checked')

	var key = $('tr[data="' + th +'"] td.jobNumber input').val() // for identity
	 var newItem = `
	 		<div class="dataRow_${th}">
	 			<input type="text" name="JOB_NUMBER[]" value="${key}">
	 			<input type="text" name="ITEM_CODE[]" value="${$('tr[data="' + th +'"] td.itemCode input').val()}">
	 			<input type="text" name="DESCRIPTION[]" value="${$('tr[data="' + th +'"] td.desc input').val()}">
	 			<input type="text" name="DEPT_CLASS[]" value="${$('tr[data="' + th +'"] td.deptClass input').val()}">
	 			<input type="text" name="TARGET_PPIC[]" value="${$('tr[data="' + th +'"] td.targetPpic input').val()}">
	 			<input type="text" name="schDate[]" value="${$('tr[data="' + th +'"] td.schDate input').val()}">
	 			<input type="text" name="SHIFT[]" value="${$('tr[data="' + th +'"] td.shift input').val()}">
	 			<input type="text" name="NEED_BY[]" value="${$('tr[data="' + th +'"] input.NEED_BY').val()}">
	 			<input type="text" name="TYPE_PRODUCT[]" value="${$('tr[data="' + th +'"] input.TYPE_PRODUCT').val()}">
	 			<input type="text" name="OPR_SEQ[]" value="${$('tr[data="' + th +'"] input.OPR_SEQ').val()}">
	 			<input type="text" name="OPERATION[]" value="${$('tr[data="' + th +'"] input.OPERATION').val()}">
	 			<input type="text" name="ACTIVITY[]" value="${$('tr[data="' + th +'"] input.ACTIVITY').val()}">
	 			<input type="text" name="RESOURCES[]" value="${$('tr[data="' + th +'"] input.RESOURCES').val()}">
	 			<input type="text" name="QR_CODE[]" value="${$('tr[data="' + th +'"] input.QR_CODE').val()}">
	 			<input type="text" name="PREVIOUS_OPERATION[]" value="${$('tr[data="' + th +'"] input.PREVIOUS_OPERATION').val()}">
	 			<input type="text" name="NEXT_OPERATION[]" value="${$('tr[data="' + th +'"] input.NEXT_OPERATION').val()}">
	 			<input type="text" name="NEXT_DEPT_CLASS[]" value="${$('tr[data="' + th +'"] input.NEXT_DEPT_CLASS').val()}">
	 			<input type="text" name="TARGETJS[]" value="${$('tr[data="' + th +'"] input.TARGETJS').val()}">
	 			<input type="text" name="TARGETSK[]" value="${$('tr[data="' + th +'"] input.TARGETSK').val()}">
	 			<input type="text" name="STATUS_STEP[]" value="${$('tr[data="' + th +'"] input.STATUS_STEP').val()}">
	 			<input type="text" name="UOM_CODE[]" value="${$('tr[data="' + th +'"] input.UOM_CODE').val()}">
	 			<input type="text" name="JML_OP[]" value="${$('tr[data="' + th +'"] input.JML_OP').val()}">
	 			<input type="text" name="ROUTING_CLASS_DESC[]" value="${$('tr[data="' + th +'"] input.ROUTING_CLASS_DESC').val()}">
	 			<input type="text" name="UNIT_VOLUME[]" value="${$('tr[data="' + th +'"] input.UNIT_VOLUME').val()}">
	 			<input type="text" name="KODE_PROSES[]" value="${$('tr[data="' + th +'"] input.KODE_PROSES').val()}">
	 			<input type="text" name="TUJUAN[]" value="${$('tr[data="' + th +'"] input.TUJUAN').val()}">
	 			<input type="text" name="NO_MESIN[]" value="${$('tr[data="' + th +'"] input.NO_MESIN').val()}">
				<input type="text" name="SCHEDULED_START_DATE[]" value="${$('tr[data="' + th +'"] input.SCHEDULED_START_DATE').val()}">
				
	 		</div>
	 `;

	if (checked == true) {
		$('#formTerserah').append(newItem);
		$('tr[data="' + th +'"] td.selectKegunaan select').removeAttr("disabled");
		$('tr[data="' + th +'"] td.inputDuedate input').removeAttr("disabled");
	}else {
		$('.dataRow_' + th).remove()
        $('tr[data="' + th +'"] td.selectKegunaan select').attr("disabled","disabled");
        $('tr[data="' + th +'"] td.inputDuedate input').attr("disabled","disabled");


	}

	$(".kegunaan").change(function(){
	var check = $('tr[data="' + th +'"] td.chkCtk input').prop('checked');
	var tujuanbaru = $('tr[data="' + th +'"] td.selectKegunaan select').val();
	var wipidbaru = $('tr[data="' + th +'"] input.WIP_ENTITY_ID').val();

	var initujuan =  `
 		<div class="dataRow_${th}">
 			<input type="text" name="tujuanbaru[]" value="${tujuanbaru}">
			<input type="text" name="wipidbaru[]" value="${wipidbaru}">
 		</div>
	 `;

	console.log(tujuanbaru,wipidbaru);

	if (check == true) {
		$('#formTerserah').append(initujuan);
		$.ajax({
			type: 'POST',
			url: baseurl+'CetakKanban/Cetak/Report',
			data: {
				tujuanbaru : tujuanbaru,
				wipidbaru : wipidbaru,
			},
			datatype : 'json',
		});
	}else {
		$('.dataRow_' + th).remove()
	}
	})

	$(".due_date").on("change", function(){
		var check = $('tr[data="' + th +'"] td.chkCtk input').prop('checked');
		var due_date = $('tr[data="' + th +'"] td.inputDuedate input').val();
		var wipidbaru = $('tr[data="' + th +'"] input.WIP_ENTITY_ID').val();

		var updateDue =  `
 		<div class="dataRow_${th}">
			<input type="text" name="due_date[]" value="${due_date}">
			<input type="text" name="wipidbaru[]" value="${wipidbaru}">
 		</div>
	 `;
		
		console.log(due_date);
		if (check == true) {
			$('#formTerserah').append(updateDue);
			$.ajax({
				type: 'POST',
				url: baseurl+'CetakKanban/Cetak/Report',
				data: {
					due_date : due_date,
					wipidbaru : wipidbaru,
				},
				datatype : 'json',
			});
		}else {
			$('.dataRow_' + th).remove()
		}
	})
}

function insertReport(th) {
	if ($(".checkedAll").is(":checked")) {
		$("#formSemua").submit();
	}else{
		$("#formTerserah").submit();
	}
	
}
