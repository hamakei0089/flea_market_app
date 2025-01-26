$(document).ready(function() {

    $('#payment_method').on('change', function() {
        var selectedPaymentMethod = $(this).val();
        $('#payment_method_display').text(selectedPaymentMethod);
    });
});