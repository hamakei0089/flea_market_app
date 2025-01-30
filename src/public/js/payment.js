$(document).ready(function() {

    $('#payment-method').on('change', function() {
        var selectedPaymentMethod = $(this).val();
        $('#payment-method-display').text(selectedPaymentMethod);
    });
});