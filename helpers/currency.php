<?php
function printcurrency($amount) {
    if(fmod($amount, 1) !== 0.00){
        // your code if its decimals has a value
        $amount = (string) number_format($amount, 2, ',', '');
    } else {
        $amount = $amount . ',-';
    }    
    $amount = '€ ' . $amount;
    return $amount;
}
?>