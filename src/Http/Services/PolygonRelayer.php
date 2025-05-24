<?php

namespace Services;

class PolygonRelayer
{
    public function send(array $data): string
    {
        // Пример: вызов Node.js скрипта или `web3.php` для отправки транзакции
        // Можно использовать symfony/process для exec

        $cmd = "node scripts/send-review.js '" . json_encode($data) . "'";
        exec($cmd, $output);

        return $output[0] ?? 'tx_placeholder';
    }
}
