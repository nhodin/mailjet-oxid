<?php

$aModule = array(
    'id'           => 'twmailjet',
    'title'        => 'Connecteur Mailjet - Take it Web',
    'description'  => array(
        'fr'=>'Synchronisez votre liste de contacts Mailjet avec vos abonnés newsletter et configurez l\'envoi des emails.<br/>Si vous ne possédez pas de compte chez Mailjet, <a href="http://fr.mailjet.com/?p=TAKEITWEB" target="_blank" style="text-decoration:underline">ouvrez un compte gratuitement</a>',
    ),
    'thumbnail'    => 'mailjet.png',
    'version'      => '1.0',
    'author'       => 'Take it Web',
    'url'          => 'http://www.takeitweb.fr/modules-oxid/',
    'email'        => 'contact@takeitweb.fr',
    'extend'       => array(
        'oxnewssubscribed'  => 'twmailjet/classes/twmailjet_oxnewssubscribed',
        'oxemail'  => 'twmailjet/classes/twmailjet_oxemail',
    ),
    'files'        => array(
        'Mailjet' => 'twmailjet/classes/mailjet/php-mailjet.class-mailjet-0.1.php',
        'twmailjet_configuration' => 'twmailjet/views/admin/twmailjet_configuration.php',
        'twmailjet_contactlist' => 'twmailjet/views/admin/twmailjet_contactlist.php',
    ),
    'events'       => array(
    ),
    'templates'    => array(
        'twmailjet_configuration.tpl' => 'twmailjet/out/tpl/admin/twmailjet_configuration.tpl',
        'twmailjet_contactlist.tpl' => 'twmailjet/out/tpl/admin/twmailjet_contactlist.tpl',
    ),
    'settings'     => array(
        array('group' => 'twmailjet', 'name' => 'mailjet_contactlist_id', 'type' => 'str',  'value' => ''),
        array('group' => 'twmailjet', 'name' => 'mailjet_contactlist_synchronize', 'type' => 'select',  'value' => 'Oui', 'constrains' => 'Oui|Non'),
        array('group' => 'twmailjet', 'name' => 'mailjet_api_key', 'type' => 'str',  'value' => ''),
        array('group' => 'twmailjet', 'name' => 'mailjet_secret_key', 'type' => 'str',  'value' => ''),
        array('group' => 'twmailjet', 'name' => 'mailjet_smtp_port', 'type' => 'select',  'value' => '25', 'constrains' => '25|465|587'),
        array('group' => 'twmailjet', 'name' => 'mailjet_smtp_server', 'type' => 'str',  'value' => 'in.mailjet.com'),
    )
);