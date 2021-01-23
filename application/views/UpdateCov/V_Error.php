<input type="hidden" value="<?= $er ?>" id="tx_err">
<script src="<?php echo base_url('assets/plugins/sweetAlert/sweetalert.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var er = $('#tx_err').val();
        Swal.fire({
            title: "Error!",
            text: er,
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK",
        }).then((result) => {
            if (result.value) {
                location.href = baseurl + "Slideshow/UploadFile";
            }
        });
    })
</script>