## Overview

The `Http_Client_Adapter_Internal` adapter connects the Zend HTTP Client to a ZF Front Controller, allowing the application to make HTTP requests directly to itself (i.e. without requests and responses going over the network).

(This could be considered a ZF port of Kohana Framework's HMVC architectural pattern.)

## Example

Calling `HelloController` from `IndexController`:

    class IndexController extends Zend_Controller_Action
    {

        public function indexAction()
        {
            $client = new Zend_Http_Client("http://api.local/hello/?name=Clem");

            $client->setAdapter(new Http_Client_Adapter_Internal($this->getFrontController()));

            $response = $client->request();
            echo $response->getBody();
        }


    }

Where `HelloController` is defined as follows:

    class HelloController extends Zend_Controller_Action
    {

        public function indexAction()
        {
            $this->_helper->viewRenderer->setNoRender(true);
            echo sprintf("Hello, %s!\n", $this->getRequest()->getParam("name", "Greg"));
        }


    }

## Author

Michael Stillwell <mjs@beebo.org>