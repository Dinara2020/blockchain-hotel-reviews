<?php

namespace HotelReviews\Http\Services;

use HotelReviews\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use kornrunner\Keccak;
use BitWasp\Bitcoin\Crypto\Random\Random;
use Mdanter\Ecc\EccFactory;

class UserWalletService
{
    public function findOrCreateForUser($user): UserWallet
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();
        if ($wallet) {
            return $wallet;
        }

        $random = new Random();
        $privateKeyHex = bin2hex($random->bytes(32));

        $adapter = EccFactory::getAdapter();
        $generator = EccFactory::getSecgCurves()->generator256k1();
        $privateKey = $generator->createPrivateKey(gmp_init($privateKeyHex, 16));
        $publicKey = $privateKey->getPublicKey();

        $x = str_pad(gmp_strval($publicKey->getX(), 16), 64, '0', STR_PAD_LEFT);
        $y = str_pad(gmp_strval($publicKey->getY(), 16), 64, '0', STR_PAD_LEFT);
        $uncompressedPublicKey = hex2bin('04' . $x . $y);

        $address = '0x' . substr(Keccak::hash($uncompressedPublicKey, 256), 24);

        return UserWallet::create([
            'user_id' => $user->id,
            'eth_address' => $address,
            'eth_private_key' => $privateKeyHex,
        ]);
    }
}
