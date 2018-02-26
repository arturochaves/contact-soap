<?php
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
 
class Server
{
    private $_soapServer = null;
 
    public function __construct()
    {
        require_once(getcwd() . './lib/nusoap.php');
        require_once(getcwd() . './service.php');
        $this->_soapServer = new soap_server();
        $this->_soapServer->configureWSDL('contactwsdl', 'urn:contactwsdl');

        $this->_soapServer->register(
            'Service.getAllContacts', // method name
            array(), // input parameters
            array('return' => 'xsd:Array'), // output parameters
            false, // namespace
            false, // soapaction
            'rpc', // style
            'encoded', // use
            'Service that return the list of contacts' // documentation
         );

         $this->_soapServer->register(
            'Service.searchContacts', // method name
            array('name' => "xsd:string"), // input parameters
            array('return' => 'xsd:Array'), // output parameters
            false, // namespace
            false, // soapaction
            'rpc', // style
            'encoded', // use
            'Service that return the list of contacts that contain that name' // documentation
         );
          
         $this->_soapServer->register(
            'Service.deleteContact', // method name
            array('id' => "xsd:int"), // input parameters
            array('return' => 'xsd:boolean'), // output parameters
            false, // namespace
            false, // soapaction
            'rpc', // style
            'encoded', // use
            'Service that delete the contact by the id' // documentation
         );

         $this->_soapServer->register(
            'Service.updateContact', // method name
            array('id' => "xsd:int",'name' => "xsd:string",'email' => "xsd:string",'phone' => "xsd:string",'address' => "xsd:string"), // input parameters
            array('return' => 'xsd:boolean'), // output parameters
            false, // namespace
            false, // soapaction
            'rpc', // style
            'encoded', // use
            'Service that update the contact by the id' // documentation
         );

         $this->_soapServer->register(
            'Service.addContact', // method name
            array('name' => "xsd:string",'email' => "xsd:string",'phone' => "xsd:string",'address' => "xsd:string"), // input parameters
            array('return' => 'xsd:boolean'), // output parameters
            false, // namespace
            false, // soapaction
            'rpc', // style
            'encoded', // use
            'Service that add a new contact with name, email, phone and address' // documentation
         );
          
         
          
         //processing the webservice
         $this->_soapServer->service(file_get_contents("php://input"));
    }
    
}
$server = new Server();
