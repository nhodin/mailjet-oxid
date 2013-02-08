<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
        <title>Configuration SMTP</title>
    
    <style type="text/css">
        body {
            margin:20px;
            font-family:Arial;
        }
        
    </style>
    
    <script type="text/javascript">
        
    </script>
</head>
<body>
<div class="tiw_export_csv">	
    
    <h1>Configuration SMTP</h1>  
    
  [{if $erreur}]
        <div class="errorbox">
                <p style="color: red; font-weight: bold;">[{ $erreur}]</p>
        </div>
        <br>
    [{/if}]
    
    <div>
        <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
            [{ $oViewConf->getHiddenSid() }]
            <input type="hidden" name="cl" value="twmailjet_configuration">
            <input type="hidden" name="fnc" value="savesmtp">
            
            <em>Vous trouverez toutes les informations nécessaires à la configuration du SMTP<br/>à cette adresse : <a href="https://www.mailjet.com/account/setup" target="_blank">https://www.mailjet.com/account/setup</a></em>
            <br/><br/>
            Serveur SMTP :
            <br/><input type="text" name="smtp_serveur" value="[{$smtp_serveur}]" style="width:400px"/>
            <br/>
            Port SMTP :
            <br/><input type="text" name="smtp_port" value="[{$smtp_port}]" style="width:400px"/>
            <br/>
            Utilisateur (clé API) :
            <br/><input type="text" name="smtp_user" autocomplete="off" value="[{$smtp_user}]" style="width:400px"/>
            <br/>
            Mot de passe (clé secrète) :
            <br/><input type="password" name="smtp_password" autocomplete="off" value="[{$smtp_password}]" style="width:400px"/>
            <br/>
            <input type="checkbox" name="force_oxid_smtp" value="1" checked="checked" /> Modifier la configuration SMTP d'Oxid 
            <br/><br/>
            <input type="submit" name="saveexclude" value="Enregistrer" />
        </form>
            
        <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
            [{ $oViewConf->getHiddenSid() }]
            <input type="hidden" name="cl" value="twmailjet_configuration">
            <input type="hidden" name="fnc" value="testsmtp">
            <input type="submit" name="test_smtp" value="Envoyer un email de test à [{$address_test}]" />
            [{if $infosmtp}]
                <div class="info">
                        <p style=" font-weight: bold;">[{ $infosmtp}]</p>
                </div>
                <br>
            [{/if}]
        </form>
            
    </div>

</div>
</body>            
</html>