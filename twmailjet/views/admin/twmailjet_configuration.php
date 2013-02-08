<?php

class twmailjet_configuration extends oxAdminDetails {
  
 	/**
   	* Current class template.
   	* @var string
   	*/
  	protected $_sThisTemplate = 'twmailjet_configuration.tpl';
  
	public function render() {
            parent::render();
            
            $myConfig = $this->getConfig();
            
            $this->_aViewData['smtp_serveur'] = $myConfig->getShopConfVar('mailjet_smtp_server', null, 'module:twmailjet');
            $this->_aViewData['smtp_port'] = $myConfig->getShopConfVar('mailjet_smtp_port', null, 'module:twmailjet');
            $this->_aViewData['smtp_user'] = $myConfig->getShopConfVar('mailjet_api_key', null, 'module:twmailjet');
            $this->_aViewData['smtp_password'] = $myConfig->getShopConfVar('mailjet_secret_key', null, 'module:twmailjet');
            
            $sCurrentAdminShop = oxSession::getVar("currentadminshop");

            if (!$sCurrentAdminShop) {
                if (oxSession::getVar( "malladmin"))
                    $sCurrentAdminShop = "oxbaseshop";
                else
                    $sCurrentAdminShop = oxSession::getVar( "actshop");
            }

            $this->_aViewData["currentadminshop"] = $sCurrentAdminShop;
            oxSession::setVar("currentadminshop", $sCurrentAdminShop);
            
            $oShop = oxNew( "oxshop" );
            if ( $oShop->load( oxSession::getVar("currentadminshop") ) ) {
                $this->_aViewData['address_test'] = $oShop->oxshops__oxinfoemail->value;
            }
            
            return $this->_sThisTemplate;	
  	}
        
        public function savesmtp() {
            
            $myConfig = $this->getConfig();
            
            $myConfig->saveShopConfVar("str", "mailjet_smtp_server", trim(oxConfig::getParameter('smtp_serveur')), null, "module:twmailjet");
            $myConfig->saveShopConfVar("str", "mailjet_smtp_port", trim(oxConfig::getParameter('smtp_port')), null, "module:twmailjet");
            $myConfig->saveShopConfVar("str", "mailjet_api_key", trim(oxConfig::getParameter('smtp_user')), null, "module:twmailjet");
            $myConfig->saveShopConfVar("str", "mailjet_secret_key", trim(oxConfig::getParameter('smtp_password')), null, "module:twmailjet");
            
            if(oxConfig::getParameter('force_oxid_smtp') == "1") {
                
                $oShop = oxNew( "oxshop" );
                if ( $oShop->load( oxSession::getVar("currentadminshop") ) ) {
                    
                    $oShop->oxshops__oxsmtp = new oxField(oxConfig::getParameter('smtp_serveur').":".oxConfig::getParameter('smtp_port'));
                    $oShop->oxshops__oxsmtpuser = new oxField(oxConfig::getParameter('smtp_user'));
                    $oShop->oxshops__oxsmtppwd = new oxField(oxConfig::getParameter('smtp_password'));
                    
                    $oShop->save();
                }
                
                
            }
            
        }
        
        public function testsmtp() {
            $oEmail = oxNew("oxemail");

            $res = $oEmail->sendTestEmail();

            if(!$res) {
                $this->_aViewData['infosmtp'] = "Erreur lors de l'envoi de l'email. Veuillez vérifier la configuration SMTP.";
            }
            else {
                $this->_aViewData['infosmtp'] = "Email envoyé avec succès";
            }
        }
        
        
}
?>
