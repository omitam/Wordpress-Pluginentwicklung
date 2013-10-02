<?php
/*
Plugin Name: Mentoren-Suche
Description: Suchfunktion der Mentoringgruppe f&uuml;r Mentees
Version: 1.0
Author: Timo Amling, Ludger Sch&ouml;nfeld, Anatol Tissen im Auftrag von Mentoring4Excellence (FH K&ouml;ln, Campus Gummersbach - Programmleitung: Frau Prof. Dr. Gabriele Koeppe)- im August 2012
License: GPL
*/
//Textdom&auml;ne fuer die Internationalisierung anmelden
add_action('init','ms_load_translation_file'); 

// Konstanten f&uuml;r Version, sonstige Einstellungen
global $wpdb;
define('MENTOR_TABLE',$wpdb->prefix.'ms_mentoren');
define('MENTEE_TABLE',$wpdb->prefix.'ms_mentees');

define('MS_MIN_WORDPRESS_VERSION', '3.0');
add_action('init', 'MS_MIN_WORDPRESS_VERSION');

// Definition der Ereignisse (=> add_action(), add_filter())
require_once('backend.php');

//Die Registrierung des Menues (Backend)
add_action('admin_menu', 'register_Mentees_menu');
add_action('admin_menu', 'me_dataset_import');
add_action('admin_menu', 'me_data_import');
add_action('admin_menu', 'me_config');

//wenn check erfolgreich, werden DB-Tabellen angelegt
add_action('hk_mentees_db_create','mentees_db_create');
add_action('hk_mentor_db_create','mentor_db_create');

add_action('ms_insert_mentor','ms_m_data_insert');
add_action('ms_insert_mentee','ms_me_data_insert');

//Optionen anlegen
add_option('ms_frontend_searchform_url','','',yes);
add_option('ms_frontend_searchform_urltext','','',yes);
add_option('ms_frontend_mentDetails_url','','',yes);
add_option('ms_frontend_mentDetails_urltext','','',yes);
add_option('ms_error_kontakt_name','','',yes);
add_option('ms_error_kontakt_email','','',yes);

//Eigene Actions (insbes. zur Auswertung von Formularen)*/
add_action('hk_edit_data','ms_showEditDataForm');
add_action('hk_delete_data','ms_showDeleteDataForm');
add_action('hk_delete_data_op','ms_deleteData');
add_action('hk_edit_data_op','ms_editData');
add_action('hk_delete_all_data','ms_deleteAllDataMessage');
add_action('hk_ms_options_update','ms_options_update');

//Deaktivieren ruft pluginUninstall auf, die beide DB-Tabellen löscht ms_mentees und ms_mentoren
register_deactivation_hook( __FILE__, 'pluginUninstall');

// Definition des Shortcodes
require_once('frontend.php');
add_shortcode('mentoren-suche','showSearchArea');

//Registrierung der speziellen CSS-Datei
define('PLUGIN_DIR','mentoren-suche');
$src=plugins_url(PLUGIN_DIR.'/css/mentoren_suche.css');
wp_register_style('mentoren_suche',$src);
wp_enqueue_style('mentoren_suche');

// Spezielle Funktionen fuer Einstellungen
/**
* Laedt die entsprechende Uebersetzungsdatei.  
*/
function ms_load_translation_file(){
  $plugin_path = plugin_basename(dirname(__FILE__).'/lang');
  load_plugin_textdomain('mentoren-suche',false,$plugin_path); 
}

/**
* Prüft aktuelle Wordpress Version, ob Plugin installiert 
* werden darf oder nicht.
*/
function MS_MIN_WORDPRESS_VERSION() {
   global $wp_version;
   
   $exit_msg='"Mentoren Suche" benötigt WordPress '
      .MS_MIN_WORDPRESS_VERSION
      .' or newer. 
      <a href="http://codex.wordpress.org/Upgrading_WordPress">Wordpress Download</a>';
      
   if (version_compare($wp_version,MS_MIN_WORDPRESS_VERSION,'<'))
   {
       exit ($exit_msg);
   }
  
  do_action('hk_mentees_db_create');
  do_action('hk_mentor_db_create');
  
   // sonst muss hier die do_action von den Datenbanekn hin.
   
}
/*EOF*/

