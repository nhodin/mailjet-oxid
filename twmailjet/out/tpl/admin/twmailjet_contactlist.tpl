<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
        <title>Configuration de la liste des contacts</title>
    
    <style type="text/css">
        body {
            margin:20px;
            font-family:Arial;
        }
        
        table {
            border-collapse:collapse;
            text-align:center;
        }
        
        td,th {
            padding:2px 4px;
        }
        
    </style>
    
    <script type="text/javascript">
        
    </script>
</head>
<body>
<div class="tiw_export_csv">	
    
    <h1>Configuration de la liste des contacts</h1>  
    
    <div>
        [{if $mailjet_ok}]
        <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
            [{ $oViewConf->getHiddenSid() }]
            <input type="hidden" name="cl" value="twmailjet_contactlist">
            <input type="hidden" name="fnc" value="savemode">
            
            Mode de synchronisation  :
            <br/><select name="contactlist_sync">
                <option value="Oui" [{if $contactlist_sync == "Oui"}]selected="selected"[{/if}]>Toutes les nouvelles inscriptions à la newsletter seront enregistrées dans Mailjet</option>
                <option value="Non" [{if $contactlist_sync == "Non"}]selected="selected"[{/if}]>Aucune inscription ne sera enregistrée dans Mailjet</option>
            </select>
            <br/>
            [{if $contactlist_list}]
                Liste de contacts à synchroniser :
                <br/>
                <select name="contactlist_id">
                    <option value="" [{if "" == $contactlist_id}]selected="selected"[{/if}]></option>
                    [{foreach from=$contactlist_list->lists item=list}]
                        <option value="[{$list->id}]" [{if $list->id == $contactlist_id}]selected="selected"[{/if}]>[{$list->label}]</option>
                    [{/foreach}]
                </select>
            [{else}]
                Identifiant de la liste des contacts à synchroniser :
                <br/><input type="text" name="contactlist_id" value="[{$contactlist_id}]" style="width:100px"/>
            [{/if}]
            <br/><br/>
            <input type="submit" name="saveexclude" value="Enregistrer" />
        </form>
            
            [{if $erreur}]
            <div class="errorbox">
                    <p style="color: red; font-weight: bold;">[{ $erreur}]</p>
            </div>
            <br>
        [{/if}]
        
        [{if $info}]
            <div class="errorbox">
                    <p style="color: green; font-weight: bold;">[{ $info}]</p>
            </div>
            <br>
        [{/if}]
        
        [{if $stats}]
            
            <table border="1">
                <tr>
                    <th></th>
                    <th>Mailjet "[{$stats->label}]"</th>
                    <th>Oxid</th>
                </tr>
                <tr>
                    <td>Emails abonnés</td>
                    <td>[{$stats->subscribers}]</td>
                    <td>[{$oxidAbonnes}]</td>
                </tr>
                <tr>
                    <td>Emails désabonnés</td>
                    <td>[{if $stats->unsub}][{$stats->unsub}][{else}]0[{/if}]</td>
                    <td>[{$oxidDesabonnes}]</td>
                </tr>
            </table>
                
            <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
                [{ $oViewConf->getHiddenSid() }]
                <input type="hidden" name="cl" value="twmailjet_contactlist">
                <input type="hidden" name="fnc" value="sync">
                <br/>
                <input type="submit" value="Synchroniser les abonnés vers Mailjet" />
            </form>
            
        [{/if}]
            
       [{else}]
           <div class="errorbox">
                    <p style="color: red; font-weight: bold;">Veuillez configurer les paramètres API ou SMTP de Mailjet</p>
            </div>
            <br>
       [{/if}]
            
       
            
            
    </div>

</div>
</body>            
</html>