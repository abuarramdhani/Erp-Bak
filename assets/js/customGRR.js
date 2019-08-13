const loading = {
    showInButton: function(buttonIcon, icon) {
        buttonIcon.parentNode.disabled = true;
        buttonIcon.classList.remove(icon);
        buttonIcon.classList.add('fa-spin', 'fa-spinner');
    },
    hideInButton: function(buttonIcon, icon) {
        buttonIcon.classList.remove('fa-spinner', 'fa-spin');
        buttonIcon.classList.add(icon);
        buttonIcon.parentNode.disabled = false;
    }
};

$(document).ready(function() {
    $('#sdm_select_tahun').select2({
        allowClear: false,
        placeholder: "Pilih Tahun",
    });
});