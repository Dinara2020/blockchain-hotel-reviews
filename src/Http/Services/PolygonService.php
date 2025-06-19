<?php

namespace HotelReviews\Http\Services;

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Exception;
use Carbon\Carbon;

class PolygonService
{
    protected Web3 $web3;
    protected Contract $contract;

    public function __construct()
    {
        $rpcUrl = config('services.polygon.rpc');
        $this->web3 = new Web3($rpcUrl);

        $abi = file_get_contents(base_path('contracts/TripReviews.abi.json'));
        $this->contract = new Contract($this->web3->provider, $abi);
        $this->contract->at(config('services.polygon.contract_address'));
    }

    /**
     * @param int $tripId
     * @return array
     * @throws Exception
     */
    public function getReviews(int $tripId): array
    {
        $reviews = [];

        $this->contract->call('getReviews', $tripId, function ($err, $result) use (&$reviews) {
            if ($err !== null) {
                throw new Exception($err->getMessage());
            }

            foreach ($result as $r) {
                $reviews[] = [
                    'user'      => $r[0],
                    'tripId'    => (int)$r[1]->toString(),
                    'rating'    => (int)$r[2]->toString(),
                    'content'   => $r[3],
                    'timestamp' => Carbon::createFromTimestamp(
                        (int)$r[4]->toString()
                                  )->toIso8601String(),
                ];
            }
        });

        return $reviews;
    }
}
