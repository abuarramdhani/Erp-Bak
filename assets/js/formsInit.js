function formInit() {
    "use strict";

	$('#myModal').on('hidden.bs.modal', function () {
		 $(this).removeData('bs.modal');
	});
		
	$('.validator').bootstrapValidator({
			framework: 'bootstrap',
			excluded: ':disabled',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			}
		});
		
	$('.toupper').keyup(function(){
		this.value = this.value.toUpperCase();
	  });
	  
	$('.noinput').keyup(function(e){
		 e.preventDefault();
	  });
  
    $('.with-tooltip').tooltip({
        selector: ".input-tooltip"
    });
	
    /*----------- BEGIN autosize CODE -------------------------*/
    $('#autosize').autosize();
    /*----------- END autosize CODE -------------------------*/

    /*----------- BEGIN inputlimiter CODE -------------------------*/
    $('#limiter').inputlimiter({
        limit: 140,
        remText: 'You only have %n character%s remaining...',
        limitText: 'You\'re allowed to input %n character%s into this field.'
    });
    /*----------- END inputlimiter CODE -------------------------*/

    /*----------- BEGIN tagsInput CODE -------------------------*/
    $('#tags').tagsInput();
    /*----------- END tagsInput CODE -------------------------*/

    /*----------- BEGIN chosen CODE -------------------------*/

	
	$('.validator').bootstrapValidator({
			framework: 'bootstrap',
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				txtDescription: {
					validators: {
						notEmpty: {
							message: 'The login access is required and cannot be empty'
						},
						stringLength: {
							max: 500,
							message: 'The password must be less than 500 characters long'
						}
					}
				}
			}
	});
	/*
	$('#form-service').bootstrapValidator({
			
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 fields: {
                txtServiceNumber: {
                   validators: {
                        notEmpty: {
                            message: 'The txtDescription is required and can\'t be empty'
                        }
                    }
                }
			 }
		
	});
	
	$(".select2").select2({
			  placeholder: "Please select from the list",
			  allowClear : true
	});
	
	$(".select2-disabled").select2({
			  placeholder: "Please select from the list",
			  allowClear : true
	});
	$(".select2-disabled").prop("disabled", true);
	
	$(".select-rusak").select2({
			allowClear : true,
			placeholder: "By damage"
	});
	
	$(".select3").select2({
			allowClear : true
	});
	*/
	$(".select4").select2({
			placeholder: "Choose Option",//add placeholder kosong karena allowclear tidak bisa jalan tanpa placeholder
			allowClear : true,
	});
	
	var base = $('#txtBaseUrl').val();
	
	$(".sp-code").select2({
		allowClear : true,
		placeholder: "By spare part code or spare part name",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/SparePartData/",
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
								return { id:obj.segment1, text:obj.segment1 +" ("+obj.item_name+")" };
							})
						};
					}
			}
 
	});
	
	$(".sp-name").select2({
		allowClear : true,
		placeholder: "By sparepart name",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/SparePartNameData/",
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
								return { id:obj.segment1, text:obj.item_name };
							})
						};
					}
			}
 
	});
	
	$(".sp-data").select2({
		allowClear : true,
		placeholder: "By sparepart name",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/SparePartData/",
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
								return { id:obj.item_id, text:obj.segment1 +" ("+obj.item_name+")" };
							})
						};
					}
			}
 
	});
	
	$(".item-name").select2({
		allowClear : true,
		placeholder: "By item code or item name",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/ItemData/",
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
								return { id:obj.item_id, text:obj.segment1 +" ("+obj.item_name+")" };
							})
						};
					}
			}
 
	});
	
	$(".body-number").select2({
		allowClear : true,
		placeholder: "By body number",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/BodyNumberData/",
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
								return { id:obj.no_body, text:obj.no_body };
							})
						};
					}
			}
 
	});
	
	$(".engine-number").select2({
		allowClear : true,
		placeholder: "By engine number",
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/EngineNumberData/",
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
								return { id:obj.no_engine, text:obj.no_engine };
							})
						};
					}
			}
 
	});
	
	$(".buying-type").select2({
		allowClear : true,
		placeholder: "By buying type", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/BuyingTypeData/",
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
								return { id:obj.buying_type_name, text:obj.buying_type_name };
							})
						};
					}
			}
 
	});
	
	$(".area-data").select2({
		allowClear : true,
		placeholder: "By area", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/AreaData/",
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
								return { id:obj.area_id+"_"+obj.province+"_"+obj.city_regency, text:obj.area_name.toUpperCase() };
							})
						};
					}
			}
 
	});
	
	
	$(".city-data").select2({
		allowClear : true,
		placeholder: "By city", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/CityData/",
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
								return { id:obj.city_regency_id, text:obj.regency_name.toUpperCase() };
							})
						};
					}
			}
 
	});
	
	
	$(".province-data").select2({
		allowClear : true,
		placeholder: "By province", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/ProvinceData/",
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
								return { id:obj.province_id, text:obj.province_name.toUpperCase() };
							})
						};
					}
			}
 
	});
	
	$(".district-data").select2({
		allowClear : true,
		placeholder: "By district", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/DistrictData/",
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
								return { id:obj.area_name, text:obj.area_name.toUpperCase() };
							})
						};
					}
			}
 
	});
	
	$(".village-data").select2({
		allowClear : true,
		placeholder: "By village", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/VillageData/",
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
								return { id:obj.area_name, text:obj.area_name };
							})
						};
					}
			}
 
	});
	
	$(".owner-name").select2({
		allowClear : true,
		placeholder: "By owner name", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/OwnerNameData/",
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
								return { id:obj.customer_name, text:obj.customer_name };
							})
						};
					}
			}
 
	});
	
	$(".employee-data").select2({
		allowClear : true,
		placeholder: "By employee name or code", 
		minimumInputLength: 1,
		ajax: {
					url: base+"CustomerRelationship/Search/EmployeeData/",
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
								return { id:obj.employee_id, text:obj.employee_code +" ("+obj.employee_name+")" };
							})
						};
					}
			}
 
	});
	
	$(".js-tes").select2({
		placeholder: "STATUS",
		minimumInputLength: 0,
		ajax: {
					url: base+"CustomerRelationship/Search/ServiceLineStatus/",
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
	
	$(".js-problem").select2({
		placeholder: "Problems",
		minimumInputLength: 0,
		ajax: {
					url: base+"CustomerRelationship/Search/ServiceProblem",
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
								return { id:obj.service_problem_id, text:obj.service_problem_name };
							})
						};
					}
			}
 
	});
	
	$(".js-cs").chosen({
		placeholder: "STATUS",
		minimumInputLength: 0,
		ajax: {
					url: base+"CustomerRelationship/Search/ServiceProblem",
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
								return { id: obj.service_line_status_id, text: obj.consecutive_number+" "+obj.service_line_status_name };
							})
						};
					}
			}
 
	});
		
    $(".chzn-select").chosen();
    $(".chosen").chosen();
    $(".chzn-select-deselect").chosen({
        allow_single_deselect: true
    });
    /*----------- END chosen CODE -------------------------*/

    /*----------- BEGIN spinner CODE -------------------------*/

    $('#spin1').spinner();
    $("#spin2").spinner({
        step: 0.01,
        numberFormat: "n"
    });
    $("#spin3").spinner({
        culture: 'en-US',
        min: 5,
        max: 2500,
        step: 25,
        start: 1000,
        numberFormat: "C"
    });
    /*----------- END spinner CODE -------------------------*/

    /*----------- BEGIN uniform CODE -------------------------*/
    $('.uniform').uniform();
    /*----------- END uniform CODE -------------------------*/

    /*----------- BEGIN validVal CODE -------------------------*/
    $('#validVal').validVal();
    /*----------- END validVal CODE -------------------------*/

    /*----------- BEGIN colorpicker CODE -------------------------*/
    $('#cp1').colorpicker({
        format: 'hex'
    });
    $('#cp2').colorpicker();
    $('#cp3').colorpicker();
    $('#cp4').colorpicker().on('changeColor', function (ev) {
        $('#colorPickerBlock').css('background-color', ev.color.toHex());
    });
    /*----------- END colorpicker CODE -------------------------*/

    /*----------- BEGIN datepicker CODE -------------------------*/
    $('#dp1').datepicker({
        format: 'mm-dd-yyyy'
    });
    $('#dp2').datepicker({
		autoclose: true,
		// format: 'yyyy-mm-dd'
	});
    $('#dp3').datepicker({
		 autoclose: true,
	});
    $('#dp6').datepicker({
		 autoclose: true,
	});
    $('#dp7').datepicker({
		 autoclose: true,
	});
    $('#dp8').datepicker({
		 autoclose: true,
	});
    $('#dp9').datepicker({
		 autoclose: true,
	});
    $('#dp10').datepicker({
		 autoclose: true,
	});
    $('#dp11').datepicker({
		 autoclose: true,
	});
    $('#dp12').datepicker({
		 autoclose: true,
	});
	
	 $('.datepicker').datepicker({
		 autoclose: true,
		 
	});
	
	$('.datepickermonth').datepicker({
		 autoclose: true,
		 format: "M yyyy",
		viewMode: "months", 
		minViewMode: "months"
		 
	});
    
	
	
	$('.datepicker').datepicker({
		 autoclose: true,
	});
	
	$('select#txtActionDate').datepicker({
			autoclose: true,
	});
		
    $('#dpYears').datepicker();
    $('#dpMonths').datepicker();
	/*
	$('#txtActionDate1').datepicker({
		 autoclose: true,
	});
	*/
$( "#txtCustomerName" ).change(function() {
	var id = document.getElementById('txtCustomerName').value;
	var n = $('#tblServiceLines tbody tr').length;
	if(id == ''){
		document.getElementById('hdnCategoryId').value = '';
		document.getElementById('hdnCustomerId').value = '';
	}
	/*
	id = document.getElementById('hdnCustomerId').value;
	
	for(var i=1;i<=n;i++){
			if(id == ''){
					document.getElementById('txtOwnership'+i).value = '';
					document.getElementById('hdnOwnershipId'+i).value = '';
					document.getElementById('txtItemDescription'+i).value = '';
					document.getElementById('txtWarranty'+i).value = '';
					document.getElementById('txtOwnership'+i).disabled = true;	
			}
			else{			
					document.getElementById('txtOwnership'+i).disabled = false;	
			}
		}	
	 */
	 
});

/* $( "#hdnCustomerId" ).change(function() {
		var id = document.getElementById('hdnCategoryId').value;
		alert(id);
		var n = $('#tblServiceLines tbody tr').length;
		document.getElementById('txtOwnership1').disabled = false;
		if(id == ''){
				for(i=1;i<=n;i++){
					document.getElementById('txtOwnership'+i).value = '';
					document.getElementById('txtOwnership'+i).disabled = true;
				}			
			}
			else{			
				for(i=1;i<=n;i++){
					document.getElementById('txtOwnership'+i).disabled = false;
				}		
			}
		});*/
	
	
	
	//for(var p=1;p<=100;p++){
		$('#txtActionDate').datepicker({
		 autoclose: true,
	});
		$('#txtFinishDate').datepicker({
		 autoclose: true,
	});
	//}

    var startDate = new Date(2012, 1, 20);
    var endDate = new Date(2012, 1, 25);
    $('#dp4').datepicker()
            .on('changeDate', function (ev) {
                if (ev.date.valueOf() > endDate.valueOf()) {
                    $('#alert').show().find('strong').text('The start date can not be greater then the end date');
                } else {
                    $('#alert').hide();
                    startDate = new Date(ev.date);
                    $('#startDate').text($('#dp4').data('date'));
                }
                $('#dp4').datepicker('hide');
            });
    $('#dp5').datepicker()
            .on('changeDate', function (ev) {
                if (ev.date.valueOf() < startDate.valueOf()) {
                    $('#alert').show().find('strong').text('The end date can not be less then the start date');
                } else {
                    $('#alert').hide();
                    endDate = new Date(ev.date);
                    $('#endDate').text($('#dp5').data('date'));
                }
                $('#dp5').datepicker('hide');
            });
    /*----------- END datepicker CODE -------------------------*/

    /*----------- BEGIN daterangepicker CODE -------------------------*/
    $('#reservation').daterangepicker({
		 format: 'D/MM/YYYY'
	});
	
	$('.daterange').daterangepicker({
		 format: 'D/MM/YYYY'
	});
	
	 $('#txtbyrangesoldunit').daterangepicker({
		 format: 'D/MM/YYYY'
	});

    /*$('#reportrange').daterangepicker(
			
            {
				format: 'D/MMM/YYYY',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                }
            },
    function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    );
	
	$('.daterangewithchoice').daterangepicker(
            {
                format: 'MMMM YYYY',
				viewMode: "months", 
				minViewMode: "months",
				ranges: {
					'1 Year After': [moment().startOf('month'), moment().add('month', 12).endOf('month')],
                    '6 Month After': [moment().startOf('month'), moment().add('month', 6).endOf('month')],
                    '6 Month Before': [moment().subtract('month', 6).startOf('month'), moment().endOf('month')],
                    '1 Year Before': [moment().subtract('month', 12).startOf('month'), moment().endOf('month')]
                }
            },
    function (start, end) {
        $('daterangewithchoice span').html(start.format('MMM, YYYY') + ' - ' + end.format('MMM, YYYY'));
    }
    );*/
    /*----------- END daterangepicker CODE -------------------------*/

    /*----------- BEGIN timepicker CODE -------------------------*/
    $('.timepicker-default').timepicker();

    $('.timepicker-24').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });
    /*----------- END timepicker CODE -------------------------*/

    /*----------- BEGIN toggleButtons CODE -------------------------*/
    // Resets to the regular style
    $('#dimension-switch').bootstrapSwitch('setSizeClass', '');
    // Sets a mini switch
    $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-mini');
    // Sets a small switch
    $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-small');
    // Sets a large switch
    $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-large');
    /*----------- END toggleButtons CODE -------------------------*/

    /*----------- BEGIN dualListBox CODE -------------------------*/
    $.configureBoxes();
    /*----------- END dualListBox CODE -------------------------*/
}