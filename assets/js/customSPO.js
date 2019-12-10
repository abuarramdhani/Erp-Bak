$(document).ready(function(){

    var EnglishMessageFormat =                 
    '\
        <div style="  font-family: Times New Roman, Times, serif;">\
            <p>Dear Mr./Ms.,</p>\
                <br>\
            <p>\
                Hereby we attached our Purchase Order (PO), please confirm your abilty to supply <b> by copying the template\
                below as a reply</b> to this email no later than <b>1x24 hours </b>and please provide invoice to process the\
                payment.\
            </p>\
            <p>Templates (copied from <b>"PO Confirmation"</b> to <b>"Signature Name")</b> : </p>\
            <p>\
                <b>PO CONFIRMATION</b> : <em>(Corresponding PO number)</em><br>\
                <b>UNIT PRICE </b>: <em>(OK / NOT OK)</em><br>\
                <b>QUANTITY</b> : <em>(OK / NOT OK)</em><br>\
                <b>RECEIVED DATE</b> : <em>(OK / NOT OK)</em><br>\
                <b>SHIP TO LOCATION</b> : <em>(OK / NOT OK)</em><br>\
                <b>VENDOR DATA</b> : <em>(OK / NOT OK)</em><br>\
                <b>SIGNATURE NAME</b> : <em>(Name and Position of PIC of Vendor)<br></em>\
            </p>\
            <p>\
                Please notice that the date that is filled as <b>"Date Received" </b>in the Purchase Order (PO) is <b>\
                Estmated Arrival Time date</b> at specified destination as written in Purchase Order.\
            </p>\
                <br>\
            <p>Thank you for your cooperation.</p>\
                <br>\
            <p>\
                Regards,<br>\
                Ms. Rika<br>\
                Admin Purchasing<br>\
                <b>CV Karya Hidup Sentosa (QUICK)</b><br>\
                Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
                Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 211<br>\
                Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>\
                Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>\
            </p>\
        </div>\
    ';

    var IndonesiaMessageFormat =
    '\
    <div style="  font-family: Times New Roman, Times, serif;">\
        <p>Selamat Siang,</p>\
            <br>\
        <p>\
            Terlampir Purchase Order (PO) dan Pedoman Kerjasama Vendor dari kami, dimohon konfirmasi kesanggupan <b>\
            dengan menyalin template balasan dibawah ini kemudian mengirim balik</b> ke alamat email ini \
            selambat-lambatnya <b>1x24 jam </b>sejak email ini diterima.\
        </p>\
        <p>Template Balasan (disalin dari <b>"PO Confirmation"</b> hingga <b>"Sign Name")</b> : </p>\
        <p>\
            <b>PO CONFIRMATION</b> : <em>(diisi dengan nomor PO terkait)</em><br>\
            <b>UNIT PRICE </b>: <em>(diisi OK/NOT OK)</em><br>\
            <b>QUANTITY</b> : <em>(diisi OK/NOT OK)</em><br>\
            <b>RECEIVED DATE</b> : <em>(diisi OK/NOT OK)</em><br>\
            <b>SHIP TO LOCATION</b> : <em>(diisi OK/NOT OK)</em><br>\
            <b>VENDOR DATA</b> : <em>(diisi OK/NOT OK)</em><br>\
            <b>SIGN NAME</b> : <em>(diisi Nama dan Jabatan penerima dan konfirmasi PO)<br></em>\
        </p>\
        <p>\
            Mohon perhatiannya, bahwa tanggal yang tercantum sebagai <b>"Received Date" </b>pada Purchase Order \
            (PO) adalah <b>tanggal diterimanya barang/jasa terkait di alamat tujuan </b>(Gudang Tujuan) yang ditentukan/\
            dituliskan pada masing-masing Purchase Order.\
        </p>\
            <br>\
        <p>Terima kasih atas kerjasamanya</p>\
            <br>\
        <p>\
            Salam,<br>\
            Ms. Rika<br>\
            Admin Purchasing<br>\
            <b>CV Karya Hidup Sentosa (QUICK)</b><br>\
            Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
            Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 211<br>\
            Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>\
            Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>\
        </p>\
    </div>\
    ';

    $('#txaPMSPOEmailBody').redactor({
        //   imageUpload: baseurl,
        //   imageUploadErrorCallback: function(json)
        //   {
        //       alert(json.error);
        //   }
    });

    // $('#txtPMSPONoPO').inputFilter(function(value) {
    //     return /^\d*$/.test(value); 
    // });
    
    $('#txtPMSPONoPO').on('blur', function(){
        var PONumber = $(this).val();
        // console.log(PONumber);
        if($(this).val().length > 0){
            $('.PMSPOimgLoadAddr').show();
            $(this).removeAttr("style", "background-color:#ffa8a8");
            $.ajax({
                url: baseurl + "PurchaseManagementSendPO/SendPO/getUserEmail/"+PONumber,
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    if (result != null){
                        $('.divPMSPOWarnAddrNotFound').fadeOut();
                        $('#txtPMSPOToEmailAddr').val(result);
                        $('.PMSPOimgLoadAddr').hide();
                        setTimeout(function() {
                            $('#txtPMSPOSubject').val('KHS PURCHASE ORDER '+PONumber);
                        }, 500);
                    }else{
                        $('.spnPMSPOWarnAddrNotFound').html(' Tidak ditemukan Email Address dengan PO Number '+PONumber+'. ');
                        $('.divPMSPOWarnAddrNotFound').fadeIn();
                        $('#txtPMSPOToEmailAddr').val('');
                        $('.PMSPOimgLoadAddr').hide();
                        setTimeout(function() {
                            $('#txtPMSPOSubject').val('KHS PURCHASE ORDER '+PONumber);
                        }, 500);
                    }
                }
            });
        }else{
            $('.PMSPOimgLoadAddr').hide();
            $('#txtPMSPOSubject').val('');
            $('#txtPMSPOToEmailAddr').val('');
        }
    });

    $('#txtPMSPOToEmailAddr').on({
        'click': function() {
            $('.divPMSPOEmailAddrWarn').fadeIn();
        },
        'blur': function() {      
            $('.divPMSPOEmailAddrWarn').fadeOut();
            if($(this).val().length > 0){
                $(this).removeAttr("style", "background-color:#ffa8a8");
            }
        }
      });

    $('#txtPMSPOCCEmailAddr').on({
        'click': function() {
            $('.divPMSPOCCEmailAddrWarn').fadeIn();
        },
        'blur': function() {      
            $('.divPMSPOCCEmailAddrWarn').fadeOut();
        }
    });

    $('#txtPMSPOBCCEmailAddr').val('purchasingsec12.quick3@gmail.com').on({
        'click': function() {
            $('.divPMSPOBCCEmailAddrWarn').fadeIn();
        },
        'blur': function() {      
            $('.divPMSPOBCCEmailAddrWarn').fadeOut();
        }
    });

    $('#slcPMSPOFormatMessage').on('change', function(){
        // console.log($(this).val());
        if ($(this).val() == 'Indonesia' ){
            $('#txaPMSPOEmailBody').redactor('set', IndonesiaMessageFormat);
        }else if($(this).val() == 'English'){
            $('#txaPMSPOEmailBody').redactor('set', EnglishMessageFormat);
        }
    })

    $('#txaPMSPOEmailBody').redactor('set', IndonesiaMessageFormat);

    $('.btnConfirmDiscard').on('click', function(){
        Swal.fire({
            title: 'Batalkan penulisan pesan?',
            text: "Anda tidak dapat mengembalikan pesan yang anda tulis",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
            }).then((result) => {
            if (result.value) {
                // console.log('Hello World!');
                $('.divPMSPOWarnAddrNotFound').fadeOut();
                $('.btnPMSPODiscard').click();
                $("#txaPMSPOEmailBody").redactor('set', ''); 
                $('#slcPMSPOFormatMessage').select2('val', '');
            }
        })
    });    

    $('.btnPMSPOcheckSend').on('click', function(){
        if ($('#txtPMSPOToEmailAddr').val().length < 1 && $('#txtPMSPONoPO').val().length < 1 ) 
        {
            // console.log('EMAIL DAN PO KOSONG');
            $('.pPMSPOwarningDetails').html('Nomor PO dan alamat email tujuan anda belum terisi.');
            $('.divPMSPOcalloutWarning').fadeIn();
            $('.divPMSPOcalloutWarning').fadeOut(10000);
            $('#txtPMSPOToEmailAddr').attr("style", "background-color:#ffa8a8");
            $('#txtPMSPONoPO').attr("style", "background-color:#ffa8a8");
        }
        else if($('#txtPMSPOToEmailAddr').val().length < 1)
        {
            // console.log('EMAIL KOSONG');
            $('.pPMSPOwarningDetails').html('Alamat email tujuan anda belum terisi.');
            $('.divPMSPOcalloutWarning').fadeIn();
            $('.divPMSPOcalloutWarning').fadeOut(10000);
            $('#txtPMSPOToEmailAddr').attr("style", "background-color:#ffa8a8");
        }
        else if($('#txtPMSPONoPO').val().length < 1)
        {
            // console.log('PO KOSONG');
            $('.pPMSPOwarningDetails').html('Nomor PO anda belum terisi.');
            $('.divPMSPOcalloutWarning').fadeIn();
            $('.divPMSPOcalloutWarning').fadeOut(10000);
            $('#txtPMSPONoPO').attr('style', 'background-color:#ffa8a8');
        }
        else
        {
            // Disable form from user interaction
            Swal.fire({
                allowOutsideClick: false,
                title: 'Mohon menunggu',
                html: 'Sedang mengirim pesan ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },    
            })

            // Ajax Send Email
            var 
                form_data       = new FormData(),
                po_number       = $('#txtPMSPONoPO').val(),
                subject         = $('#txtPMSPOSubject').val(),
                toEmail         = $('#txtPMSPOToEmailAddr').val();
                ccEmail 		= $('#txtPMSPOCCEmailAddr').val(),
                bccEmail 		= $('#txtPMSPOBCCEmailAddr').val(),
                file_attach1    = $('#inpPMSPOAttachment1').prop('files')[0],
                file_attach2    = $('#inpPMSPOAttachment2').prop('files')[0],
                format_message  = $('#slcPMSPOFormatMessage').val(),
                body            = $('#txaPMSPOEmailBody').val();
            form_data.append('po_number', po_number);
            form_data.append('toEmail', toEmail);
            form_data.append('ccEmail', ccEmail);
            form_data.append('bccEmail', bccEmail);
            form_data.append('subject', subject);
            form_data.append('file_attach1', file_attach1);
            form_data.append('file_attach2', file_attach2);
            form_data.append('format_message', format_message);
            form_data.append('body', body);

            $.ajax({
                type: 'post',
                url: baseurl + 'PurchaseManagementSendPO/SendPO/SendEmail',
                processData: false,
                contentType: false,
                data: form_data,
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    if (result == 'Message sent!'){
                        Swal.fire
                        (
                            'Success!',
                            'Pesan telah terkirim dan terarsip',
                            'success'
                        )
                    }else{
                        Swal.fire
                        ({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Pesan gagal terkirim :(',
                            footer: '<span style="color:#3c8dbc">'+result+'</span>'
                        })
                    }
                }
            });
        }
    });

});
