<?php
class Core_Model_Message extends Core_Model_Session
{
    public function addMessage($type,$message){
        $value = 'add'.$type;
        $this->$value($message);
    }
   
    public function AddSuccess($message) {
        $messagearray = $this->get("message");
        if(isset($messagearray)){
            $messagearray['success']=$message;
            $this->set("message",$messagearray);
        }
        else{
            $this->set("message",["success"=>$message]);
        }
    }
    public function AddError($message) {
        $messagearray = $this->get("message");
        if(isset($messagearray)){
            $messagearray['error']=$message;
            $this->set("message",$messagearray);
        }
        else{
            $this->set("message",["error"=>$message]);
        }
    }
    public function AddWarning($message) {
        $messagearray = $this->get("message");
        if(isset($messagearray)){
            $messagearray['warning']=$message;
            $this->set("message",$messagearray);
        }
        else{
            $this->set("message",["warning"=>$message]);
        }
    }
    public function getMessage($type) {
        $value = 'get'.ucfirst($type);
        return $this->$value();
    }
    public function getSuccess() {
        if(isset($this->get("message")["success"])){
            $successmessage = $this->get("message")["success"];
            $this->removemessage("success");
            // echo $successmessage;
            // die;
            return $successmessage;
        }
    }
    public function getError() {
        if(isset($this->get("message")["error"])){
            $errormessage = $this->get("message")["error"];
            $this->removemessage("error");
            return $errormessage;
        }
    }
    public function getWarning() {
        if(isset($this->get("message")["warning"])){
            $warningmessage = $this->get("message")["warning"];
            $this->removemessage("warning");
            return $warningmessage;
        }
    }
   
}
 
 