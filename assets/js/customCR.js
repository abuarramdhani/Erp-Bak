//---------------------------------CLAIMS EXTERNAL.begin-------------------------------
$(document).ready(function() {
    //--------------------------------DATA TABLE-------------------------------------
    function datatable() {
        $('#tbNewClaim').DataTable({
            "aoColumns": [ 
                null, // id
                null, // product
                null, // another column
                null, // another column
                null, // another column
                {
                    "bSortable": false,
                    "bVisible": true
                }, //action column
            ],
        });
        $('#tbClosedClaim').DataTable({
            "aoColumns": [ 
                null, // id
                null, // product
                null, // another column
                null, // another column
                null, // another column
                {
                    "bSortable": false,
                    "bVisible": true
                }, //action column
            ],
        });
        $('#tbOverClaim').DataTable({
            "aoColumns": [ 
                null, // id
                null, // product
                null, // another column
                null, // another column
                null, // another column
                {
                    "bSortable": false,
                    "bVisible": true
                }, //action column
            ],
        });
        $('#tbApprovedClaim').DataTable({
            "aoColumns": [ 
                null, // id
                null, // product
                null, // another column
                null, // another column
                null, // another column
                {
                    "bSortable": false,
                    "bVisible": true
                }, //action column
            ],
        });
    };
    //--------------------------------JAVASCRIPT OnCLICK-------------------------------------
    $('#newClaims').click(function() {
        $.ajax({
            url: baseurl + "SalesOrder/BranchApproval/NewClaims",
            success: function(result) {
                $('#showClaimsData').html(result);
                datatable();
            }
        })
    });
    $('#claimApproved').click(function() {
        $.ajax({
            url: baseurl + "SalesOrder/BranchApproval/ClaimApproved",
            success: function(result) {
                $('#showClaimsData').html(result);
                datatable();
            }
        })
    });
    $('#centralApproved').click(function() {
        $.ajax({
            url: baseurl + "SalesOrder/CentralApproval/ClaimApproved",
            success: function(result) {
                $('#showClaimsData').html(result);
                datatable();
            }
        })
    });
    $('#over24Hour').click(function() {
        $.ajax({
            url: baseurl + "SalesOrder/BranchApproval/Over24Hour",
            success: function(result) {
                $('#showClaimsData').html(result);
                datatable();
            }
        })
    });
    $('#ClaimClosed').click(function() {
        $.ajax({
            url: baseurl + "SalesOrder/BranchApproval/ClaimClosed",
            success: function(result) {
                $('#showClaimsData').html(result);
                datatable();
            }
        })
    });
    $('#provinceIncident').change(function() {
        var value = $('#provinceIncident').val();
        $.ajax({
            type: 'POST',
            data: {
                data_name: value,
                modul: 'CityRegency'
            },
            url: baseurl + "CustomerRelationship/ServiceProducts/Location",
            success: function(result) {
                $('#CityIncident').prop('disabled', false).html(result);
            }
        });
    });
    $('#CityIncident').change(function() {
        var value = $('#CityIncident').val();
        $.ajax({
            type: 'POST',
            data: {
                data_name: value,
                modul: 'District'
            },
            url: baseurl + "CustomerRelationship/ServiceProducts/Location",
            success: function(result) {
                $('#DistrictIncident').prop('disabled', false).html(result);
            }
        });
    });
    $('#DistrictIncident').change(function() {
        var value = $('#DistrictIncident').val();
        $.ajax({
            type: 'POST',
            data: {
                data_name: value,
                modul: 'Village'
            },
            url: baseurl + "CustomerRelationship/ServiceProducts/Location",
            success: function(result) {
                $('#VillageIncident').prop('disabled', false).html(result);
            }
        });
    });

    function datepick() {
        $('#sentDate').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "showDropdowns": false,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            },
        });
    };
    $('#claimsItem1').click(function() {
        $.ajax({
            url: baseurl + "CustomerRelationship/ServiceProducts/shipped",
            success: function(result) {
                $('#showClaimsItem').html(result);
                datepick();
            }
        })
    });
    $('#claimsItem2').click(function() {
        $('#loadAjax').show();
        document.getElementById("showClaimsItem").innerHTML = '<div class="form-group"><label>Reason Can Not be Sent</label><input type="text" class="form-control" name="reason" placeholder="Reason Can Not be Sent" data-toggle="tooltip" data-placement="top" title="Masukkan alasan barang tidak dapat dikirim" required></div>';
    });
    $('#claimsItem3').click(function() {
        $('#loadAjax').show();
        document.getElementById("showClaimsItem").innerHTML = '<p style="text-align:center;"><strong>- No Evidence for The Claim -</strong></p>';
    });
    $('#start').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#end').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    /*$('#slcBranchApproval').change(function(){
        var value = $('#slcBranchApproval').val();
        $.ajax({
            type:'POST',
            data:{'value':value},
            url:baseurl+"CustomerRelationship/Setting/ApprovalClaim/Employee",
            success:function(result)
            {
                $('#slcEmployeeApproval').prop('disabled',false).html(result);
            }
        });
    });*/
    if ($('#approvedis').val() != "" && $('#approvedis').val() !== "NOT APPROVED 1" && $('#approvedis').val() !== "NOT APPROVED 2") {
        $('select[name="officer"]').prop("disabled", true);
        $('#serviceDate').prop("disabled", true);
        $('#slcConnectNum').prop("disabled", true);
        $('#Description').prop("disabled", true);
        $('#QtyClaim').prop("disabled", true);
        $('#durationUse').prop("disabled", true);
        $('#durationUseType').prop("disabled", true);
        $('#claimsItem1').prop("disabled", true);
        $('#claimsItem2').prop("disabled", true);
        $('#claimsItem3').prop("disabled", true);
        $('#sentDate').prop("disabled", true);
        $('#reason').prop("disabled", true);
        $('#provinceIncident').prop("disabled", true);
        $('#CityIncident').prop("disabled", true);
        $('#DistrictIncident').prop("disabled", true);
        $('#VillageIncident').prop("disabled", true);
        $('#AddressIncident').prop("disabled", true);
        $('input[name="area[]"]').prop("disabled", true);
        $('input[name="Soil[]"]').prop("disabled", true);
        $('input[name="Depth[]"]').prop("disabled", true);
        $('input[name="Weeds[]"]').prop("disabled", true);
        $('input[name="Topography[]"]').prop("disabled", true);
        $('textarea[name="Chronology"]').prop("disabled", true);
        $('#addDelService1').hide();
        $('#addDelService2').hide();
        $('#addDelService3').hide();
        $('input[name="txtOwnership[]"]').prop("disabled", true);
        $('input[name="txtClaimNum[]"]').prop("disabled", true);
        $('select[name="slcSparePart[]"]').prop("disabled", true);
        $('select[name="slcProblem[]"]').prop("disabled", true);
        $('input[name="txtProblemDescription[]"]').prop("disabled", true);
        $('input[name="txtAction[]"]').prop("disabled", true);
        $('select[name="slcEmployeeNum[]"]').prop("disabled", true);
        $('select[name="slcServiceLineStatus[]"]').prop("disabled", true);
        $('input[name="txtActionDate[]"]').prop("disabled", true);
        $('select[name="actionClaim[]"]').prop("disabled", true);
    }
    $('input[name="approveval"]').change(function() {
        if ($(this).val() == 'N') {
            $('#reasonnotapprove').html('<div class="form-group"><label>Reason Not Approved</label><textarea rows="2" class="form-control" name="reasonnotapprove" placeholder="Reason Not Approved" required></textarea></div>');
        } else {
            $('#reasonnotapprove').html('');
        }
    });
    $('#serviceDate').datepicker({
        autoclose: true,
    });
});

function fineuploader() {
    var uploader = new qq.FineUploader({
        debug: true,
        element: document.getElementById('fine-uploader-manual-trigger'),
        template: 'qq-template-manual-trigger',
        request: {
            endpoint: baseurl + 'CustomerRelationship/ServiceProducts/UploadImage'
        },
        callbacks: {
            onAllComplete: function() {
                $.ajax({
                    url: baseurl + 'CustomerRelationship/ServiceProducts/getImageData',
                    success: function(result) {
                        $('#modalContent').html(result);
                    }
                });
            }
        }
    });
}
checkcustomer();

function checkcustomer() {
    var CustomerName = $('#hdnCustomerId').val();
    if (CustomerName == "" || CustomerName == null) {
        $('#cust-message').show();
        $('#fine-uploader-manual-trigger').hide();
    } else {
        $('#cust-message').hide();
        fineuploader();
        $('#fine-uploader-manual-trigger').show();
    }
}

function setCustIdSession(cust_id) {
    $.ajax({
        type: "POST",
        url: baseurl + 'CustomerRelationship/ServiceProducts/getCustVal',
        data: {
            id: cust_id
        },
        cache: false,
        success: function(result) {
            //alert(result);
        }
    });
}

function modalImg(s) {
    var id = $(s).closest('tr').find('#claimImage').attr('row-id');
    var ownerId = $(s).closest('tr').find('#hdnOwnershipId').val();
    $('#owner_id').val(ownerId);
    $('#line_id').val(id);
    $('#modalImg').modal();
}

function checkThis(id) {
    if ($('#img' + id).hasClass('img-selected')) {
        $('#' + id).attr('disabled', true);
        $('#img' + id).removeClass(' img-selected');
    } else {
        $('#' + id).attr('disabled', false);
        $('#img' + id).addClass(' img-selected');
    }
}

function chooseImage(url) {
    $.ajax({
        type: "POST",
        url: url,
        data: $('#formImg').serialize(),
        cache: false,
        success: function(result) {
            $('input[id="claimImageData"][row-id="' + $('#line_id').val() + '"]').val(result);
            $('input[name="imgLineSelect[]"]').attr('disabled', true);
            $('.img-responsive').removeClass('img-selected');
            $('#modalImg').modal('hide');
        }
    });
}

function chooseImageUpdate(url) {
    $.ajax({
        type: "POST",
        url: url,
        data: $('#formImg').serialize(),
        cache: false,
        success: function(result) {
            $('input[id="claimImageData"][row-id="' + $('#line_id').val() + '"]').val(result);
            $('#modalImgUpdate').modal('hide');
        }
    });
}

function modalImgUpdate(m) {
    var rowId = $(m).closest('tr').find('#claimImage').attr('row-id');
    var ownerId = $(m).closest('tr').find('#hdnOwnershipId').val();
    var selected = $(m).closest('tr').find('#claimImageData').val();
    var serviceNumb = $('#txtServiceNumber').val();
    $('#owner_id').val(ownerId);
    $('#line_id').val(rowId);
    $.ajax({
        type: 'POST',
        data: {
            selected: selected,
            serviceNumb: serviceNumb
        },
        url: baseurl + 'CustomerRelationship/ServiceProducts/getImageDataUpdate',
        cache: false,
        success: function(result) {
            if (result == 0) {
                $('#formImg').submit(function(e) {
                    e.preventDefault();
                });
                $('#btnChooseImg').prop('disabled', true);
                $('#modalContent').html('<div id="modalImg-content"><div class="text-center" id="modalImg-message"><b><p>You have not uploaded any images.</p></b><h3>Please do upload a picture in the upload menu header.</h3></div></div>');
            } else {
                $('#modalContent').html(result);
            }
            $('#modalImgUpdate').modal();
        }
    });
}
//---------------------------------CLAIMS EXTERNAL.end---------------------------------