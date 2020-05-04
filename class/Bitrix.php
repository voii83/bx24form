<?php

class Bitrix
{
    protected $domain;
    protected $secret;
    protected $user_id;
    protected $curl;

    function __construct($domain, $secret, $user_id)
    {
        $this->domain = $domain;
        $this->secret = $secret;
        $this->user_id = $user_id;
        $this->curl = new Curl();
    }

    public function CRMStatusList($order = [], $filter = [])
    {
        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.status.list.json";
        $request = array(

            "order" => $order,
            "filter" => $filter,
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
        if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadList($order = array(), $filter = array(), $select = array())
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.list.json";

        $request = array(
            
            "order" => $order,
            "filter" => $filter,
            "select" => $select
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }
    public function CRMLeadProductrowsSet($id, $rows = array())
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.productrows.set.json";

        $request = array(

            "id" => $id,
            "rows" => $rows
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
        if(isset($response["result"])) return $response["result"];
    }
    public function CRMLeadGet($id)
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.get.json";

        $request = array(
            
            "id" => $id
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadAdd($fields = array(), $params = array())
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.add.json";

        $request = array(
            
            "fields" => $fields,
            "params" => $params
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadUpdate($id, $fields = array(), $params = array())
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.update.json";

        $request = array(
            "id" => $id,
            "fields" => $fields,
            "params" => $params
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadDelete($id)
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.delete.json";

        $request = array(
            
            "id" => $id
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadUserFieldList($order = array(), $filter = array())
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.userfield.list.json";

        $request = array(
            
            "order" => $order,
            "filter" => $filter,
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }

    public function CRMLeadFields()
    {

        $url = "https://".$this->domain."/rest/".$this->user_id."/".$this->secret."/crm.lead.fields.json";

        $request = array(
            
        );

        $response = $this->curl->Post($url, $request);
        $response = json_decode($response, true);
         if(isset($response["result"])) return $response["result"];
    }
}