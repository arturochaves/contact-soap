<?php
//RED BEANS
require './lib/rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=multireisen', 'root', 'root' );

class Service
{
    public function getAllContacts()
    {                
        $contact = R::find('contact');
        
        return json_encode($contact);
    }

    public function searchContacts($name)
    {        
        if($name!=""){
            $contact = R::find('contact','name LIKE ?',["%$name%"]);
        }else{
            $contact = array("Error"=>"SERVER: Name not given for the search.");
        }
        
        return json_encode($contact);
        
    }

    public function deleteContact($id)
    {                
        if($id!=""){
            $contact = R::load('contact',$id);    
            R::trash( $contact );    
            $return = true;
        }else{
            $return = false;
        }                
        
        return $return;
    }

    public function updateContact($id,$name,$email,$phone,$address)
    {                
        if($name!=""&&$email!=""&&$phone!=""&&$address!=""&&$id!=""){
            $contact = R::load('contact',$id);    
            $contact->name = $name;
            $contact->email = $email;
            $contact->phone = $phone;
            $contact->address = $address;
            R::store( $contact );
            $contact = true;
        }else{
            $contact = false;
        }        
        
        return json_encode($contact);
    }

    public function addContact($name,$email,$phone,$address)
    {                
        if($name!=""&&$email!=""&&$phone!=""&&$address!=""){            
            $contact = R::dispense('contact');    
            $contact->name = $name;
            $contact->email = $email;
            $contact->phone = $phone;
            $contact->address = $address;
            R::store( $contact );
            $return = true;
        }else{
            $return = false;
        }
        
        return $return;
    }
}