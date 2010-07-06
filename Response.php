<?php

class Http_Client_Adapter_Internal_Response extends Zend_Controller_Response_Http {

    /**
     * Slightly modified version of its parents' sendHeaders() method.  We need this
     * because we need the __toString() method to return headers as well as body,
     * but original sendHeaders() (called by __toString()) uses header() to output
     * headers, and these aren't captured.  Therefore, we need our own version
     * of sendHeaders() which outputs headers via echo, instead of header() to
     * allow them to be captured.
     *
     * See http://www.php.net/manual/en/intro.outcontrol.php
     *
     * The current code should be rewritten to not be such a direct translation
     * from parent::sendHeaders() to remove two limitations: we don't return
     * the response code human-readable name (perhaps this isn't actually necessary)
     * and we don't respect the "replace" value of each of the headers.
     */
    public function sendHeaders()
    {

        $httpCodeSent = false;

        foreach ($this->_headersRaw as $header) {
            if (!$httpCodeSent && $this->_httpResponseCode) {
                echo "HTTP/1.1 " . $this->_httpResponseCode . "\n"; // we don't actually sent the status code name
                echo $header . "\n";
                $httpCodeSent = true;
            } else {
                echo $header . "\n";
            }
        }

        foreach ($this->_headers as $header) {
            if (!$httpCodeSent && $this->_httpResponseCode) {
                echo "HTTP/1.1 " . $this->_httpResponseCode . "\n";
                echo $header['name'] . ': ' . $header['value'] . "\n"; // the "replace" value is ignored
                $httpCodeSent = true;
            } else {
                echo $header['name'] . ': ' . $header['value'] . "\n"; // the "replace" value is ignored
            }
        }

        if (!$httpCodeSent) {
            echo "HTTP/1.1 " . $this->_httpResponseCode . "\n";
            $httpCodeSent = true;
        }

        echo "\n";

        return $this;
    }

}
