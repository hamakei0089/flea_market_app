$(document).ready(function() {

    $('#payment_method').on('change', function() {
        var paymentMethod = $(this).val();
        $('#payment-method-display').text(paymentMethod);
    });

    $('#payment_method').change(function() {
        var paymentMethod = $(this).val();
        $('#hidden-payment-method').val(paymentMethod);
    });
});
