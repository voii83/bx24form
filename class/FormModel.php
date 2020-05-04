<?php

class FormModel
{
    const STATUS_LEAD = 'В работе';
    const SOURCE_LEAD = 'Веб-сайт';

    protected $name = '';
    protected $phone = '';
    protected $position = '';
    protected $email = '';
    protected $products = [];
    protected $validateErrors = [];

    public function getFieldsValue()
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'position' => $this->position,
            'email' => $this->email,
            'products' => $this->products,
        ];
    }

    public function loadParams(array $fields)
    {
        $this->name = $fields['name'];
        $this->phone = $fields['phone'];
        $this->position = $fields['position'];
        $this->email = $fields['email'];

        if (isset($fields['products']) && is_array($fields['products'])) {
            foreach ($fields['products'] as $product) {
                $this->products[] = $product;
            }
        }
    }

    public function validate()
    {
        if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i', $this->phone)) {
            $this->validateErrors[] = ['message' => 'Неправильный номер телефона'];
        }

        if (!preg_match ('/[\.a-z0-9_\-]+[@][a-z0-9_\-]+([.][a-z0-9_\-]+)+[a-z]{1,4}/i', $this->email))
            $this->validateErrors[] = ['message' => 'Неправильный Email'];

        if ($this->validateErrors) {
            return false;
        }

        return true;
    }

    public function getValidateErrors()
    {
        return $this->validateErrors;
    }

    public function send()
    {
        $params = include_once ROOT . '/config/params-local.php';
        $bitrix = new Bitrix($params['urlBitrix'], $params['secretBitrix'], $params['userBitrix']);

        $arrStatus = $bitrix->CRMStatusList([], ['ENTITY_ID' => 'STATUS']);
        $status = array_filter($arrStatus, function ($item) {
            return $item['NAME'] == self::STATUS_LEAD;
        });

        $arrSource = $bitrix->CRMStatusList([], ['ENTITY_ID' => 'SOURCE']);
        $source = array_filter($arrSource, function ($item) {
            return $item['NAME'] == self::SOURCE_LEAD;
        });

        $itemRows = [];
        foreach ($this->products as $product) {
            $itemRows[] = [
                'PRODUCT_NAME' => $product,
            ];
        }

        $leadId = $bitrix->CRMLeadList([], ["PHONE" => $this->phone], ["ID"]);

        if ($leadId) {

            $leadParams = [
                'TITLE' => 'Заявка с формы',
                'SOURCE_ID' => $source ? current($source)['STATUS_ID'] : '',
                'STATUS_ID' => $status ? current($status)['STATUS_ID'] : '',
                'NAME' => $this->name,
                'POST' => $this->position,
            ];
            $bitrix->CRMLeadUpdate(current($leadId)['ID'], $leadParams);
            $bitrix->CRMLeadProductrowsSet(current($leadId)['ID'], $itemRows);

        } else {

            $leadParams = [
                'TITLE' => 'Заявка с формы',
                'SOURCE_ID' => $source ? current($source)['STATUS_ID'] : '',
                'STATUS_ID' => $status ? current($status)['STATUS_ID'] : '',
                'NAME' => $this->name,
                'POST' => $this->position,
                'EMAIL' => [
                    ['VALUE' => $this->email, 'VALUE_TYPE' => 'WORK']
                ],
                'PHONE' => [
                    ['VALUE' => $this->phone, 'VALUE_TYPE' => 'WORK']
                ],

            ];
            $leadId = $bitrix->CRMLeadAdd($leadParams);
            $bitrix->CRMLeadProductrowsSet($leadId, $itemRows);
        }

        return true;
    }
}