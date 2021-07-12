function addRow(tableID) {
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;
	var jlhRow = Number(rowCount) - 1;
	var row = table.insertRow(rowCount);

	var colCount = table.rows[0].cells.length;

	for (var i = 0; i < colCount; i++) {
		var newcell = row.insertCell(i);

		newcell.innerHTML = table.rows[jlhRow].cells[i].innerHTML;
		//alert(newcell.childNodes);
		switch (newcell.childNodes[0].type) {
			case "text":
				newcell.childNodes[0].value = "";
				break;
			case "select-one":
				newcell.childNodes[0].selectedIndex = 0;
				break;
		}
	}
}
/*
function autocompleteActivity(){
	//alert ('tes');
	$('.additional-activity').autocomplete({
		source:'http://quick.com/quickERPdev/CustomerRelationship/Search/AdditionalActivity'

	});
}
*/
/*
$('.additional-activity').change(function() {
		$('.additional-activity').autocomplete({
				source:'http://quick.com/quickERPdev/CustomerRelationship/Search/AdditionalActivity'

			});
	});
*/

function addRowSpLine(base) {
	var counter = 0;
	var n = $("#tblServiceLines tbody tr").length;
	counter = n + 1;

	var param2 = $("#tblServiceLines tbody tr").length;
	var param3 = $("#hdnCustomerId").val();
	var param1 = base + "ajax/ModalItemLines/" + param2 + "/" + param3;
	var url = base + "ajax/ModalItemLines/" + param2 + "/" + param3;
	//$("input#txtOwnership:last").attr("onfocus","callModal('"+param1+"')");

	var newRow = jQuery(
		"<tr>" +
			"<td>" +
			"<input type='text' id='txtOwnership' name='txtOwnership[]' onfocus=callModal('" +
			param1 +
			"/'); onchange=enadisServiceLine('" +
			counter +
			"'); placeholder='Product code' class='form-control' disabled='disabled'/>" +
			"<input type='hidden' id='hdnOwnershipId' name='hdnOwnershipId[]' class='form-control'/>" +
			"</td>" +
			"<td><input type='text' name='txtItemDescription[]' id='txtItemDescription' class='form-control' readonly='readonly'/></td>" +
			"<td><input type='text' name='txtWarranty[]' id='txtWarranty' disabled='disabled' class='form-control' style='text-align:center;' /></td>" +
			"<td><input type='text' name='txtClaimNum[]' id='txtClaimNum' disabled='disabled' class='form-control' style='text-align:center;' /></td>" +
			"<td>" +
			//+"<input type='text' name='txtSparePart[]' id='txtSparePart"+counter+"' onblur='selectItemSparePart("+counter+")' class='form-control2 txtSparePart' disabled='disabled'/>"
			//+"<input type='hidden' name='hdnSparePartId[]' id ='hdnSparePartId"+counter+"' />"
			"<select name='slcSparePart[]' id='slcSparePart' disabled='disabled' class='form-control jsSparePart' data-placeholder='Spare part'>" +
			"<option value=''></option></select>" +
			"</td>" +
			//+"<td><input type='text' name='txtSparePartDescription[]' id='txtSparePartDescription"+counter+"' class='form-control' readonly='readonly'/></td>"
			"<td><select  name='slcProblem[]' id='slcProblem' class='form-control jsProblem' disabled='disabled'>" +
			"<option value='' select='selected'>" +
			"</select></td>" +
			"<td><input type='text' name='txtProblemDescription[]' id='txtProblemDescription'  class='form-control' disabled='disabled'/></td>" +
			"<td>" +
			"<select name='actionClaim[]' id='actionClaim' class='form-control select4' data-placeholder='Action Claim' disabled>" +
			"<option value='' disabled selected>-- CHOOSE ONE --</option>" +
			"<option value='Y'>PROCESS</option>" +
			"<option value='N'>NO PROCESS</option>" +
			"</select>" +
			"</td>" +
			"<td>" +
			"<input type='text' name='claimImage' id='claimImage' onfocus='modalImg(this)'  class='form-control' row-id='" +
			counter +
			"'>" +
			"<input type='hidden' name='claimImageData[]'' id='claimImageData' row-id='" +
			counter +
			"'>" +
			"</td>" +
			"<td></td>" +
			"</tr>"
	);

	jQuery("#tblServiceLines").append(newRow);

	var id = $("#txtCustomerName").val();
	//alert(id);
	if (id == "") {
		$("input#txtOwnership").eq(counter).val("");
		$("#hdnOwnershipId").eq(counter).val("");
		$("#txtItemDescription").eq(counter).val("");
		$("#txtWarranty").eq(counter).val("");
		$("input#txtOwnership").prop("disabled", true);
	} else {
		$("input#txtOwnership").prop("disabled", false);
		$("input#hdnOwnershipId").prop("disabled", false);
	}

	//jQuery.noConflict();

	$("input#txtActionDate").datepicker({
		autoclose: true,
	});
	$("input#txtFinishDate").datepicker({
		autoclose: true,
	});
	$("input.datePicker1").datepicker({
		autoclose: true,
	});
	/*
		$(".jsLineStatus").select2({
		placeholder: "STATUS",
		minimumInputLength: 0,
		ajax: {
					url: "http://quick.com/quickERPdev/CustomerRelationship/Search/ServiceLineStatus/",
					dataType: 'json',
					type: "GET",
					data: function (params) {

						var queryParameters = {
							term: params.term
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.service_line_status_id, text:obj.consecutive_number+" "+obj.service_line_status_name };
							})
						};
					}
			}

		});
		*/
	$(".jsProblem").select2({
		placeholder: "Problems",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/ServiceProblem",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.service_problem_id,
							text: obj.service_problem_name,
						};
					}),
				};
			},
		},
	});

	$("select.jsSparePart").select2({
		allowClear: true,
		placeholder: "By spare part code or spare part name",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/SparePartData/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.item_id,
							text: obj.segment1 + " (" + obj.item_name + ")",
						};
					}),
				};
			},
		},
	});

	$(".jsEmployeeData").select2({
		allowClear: true,
		placeholder: "Employee",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/EmployeeData/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.employee_id,
							text: obj.employee_code + " (" + obj.employee_name + ")",
						};
					}),
				};
			},
		},
	});

	//$("select#slcServiceLineStatus").select2();
}

function addRowSpFaqs(base) {
	var n = $("#tblFaq tbody tr").length;
	counter = n + 1;
	var newRow = jQuery("<tr>" + "<td><select name='slcFaqType[]' id='slcFaqType'  class='form-control'>" + "<option value='' ></option>" + "<option value='Complain' >Complain</option>" + "<option value='Feedback' >Feedback</option>" + "<option value='Question' >Question</option>" + "<option value='Other' >Other</option></select></td>" + "<td><input type='text' name='txtFaqDescription1[]' id='txtFaqDescription1' class='form-control faq-descriptions' /></td>" + "<td><input type='text' name='txtFaqDescription2[]' id='txtFaqDescription2' class='form-control' /></td>" + "</tr>");
	jQuery("#tblFaq").append(newRow);

	//check the function inside jquery too
	$(".faq-descriptions").autocomplete({
		//source:'http://quick.com/quickERPdev/CustomerRelationship/Search/FaqDescription'
		/*source: function(request, response) {
				$.getJSON("http://quick.com/quickERPdev/CustomerRelationship/Search/FaqDescription", { faq_type: $('#slcFaqType').val() }, 
              response);
			  },
			  minLength: 1
		});*/
		source: function (request, response) {
			$.ajax({
				url: base + "CustomerRelationship/Search/FaqDescription",
				dataType: "json",
				data: {
					term: request.term,
					faq_type: $("#slcFaqType").val(),
				},
				success: function (data) {
					response(data);
				},
			});
		},
		min_length: 2,
	});
}

function addRowAddAct(base) {
	var n = $("#tblAddAct tbody tr").length;
	counter = n + 1;
	var newRow = jQuery("<tr>" + "<td>" + counter + "</td>" + "<td>" + "<select name='txtAdditionalAct[]' id='txtAdditionalAct' class='form-control jsAdditionalActivity'>" + "<option value=''></option></select></td>" + "<td><input type='text' name='txtActDescription[]' id='txtActDescription' class='form-control' /></td>" + "</tr>");
	jQuery("#tblAddAct").append(newRow);

	/*$(".additional-activity").autocomplete({
			source:'http://quick.com/quickERPdev/CustomerRelationship/Search/AdditionalActivity'

		});*/

	$(".jsAdditionalActivity").select2({
		placeholder: "Additional Activity",
		//placeholder: "By employee name or code",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/AdditionalActivity",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.setup_service_additional_activity_id,
							text: obj.additional_activity,
						};
					}),
				};
			},
		},
	});
}

function addRowResponsibility(base) {
	var newgroup = $("<tr>").addClass("clone");
	var e = jQuery.Event("click");
	e.preventDefault();

	$(".clone").last().clone().appendTo(newgroup).appendTo("#tbodyUserResponsibility");
	$("select#slcUserResponsbility:last").siblings("span").remove();
	$("select#slcActive:last").siblings("span").remove();
	$("select#slcLokal:last").siblings("span").remove();
	$("select#slcInternet:last").siblings("span").remove();

	$("select#slcUserResponsbility:last, select#slcActive:last, select#slcLokal:last, select#slcInternet:last").select2({
		placeholder: "Choose option",
		allowClear: true,
	});

	$("select#slcUserResponsbility:last").val("").change();
	$("select#slcActive:last").val("Y").change();
	$("select#slcLokal:last").val("1").change();
	$("select#slcInternet:last").val("0").change();
	$("input#hdnUserApplicationId:last").val("0");
	$("button.btnDeleteUserResponsibility:last").attr("id-user-responsibility", "0");
}

function addRowMenu(base) {
	var newgroup = $("<tr>").addClass("clone");
	var e = jQuery.Event("click");
	e.preventDefault();
	$("select#slcMenu:last").select2("destroy");

	$(".clone").last().clone().appendTo(newgroup).appendTo("#tblMenuGroup");

	$("select#slcMenu").select2({
		placeholder: "",
		allowClear: true,
	});
	$("select#slcMenu:last").select2({
		placeholder: "",
		allowClear: true,
	});
	$("select#slcMenu:last").val("").change();
	$("input#txtMenuSequence:last").val($(".clone").length);
	$("input#txtMenuPrompt:last").val("");
	$("input#hdnMenuGroupListId:last").val("");
	$("input#hdnMenuGroupListId:last").val("");
	$("a#btn-edit-row:last").css("display", "none");
	$("a#btn-delete-row:last").attr("onclick", "");
	$("a#btn-delete-row:last")
		.off("click")
		.click(function () {
			deleteSubMenuGroup("", "", this);
		});
	// sortSequence();
	console.log("test");
}

function addRowReport(base) {
	var newgroup = $("<tr>").addClass("clone");
	var e = jQuery.Event("click");
	e.preventDefault();
	$("select#slcReport:last").select2("destroy");

	$(".clone").last().clone().appendTo(newgroup).appendTo("#tblReportGroup");

	$("select#slcReport").select2({
		placeholder: "",
		allowClear: true,
	});

	$("select#slcReport:last").select2({
		placeholder: "",
		allowClear: true,
	});

	$("select#slcReport:last").val("").change();
	$("input#hdnReportGroupListId:last").val("0");
}

function addRowItemDelivery(base) {
	var newgroup = $("<tr>").addClass("clone");
	var e = jQuery.Event("click");
	e.preventDefault();
	$("select#slcDeliveryItem:last").select2("destroy");

	$(".clone").last().clone().appendTo(newgroup).appendTo("#tblItemDelivery");

	$("select#slcDeliveryItem").select2({
		placeholder: "",
		allowClear: true,
	});

	$("select#slcDeliveryItem:last").select2({
		placeholder: "",
		allowClear: true,
	});

	$(".jsDeliveryItem").select2({
		allowClear: true,
		placeholder: "item",
		minimumInputLength: 1,
		ajax: {
			url: base + "InventoryManagement/Search/DeliveryItem",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.INVENTORY_ITEM_ID,
							text: obj.SEGMENT1 + " - " + obj.DESCRIPTION,
						};
					}),
				};
			},
		},
	});

	var n = $("#tblItemDelivery tbody tr").length;

	$("select#slcDeliveryItem:last").val("").change();
	$("input#txtNumber:last").val(n);
	$("input#txtQuantity:last").val("");
}

function delRow(base) {
	var rowCount = $("#tbl1 tr").size();
	if (rowCount > 2) {
		$("#tbl1 tr:last").remove();
	} else {
	}
}

function deleteRow(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var i = rowCount - 1;
		var lineID = $("#" + tableID + " tbody tr input.id")
			.eq(rowCount - 2)
			.val();
		//alert(n);
		if (rowCount > 2) {
			if (lineID > 0) {
				alert("Baris sudah tersimpan tidak bisa dihapus");
			} else {
				table.deleteRow(i);
			}
		} else {
			alert("Minimal harus ada satu baris tersisa");
		}
	} catch (e) {
		alert(e);
	}
}

function changeLineStatus(rowid) {
	$("input#txtActionDate").eq(rowid).val("");
}
/*function enadisMethod() {

		var id = document.getElementById('slcActivityType').value;
		if(id == 'others'){

			document.getElementById('txtOtherType').disabled = false;
		}
		else{
			document.getElementById('txtOtherType').value = '';
			document.getElementById('txtOtherType').disabled = true;
		}
		//document.getElementById('txtDescription').value = id;
		//alert(id);
}*/

function contact() {
	//PASANGANNYA linemask
	//ubah juga pada $(document).ready(function()
	if ($("#txtType").val() === "HANDPHONE") {
		$("#txtData").mask("099999999999");
	}
	if ($("#txtType").val() === "TELEPHONE") {
		$("#txtData").mask("09999999999999");
	}
	if ($("#txtType").val() === "EMAIL") {
		$("#txtData").mask("A", {
			translation: {
				A: { pattern: /[\w@\-.+]/, recursive: true },
			},
		});
	}
	if ($("#txtType").val() === "PIN BBM") {
		$("#txtData").mask("AAAAAAAA");
	}
}

function enadisServiceLine(rowid) {
	//var id = document.getElementById('txtOwnership'+rowid).value;
	var id = $("input#txtOwnership").eq(rowid).val();
	//alert('id');
	if (id == "") {
		document.getElementById("hdnOwnershipId").value = "";
		document.getElementById("txtItemDescription").value = "";
		document.getElementById("txtWarranty").value = "";
		document.getElementById("claimImage").value = "";
		//document.getElementById('slcSparePart').value = '';
		//document.getElementById('hdnSparePartId').value = '';
		//document.getElementById('txtSparePartDescription').value = '';
		//document.getElementById('slcProblem').value = '';
		//document.getElementById('txtProblemDescription').value = '';
		//document.getElementById('txtAction').value = '';
		//document.getElementById('slcEmployeeNum').value = '';
		//document.getElementById('hdnEmployeeId').value = '';
		//document.getElementById('slcSparePart').disabled = true;
		//document.getElementById('slcProblem').disabled = true;
		document.getElementById("txtProblemDescription").disabled = true;
		document.getElementById("txtAction").disabled = true;
		document.getElementById("slcEmployeeNum").disabled = true;
		document.getElementById("slcServiceLineStatus").disabled = true;
		document.getElementById("txtActionDate").disabled = true;
		document.getElementById("txtFinishDate").disabled = true;
		document.getElementById("txtClaimNum").disabled = true;
		document.getElementById("actionClaim").disabled = true;
		document.getElementById("claimImage").disabled = true;
	} else {
		//document.getElementById('slcProblem').disabled = false;
		$("#slcSparePart").eq(rowid).prop("disabled", false);
		document.getElementById("txtProblemDescription").disabled = false;
		document.getElementById("txtAction").disabled = false;
		document.getElementById("slcEmployeeNum").disabled = false;
		document.getElementById("slcServiceLineStatus").disabled = false;
		document.getElementById("txtActionDate").disabled = false;
		document.getElementById("txtFinishDate").disabled = false;
		document.getElementById("txtClaimNum").disabled = false;
		document.getElementById("actionClaim").disabled = false;
		document.getElementById("claimImage").disabled = false;
	}
	//document.getElementById('txtDescription').value = id;
	//alert(id);
}

function enadisLineOwner() {
	var id = $("#txtCustomerName").val();
	//alert('id');
	var n = $("#tblServiceLines tbody tr").length;
	for (var i = 1; i <= n; i++) {
		if (id == "") {
			document.getElementById("txtOwnership" + i).value = "";
			document.getElementById("hdnOwnershipId" + i).value = "";
			document.getElementById("txtItemDescription" + i).value = "";
			document.getElementById("txtWarranty" + i).value = "";
			document.getElementById("txtSparePart" + i).value = "";
			document.getElementById("hdnSparePartId" + i).value = "";
			document.getElementById("txtSparePartDescription" + i).value = "";
			document.getElementById("slcProblem" + i).value = "";
			document.getElementById("txtProblemDescription" + i).value = "";
			document.getElementById("txtAction" + i).value = "";
			document.getElementById("txtEmployeeNum" + i).value = "";
			document.getElementById("hdnEmployeeId" + i).value = "";
			//document.getElementById('slcServiceLineStatus'+i).value = '';
			//document.getElementById('txtActionDate'+i).value = '';
			//document.getElementById('txtFinishDate'+i).value = '';
			document.getElementById("txtOwnership" + i).disabled = true;
			document.getElementById("txtSparePart" + i).disabled = true;
			document.getElementById("slcProblem" + i).disabled = true;
			document.getElementById("txtProblemDescription" + i).disabled = true;
			document.getElementById("txtAction" + i).disabled = true;
			document.getElementById("txtEmployeeNum" + i).disabled = true;
			document.getElementById("slcServiceLineStatus" + i).disabled = true;
			document.getElementById("txtActionDate" + i).disabled = true;
			document.getElementById("txtFinishDate" + i).disabled = true;
			document.getElementById("actionClaim" + i).disabled = true;
			document.getElementById("claimImage" + i).disabled = true;
		}
	}
	//document.getElementById('txtDescription').value = id;
	//alert(id);
}

function sendValueCustomer(cust_id, cust_name, cat_id, base) {
	$("#txtCustomerName").val(cust_name);
	$("#hdnCustomerId").val(cust_id);
	$("#hdnCategoryId").val(cat_id);
	checkcustomer();
	setCustIdSession(cust_id);

	var id = document.getElementById("hdnCustomerId").value;
	var n = $("#tblServiceLines tbody tr").length;
	/*
		for(var i=1;i<=n;i++){
				if(id !== ''){
					//document.getElementById('txtOwnership').disabled = false;
					var param2 = $('#tblServiceLines tbody tr').length;
					var param3 = $('#hdnCustomerId').val();
					var param1 = "http://quick.com/quickERPdev/ajax/ModalItemLines/"+n+"/"+param3;
					$("input#txtOwnership").eq(i).attr("onfocus","callModal('"+param1+"')");
				}
		}
		*/
	$("input#txtOwnership").prop("disabled", false);

	var param2 = $("#tblServiceLines tbody tr").length - 1;
	var param3 = $("#hdnCustomerId").val();
	var param1 = base + "ajax/ModalItemLines/" + param2 + "/" + param3;
	$("input#txtOwnership").attr("onfocus", "callModal('" + param1 + "')");

	$("a#addSpLine").attr("style", "pointer-events: auto;");
	$("a#delSpLine").attr("style", "pointer-events: auto;");

	if ($("#hdnCustomerId").val()) {
		var id = "";
		var cust = $("input#hdnCustomerId").val();

		if (cust == "") {
			$("tbody#result").html("");
		} else {
			var rowCountConnect = $("#tblCallLines tbody tr").size();
			var rowCountService = $("#tblServiceLines tbody tr").size();

			if (rowCountConnect > 0 || rowCountService > 0) {
				//untuk new connect
				$("#tblCallLines tbody tr").remove();
				$.post(base + "CustomerRelationship/Search/Ownership", { id: id, cust: cust }, function (data) {
					if (data) {
						data = $.parseJSON(data); //change to json array cause data is in string
						var len = data.length;
						var txt = "";
						if (len > 0) {
							for (var i = 0; i < len; i++) {
								if (data[i].segment1 && data[i].item_name) {
									txt += "<tr><td><input type='text' id='txtOwnership' name='txtOwnership[]' value='" + data[i].segment1 + "' class='form-control' readonly/>" + "<input type='hidden' id='hdnOwnershipId' name='hdnOwnershipId[]' value='" + data[i].customer_ownership_id + "' /></td>" + "<td><input type='text' id='txtItemDescription' name='txtItemDescription[]' value='" + data[i].item_name + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtBody' name='txtBody[]' value='" + data[i].no_body + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtEngine' name='txtEngine[]' value='" + data[i].no_engine + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtUse' name='txtUse[]' class='form-control'/></td>" + "</tr>";
									//txt += txt;
								}
							}
							$("input#txtUse").keypress(function (eve) {
								if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
									eve.preventDefault();
								}

								// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
								$("input#txtUse").keyup(function (eve) {
									if ($(this).val().indexOf(".") == 0) {
										$(this).val($(this).val().substring(1));
									}
								});
							});
							if (txt != "") {
								$("tbody#result").append(txt);
							}
						}
					}
				});
				///////

				//untuk new service
				$("#tblServiceLines tbody tr :input").each(function () {
					$(this).val("");
					$(this).prop("disabled", true);
					//$("tblServiceLines tbody tr select").val("");
				});
				$("input#txtOwnership").prop("disabled", false);
				$("#tblServiceLines tbody tr select#slcServiceLineStatus").val("OPEN");
				///////
			}
		}
	}
}

function sendValueItem(item_id, item_code, item_name, i, base) {
	$("input#txtOwnership").eq(i).val(item_code);
	$("input#txtItemDescription").eq(i).val(item_name);
	$("input#hdnOwnershipId").eq(i).val(item_id);
	checkWarranty(base, i, item_id);

	var id = $("input#txtOwnership").eq(i).val();

	//$('input#txtProblemDescription').eq(i).val(i);

	if (id !== "") {
		//document.getElementById('slcSparePart').disabled = false;
		//document.getElementById('txtClaimNum').disabled = false;
		//document.getElementById('slcProblem').disabled = false;
		//document.getElementById('txtProblemDescription').disabled = false;
		//document.getElementById('txtAction').disabled = false;
		//document.getElementById('slcEmployeeNum').disabled = false;
		//document.getElementById('slcServiceLineStatus').disabled = false;
		//document.getElementById('txtActionDate').disabled = false;
		//document.getElementById('txtFinishDate').disabled = false;
		$("input#hdnOwnershipId").eq(i).prop("disabled", false);
		$("select#slcSparePart").eq(i).prop("disabled", false);
		$("input#txtClaimNum").eq(i).prop("disabled", false);
		$("input#txtWarranty").eq(i).prop("disabled", false);
		$("select#slcProblem").eq(i).prop("disabled", false);
		$("input#txtProblemDescription").eq(i).prop("disabled", false);
		$("input#txtAction").eq(i).prop("disabled", false);
		$("select#slcEmployeeNum").eq(i).prop("disabled", false);
		$("select#slcServiceLineStatus").eq(i).prop("disabled", false);
		$("input#txtActionDate").eq(i).prop("disabled", false);
		$("input#txtFinishDate").eq(i).prop("disabled", false);
		$("select#actionClaim").eq(i).prop("disabled", false);
		$("input#claimImage").eq(i).prop("disabled", false);
	}
}

function checkWarranty(base, i, owner_id) {
	var id = document.getElementById("hdnCustomerId").value;
	var item_id = owner_id;
	$.post(base + "ajax/CheckProductWarranty", { id: id, item_id: item_id }, function (data) {
		$("input#txtWarranty").eq(i).val(data);
	});
}

// function qtyProcessCheck(base,i,owner_id){
// var id = document.getElementById('hdnCustomerId').value;
// var item_id = owner_id;
// $.post(base+"ajax/CheckProductWarranty", {id:id,item_id:item_id}, function(data){
// $("input#txtWarranty").eq(i).val(data);
// });
// }

function getUnit(url) {
	var id = "";
	var cust = $("input#hdnCustomerId").val();

	if (cust == "") {
		$("tbody#result").html("");
	} else {
		//$( "#result" ).html(id);

		$.post("CustomerRelationship/Search/Ownership", { id: id, cust: cust }, function (data) {
			if (data) {
				data = $.parseJSON(data); //change to json array cause data is in string
				var len = data.length;
				var txt = "";
				if (len > 0) {
					for (var i = 0; i < len; i++) {
						if (data[i].segment1 && data[i].item_name) {
							txt += "<tr><td>" + data[i].segment1 + "</td><td>" + data[i].item_name + "</td><td>" + data[i].no_body + "</td><td>" + data[i].no_engine + "</td></tr>";
						}
					}
					/*$.each(data, function(k, v) {
							$.each(v, function(key, value) {
								$('tbody#result').append("<tr><td>"+key+"</td><td>"+value+"</td></tr>");
							})
						})*/
					//alert(JSON.stringify(data[1].segment1));
					alert(txt);
					if (txt != "") {
						$("tbody#result").append(txt);
					}
				}
			}
		});
	}
}

function enadisDriverOwner(base) {
	//pasangan dari 721
	var returnedValue;
	var url = base + "ajax/SearchCategoryDriver";
	$.ajax({
		type: "POST",
		url: url,
		data: { term: $("#txtCategory").val() },
		cache: false,

		success: function (result) {
			//just add the result as argument in success anonymous function
			//$('#txtDescription').val(result) ;
			if (result == "Y") {
				$("select#slcCustOwner").prop("disabled", false);
			} else {
				$("select#slcCustOwner").prop("disabled", true);
			}
			//alert(returnedvalue);
		},
	});

	//$('#txtDescription').val(returnedValue) ;
}

function getLastActivityNumber(base) {
	var returnedValue;
	var url = base + "ajax/GetLastActivityNumber";
	$.ajax({
		type: "POST",
		url: url,
		data: { term: $("#slcActivityType").val() },
		cache: false,

		success: function (result) {
			//just add the result as argument in success anonymous function
			//$('#txtDescription').val(result) ;
			if (result == "call_out") {
				$("input#txtServiceNumber").prop("disabled", false);
			} else {
				//$('input#txtServiceNumber').prop('disabled', true);
				$("input#txtServiceNumber").val(result);
				$("input#txtCustomerName").prop("disabled", false);
				$("#btnSearchCustomer").prop("disabled", false);
			}
			//alert(returnedvalue);
		},
	});

	//$('#txtDescription').val(returnedValue) ;
}

function checkPass() {
	var pass = $("input#txtPassword").val();
	var repass = $("input#txtPasswordCheck").val();
	//var n = $( "input#txtPasswordCheck" ).val().length;
	var o = $("span#statusPass").length;
	//alert(pass);
	//alert(repass);

	if (pass == repass) {
		$("span#statusPass").html("");
		$("#btnUser").prop("disabled", false);
	} else {
		if (o == 0) {
			$("div#divPassCheck").after("<span id='statusPass'><b>Password didn't match.</b></span>");
		} else {
			$("span#statusPass").html("<b>Password didn't match.</b>");
		}
		$("#btnUser").prop("disabled", true);
	}
}

function checkSave() {
	$(".error-save").removeClass("error-save bg-warning-important");
	$("#tbodyUserResponsibility")
		.find("select")
		.each(function () {
			if (($(this).val() === null || $(this).val() === "") && !$(this).parents("tr").hasClass("error-save")) {
				$(this).parents("tr").addClass("error-save bg-warning-important");
			}
		});
	if ($(".error-save").length) {
		$([document.documentElement, document.body]).animate(
			{
				scrollTop: $(".error-save").offset().top - 100,
			},
			500
		);
		Swal.mixin({
			toast: true,
			position: "top-end",
			showConfirmButton: false,
			timer: 3000,
		}).fire({
			customClass: "swal-font-small",
			type: "error",
			title: "Silahkan melengkapi atau menghapus baris data yang masih kosong!",
		});
	} else {
		$("#btnUser").attr({ type: "submit", onclick: "" }).click();
	}
}

$(document).ready(function () {
	//PASANGANNYA linemask
	if ($("#txtType").val() === "HANDPHONE") {
		$("#txtData").mask("099999999999");
	}
	if ($("#txtType").val() === "TELEPHONE") {
		$("#txtData").mask("09999999999999");
	}
	if ($("#txtType").val() === "EMAIL") {
		$("#txtData").mask("A", {
			translation: {
				A: { pattern: /[\w@\-.+]/, recursive: true },
			},
		});
	}
	if ($("#txtType").val() === "PIN BBM") {
		$("#txtData").mask("AAAAAAAA");
	}

	$("input#txtActionDate").datepicker({
		autoclose: true,
	});
	$("input#txtFinishDate").datepicker({
		autoclose: true,
	});
	$("input.datePicker1").datepicker({
		autoclose: true,
		format: "M-yyyy",
		viewMode: "months",
		minViewMode: "months",
	});
	$(".daterange3").daterangepicker({
		format: "D/MM/YYYY",
	});
	/*$('#form-service').bootstrapValidator({
			framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 fields: {
                txtCustomerName: {
                    message: 'The Customer is empty',
                    validators: {
                        notEmpty: {
                            message: 'The Customer is empty'
                        }
                    }
                }
			 }

		});*/

	var base = $("#txtBaseUrl").val();
	var org_id = $("#txtOrgId").val();

	if ($("#hdnCustomerId").val()) {
		var param2 = $("#tblServiceLines tbody tr").length - 1;
		var param3 = $("#hdnCustomerId").val();
		var param1 = base + "ajax/ModalItemLines/" + param2 + "/" + param3;
		$("input#txtOwnership").attr("onfocus", "callModal('" + param1 + "')");

		var id = "";
		var cust = $("input#hdnCustomerId").val();

		if (cust == "") {
			$("tbody#result").html("");
		} else {
			//$( "#result" ).html(id);
			var rowCount = $("#tblCallLines tbody tr").size();
			//alert($("input#txtConnectId").length);
			if (rowCount > 0 && $("input#txtConnectId").length < 1) {
				$("#tblCallLines tbody tr").remove();

				$.post(base + "CustomerRelationship/Search/Ownership", { id: id, cust: cust }, function (data) {
					if (data) {
						data = $.parseJSON(data); //change to json array cause data is in string
						var len = data.length;
						var txt = "";
						if (len > 0) {
							for (var i = 0; i < len; i++) {
								if (data[i].segment1 && data[i].item_name) {
									txt += "<tr><td><input type='text' id='txtOwnership' name='txtOwnership[]' value='" + data[i].segment1 + "' class='form-control' readonly/>" + "<input type='hidden' id='hdnOwnershipId' name='hdnOwnershipId[]' value='" + data[i].customer_ownership_id + "' /></td>" + "<td><input type='text' id='txtItemDescription' name='txtItemDescription[]' value='" + data[i].item_name + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtBody' name='txtBody[]' value='" + data[i].no_body + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtEngine' name='txtEngine[]' value='" + data[i].no_engine + "' class='form-control' readonly/></td>" + "<td><input type='text' id='txtUse' name='txtUse[]' class='form-control'/></td>" + "</tr>";
								}
							}

							$("input#txtUse").keypress(function (eve) {
								if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
									eve.preventDefault();
								}

								// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
								$("input#txtUse").keyup(function (eve) {
									if ($(this).val().indexOf(".") == 0) {
										$(this).val($(this).val().substring(1));
									}
								});
							});

							if (txt != "") {
								$("tbody#result").append(txt);
							}
						}
					}
				});
			}
		}
	}

	$("form select#slcIo").change(function () {
		var io = $("select#slcIo option:selected").val();
		$("select#slcSubInventory").val("").trigger("change");
		$("select#slcToSubInventory").val("").trigger("change");

		if (io == "") {
			$("select#slcSubInventory").prop("disabled", true);
			$("select#slcToSubInventory").prop("disabled", true);
		} else {
			$("select#slcSubInventory").prop("disabled", false);
			$("select#slcToSubInventory").prop("disabled", false);
		}
	});

	$("form#frmDeliveryRequest select#slcRequestType").change(function () {
		var returnedValue;
		var url = base + "InventoryManagement/ajax/GetLastRequestNumber";

		$.ajax({
			type: "POST",
			url: url,
			data: { term: $("#slcRequestType").val() },
			cache: false,

			success: function (result) {
				//just add the result as argument in success anonymous function
				//$('#txtDescription').val(result) ;
				if (result == "call_out") {
					$("input#txtServiceNumber").prop("disabled", false);
				} else {
					//$('input#txtServiceNumber').prop('disabled', true);
					$("input#txtServiceNumber").val(result);
				}
				//alert(returnedvalue);
			},
		});
	});

	if (org_id != 82) {
		$("input#txtContractNumber").prop("readonly", true);
		$("input#txtEmblem").prop("readonly", true);
		$("textarea#txtAllocation").prop("readonly", true);
	}

	if ($("form#frmDeliveryRequest  input#txtDeliveryStatus").length) {
		var status = document.getElementById("txtDeliveryStatus").value;
		if (status != "REQUEST NEW") {
			$("#frmDeliveryRequest :input").prop("disabled", true);
			//BAGAIMANA DISABLE ADD ROW BUTTON AND CLOSE SEWAKTU NEW
			if (status == "REQUEST WAITING APPROVAL") {
				$("input#txtDeliveryRequestNum").prop("disabled", false);
				$("button#btnDeliveryRequestApprovalA").prop("disabled", false);
				$("button#btnLRequestApprovalLine").prop("disabled", false);
			} else if (status == "REQUEST APPROVED") {
				$("button#btnLRequestApprovalLine").prop("disabled", false);
			} else {
				$("button#btnDeliveryRequestApprovalA").prop("disabled", true);
			}
		} else {
			$("button#btnDeliveryRequestApprovalA").prop("disabled", true);
		}
	}

	if ($("form#frmDeliveryRequestComponent  input#txtDeliveryStatus").length) {
		var status = document.getElementById("txtDeliveryStatus").value;
		if (status != "REQUEST NEW") {
			$("#frmDeliveryRequestComponent :input").prop("disabled", true);
			//BAGAIMANA DISABLE ADD ROW BUTTON AND CLOSE SEWAKTU NEW
			// if(status == 'REQUEST WAITING APPROVAL'){
			// $("button#btnComponent").prop("disabled", false);
			// }else{
			// $("button#btnDeliveryRequestApprovalA").prop("disabled", true);
			// }
		}
	}

	if ($("form#frmDeliveryProcess  input#txtDeliveryStatus").length) {
		var status = document.getElementById("txtDeliveryStatus").value;
		if (status === "REQUEST CLOSED") {
			$("#frmDeliveryProcess :input").prop("disabled", true);
			$("button#btnDeliveryRequestComponent").prop("disabled", false);
			$("#txtDeliveryStatus").prop("disabled", false);
		}
	}

	$("#tblComponentDeliveryProcess")
		.find("tr")
		.keyup(function () {
			var row = $(this).index();
			var picked_qty = Number($("input#txtPickedQuantity").eq(row).val());
			var processed_qty = Number($("input#txtProcessedQuantity").eq(row).val());
			var to_process_qty = Number($("input#txtQtyToProcess").eq(row).val());
			if (picked_qty - processed_qty < to_process_qty) {
				alert("Don't insert number more than " + (picked_qty - processed_qty));
				$("input#txtQtyToProcess").eq(row).val("");
			}
		});

	$("#tblComponentDeliveryProcess input#txtBtnExIn").click(function () {
		var type = $("input#txtBtnExIn").val();
		if (type === "External") {
			$("input#txtBtnExIn").val("Internal");
		} else {
			$("input#txtBtnExIn").val("External");
		}
		var n = $("#tblComponentDeliveryProcess tbody tr").length;
		// $("#frmProcessRequestComponent input#txtItem").val(n);
		for (var i = 0; i <= n; i++) {
			$("#frmProcessRequestComponent select#slcLineType").eq(i).val(type);
			// $("#frmProcessRequestComponent input#txtPickedQuantity").eq(i).val("5") ;
		}
		// alert(n);
	});

	$("#frmDeliveryProcess input#txtBtnExIn").click(function () {
		var type = $("input#txtBtnExIn").val();
		if (type === "External") {
			$("input#txtBtnExIn").val("Internal");
		} else {
			$("input#txtBtnExIn").val("External");
		}
		var n = $("#tblDeliveryRequestLinesDeliveryProcess tbody tr").length;
		// $("#frmProcessRequestComponent input#txtItem").val(n);
		for (var i = 0; i <= n; i++) {
			$("#frmDeliveryProcess select#slcLineType").eq(i).val(type);
			// $("#frmProcessRequestComponent input#txtPickedQuantity").eq(i).val("5") ;
		}
		// alert(n);
	});

	//pasangan dari function enadisDriverOwner
	$.ajax({
		type: "POST",
		url: base + "ajax/SearchCategoryDriver",
		data: { term: $("#txtCategory").val() },
		cache: false,

		success: function (result) {
			//just add the result as argument in success anonymous function
			//$('#txtDescription').val(result) ;
			if (result == "Y") {
				$("select#slcCustOwner").prop("disabled", false);
			} else {
				$("select#slcCustOwner").prop("disabled", true);
			}
			//alert(returnedvalue);
		},
	});

	//check addRowSpFaqs too
	$(".faq-descriptions").autocomplete({
		//source:'http://quick.com/quickERPdev/CustomerRelationship/Search/FaqDescription'
		source: function (request, response) {
			$.ajax({
				url: base + "CustomerRelationship/Search/FaqDescription",
				dataType: "json",
				data: {
					term: request.term,
					faq_type: $("#slcFaqType").val(),
				},
				success: function (data) {
					response(data);
				},
			});
		},
		min_length: 2,
	});

	$(".additional-activity").autocomplete({
		source: base + "CustomerRelationship/Search/AdditionalActivity",
	});

	if ($("#txtActivityStatus").length) {
		var status = document.getElementById("txtActivityStatus").value;
		if (status == "CLOSE") {
			$("#form-service :input").prop("disabled", true);
			//BAGAIMANA DISABLE ADD ROW BUTTON AND CLOSE SEWAKTU NEW
		}
	}

	if ($("table#tblServiceLines tr").length) {
		var total_row = $("table#tblServiceLines tr").length - 1;
		//$('input#txtClaimNum').eq(1).val(total_row);
		for (var i = 0; i < total_row; i++) {
			if ($("select#slcServiceLineStatus").eq(i).val() == "CLOSE") {
				//var param3 = $('#hdnCustomerId').val();

				$("input#txtOwnership").eq(i).prop("disabled", true);
				$("input#txtItemDescription").eq(i).prop("disabled", true);
				$("input#txtWarranty").eq(i).prop("disabled", true);
				$("input#txtClaimNum").eq(i).prop("disabled", true);
				$("select#slcSparePart").eq(i).prop("disabled", true);
				$("select#slcProblem").eq(i).prop("disabled", true);
				$("input#txtProblemDescription").eq(i).prop("disabled", true);
				$("input#txtAction").eq(i).prop("disabled", true);
				$("select#slcEmployeeNum").eq(i).prop("disabled", true);
				$("select#slcServiceLineStatus").eq(i).prop("disabled", true);
				$("input#txtActionDate").eq(i).prop("disabled", true);
				$("select#actionClaim").eq(i).prop("disabled", true);
				$("input#claimImage").eq(i).prop("disabled", true);
			}
		}
	}

	if ($("#tblServiceLines").length) {
		var n = $("#tblServiceLines tbody tr").length;
		$("#txtServiceNumber").prop("readonly", true);
	}

	if ($("#slcActivityType").val() != "") {
		$("#slcActivityType").prop("disabled", true);
	}

	if ($("#txtCustomerName").val() != null) {
		if ($("#txtCustomerName").val().length) {
			var n = $("#tblServiceLines tbody tr").length;
			var id = $("#txtCustomerName").val();
			//alert(id);
			//	$('#txtOwnership1').prop('disabled', false);
			if (id != "") {
				for (var i = 1; i <= n; i++) {
					//document.getElementById('txtOwnership'+i).disabled = false;
					$("#txtOwnership").eq(i).prop("disabled", false);
					$("#hdnOwnershipId").eq(i).prop("disabled", false);
				}
			}
		}
	}

	$("#dataTables-customer").DataTable();
	$(".dataTables").DataTable();
	$("#tblUser").DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Blfrtip',
        "buttons" : [
            'excel', 'pdf'
        ],
	});
	$('#tblMenuGroup').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Blfrtip',
        "buttons" : [
            'excel', 'pdf'
        ],
	});
	$('#tblModule').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Blfrtip',
        "buttons" : [
            'excel', 'pdf'
        ],
	});

	$(".jsLineStatus").select2({
		placeholder: "STATUS",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/ServiceLineStatus/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.service_line_status_id,
							text: obj.consecutive_number + " " + obj.service_line_status_name,
						};
					}),
				};
			},
		},
	});

	$(".jsTes").select2();

	$(".jsProblem").select2({
		placeholder: "Problems",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/ServiceProblem",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.service_problem_id,
							text: obj.service_problem_name,
						};
					}),
				};
			},
		},
	});

	$(".jsSparePart").select2({
		allowClear: true,
		placeholder: "By spare part code or spare part name",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/SparePartData/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.item_id,
							text: obj.segment1 + " (" + obj.item_name + ")",
						};
					}),
				};
			},
		},
	});

	$(".jsEmployeeData").select2({
		allowClear: true,
		placeholder: "By employee name or code",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/EmployeeData/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.employee_id,
							text: obj.employee_code + " (" + obj.employee_name + ")",
						};
					}),
				};
			},
		},
	});

	$(".jsServiceNumber").select2({
		//var cust_id = $('input#hdnCustomerId').val();
		placeholder: "Service Number",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/ServiceNumber/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					cust: $("input#hdnCustomerId").val(),
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.service_product_id, text: obj.service_number };
					}),
				};
			},
		},
	});

	$(".jsConnectNumber").select2({
		placeholder: "Connect Number",
		minimumInputLength: 0,
		ajax: {
			//var cust_id = $('input#hdnCustomerId').val();
			url: base + "CustomerRelationship/Search/ConnectNumber/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					cust: $("input#hdnCustomerId").val(),
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.connect_id, text: obj.connect_number };
					}),
				};
			},
		},
	});

	$(".jsContactNumber").select2({
		tags: true,
		//var cust_id = $('input#hdnCustomerId').val();
		placeholder: "Contact Number",
		minimumInputLength: 0,
		ajax: {
			url: base + "ajax/ContactNumber",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					cust: $("input#hdnCustomerId").val(),
					type: $("select#slcContactType").val(),
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.data, text: obj.data };
					}),
				};
			},
		},
	});

	$(".jsAdditionalActivity").select2({
		allowClear: true,
		placeholder: "Additional Activity",
		minimumInputLength: 0,
		ajax: {
			url: base + "CustomerRelationship/Search/AdditionalActivity",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.setup_service_additional_activity_id,
							text: obj.additional_activity,
						};
					}),
				};
			},
		},
	});

	$(".jsCityProvince").select2({
		allowClear: true,
		placeholder: "By area",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/AreaData/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.area_id, text: obj.area_name.toUpperCase() };
					}),
				};
			},
		},
	});

	$(".jsCustomerGroup").select2({
		allowClear: true,
		placeholder: "Customer Group",
		minimumInputLength: 1,
		ajax: {
			url: base + "CustomerRelationship/Search/CustomerGroup",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.customer_group_id,
							text: obj.customer_group_name.toUpperCase(),
						};
					}),
				};
			},
		},
	});

	$(".jsDeliveryItem").select2({
		allowClear: true,
		placeholder: "item",
		minimumInputLength: 1,
		ajax: {
			url: base + "InventoryManagement/Search/DeliveryItem",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.INVENTORY_ITEM_ID,
							text: obj.SEGMENT1 + " - " + obj.DESCRIPTION,
						};
					}),
				};
			},
		},
	});

	$(".jsInvOrg").select2({
		allowClear: true,
		placeholder: "IO",
		minimumInputLength: 1,
		ajax: {
			url: base + "InventoryManagement/Search/InvOrg",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.ORGANIZATION_ID, text: obj.ORGANIZATION_CODE };
					}),
				};
			},
		},
	});

	$(".jsSubInvOrg").select2({
		allowClear: true,
		placeholder: "SubInventory",
		minimumInputLength: 1,
		ajax: {
			url: base + "InventoryManagement/Search/SubIo",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var val = $("select#slcIo option:selected").val() || $("select#slcIoInterOrg option:selected").val();
				var queryParameters = {
					term: params.term,
					term2: val,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.SECONDARY_INVENTORY_NAME,
							text: obj.SECONDARY_INVENTORY_NAME,
						};
					}),
				};
			},
		},
	});

	$(".jsOracleEmployee").select2({
		allowClear: true,
		placeholder: "By employee name or code",
		minimumInputLength: 1,
		ajax: {
			url: base + "InventoryManagement/Search/OracleEmployee/",
			dataType: "json",
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				};
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.PERSON_ID,
							text: obj.NATIONAL_IDENTIFIER + " (" + obj.FULL_NAME + ")",
						};
					}),
				};
			},
		},
	});
});

function sendValueCustomerNoGroup(cust_id, cust_name, cat_id) {
	$("#txtCustomerName").val(cust_name);
	$("#hdnCustomerId").val(cust_id);
	$("#hdnCategoryId").val(cat_id);
}

//------------------money format untuk MoneyFormat----------------\\
$.fn.moneyFormat = function () {
	$(this).each(function () {
		var erpMoneyFormat = $(this).html();
		var fixerpMoneyFormat = parseFloat(erpMoneyFormat)
			.toFixed(0)
			.toString()
			.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		$(this).html(fixerpMoneyFormat + ".00");

		var erpMoneyFormatval = $(this).val();
		var fixerpMoneyFormatval = parseFloat(erpMoneyFormatval)
			.toFixed(0)
			.toString()
			.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		$(this).val(fixerpMoneyFormatval + ".00");
	});
};

$.fn.resetFormat = function () {
	$(this).each(function () {
		var resethtml = $(this).html().split(".", 1);
		var erpResetFormat = resethtml[0].replace(/[\D]/g, "");
		$(this).html(erpResetFormat);

		var resetval = $(this).val().split(".", 1);
		var erpResetFormatval = resetval[0].replace(/[\D]/g, "");
		$(this).val(erpResetFormatval);
	});
};
