var currentTabIA = 0;
$(document).ready(function(){
	$('input[type=checkbox]').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
	$('.tab').eq(currentTabIA).show();
	$('.slc2').select2({
		allowClear:true
	});
// $(".tblDetailMonitoringIa").wrap('<div class="dataTables_scroll" />');
	$('.dtb').dataTable({
		info : false
	});
	$(".tblDetailMonitoringIa").dataTable({
		scrollX : true
	});
	$('.dtpc2').daterangepicker({
		});
	$('.dtpc').datepicker({
  			autoclose:true,
  			todayHighlight :true
  		});

});
	$('.add-new-account-ia').click(function () {
		ShowFormAddAccount();
	});

$('.closeIa').click(function(){
	$(this).parent().hide();
});




function nextPrevIA(n) {
	  var x = $('.tab');
	  tungitung = currentTabIA;
	  tungitung = tungitung + n;
	  if (tungitung == (x.length)) {
		  $('#formImprove2').submit();
	  }else{
		  $('#formImprove1').submit();
		  $('.slc2').select2('destroy');
		  $(x).eq(currentTabIA).css('display','none');
		  currentTabIA = currentTabIA + n;
		  showTabIA(currentTabIA);
		  saveDraftOs();
		  $('.slc2').select2({'allowClear' : true}).css('width','100%');
	  }
	}

 $("#formImprove1").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
	         url : baseurl+"InternalAudit/CreateImprovement/saveDraftImprove1",
	        type : "POST",
	        data : new FormData(this),
     contentType : false,
           cache : false,
     processData : false,
     dataType: "json",
         success : function(result)
		              {
		                $('#tmp_seksi_auditee').text(': '+$('select[name="slcSeksi[]"]').val());
		                $('#tmp_pic_auditee').text(': '+result.pic_auditee);
		                setTimeout(function(){ $('.notif-draft').fadeOut(3000); $('.notif-loading').html('').hide();}, 1000);
						setTimeout(function(){$('.notif-del-draft').show('slow'); },3500);
		             }         
    });
}));

function saveDraftOs(){
		 $('.notif-loading').html('<img src="'+baseurl+'/assets/img/gif/spinner.gif">').show();
		 $('.notif-draft').show('slow');
		 
	}

 function showTabIA(n) {
	  var x = $('.tab');
	  $(x).eq(n).css('display','block');
	  if (n == 0) {
	    $('#prevBtnIA').css('display','none');
	  } else {
	    $('#prevBtnIA').css('display','inline');
	  }
	  if (n == (x.length - 1)) {
	  	$('#nextBtnIA').addClass('btn-success').removeClass('btn-primary')
	  	.html('<b><b class="fa fa-check "></b> &nbsp; SUBMIT </b>')
	  }else{
	  	$('#nextBtnIA').removeClass('btn-success').addClass('btn-primary')
	  	.html('<b><b class="fa fa-chevron-right "></b> &nbsp; NEXT </b>')
	  }
	}

	// $('tr').click(checkByTr);

function checkByTr() {
	$(this).find('input[name="chkIA"]').iCheck('toggle');
}

function addRowTblIA(tbl) {
	var tableRev = $(tbl).find('tbody');
	var i = 1;
	$('.slc2').select2('destroy');
	var newRow = $(tableRev).find('tr').last().clone();
	$(tbl).append(newRow);
	$(tbl).find('tbody').find('tr').last().find('td.chk').html('<center><input type="checkbox" name="chkIA" class="chkIA"></center>');
	$(tbl).find('tbody').find('tr').last().find('#prevImprove').html('');
	$(tbl).find('tbody').find('tr').last().find('.hrefDet').html('<b class="fa fa-edit"></b> <i>Input Improve..</i>');
	// $(tbl).find('tbody').find('tr').last().click(checkByTr);
	$('.slc2').select2({'allowClear' : true}).css('width','100%');
	$('input[type=checkbox]').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue'
	});
	$('.dtpc').datepicker({
  			autoclose:true,
  			todayHighlight :true
  		});
	$(tbl).find('tbody').find('tr').last().find('input').val('');
	$('textarea').val('');
	sortTableIA(tbl);
	mencheckedIA();

}

function sortTableIA(tbl) {
	var i = 1;
	$(tbl).find('.no_ur').each(function () {
		$(this).text(i);
		$(this).closest('tr').find('input[name="chkIA"]').attr('value',i);
		$(this).parent().attr('id_ur',i);
		i += 1;
	});
}

function checkCheckedExistIA(){
	var a = 0;
	$('input[name="chkIA"]').each(function(){
		var attrCheck = $(this).attr('checked');

		if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)) {
			a += 1;
		}
	});

	if (a != 0) {
		$('.btn-delete-row').removeClass('disabled btndis');
	}else{
		$('.btn-delete-row').addClass('disabled btndis');
	}
}

function mencheckedIA(){
	var countChk = 0;	
	$('input[name="chkIA"]').on('ifChanged',function(){
		if($(this).is(':checked')){
						$(this).attr('checked','checked');
						$(this).parent().addClass('checked');
				}else{
						$(this).removeAttr('checked');
						$(this).parent().removeClass('checked');
				}

		arrChk = [];
		var countChk = 0;           
		$('input[name="chkIA"]').each(function() {
				var attrCheck = $(this).attr('checked');
				if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)) {
					arrChk.push('1');
					countChk += 1;
				}else{
					arrChk.push('0');
				}
			});
		
		if (countChk > 0 ) {
			$('.btn-delete-row').attr('data-original-title','Delete '+countChk+' Improvement');
		}else{
			$('.btn-delete-row').attr('data-original-title','Delete Improvement');
		}
		checkCheckedExistIA();
	});
}

function delRowTblIA(th,tbl) {
	if(!$(th).hasClass('disabled')){
		var tableRev = $(tbl).find('tbody');
		$('.slc2').select2('destroy');
		var newRow = $(tableRev).find('tr').last().clone();
		$('input[name="chkIA"]').each(function() {
			var attrCheck = $(this).attr('checked');
			if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)) {
				val = $(this).val();
				$('tr[id_ur="'+val+'"]').remove();
			}
		});
		rowCount = $(tbl+' tr').length;
		if (rowCount == 1) {
			$(tbl).append(newRow);
			$(tbl).find('tbody').find('tr').last().find('td.chk').html('<input type="checkbox" name="chkIA" class="chkIA">');
		}
		$('.slc2').select2({'allowClear' : true}).css('width','100%');
		$('input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});
		sortTableIA(tbl);
		checkCheckedExistIA();
		mencheckedIA();

	}
}

function btnSaveImproveIA(th) {
		data_id = $('#ModImprove').attr('data-id');
		var rekomendasi = $('input[name="txtRekomendasiImprovement"]').val();
		var ImproveKon = $('textarea[name="textareaImproveKon"]').val();
		var ImproveKri = $('textarea[name="textareaImproveKri"]').val();
		var ImproveAki = $('textarea[name="textareaImproveAki"]').val();
		var ImprovePenye = $('textarea[name="textareaImprovePenye"]').val();

		$('tr[id_ur="'+data_id+'"]').find('input[name="txtImproveRekomendasi[]"]').val(rekomendasi);
		$('tr[id_ur="'+data_id+'"]').find('input[name="txtImproveKon[]"]').val(ImproveKon);
		$('tr[id_ur="'+data_id+'"]').find('input[name="txtImproveKrit[]"]').val(ImproveKri);
		$('tr[id_ur="'+data_id+'"]').find('input[name="txtImproveAkib[]"]').val(ImproveAki);
		$('tr[id_ur="'+data_id+'"]').find('input[name="txtImprovePenyeb[]"]').val(ImprovePenye);
		html = rekomendasi;

		keterisian = (rekomendasi.length)+(ImproveKon.length)+(ImproveKri.length)+(ImproveAki.length)+(ImprovePenye.length);

		$('tr[id_ur="'+data_id+'"]').closest('tr').find('#prevImprove').html(html);
		if (keterisian > 0) {
			$('tr[id_ur="'+data_id+'"]').closest('tr').find('.hrefDet').html('<br/>.. see detail');
		}else{
			$('tr[id_ur="'+data_id+'"]').closest('tr').find('.hrefDet').html('<b class="fa fa-edit"></b> <i>Input Improve..</i>');
		}
	$('#ModImprove').modal('hide');
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();

	$('#ModImprove').find('textarea').val('');
	$('#ModImprove').find('input[name="txtRekomendasiImprovement"]').val('');
}

function btnAhrefModImprove(th) {
	var a = $(th).parent().parent().parent().attr('id_ur');
	var rek = $(th).parent().closest('center').find('input[name="txtImproveRekomendasi[]"]').val();
	var kon = $(th).parent().closest('center').find('input[name="txtImproveKon[]"]').val();
	var krit = $(th).parent().closest('center').find('input[name="txtImproveKrit[]"]').val();
	var akib = $(th).parent().closest('center').find('input[name="txtImproveAkib[]"]').val();
	var penye = $(th).parent().closest('center').find('input[name="txtImprovePenyeb[]"]').val();

	$('input[name="txtRekomendasiImprovement"]').val(rek);
	$('textarea[name="textareaImproveKon"]').val(kon);
	$('textarea[name="textareaImproveKri"]').val(krit);
	$('textarea[name="textareaImproveAki"]').val(akib);
	$('textarea[name="textareaImprovePenye"]').val(penye);
		$('#ModImprove').attr('data-id',a);

}


function ShowFormAddAccount() {
	$('.res').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
	$.ajax({
		url: baseurl+'InternalAudit/SettingAccount/AuditObject/ShowFormAddAccount',
		datatype: 'html',
		success: function (result) {
			$('.res').html(result)
			$('.slc2').select2({'allowClear' : true}).css('width','100%');
			$('.btn-del-ia')
				.mouseover(function () {
				$(this).parent().parent().addClass('bg-danger');
			})
				.mouseout(function () {
				$(this).parent().parent().removeClass('bg-danger');
			})
		}
	})
}

function ShowFormEditAccount(th) {
	var id = $(th).attr('data-id');
	$('.res').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
	$.ajax({
		url: baseurl+'InternalAudit/SettingAccount/AuditObject/ShowFormEditAccount',
		data: {
			id : id
		},
		type: "post",
		datatype: 'html',
		success: function (result) {
			$('.res').html(result)
			$('.slc2').select2({'allowClear' : true}).css('width','100%');
			$('.btn-del-ia')
				.mouseover(function () {
				$(this).parent().parent().addClass('bg-danger');
			})
				.mouseout(function () {
				$(this).parent().parent().removeClass('bg-danger');
			})
		}
	})
}

function addRowTblSettAccountIA(tbl) {
	$('.slc2').select2('destroy');
	var newRow = $(tbl).find('tr').last().clone();
	$(tbl).append(newRow);
	$('.slc2').select2({'allowClear' : true}).css('width','100%');
	$(tbl).find('tr').last().find('.slc2').val(null).trigger('change');
	$('.btn-del-ia')
				.mouseover(function () {
				$(this).parent().parent().addClass('bg-danger');
			})
				.mouseout(function () {
				$(this).parent().parent().removeClass('bg-danger');
			})
}

function delRowTblSettAccountIA(th) {
	var jml = $('#tbl-acc-set-ia tr').length;
	if (jml == 1) {
		$(this).parent().parent().closest('tr').find('.slc2').val(null).trigger('change');
	}else{
		$(th).parent().parent().remove();
	}

}

$('.det_improve').click(function () {
	var kondisi = $(this).find('.kondisi').val();
	var kriteria = $(this).find('.kriteria').val();
	var akibat = $(this).find('.akibat').val();
	var penyebab = $(this).find('.penyebab').val();
	$('textarea[name="textareaImproveKon"]').val(kondisi);
	$('textarea[name="textareaImproveKri"]').val(kriteria);
	$('textarea[name="textareaImproveAki"]').val(akibat);
	$('textarea[name="textareaImprovePenye"]').val(penyebab);
	$('#ModDetailFinding').modal('show');
});

function getCompReportIa(th) {
	$('#ModPrintCompReport').modal('show');
	var id = $(th).attr('data-id');
	$('#detailPrintComplReport').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
	$.ajax({
		url : baseurl+"InternalAudit/MonitoringImprovement/DetailCompletion/"+id,
		type : "POST",
		datatype : "html",
		success : function (result) {
			setTimeout(function () {
				$('#detailPrintComplReport').html(result);
			},3000);
		}
	})
}

function delImprovementIa(th) {
	var id = $(th).attr('data-id');
	$('#ModDeleteImproveIa').modal('show');
	$('#formDelImprove').find('input[name="improvement_id"]').val(id);
	$('.delImproveIa').click(function () {
		$('#formDelImprove').submit();
	})
}

function deleteAuditIa(th) {
	var id = $(th).attr('data-id');
	$('#formDeleteAuditIa').find('input[name="id_audit"]').val(id);
}

$('select[name="slcObjectAudit"]').change(function () {
	var val = $(this).val();
	var slcAuditee = '';
	$.ajax({
		url : baseurl+"InternalAudit/CreateImprovement/getDetailAuditor",
		type: "POST",
		dataType : "json",
		data: {
			id : val
		},
		success:function (result) {
			htmlAuditor = '<table class="table table-curved"><tr><th>Auditor</th></tr>';
			if (result.auditor.length > 0) {
				for (var i = 0; i <  result.auditor.length; i++) {
					htmlAuditor += "<tr><td>"+result.auditor[i].employee_name+"</td></tr>"
				}
			}else{
				htmlAuditor +='<tr><td> No Auditor found..</td></tr>'
			}
			htmlAuditor += '</table>';

			htmlAuditee = '<table class="table table-curved"> <tr><th>Auditee</th></tr>';
			slcAuditee = '<option></option>';
			if (result.detail.length == 0 && result.auditee.length == 0) {
				htmlAuditor +='<tr><td> No Auditee found..</td></tr>'
			}else{
				htmlAuditee += '<tr><td>'+result.detail[0].employee_name+'</td></tr>';
				slcAuditee += '<option value="'+result.detail[0].pic+'">'+result.detail[0].user_name+' - '+result.detail[0].employee_name+'</option>';
				for (var i = 0; i <  result.auditee.length; i++) {
					htmlAuditee += "<tr><td>"+result.auditee[i].employee_name+"</td></tr>";
					slcAuditee += '<option value="'+result.auditee[i].staff_id+'">'+result.auditee[i].user_name+' - '+result.auditee[i].employee_name+'</option>';
				}
			};
			htmlAuditee += '</table>';

			$('#res_auditor').html(htmlAuditor);
			$('#res_auditee').html(htmlAuditee);
			$('.slcImprovePIC').html(slcAuditee);
		}
	})
});

$('#del_draft_improve').click(function () {
	$('input, textarea').val(null);
	$('.slc2').val(null).trigger('change');
	$('.tab').hide();
	$('.tab').eq(0).show();
	$('.slc2').select2('destroy');
	$('.slc2').select2({'allowClear' : true}).css('width','100%');
	$('#nextBtnIA').addClass('btn-success').removeClass('btn-primary').html('<b><b class="fa fa-check "></b> &nbsp; SUBMIT </b>');
  	$('#prevBtnIA').css('display','none');
});

$('.det_prog_hist_ia').click(function () {
	var id = $(this).attr('data-id');
	var type = $(this).attr('data-type');
	var imp_id = $(this).attr('data-im');
	if (type == '2') {
		ctrl_typenya = 'MonitoringImprovement';
	}else if (type == '1') {
		ctrl_typenya = 'MonitoringImprovementAuditee';
	}
	$('#DetProgHistResult').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
	$.ajax({
		url: baseurl+"InternalAudit/"+ctrl_typenya+"/getDetailProgressHistory",
		data: {
			imp_list_id : id,
			imp_id : imp_id
		},
		type:"POST",
		dataType: "html",
		success:function (result) {
			$('#DetProgHistResult').html(result);
			$('.dtb2').dataTable({
				info : true,
				searching : false, 
			});
		}
	})
});

function showFormAddHistory(th) {
	var imp_list_id = $(th).attr('data-id');
	var imp_id = $(th).attr('data-im');
	$('#ModDetProgHist').modal('hide');
	$('#formAddHistory').find('input[name="improvement_id"]').val(imp_id);
	$('#formAddHistory').find('input[name="improvement_list_id"]').val(imp_list_id);
	$('input[name="typeProgress"]').on('ifChanged',function () {
	if($(this).is(':checked')){
			$(this).attr('checked','checked');
			$(this).parent().addClass('checked');
	}else{
			$(this).removeAttr('checked');
			$(this).parent().removeClass('checked');
	}
})
}

function replyAuditor(id,det,imp,type) {
	$('#formResponseAuditor').find('input[name="id_response"]').val(id);
	$('#formResponseAuditor').find('input[name="id_detail"]').val(det);
	$('#formResponseAuditor').find('input[name="id_improvement"]').val(imp);
	html = '<input type="checkbox" id="approveAuditor" name="approveAuditor" value="1">'
	html += '<label for="approveAuditor"> Approve Request </label>';
	if (type == '5') {
		$('#approveCheckbox').html(html);
		$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
		$('input[name="approveAuditor"]').on('ifChanged',function () {
			if($(this).is(':checked')){
					$(this).attr('checked','checked');
					$(this).parent().addClass('checked');
			}else{
					$(this).removeAttr('checked');
					$(this).parent().removeClass('checked');
			}
	});
	}
}

$('.btn-update-user-ia').click(function () {
	$('#li_setting').show().addClass('active');
	$('#profile, #li_profile').removeClass('active');
	$('#settings').addClass('active');
});

$('.userIa').click(function () {
	var user_id = $(this).attr('data-id');
	$('.modal').modal('hide');
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();
	$('#ModUserIa').modal('show');
	$('#viewDataUser').html('<div style="height:400px; padding-top:25%"><center><img style="width:100px; height:auto;" src="'+baseurl+'assets/img/gif/loading3.gif"></center></div>');
	$.ajax({
		url : baseurl+"InternalAudit/SettingAccount/User/getUserData",
		type: "POST",
		data: {
			user_id:user_id
		},
		datatype: "html",
		success: function (result) {
			$('#viewDataUser').html(result);
		}
	})

});

$('.btn-delete-improve-list').click(function () {
	var id = $(this).attr('data-id');
	var imp_id = $(this).attr('data-imp-id');
	$('#ModDeleteImproveIa').modal('show');
	$('#formDelImprove').find('input[name="improvement_list_id"]').val(id);
	$('#formDelImprove').find('input[name="improvement_id"]').val(imp_id);
	$('.delImproveIa').click(function () {
		$('#formDelImprove').submit();
	})
});

$('.btn-submit-newimprove').click(function () {
	$('#formAddNewImprove').submit();
});

$('.btn-submit-editimprove').click(function () {
	$('#formeEditImprovementList').submit();
})

function showFormEditAuditeeResponse(th) {
	var desc = $(th).parent().parent().closest('tr').find('.desc_progress').text();
	var id = $(th).attr('data-id');
	var imp_id = $(th).attr('data-imp_id');
	var imp_list_id = $(th).attr('data-imp_list_id');
	$('#formEditHistory').find('textarea[name="txtDescProgress"]').val(desc);
	$('#formEditHistory').find('input[name="id"]').val(id);
	$('#formEditHistory').find('input[name="improvement_id"]').val(imp_id);
	$('#formEditHistory').find('input[name="improvement_list_id"]').val(imp_list_id);
	$('#ModEditHistory').modal('show');

}


