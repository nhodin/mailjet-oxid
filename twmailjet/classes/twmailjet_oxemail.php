<?php

class twmailjet_oxemail extends twmailjet_oxemail_parent {
    
    /*
     * Permet de forcer l'adresse expéditeur à être l'adresse de contact de la boutique Oxid
     * Sans cela, Mailjet enverra une alerte à chaque fois qu'un client envoie un message de contact
    */
    public function setFrom( $sFromAdress, $sFromName = null )
    {
        $oShop = $this->_getShop();

        $sFromAdress = $oShop->oxshops__oxinfoemail->value;
        $sFromName   = $oShop->oxshops__oxname->getRawValue();

        try {
            parent::setFrom( $sFromAdress, $sFromName );
        } catch( Exception $oEx ) {
        }
    }    
    
    public function sendTestEmail()
    {
        $oLang = oxLang::getInstance();
        
        // shop info
        $oShop = $this->_getShop();

        //set mail params (from, fromName, smtp)
        $this->_setMailParams( $oShop );

        // create messages
        $oSmarty = $this->_getSmarty();

        // Process view data array through oxoutput processor
        $this->_processViewArray();

        $this->setBody( "Email de test Mailjet / Oxid" );
        $this->setAltBody( "Email de test Mailjet / Oxid" );
        $this->setSubject( "Email de test Mailjet / Oxid" );

        $this->setRecipient( $oShop->oxshops__oxinfoemail->value );
        $this->setFrom( $oShop->oxshops__oxinfoemail->value, $oShop->oxshops__oxname->getRawValue() );
        $this->setReplyTo( $oShop->oxshops__oxinfoemail->value, $oShop->oxshops__oxname->getRawValue() );

        return $this->send();
    }
    
}

?>
