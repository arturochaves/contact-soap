<?php
require_once('client.php');

$client = new Client();
//$client->searchContacts('arturo');
//$client->getAllContacts();
//$client->deleteContact(1);
//$client->updateContact(2,'Arturo','asd@asd.com','Adriano 2','321654987');
//$client->addContact('Arturo','asd@asd.com','Adriano 2','321654987');


switch($_POST['type']){
    case 'add':
        $client->addContact($_POST['name'],$_POST['email'],$_POST['phone'],$_POST['address']);
        break;
    case 'all':
        $client->getAllContacts();
        break;
    case 'search':
        $client->searchContacts($_POST['name']);
        break;
    case 'update':        
        $client->updateContact($_POST['id'],$_POST['name'],$_POST['email'],$_POST['phone'],$_POST['address']);
        break;    
    case 'delete':
        $client->deleteContact($_POST['id']);
        break;            
}        


