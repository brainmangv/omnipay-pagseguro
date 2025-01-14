<?php

namespace Omnipay\PagSeguro\Message;

class FindTransactionRequest extends AbstractRequest
{
    protected $resource = "transactions";

    public function getTransactionID()
    {
        return $this->getParameter('transactionId');
    }

    public function setTransactionID($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    protected function createResponse($data)
    {
        return $this->response = new FindTransactionResponse($this, $data);
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function sendData($data)
    {
        $url = sprintf('%s/%s/%s?%s', $this->getEndpoint(),
                                      $this->getResource(),
                                      $this->getTransactionID(),
                                      http_build_query($data, '', '&'));

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url);
        $xml = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }
}
