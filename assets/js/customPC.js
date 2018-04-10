// ---- Custom JS Product Cost ----
$('table.datatable-default').dataTable({
    dom: 'frtip'
});
$('table#tblBppbgAccount').dataTable({
    dom: 'rtip'
});
$('table#tblBppbgCategory').dataTable({
	dom: 'Bfrtip',
    buttons: [{
        extend: 'excel',
        exportOptions: {
            columns: [0, 2, 3, 4]
        },
        title: 'Bppbg_Category_' + (new Date()).getFullYear()
    }, {
        extend: 'pdf',
        exportOptions: {
            columns: [0, 2, 3, 4]
        },
        title: 'Bppbg_Category_' + (new Date()).getFullYear(),
        orientation: 'landscape'
    }]
});
$('form#searchBppbgAccountArea').submit(function (event) {
	event.preventDefault();
	$.ajax({
		type: 'post',
		url: baseurl+'ProductCost/Ajax/getBppbgAccount',
		data: $('form#searchBppbgAccountArea').serialize(),
        beforeSend: function() {
            $('div#loadingArea').html('<div style="text-align: center; width: 100%; height: 100%; vertical-align: middle;">' + '<img src="' + baseurl + 'assets/img/gif/loading13.gif" style="display: block; margin: auto; width: auto;">' + '</div>');
            $('#tblBppbgAccount').DataTable().destroy();
            $('div#tblBppbgAccountArea').empty();
        },
        success: function(result) {
            $('div#loadingArea').empty();
            $('div#tblBppbgAccountArea').html(result);
            $('#tblBppbgAccount').DataTable({
                dom: 'rtip'
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('div#loadingArea').empty();
            $.toaster(textStatus+' | '+errorThrown, 'Error', 'danger');
            $('div#tbMemoArea').html();
        }
	});
});
$('.checking-database-account').change(function (event) {
    var value = $(this).val();
    var id = $(this).attr('name');
    $.ajax({
        type: 'post',
        url: baseurl+'ProductCost/Ajax/checkingAccount',
        data: {
            value:value,
            field:id
        },
        beforeSend: function() {
            $('span#'+id).html('<i class="fa fa-circle-o-notch fa-pulse"></i>');
            if ($('span#'+id).hasClass('bg-green')) {
                $('span#'+id).removeClass(' bg-green')
            }
        },
        success: function(result) {
            if (result==0) {
                $('span#'+id).html('<i class="fa fa-check"></i>');
                $('span#'+id).addClass(' bg-green');
                $('span#'+id).attr('data-original-title', 'Data not Exist!');
                $('input[name="'+id+'_checkout"]').val('1');
            }else{
                $('span#'+id).html('<i class="fa fa-close"></i>');
                $('span#'+id).addClass(' bg-red');
                $('span#'+id).attr('data-original-title', 'Data Already Exist!');
                $('input[name="'+id+'_checkout"]').val('0');
            }

            // ---- enable / disable button submit ----
                var c1 = $('input[name="using_category_code_checkout"]').val();
                var c2 = $('input[name="cost_center_checkout"]').val();
                var c3 = $('input[name="account_number_checkout"]').val();

                if (c1=='1' || c2=='1' || c3=='1') {
                    $('button#bAccountSubmitBtn').attr('disabled',false);
                }else{
                    $('button#bAccountSubmitBtn').attr('disabled',true);
                }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('span#'+id).html('<i class="fa fa-close"></i>');
            $.toaster(textStatus+' | '+errorThrown, 'Error', 'danger');
        }
    });
});
function deleteBppbgAccount(th,id) {
    $('#deleteBppbgAccountModal #ba_number').html($(th).closest('tr').find('td.col-numb').attr('data-number'));
    $('#deleteBppbgAccountModal #ba_ucc').html($(th).closest('tr').find('td.col-ucc').attr('data-ucc'));
    $('#deleteBppbgAccountModal #ba_uc').html($(th).closest('tr').find('td.col-uc').attr('data-uc'));
    $('#deleteBppbgAccountModal #ba_cc').html($(th).closest('tr').find('td.col-cc').attr('data-cc'));
    $('#deleteBppbgAccountModal #ba_ccd').html($(th).closest('tr').find('td.col-ccd').attr('data-ccd'));
    $('#deleteBppbgAccountModal #ba_an').html($(th).closest('tr').find('td.col-an').attr('data-an'));
    $('#deleteBppbgAccountModal #ba_a').html($(th).closest('tr').find('td.col-aa').attr('data-aa'));
    $('#deleteBppbgAccountModal #btnDelAction').attr('href', baseurl+'ProductCost/BppbgAccount/delete/'+id);
    $('#deleteBppbgAccountModal').modal('show');
}
function editBppbgCategory(th,id) {
    $('#editBppbgCategoryModal input[name="category_code"]').val($(th).closest('tr').find('td.c_ucc').attr('data-ucc'));
    $('#editBppbgCategoryModal input[name="category_description"]').val($(th).closest('tr').find('td.c_ucd').attr('data-ucd'));
    $('#editBppbgCategoryModal textarea[name="general_description"]').html($(th).closest('tr').find('td.c_gd').attr('data-gd'));
    $('#editBppbgCategoryModal #editBppbgCategoryForm').attr('action', baseurl+'ProductCost/BppbgCategory/edit/'+id);
    $('#editBppbgCategoryModal').modal('show');
}
function deleteBppbgCategory(th,id) {
    $('#deleteBppbgCategoryModal #bc_number').html($(th).closest('tr').find('td.c_number').attr('data-number'));
    $('#deleteBppbgCategoryModal #bc_ucc').html($(th).closest('tr').find('td.c_ucc').attr('data-ucc'));
    $('#deleteBppbgCategoryModal #bc_uc').html($(th).closest('tr').find('td.c_ucd').attr('data-ucd'));
    $('#deleteBppbgCategoryModal #bc_gd').html($(th).closest('tr').find('td.c_gd').attr('data-gd'));
    $('#deleteBppbgCategoryModal #btnDelAction').attr('href', baseurl+'ProductCost/BppbgCategory/delete/'+id);
    $('#deleteBppbgCategoryModal').modal('show');
}
function slcCostCenter() {
    $('#slcCostCenterModal').modal('show');
}
function slcBppbgCategory() {
    $('#slcBppbgCategoryModal').modal('show');
}
function slcCostCenterProceed(cc, ccd) {
    $('input[name="cost_center"]').attr('value', cc);
    $('input[name="cost_center_description"]').val(ccd);
    $('#slcCostCenterModal').modal('hide');
    $('input[name="cost_center"].checking-database-account').trigger("change");
}
function slcBppbgCategoryProceed(cc, cd) {
    $('input[name="using_category_code"]').attr('value', cc);
    $('input[name="using_category"]').val(cd);
    $('#slcBppbgCategoryModal').modal('hide');
    $('input[name="using_category_code"].checking-database-account').trigger("change");
}