<?php

namespace Omnipay\PagSeguro\Message;
/*
 * PagSeguro Fetch Notification Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-notificacoes
 *
 */

class FetchNotificationRequest extends AbstractRequest
{
    protected $endpoint = 'https://ws.pagseguro.uol.com.br/v3';
    protected $sandboxEndpoint = 'https://ws.sandbox.pagseguro.uol.com.br/v3';
    protected $resource = "transactions/notifications";

    public function getNotificationCode()
    {
        return $this->getParameter('notificationCode');
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function setNotificationCode($value)
    {
        return $this->setParameter('notificationCode', $value);
    }

    public function sendData($data)
    {
        $this->validate('notificationCode');

        $url = sprintf('%s/%s/%s?%s', $this->getEndpoint(),
                                      $this->getResource(),
                                      $this->getNotificationCode(),
                                      http_build_query($data, '', '&'));

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url, $this->getHeaders());
        $xml = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }

    public function createResponse($data)
    {
        return $this->response = new FetchNotificationResponse($this, $data);
    }
}
