<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Campaign;
use Acquia\LiftClient\Entity\CampaignResponse;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class CampaignManager extends ManagerBase
{

    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'status' => null,
        'type' => null,
        'label' => null,
        'sort_field' => null,
        'include_rule_and_goal_ids' => null,
        'rows' => null,
        'sort' => null,
        'start' => null,
        'time_filters' => null
    ];

    /**
     * Get a list of sites associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns_get
     *
     * @throws \GuzzleHttp\Exception\RequestException for network errors
     *
     * @return \Acquia\LiftClient\Entity\Campaign[]
     */
    public function getCampaigns($options = [])
    {
        $url = CAMPAIGNS_EP;
        $url .= $this->getQueryString($options);

        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        $campaignResp = new CampaignResponse($data);

        return $campaignResp->getCampaigns();
    }
    
    /**
     * Retrived campaign properties based on campaign id
     * 
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns__campaignId__get
     *
     * @throws \GuzzleHttp\Exception\RequestException for network errors
     * @throws \GuzzleHttp\Exception\ClientException for 4xx errors
     *
     * @return \Acquia\LiftClient\Entity\Campaign when found
     * @return null when not found or if campaign id is null or empty
     * 
     */
    public function getById($campaignId){

        if (!isset($campaignId) || trim($campaignId) == ""){
            return;
        }

        try {
            $url = CAMPAIGNS_EP."/".$campaignId;
            $request = new Request('GET', $url);

            $data = $this->getResponseJson($request);
            $campaign = new Campaign($data);
        } catch (ClientException $e){
            return;
        } catch (Exception $e){
            throw $e;
        }

        return $campaign;
    }

    /**
     * Push a campaign create/update via POST method
     * 
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns_post
     *
     * @throws \GuzzleHttp\Exception\RequestException for network errors
     * @throws \GuzzleHttp\Exception\ServerException for 5xx status codes
     *
     * @return \Acquia\LiftClient\Entity\Campaign when found
     * @return null when not found or if campaign id is null or empty
     * 
     */
    public function post(Campaign $campaign){

        if (!isset($campaign)){
            return;
        }

        try {
            $url = CAMPAIGNS_EP;
            $body = $campaign->json();

            $request = new Request('POST', $url, [], $body);
            $data = $this->getResponseJson($request);

            $campaign = new Campaign($data);
        } catch (ServerException $e){
            throw $e;
        } catch (ClientException $e){
            throw $e;
        } catch (Exception $e){
            throw $e;
        }

        return $campaign;
    }

    /**
     * Patch campaign based on campaign id create/update via PATCH method
     * 
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns__campaignId__patch
     *
     * @param $campaignId - Campaign Id
     * @param $patchPayload - Campaign Patch Payload
     * 
     * @throws \GuzzleHttp\Exception\RequestException for network errors
     * @throws \GuzzleHttp\Exception\ClientException for 4xx status codes
     * @throws \GuzzleHttp\Exception\ServerException for 5xx status codes
     *
     * @return \Acquia\LiftClient\Entity\Campaign when found
     * @return null when not found or if campaign id is null or empty
     * 
     */
    public function patch($campaignId, $patchPayload){

        if (!isset($campaignId) || $campaignId == ""){
            return;
        }

        try {
            $url = CAMPAIGNS_EP."/".$campaignId;
            $body = $patchPayload->json();

            $request = new Request('PATCH', $url, [], $body);
            $data = $this->getResponseJson($request);

            $campaign = new Campaign($data);
        } catch (ServerException $e){
            throw $e;
        } catch (ClientException $e){
            return; 
        } catch (Exception $e){
            throw $e;
        }

        return $campaign;
    }

    /**
     *  Deletes all campaigns associated with account id. Returns true when successful, otherwise a RequestException will be thrown
     * 
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns_delete
     *
     * @throws \GuzzleHttp\Exception\RequestException for network errors
     *
     * @return bool
     */
    public function delete(){
        $url = CAMPAIGNS_EP;

        $request = new Request('DELETE', $url);
        $data = $this->getResponseJson($request);

        if (isset($data)){
            return false;
        }

        return true;
    }

    /**
     *  Deletes all campaigns associated with account id. Returns true when successful, otherwise false
     * 
     * @see http://docs.lift.acquia.com/decision/v2/#campaigns__campaignId__delete
     *
     * @throws \GuzzleHttp\Exception\RequestException for networking errors
     * @throws \GuzzleHttp\Exception\ClientException for 4xx status codes
     *
     * @return bool
     */
    public function deleteById($campaignId){

        if (!isset($campaignId) || trim($campaignId) == ""){
            return false;
        }

        try {
            $url = CAMPAIGNS_EP."/".$campaignId;
            $request = new Request('DELETE', $url);
            $data = $this->getResponseJson($request);
        }catch (ClientException $e){
            return false;
        }

        if (isset($data)){
            return false;
        }

        return true;
    }


}
