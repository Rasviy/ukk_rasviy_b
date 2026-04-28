<?php

namespace App\Services;

class QRISPayment implements PaymentInterface {
    public function pay($amount){
        return "Pembayaran QRIS sebesar " . $amount;
    }
}