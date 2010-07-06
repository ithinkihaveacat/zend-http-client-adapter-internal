<?php

class Http_Client_Adapter_Internal implements Zend_Http_Client_Adapter_Interface {

    protected $_front = null;

    protected $_response = null;

    public function __construct($front) {
        $this->_front = $front;
    }

    public function setConfig($config = array()) {}

    public function connect($host, $port = 80, $secure = false) {}

    public function write($method, $url, $http_ver = '1.1', $headers = array(), $body = '') {

        $request = new Http_Client_Adapter_Internal_Request($url);
        $request->setMethod($method);
        $request->setHeaders($headers);
        $request->setRawBody($body);

        $response = new Http_Client_Adapter_Internal_Response();

        $this->_front->getRouter()->route($request);
        $this->_front->getDispatcher()->dispatch($request, $response);

        $this->_response = $response;

    }

    public function read() {
        return $this->_response->__toString();
    }

    public function close() {}

}
