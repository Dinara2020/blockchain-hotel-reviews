<?php

namespace HotelReviews\Services;

use HotelReviews\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use kornrunner\Keccak;
use Elliptic\EC;

class UserWalletService
{
    public function findOrCreateForUser($user): UserWallet
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();
        if ($wallet) return $wallet;

        $ec = new EC('secp256k1');
        $key = $ec->genKeyPair();
        $privateKey = $key->getPrivate('hex');
        $publicKey = $key->getPublic(false, 'hex');
        $publicKey = substr($publicKey, 2);

        $address = '0x' . substr(Keccak::hash(hex2bin($publicKey), 256), 24);

        return UserWallet::create([
            'user_id' => $user->id,
            'eth_address' => $address,
            'eth_private_key' => $privateKey,
        ]);
    }
}
