<?php

namespace HotelReview\Services;

use kornrunner\Keccak;

class SignatureVerifier
{
    public function isValid(array $data): bool
    {
        $message = "{$data['hotel_id']}|{$data['content']}|{$data['rating']}";
        $msgHash = Keccak::hash("\x19Ethereum Signed Message:\n" . strlen($message) . $message, 256);

        // Здесь должен быть ecrecover через веб3 или JS-процесс (Laravel не умеет сам)
        // Можно через node cli обёртку проверить адрес

        return true; // временно для примера
    }
}
