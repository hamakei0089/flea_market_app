$(document).ready(function() {
    $('#payment-method').on('change', function() {
        var selectedPaymentMethod = $(this).val();
        var displayText = '';

        if (selectedPaymentMethod === 'convenience') {
            displayText = 'コンビニ支払い';
        } else if (selectedPaymentMethod === 'card') {
            displayText = 'カード支払い';
        } else {
            displayText = '選択されていません';
        }

        $('#payment-method-display').text(displayText);
    });
});
