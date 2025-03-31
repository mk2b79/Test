<?php

namespace API\Services\Freshdesk;

use API\Models\Freshdesk\CompanyFd;
use API\Utilities\JsonDecode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class fCompanyServices
{
    private Client $client;
    public function __construct(Client $client){ $this->client = $client; }

    /**
     * @throws GuzzleException
     */
    public function getOrCreateCompany(?CompanyFd $company):?CompanyFd {
        if($company === null){
            return null;
        }
        $data=JsonDecode::decode($this->client->get("/api/v2/companies/autocomplete?name={$company->getName()}"))["companies"];
        if(empty($data)){
            return $this->createCompany($company);
        }
        $data=$data[0];
        return new CompanyFd(
            $data["id"],
            $data["name"]
        );
    }

    /**
     * @throws GuzzleException
     */
    private function createCompany(CompanyFd $companyFd):CompanyFd
    {
        $responseData=JsonDecode::decode($this->client->post("/api/v2/companies",
            [
                "json"=>[
                    "name"=>$companyFd->getName()
                ]
            ]
        ));
        return new CompanyFd(
            $responseData["id"],
            $responseData["name"]
        );
    }
}