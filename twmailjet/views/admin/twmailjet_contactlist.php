<?php

class twmailjet_contactlist extends oxAdminDetails {
  
 	/**
   	* Current class template.
   	* @var string
   	*/
  	protected $_sThisTemplate = 'twmailjet_contactlist.tpl';
  
	public function render() {
            parent::render();
            
            $myConfig = $this->getConfig();
            
            $sContactListId = $myConfig->getShopConfVar('mailjet_contactlist_id', null, 'module:twmailjet');
            $sModeSync = $myConfig->getShopConfVar('mailjet_contactlist_synchronize', null, 'module:twmailjet');
            
            $this->_aViewData['contactlist_id'] = $sContactListId;
            $this->_aViewData['contactlist_sync'] = $sModeSync;
            
            $blMailjetOK = true;
            
            define(TWMAILJET_MAILJET_API_KEY,$myConfig->getShopConfVar('mailjet_api_key', null, 'module:twmailjet'));
            define(TWMAILJET_MAILJET_SECRET_KEY,$myConfig->getShopConfVar('mailjet_secret_key', null, 'module:twmailjet'));
            $oMailjet = oxNew('Mailjet');
            
            if(strlen(TWMAILJET_MAILJET_API_KEY) == 0 || TWMAILJET_MAILJET_SECRET_KEY == 0) {
                $blMailjetOK = false;
            }
            else {
                $me = $oMailjet->userInfos();
                if($me === false) {
                    $blMailjetOK = false;
                }
            }

            if($blMailjetOK) {
                $this->_aViewData['contactlist_list'] = $oMailjet->listsAll();
            }
            
            $this->_aViewData['mailjet_ok'] = $blMailjetOK;

            if(strlen($sContactListId) > 0) {    
                $params = array(
                    'id' => $sContactListId
                );
                
                $response = $oMailjet->listsStatistics($params);
                //var_dump($response);
                if($response === false) {
                    $this->_aViewData['erreur'] = "Impossible d'obtenir des informations sur cette liste de contacts";
                }
                elseif($response->status == "OK") {
                    $this->_aViewData['stats'] = $response->statistics;
                    
                    $sSql = "SELECT count(*) FROM oxnewssubscribed WHERE oxdboptin = 1";
                    $sNbAbonnes = oxDb::getDb()->getOne($sSql);
                    
                    $sSql = "SELECT count(*) FROM oxnewssubscribed WHERE oxdboptin = 0";
                    $sNbDesabonnes = oxDb::getDb()->getOne($sSql);
                    
                    $this->_aViewData['oxidAbonnes'] = $sNbAbonnes;
                    $this->_aViewData['oxidDesabonnes'] = $sNbDesabonnes;
                    
                }
                
            }
            
            return $this->_sThisTemplate;	
  	}
        
        public function savemode() {
            
            $myConfig = $this->getConfig();
            
            $myConfig->saveShopConfVar("str", "mailjet_contactlist_id", trim(oxConfig::getParameter('contactlist_id')), null, "module:twmailjet");
            $myConfig->saveShopConfVar("select", "mailjet_contactlist_synchronize", trim(oxConfig::getParameter('contactlist_sync')), null, "module:twmailjet");
            
        }
        
        public function sync() {

            $aMails = array();
            $iNb = 0;
            $sSql = "SELECT oxemail FROM oxnewssubscribed WHERE oxdboptin = 1";
            $rs = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->Execute($sSql);
            
            if($rs != false && $rs->RecordCount() > 0) {
                while(!$rs->EOF) {
                    $aMails[] = $rs->fields('oxemail');
                    $iNb++;
                    $rs->MoveNext();
                }
            }
            
            if(count($aMails)>0) {
                $myConfig = $this->getConfig();
                $sContactListId = $myConfig->getShopConfVar('mailjet_contactlist_id', null, 'module:twmailjet');
                
                define(TWMAILJET_MAILJET_API_KEY,$myConfig->getShopConfVar('mailjet_api_key', null, 'module:twmailjet'));
                define(TWMAILJET_MAILJET_SECRET_KEY,$myConfig->getShopConfVar('mailjet_secret_key', null, 'module:twmailjet'));
                $oMailjet = oxNew('Mailjet');

                $params = array(
                    'method' => 'POST',
                    'id' => $sContactListId,
                    'contacts' => implode(',',$aMails)
                );
                
                $response = $oMailjet->listsAddManyContacts($params);

                if($response === false) {
                    $this->_aViewData['erreur'] = "Erreur : l'ajout des contacts n'a pas fonctionné ou aucun email n'a été ajouté";
                }
                else {
                    $this->_aViewData['info'] = $iNb." email".($iNb>1 ? "s" : "")." ".($iNb>1 ? "ont" : "a")." été envoyé à Mailjet";
                }
            
            }
        }
        
        
}
?>
