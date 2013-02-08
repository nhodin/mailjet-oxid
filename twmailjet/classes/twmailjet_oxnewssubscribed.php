<?php

class twmailjet_oxnewssubscribed extends twmailjet_oxnewssubscribed_parent {
    
    public function setOptInStatus( $iStatus )
    {
        parent::setOptInStatus($iStatus);
        
        $myConfig = $this->getConfig();
        
        $sSynchronizeMailjet = $myConfig->getShopConfVar('mailjet_contactlist_synchronize', null, 'module:twmailjet');
        
        if($sSynchronizeMailjet == "Oui") {
            $sMailjetContactListId = $myConfig->getShopConfVar('mailjet_contactlist_id', null, 'module:twmailjet');
            
            if(strlen($sMailjetContactListId) > 0) {
                
                define(TWMAILJET_MAILJET_API_KEY,$myConfig->getShopConfVar('mailjet_api_key', null, 'module:twmailjet'));
                define(TWMAILJET_MAILJET_SECRET_KEY,$myConfig->getShopConfVar('mailjet_secret_key', null, 'module:twmailjet'));
                $oMailjet = oxNew('Mailjet');

                if($iStatus == 1) {
                    //Abonnement
                    $sEmail = $this->oxnewssubscribed__oxemail->value;
                    if(strlen($sEmail) > 0) {
                        $params = array(
                                    'method' => 'POST',
                                    'contact' => $sEmail,
                                    'id' => $sMailjetContactListId
                                );
                        
                        $response = $oMailjet->listsAddContact($params);

                        if($response === false) {
                            //Contact déjà dans la liste liste des contacts en mode désabonné
                            
                            //On essaie de supprimer le contact
                            $response1 = $oMailjet->listsRemoveContact($params);

                            //Puis de le réajouter
                            $response2 = $oMailjet->listsAddContact($params);
                            
                            if($response2 === false) {
                                oxRegistry::getUtils()->writeToLog( "\n".date("d-m-Y H:i:s", time()).": Abonnement / ".$sEmail." n'a pas été abonné.", 'twmailjet.log' );		
                            }
                        }
                    }
                }
                elseif($iStatus == 0) {
                    //Désabonnement
                    $sEmail = $this->oxnewssubscribed__oxemail->value;
                    if(strlen($sEmail) > 0) {
                        $params = array(
                                    'method' => 'POST',
                                    'contact' => $sEmail,
                                    'id' => $sMailjetContactListId
                                );
                        
                        $response = $oMailjet->listsUnsubContact($params);

                        if($response === false) {
                            oxRegistry::getUtils()->writeToLog( "\n".date("d-m-Y H:i:s", time()).": Désabonnement / ".$sEmail." n'a pas été désabonné.", 'twmailjet.log' );		
                        }
                    }
                }
            }
        }
    }
    
}
?>
