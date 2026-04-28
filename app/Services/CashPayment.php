<?php

namespace App\Services;

class CashPayment implements PaymentInterface {
    public function pay($amount){
        return "Pembayaran cash sebesar " . $amount;
    }
}
