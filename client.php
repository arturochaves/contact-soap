<?php
require_once('lib/nusoap.php');

class Client
{
    private $_soapClient = null;

    public function __construct()
    {        
        $this->_soapClient= new nusoap_client("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/api?wsdl');
        $this->_soapClient->soap_defencoding = 'UTF-8';    
    }

    public function getAllContacts()
    {
        try
        {
            $result = $this->_soapClient->call('Service.getAllContacts', array());
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function searchContacts($name)
    {
        try
        {
            $result = $this->_soapClient->call('Service.searchContacts', array('name'=>$name));
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function deleteContact($id)
    {
        try
        {
            $result = $this->_soapClient->call('Service.deleteContact', array('id'=>$id));
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function updateContact($id,$name,$email,$phone,$address)
    {
        try
        {
            $result = $this->_soapClient->call('Service.updateContact', array('id'=>$id,'name'=>$name,'email'=>$email,'phone'=>$phone,'address'=>$address));
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function addContact($name,$email,$phone,$address)
    {
        try
        {
            $result = $this->_soapClient->call('Service.addContact', array('name'=>$name,'email'=>$email,'phone'=>$phone,'address'=>$address));
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }
         

    /**
     * @param $result
     */
    private function _soapResponse($result)
    {        
        //save xml logs: request and response
        file_put_contents("xml-logs/".time()."-respond.xml", $this->_soapClient->responseData);
        $request = explode('<?xml',$this->_soapClient->request);
        file_put_contents("xml-logs/".time()."-request.xml", '<?xml'.$request[1]);

        echo $result;
    }
}