<?php

/**
 * Request object that allows otherwise unwritable properties to be written, such as
 * the method and headers.
 *
 * This should probably be rewritten so that multiple headers with the same name
 * are supported.
 */

class Http_Client_Adapter_Internal_Request extends Zend_Controller_Request_Http {

    protected $_headers = array();
    protected $_method = null;
    protected $_body = "";

    public function setHeader($header, $value) {
        $this->_headers[$header] = $value;
    }

    public function getHeader($header) {
        return array_key_exists($header, $this->_headers) ? $this->_headers[$header] : false;
    }

    public function setHeaders(array $params) {
        foreach ($params as $p) {
            list($key, $value) = split(": ", $p, 2);
            $this->setHeader($key, $value);
        }
        return $this;
    }

    public function getHeaders() {
        return $this->_headers;
    }

    public function setMethod($method) {
        $this->_method = $method;
    }

    public function getMethod() {
        return $this->_method;
    }

    public function setRawBody($body) {
        $this->_body = $body;
    }

    public function getRawBody() {
        return $this->_body;
    }

}