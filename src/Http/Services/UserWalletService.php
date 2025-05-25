<?php

namespace HotelReviews\Http\Services;

use HotelReviews\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use kornrunner\Keccak;
use BitWasp\Secp256k1\Secp256k1;
use BitWasp\Buffertools\Buffer;

class UserWalletService
{
    public function findOrCreateForUser($user): UserWallet
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();
        if ($wallet) {
            return $wallet;
        }

        // 1. Сгенерировать 32-байтовый приватный ключ
        $privateKeyBytes = random_bytes(32);
        $privateKeyHex = bin2hex($privateKeyBytes);

        // 2. Создать публичный ключ (несжатый)
        $secp256k1 = new Secp256k1();
        $context = $secp256k1->context();
        $privateKey = $context->secretKeyCreate($privateKeyBytes);
        $publicKey = $context->pubkeyCreate($privateKey);
        $serializedPubKey = $context->pubkeySerialize($publicKey, false); // false = uncompressed

        // 3. Удалить префикс 0x04 и хешировать оставшиеся 64 байта
        $pubKeyBody = substr($serializedPubKey, 1); // пропускаем первый байт (0x04)
        $address = '0x' . substr(Keccak::hash($pubKeyBody, 256), 24);

        return UserWallet::create([
            'user_id' => $user->id,
            'eth_address' => $address,
            'eth_private_key' => $privateKeyHex,
        ]);
    }
}
