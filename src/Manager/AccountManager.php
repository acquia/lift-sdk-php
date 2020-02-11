<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Account;
use GuzzleHttp\Psr7\Request;

class AccountManager extends ManagerBase
{
    /**
     * Get a list of accounts
     *
     * @see http://docs.lift.acquia.com/decision/v2/#sites_get
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Account[]
     */
    public function get()
    {
        $url = ACCOUNTS_EP;

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Iterate through each account
        $accounts = [];
        foreach ($data as $dataItem) {
            $accounts[] = new Account($dataItem);
        }

        return $accounts;

    }
}
