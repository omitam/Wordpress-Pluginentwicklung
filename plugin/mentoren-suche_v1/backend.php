<?php
require_once('mentoren-suche.php');

/**
* Pflegt den Menüpunkt "Mentoren Suche" ein (als Top-Level 
* Menüpunkt)
*/
function register_Mentees_menu() {
	add_menu_page(__('Mentoren Suche','mentoren-suche'), __('Mentoren Suche','mentoren-suche'),'unfiltered_html', 'mentees', 'ms_row_edit');
}


/**
* Pflegt den Untermenüpunkt/submenu "Datensatz eintragen"
* in das Menue "Mentorensuche" ein
*/
function me_dataset_import() {
	add_submenu_page( 'mentees', __('Datensatz eintragen','mentoren-suche'), __('Datensatz eintragen','mentoren-suche'), 'unfiltered_html', 'row-import', 'ms_row_new');
}

/**
* Pflegt den Untermenüpunkt/submenu "Daten importieren" unter 
* ins Menue "Mentorensuche" ein
*/
function me_data_import() {
	add_submenu_page( 'mentees', __('CSV importieren','mentoren-suche'),__('CSV importieren','mentoren-suche'), 'unfiltered_html', 'csv-import', 'ms_csv_import' );  
}
/**
* Pflegt den Untermenüpunkt/submenu "Einstellungen" 
* in das Menue "Mentorensuche" ein
*/
function me_config() {
	add_submenu_page( 'mentees', __('Einstellungen','mentoren-suche'), __('Einstellungen','mentoren-suche'),'unfiltered_html', 'ms-options', 'ms_getOptionsPage' ); 
}

	
/**
* Darstellung der Backend-Seite "Einstellungen".
*
* Letzte Aenderung: 23.05.2012
*/
function ms_getOptionsPage()
{
  global $title;
  echo "<h1>".$title."</h1>";
  echo "<p>".__('Auf dieser Seite nehmen Sie Einstellungen f&uuml;r das  Plugin vor.','mentoren-suche')."</p>";
echo "<h2>".__('Frontend-Seiten:','mentoren-suche')."</h2>";
   echo "<p>".__('Geben Sie in die Textfelder den (absoluten) Pfad zur Seite und eine Beschreibung (Linktext) an. - Es erscheint ein Link mit der angebenen Beschreibung, auf der entsprechenden Seite.','mentoren-suche')."</p>";
   echo "<form action=\" \" method=\"post\">
       <table>
          <tr>
            <th align=\"left\">".__('Suchformular:','mentoren-suche')."</th>
            <td><label for=\"ms_options_frontendsearch_url\">&nbsp;".__('URL:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_frontendsearch_url\" 
                       value=\"";?><?php echo 
                       get_option('ms_frontend_searchform_url');?>
                       <?php echo "\">&nbsp;&nbsp;
                       <label for=\"ms_options_frontendsearch_urltext\">&nbsp;".__('Linktext:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_frontendsearch_urltext\" 
                       value=\"";?><?php echo 
                       get_option('ms_frontend_searchform_urltext');?>
                       <?php echo "\">
                       
                       
                       </td>
          </tr>
          <tr>
            <th>".__('Mentoren-Details:','mentoren-suche')."</th>
            <td><label for=\"ms_options_mentDetails_url\">&nbsp;".__('URL:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_mentDetails_url\" 
                       value=\"";?><?php echo 
                       get_option('ms_frontend_mentDetails_url');?>
                       <?php echo "\">&nbsp;&nbsp;
                       <label for=\"ms_options_mentDetails_urltext\">&nbsp;".__('Linktext:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_mentDetails_urltext\" 
                       value=\"";?><?php echo 
                       get_option('ms_frontend_mentDetails_urltext');?>
                       <?php echo "\">
                       
                       
                       </td>
          </tr>
          <tr>
            <td colspan=\"2\">&nbsp;</td>
          </tr>
          <tr>
           <td colspan=\"2\">
           ".__('Hier k&ouml;nnen Sie die Kontaktdaten der Person einpflegen, die es bei Problemen zu kontaktieren gilt.','mentoren-suche')."
           </td>
          <tr>
          <th align=\"left\">".__('Fehler-Seite:','mentoren-suche')."</th>
          <td><label for=\"ms_options_contact_name\">&nbsp;".__('Name:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_contact_name\" 
                       value=\"";?><?php echo 
                       get_option('ms_error_kontakt_name');?>
                       <?php echo "\">&nbsp;&nbsp;
                       <label for=\"ms_options_contact_email\">&nbsp;".__('E-Mail:','mentoren-suche')."</label>
                  <input type=\"text\" size=\"50\" 
                       name=\"ms_options_contact_email\" 
                       value=\"";?><?php echo 
                       get_option('ms_error_kontakt_email');?>
                       <?php echo "\">
                       
                       
             </td>
           </tr>
            <td colspan=\"2\"><input type=\"submit\" 
                name=\"ms_options_save\" 
                value=\"".__('Speichern','mentoren-suche')."\"></td>
          </tr>
                     
       </table>
   </form>";
 
    if(isset($_POST['ms_options_save']))
  {
    ms_options_update();
    echo "<h2 class=\"ms_info_message\">".
         __('Bitte aktualisieren Sie die Browseransicht (z.B. 
            mit F5), um die ver&auml;nderten Daten zu 
            sehen.','mentoren-suche')."</h2>"; 
  }
}	
/**
* Aktualisiert die Einstellungen, die in der FUnktione getOptionsPage()
* verwendet werden.
*
* Letzte Aenderung: 26.07.2012
*/
function ms_options_update() {
    //Suchformular:
    update_option('ms_frontend_searchform_url',               
                   $_POST['ms_options_frontendsearch_url']);
    update_option('ms_frontend_searchform_urltext',               
                   $_POST['ms_options_frontendsearch_urltext']); 
                   
    //Anzeige der Details zum Mentor:                             
    update_option('ms_frontend_mentDetails_url',          
                   $_POST['ms_options_mentDetails_url']);
    update_option('ms_frontend_mentDetails_urltext',          
                   $_POST['ms_options_mentDetails_urltext']);
    //Kontakt-Person bei nicht vorhandenen Eintr&auml;gen (Mentees):               
    update_option('ms_error_kontakt_name',          
                   $_POST['ms_options_contact_name']);
    update_option('ms_error_kontakt_email',          
                   $_POST['ms_options_contact_email']);                               
                                           
  
}
/**
* Oberflaeche fuer "Datensatz eintragen" 
*
* Letzte Aenderung: 31.07.2012
*/
function ms_row_new() {
	
	global $wpdb;
	global $title;
	echo "<h1>".$title."</h1>";
	
echo "<div id=\"ms_row_new\">  
        <div class=\"register-form\">  
        <div class=\"title\">  ".
           "<h3>".__('Mentor eintragen','mentoren-suche')."</h3>
        </div>  
            <form action=\"\" method=\"post\">  
            <p>".__('Vorname','mentoren-suche').":<br><input type=\"text\" name=\"ms_m_vorname\" id=\"ms_m_vorname\" class=\"input\" size=\"50\" maxlength=\"50\"/>  </p>
            <p>".__('Name','mentoren-suche').":<br><input type=\"text\" name=\"ms_m_name\" id=\"ms_m_name\" class=\"input\" size=\"50\" maxlength=\"50\" /> </p>
            <p>".__('E-Mail','mentoren-suche').":<br><input name=\"ms_m_email\" type=\"text\" id=\"ms_m_email\" class=\"input\" size=\"50\" maxlength=\"50\"></p>
			<p>".__('Bild','mentoren-suche').":<br><input type=\"text\" name=\"ms_m_bild\" id=\"ms_m_bild\" class=\"input\" size=\"50\" maxlength=\"250\" /> </p>";

			do_action('ms_insert_mentor');

echo " <input type=\"submit\" value=\"Eintragen\" id=\"register\" />  
            <hr />   
            </form>  
</div></div>  ";

  	$my_result = $wpdb->get_results( 
	"SELECT mentoren_mid, mentoren_vorname, mentoren_name FROM ".MENTOR_TABLE);

echo "<div id=\"ms_row_new2\">  
        <div class=\"register-form\">  
        <div class=\"title\">".
           "<h3>".__('Mentees eintragen','mentoren-suche')."</h3>
      </div>  
		<form action=\"\" method=\"post\">  
            <p>".__('MatrikelNr','mentoren-suche').":<br><input type=\"text\" name=\"ms_me_matrikelnr\" id=\"ms_me_matrikelnr\" class=\"input\" size=\"10\" maxlength=\"8\" />  </p>
            <p>".__('Vorname','mentoren-suche').":<br><input type=\"text\" name=\"ms_me_vorname\" id=\"ms_me_vorname\" class=\"input\" size=\"50\" maxlength=\"50\" />   </p>
            <p>".__('Name','mentoren-suche').":<br><input type=\"text\" name=\"ms_me_name\" id=\"ms_me_name\" class=\"input\" size=\"50\" maxlength=\"50\" /> </p>
            
			<p>".__('Mentor','mentoren-suche').":<br><select name=\"ms_me_mentoren\" size=\"1\">";
			foreach ( $my_result as $one_row ) 
			{
				echo "<option value=\"".$one_row->mentoren_mid." \">". $one_row->mentoren_name.", ".$one_row->mentoren_vorname."</option>";
			}
			echo "</select></p>
			
			<p>".__('Gruppe','mentoren-suche').":<br><input name=\"ms_me_gruppe\" type=\"text\" id=\"ms_me_gruppe\" class=\"input\" size=\"50\" maxlength=\"50\"></p>";

			do_action('ms_insert_mentee');			
			echo "<input type=\"submit\" value=\"Eintragen\" id=\"register\" />   
            </form>  
</div></div>  ";

}
	
/**
* Zeigt die Datens&auml;tze der Mentees mit ihren Mentoren an.
* Je Datensatz wird ein Bearbeiten- und ein L&ouml;schen-Button angeboten.
*
* Letzte Aenderung: 13.08.2012
*/
function ms_row_edit() {

  global $wpdb;
	global $title;
	echo "<h1>".$title."</h1>";
 if(!isset($_POST['send_data_edit'])) //Bearbeiten-Button
 {
  $sql="SELECT ms.mentees_matrikelnr,ms.mentees_name, ". 
       "ms.mentees_vorname, ms.mentees_gruppe,me.mentoren_name, ".
       "me.mentoren_vorname, me.mentoren_email, ".
       "me.mentoren_bild ".
       "FROM ".MENTEE_TABLE." ms JOIN ".MENTOR_TABLE." me ON ".   
       "ms.mentees_mid=me.mentoren_mid ".
       "ORDER BY ms.mentees_name,ms.mentees_vorname";
              
   $results=$wpdb->get_results($sql);
   if($wpdb->num_rows > 0)
   {
    echo "<div class=\"ms_backend_wrapper\">";
    echo "<table border=\"1\" class=\"ms_row_edit_table\">
         <tr><td colspan=\"10\" align=\"center\">
           <form action=\" \" method=\"post\">
             ";
             do_action('hk_delete_all_data');
             
    echo "<input type=\"submit\" name=\"send_all_data_delete\" id=\"send_all_data_delete\" value=\""
                       .__('Alle Datens&auml;tze l&ouml;schen','mentoren-suche')."\">
           </form>
           </td>
         </tr>
         <tr>
           <td class=\"table_row\" style=\"border:0px;\"
               colspan=\"4\"><h3>".
               __('Menteedaten','mentoren-suche')."</h3></th>
           <td  style=\"text-align:center;
 border-left:1px solid;\" colspan=\"4\"><h3>".__('Daten des zugeordneten Mentors','mentoren-suche')."</h3></td>
         </tr>
          <tr>
           <th class=\"table_row\">".
            __('Matrikelnummer','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Name','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Vorname','mentoren-suche')."</th>
           <th class=\"table_row\"
               style=\"border:1px solid;\">".
               __('Gruppe','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Name','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Vorname','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Email','mentoren-suche')."</th>
           <th class=\"table_row\">".
               __('Bild','mentoren-suche')."</th>
           <th class=\"table_row\">&nbsp;</th>
           <th class=\"table_row\">&nbsp;</th>
         </tr>";
         foreach($results as $row)
         {
                echo "<tr>
                  <td>".$row->mentees_matrikelnr."</td>
                  <td>".$row->mentees_name."</td>
                  <td>".$row->mentees_vorname."</td>
                  <td style=\"border-right: 1px solid;\">".$row->mentees_gruppe."</td>
                  <td>".$row->mentoren_name."</td>
                  <td>".$row->mentoren_vorname."</td>
                  <td>".$row->mentoren_email."</td>
                  <td>".$row->mentoren_bild."</td>
                  <td><form action=\"\" method=\"post\">";
                   do_action('hk_edit_data');
                  
                  echo "
                      <input type=\"submit\" name=\"send_data_edit\" value=\""
                       .__('Bearbeiten','mentoren-suche')."\">
                       <input type=\"hidden\" name=\"edit_mentee_id\" value=\"".$row->mentees_matrikelnr."\">
                      </form>
                  </td>
                  <td>
                     <form action=\"\" method=\"post\">
                     ";
                       do_action('hk_delete_data'); 
                     
                     echo "
                      <input type=\"submit\" name=\"send_data_delete\" value=\""
                       .__('L&ouml;schen','mentoren-suche')."\">
                       <input type=\"hidden\" name=\"delete_mentee_id\" value=\"".$row->mentees_matrikelnr."\">
                      </form>
                  </td> 
                </tr>";
          }//End of foreach
      
           
       echo "</table>"; echo "</div>";
       
	  }//End if
     else echo "<h2 class=\"ms_info_message\"> ".
               __('Es sind aktuell keine Datens&auml;tze vorhanden!','mentoren-suche')
           ."</h2>";
 }
  else{
        ms_showEditDataForm();       
      }          
 }//End of Function

/**
* Zeigt das Bearbeiten-Formular mit dem entsprechenden
* ausgewaehlten Datensatz an.
*
* Letzte Aenderung: 13.08.2012
*/
function ms_showEditDataForm()
{
 global $wpdb;
 
 if(isset($_POST['send_data_edit']))
 {
   $edit_mentee_id = $_POST['edit_mentee_id']; //Matrikelnummer
 
    $sql="SELECT ms.mentees_matrikelnr,ms.mentees_name, ms.mentees_mid,".
         "ms.mentees_vorname, ms.mentees_gruppe,me.mentoren_name, ".
         "me.mentoren_vorname, me.mentoren_email, me.mentoren_bild ".
         "FROM ".MENTEE_TABLE." ms JOIN ".MENTOR_TABLE." me ON ".   
         "ms.mentees_mid=me.mentoren_mid ". 
         "WHERE ms.mentees_matrikelnr ='".$edit_mentee_id."'".
         "ORDER BY ms.mentees_name,ms.mentees_vorname";
 
    $result_one_row=$wpdb->get_row($sql);
     
        echo "<div class=\"ms_showEditDataForm_Frame\">
         <form action=\"\" method=\"post\">  
         <h3>".__('Mentor bearbeiten','mentoren-suche')."</h3>                  
         <p>".__('Vorname','mentoren-suche').":<br><input type=\"text\" name=\"ms_m_vorname_edit\" id=\"ms_m_vorname_edit\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentoren_vorname."\"/>  </p>
            <p>".__('Name','mentoren-suche').":<br><input type=\"text\" name=\"ms_m_name_edit\" id=\"ms_m_name_edit\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentoren_name."\" /> </p>
            <p>".__('E-Mail','mentoren-suche').":<br><input name=\"ms_m_email_edit\" type=\"text\" id=\"ms_m_email_edit\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentoren_email."\"></p>
      <p>".__('Bild (URL)','mentoren-suche').":<br><input name=\"ms_m_picture_edit\" type=\"text\" id=\"ms_m_picture_edit\" class=\"input\" size=\"50\" maxlength=\"100\" value=\"".$result_one_row->mentoren_bild."\"></p>
         </div>
         <div class=\"ms_showEditDataForm_Frame_Mentee\"> 
            <form action=\"\" method=\"post\">  
         <h3>".__('Mentee bearbeiten','mentoren-suche')."</h3>                  
<p>".__('Matrikelnummer','mentoren-suche').":<br>
<input type=\"text\" name=\"ms_me_matrikelnr_edit\" id=\"ms_me_matrikelnr_edit\" class=\"input\" size=\"10\" maxlength=\"8\"  value=\"".$result_one_row->mentees_matrikelnr."\"/>  </p>
            <p>".__('Vorname','mentoren-suche').":<br><input type=\"text\" name=\"ms_me_vorname_edit\" id=\"ms_me_vorname_edit\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentees_vorname."\" />   </p>
            <p>".__('Name','mentoren-suche').":<br><input type=\"text\" name=\"ms_me_name_edit\" id=\"ms_me_name_edit\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentees_name."\" /> </p>
 <p>".__('Gruppe','mentoren-suche').":<br><input name=\"ms_me_gruppe_edit\" type=\"text\" id=\"ms_me_gruppe\" class=\"input\" size=\"50\" maxlength=\"50\" value=\"".$result_one_row->mentees_gruppe."\"></p>
</div>
<div class=\"ms_showEditDataForm_Frame2\">";
              
echo "<input type=\"hidden\" name=\"ms_me_menteesmid_edit\" value=\"".$result_one_row->mentees_mid."\"/>
<input type=\"hidden\" name=\"ms_me_matrikelNr_edit\" value=\"".$result_one_row->mentees_matrikelnr."\"/>    
<input type=\"submit\" value=\"".__('Speichern','mentoren-suche')."\" name=\"send_ds_edit\" id=\"send_ds_edit\" />  
 </form>  
</div>";   
 }
  ms_editData();  
} 
/**
* Fuehrt die Aenderung der Mentoren- und Menteedaten
* durch.
*
* Letzte Aenderung: 08.08.2012
*/
function ms_editData()
{
  global $wpdb;

 if(isset($_POST['send_ds_edit'])){
    echo "<div class=\"backend_detail_box\" style=\"border: 0px;\">";
   //Mentoren
   $ms_m_vorname_edit = $_POST['ms_m_vorname_edit'];
   $ms_m_name_edit = $_POST['ms_m_name_edit'];
   $ms_m_email_edit = $_POST['ms_m_email_edit'];
   $ms_m_picture_edit = $_POST['ms_m_picture_edit'];
   //Mentee
   $ms_me_matrikelnr_edit = $_POST['ms_me_matrikelnr_edit'];
   $hidden_matrikelNr = $_POST['ms_me_matrikelNr_edit'];
   $ms_me_vorname_edit = $_POST['ms_me_vorname_edit'];
   $ms_me_name_edit = $_POST['ms_me_name_edit'];
   $ms_me_gruppe_edit = $_POST['ms_me_gruppe_edit'];
   $ms_me_menteesmid_edit = $_POST['ms_me_menteesmid_edit'];
      
   if(!empty($ms_me_matrikelnr_edit) &&
      !empty($ms_me_vorname_edit) &&
      !empty($ms_me_name_edit) &&
      !empty($ms_me_gruppe_edit) && 
      !empty($ms_m_vorname_edit) &&
      !empty($ms_m_name_edit) &&
      !empty($ms_m_email_edit))
   {
   
   
   if (strlen($ms_me_matrikelnr_edit) == 8){ 
   	 $wpdb->update( MENTEE_TABLE, array( 
       'mentees_matrikelnr' => utf8_encode($ms_me_matrikelnr_edit),  
       'mentees_name' => utf8_encode($ms_me_name_edit), 
       'mentees_vorname' => utf8_encode($ms_me_vorname_edit),  
       'mentees_gruppe' => utf8_encode($ms_me_gruppe_edit) ),  
       array('mentees_matrikelnr' => utf8_encode($hidden_matrikelNr)));	   
	
   $wpdb->update( MENTOR_TABLE, array( 
        'mentoren_name' => utf8_encode($ms_m_name_edit), 
        'mentoren_vorname' => utf8_encode($ms_m_vorname_edit), 
        'mentoren_email' => utf8_encode($ms_m_email_edit), 
        'mentoren_bild' => utf8_encode($ms_m_picture_edit)),  
        array('mentoren_mid' => utf8_encode($ms_me_menteesmid_edit)));	
   
   } else {
   
	echo "<div 
            class=\"ms_error_message\">".
            __('Bitte sorgen Sie daf&uuml;r, dass die Matrikelnr. achtstellig ist.','mentoren-suche')."</div>"; 
  }
     

  } //End of if (!empty(...) && ...)
   
  else{
        echo "<div 
            class=\"ms_error_message\">".
            __('Bitte sorgen Sie daf&uuml;r, dass alle Felder (Au&szlig;nahme: Bild-URL beim Mentor) ausgef&uuml;llt sind.','mentoren-suche')."</div>"; 
    }
	   echo "<h2 class=\"ms_info_message\">".
         __('Bitte aktualisieren Sie die Browseransicht (z.B. 
            mit F5), um die ver&auml;nderten Daten zu 
            sehen.','mentoren-suche')."</h2>";      
  } // End of isset($_POST['send_ds_edit'])
 echo "</div>"; 
} // End of Function

/**
* Zeigt das Loeschen-Formular fuer den Datensatz an.
*
* Letzte Aenderung: 13.08.2012
*/
function ms_showDeleteDataForm()
{
 global $wpdb;

  $send_data_delete=$_POST['send_data_delete'];
  $delete_mentee_id=$_POST['delete_mentee_id'];
  
  if(isset($send_data_delete))
  { 
   //Zugeordneten Mentor (=> Mentor-ID) ermitteln
    $sql_mentorID="SELECT mentees_mid ".
                  "FROM ".MENTEE_TABLE.   
                  " WHERE mentees_matrikelnr ='".
                  $delete_mentee_id."'";
    $rs_mentorID=$wpdb->get_row($sql_mentorID);
    
    //Anzeige:  
    echo "<div class=\"backend_detail_box\">";
    echo "<h2 class=\"ms_info_message\">".sprintf(__('Soll der Datensatz mit der angegebenen Matrikelnummer %d wirklich gel&ouml;scht werden?','mentoren-suche'),$delete_mentee_id)."</h2>
<h2 class=\"ms_info_message\">".__('Bitte beachten Sie, dass der zugeordnete Mentordatensatz erst gel&ouml;scht wird, wenn der letzte, zugeordnete Menteedatensatz gel&ouml;scht wurde.','mentoren-suche')."</h2>

"; echo "<div class=\"ms_showDeleteDataForm_SecQuery\">
         <table><tr><td>";
   echo "<form action=\"\" method=\"post\">";        
         echo "
         <input type=\"submit\" name=\"ms_enter_delete_op\"
         id=\"ms_enter_delete_op\"  value=\"".__('Ja','mentoren-suche')."\">
         <input type=\"hidden\" name=\"ms_delete_op_id\"
          id=\"ms_delete_op_id\" value=\"".$delete_mentee_id."\">
<input type=\"hidden\" name=\"ms_delop_mentorID\"
          id=\"ms_delop_mentorID\" value=\"".$rs_mentorID->mentees_mid."\">
        </form></td>
        <td>&nbsp;</td>
        <td>
        <form action=\"\" method=\"post\">
         <input type=\"submit\" name=\"cancel_delete_op\" value=\"".__('Nein','mentoren-suche')."\">
         </form>
         </td> 
         </tr>
         </table>
         ";
     echo "</div>"; 
    echo "</div>";
    
  }
   ms_deleteData(); 
} 
/**
* F&uuml;hrt eine Sicherheitsabfrage durch, ob der Benutzer
* wirklich ALLE Datens&auml;tze l&ouml;schen m&ouml;chte.
*
* Letzte Aenderung: 23.05.2012
*/
function ms_deleteAllDataMessage()
{
  if(isset($_POST['send_all_data_delete'])){
     echo "<div class=\"backend_detail_box\">";
     echo "<h2 class=\"ms_info_message\">".
                __('Sollen wirklich alle Datens&auml;tze '.
                   'gel&ouml;scht werden?',
                   'mentoren-suche')."</h2>";
     echo "<div class=\"ms_deleteAllDataMessage_SecQuery\">
         <table><tr><td>";
     echo "<form action=\"\" method=\"post\">";
       echo "
         <input type=\"submit\" name=\"enter_deleteAllData_op\" 
                id=\"enter_deleteAllData_op\" 
                value=\"".__('Ja','mentoren-suche')."\">";
       echo "         
         </form></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
        <form action=\"\" method=\"post\">
         <input type=\"submit\" name=\"cancel_delete_op\" 
                value=\"".__('Nein','mentoren-suche')."\">
         </form>
         </td> 
         </tr>
         </table>
         ";
     echo "</div>";      
    echo "</div>";
  }
  ms_deleteAllData();  
}
/**
* F&uuml;hrt das L&ouml;schen aller Datens&auml;tze durch, die
* in beiden - zum Plugin zugeh&ouml;rigen - Tabellen 
* eingetragen sind.
*
* Letzte Aenderung: 30.07.2012
*/
function ms_deleteAllData()
{
 global $wpdb;
 
 if(isset($_POST['enter_deleteAllData_op']))
    {
      $wpdb->query("DELETE FROM ".MENTOR_TABLE);
      $wpdb->query("DELETE FROM ".MENTEE_TABLE);
    }
}

/**
* Fuehrt den Loeschvorgang eines Datensatzes durch.
*
* Letzte Aenderung: 15.11.2012
*/
function ms_deleteData()
{  
  global $wpdb;
  //Matrikelnummer des zu loeschenden Mentees:
  $ms_delete_op_id = $_POST['ms_delete_op_id']; 
  //Zugeordneter Mentor (=> Mentor-ID):
  $ms_delop_mentorID = $_POST['ms_delop_mentorID'];
  
  if(isset($_POST['ms_enter_delete_op']))
  {
   /*Pruefen, ob der zugeordnete Mentor bei weiteren Mentees 
     zugeordnet wurde*/
      $sql="SELECT COUNT(mentees_matrikelnr) AS 'anzahl' ". 
           "FROM ".MENTEE_TABLE." ".
           "WHERE mentees_mid='".$ms_delop_mentorID."'";
      $rs_anzZeilen = $wpdb->get_row($sql);     
 
      if($rs_anzZeilen->anzahl>1)
     {
        //Nur den Mentee loeschen
          $wpdb->query("DELETE FROM ".MENTEE_TABLE.
                       " WHERE mentees_matrikelnr='".
                         $ms_delete_op_id."'");  
                     
                                  
     } 
     else{
            //Mentee loeschen             
             $wpdb->query("DELETE FROM ".MENTEE_TABLE.
                         " WHERE mentees_matrikelnr='".
                         $ms_delete_op_id."'");          
            //Mentor darf auch geloescht werden
            $wpdb->query("DELETE FROM ".MENTOR_TABLE.
                         " WHERE mentoren_mid='".
                           $ms_delop_mentorID."'");          
                                                   
         }
    
  }

}
/**
* Eine CSV Datei mit dem Format matrikelnr;name;vorname;mentor-gruppe wird ausgewählt, die Mentees werden eingelesen
*
* HINWEIS: zuerst MENTOREN einfügen, sonst kann die ID aus der MENTOR Tabelle nicht übernommen werden.
* Ergänzung: Sollte der Mentor für den Mentee noch nicht vorhanden sein, wird der Mentor mit seinem Nachnamen angelegt,
* und muss später mit Vorname etc. vervollständigt werden.
* die selbe CVS kann mehrmals importiert werden, wenn vermutet wird das nicht alle Mentees verarbeitet wurden.
*
* Datum der Änderung: 26.07.2012
*/
function ms_csv_import() {
	
	global $title;
	echo "<h1>".$title."</h1>";

	global $wpdb;
	
echo __('&Uumlbernimmt CSV-Dateien mit dem Format matrikelnr;name;vorname;mentor-gruppe','mentoren-suche');

echo "<div class=\"wrap\">
    <form class=\"add:the-list: validate\" method=\"post\" enctype=\"multipart/form-data\">

        <!-- File input -->
        <p><label for=\"csv_import\">".__('Datei hochladen','mentoren-suche').":</label><br/>
            <input name=\"thefile\" id=\"thefile\" type=\"file\" value=\"\" aria-required=\"true\" /></p>
			
			

        <p class=\"submit\"><input type=\"submit\" class=\"button\" name=\"submit\" value=\"Import\" /></p>
    </form>
</div>";

//////////////////////////////////////////////////////////////
// aus alter version entnehmen wie die abprüfung stattfand, falls file nicht extra im WP upload ordner hinterlegt werden soll
IF (isset($_FILES['thefile']['tmp_name']) AND ($_FILES['thefile']['tmp_name'] == TRUE)) {


		if (($handle = fopen($_FILES['thefile']['tmp_name'], "r")) !== FALSE) {
	
					echo __('Ausgabe:','mentoren-suche');
					echo "<br>";
	
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
		
			$teile = explode("-", $data[3]);

		global $wpdb;
	
		$my_result = $wpdb->get_results( 
		"
		SELECT mentoren_mid
		FROM ".MENTOR_TABLE." WHERE mentoren_name = '".utf8_encode($teile[0])."'");

		$mentor = NULL;			

					foreach ( $my_result as $one_row ) 
				{
						$mentor = $one_row->mentoren_mid;		
				}

					$matrikelnr = $data[0];
					$name = utf8_encode($data[1]); 
					$vorname = utf8_encode($data[2]); 
					$gruppe = utf8_encode($data[3]); 
							
				IF ($mentor == NULL) {	

					$rows_affected = $wpdb->insert( MENTOR_TABLE, array( 'mentoren_name' => utf8_encode($teile[0]), ) );
					
          echo "<h3 class=\"ms_info_message\">".
					sprintf( __('Mentor %s wurde mit seinem Nachnamen angelegt, bitte Mentoren Stammdaten vervollst&auml;ndigen','mentoren-suche'), utf8_encode($teile[0]))	
					."</h3><br/>";			
					
					$mentor = NULL;
					// mentor variable  leer, für seine ID wird auf das letzte eingefügte autoincrement zugegriffen 
					$rows_affected = $wpdb->insert(MENTEE_TABLE, array( 'mentees_matrikelnr' => $matrikelnr, 'mentees_name' => $name, 'mentees_vorname' => $vorname, 'mentees_gruppe' => $gruppe, 'mentees_mid' => $wpdb->insert_id, ) );
					
				} else {
					$rows_affected = $wpdb->insert(MENTEE_TABLE, array( 'mentees_matrikelnr' => $matrikelnr, 'mentees_name' => $name, 'mentees_vorname' => $vorname, 'mentees_gruppe' => $gruppe, 'mentees_mid' => $mentor, ) );
				}
		}
		fclose($handle);
			
		echo "<br/>";
    echo "<h3 class=\"ms_info_message\">".
		     sprintf( __('Verarbeitung der Datei %s 
         abgeschlossen.','mentoren-suche'), 
         $_FILES['thefile']['name'])		
		     ."<br/>";				
		
	
	}

} else {

echo __('Bitte eine Datei ausw&auml;hlen die Mentee Daten beinhaltet.','mentoren-suche');
}


}

/**
* 
* Funktion speichert Mentoren in die Mentoren Tabelle,  
* nachdem der submit-button bestätigt wurde.
*
* Letzte Aenderung: 31.07.2012
*/
function ms_m_data_insert() {

	global $wpdb;

	if(isset($_POST['ms_m_name']) and isset($_POST['ms_m_vorname']) and isset($_POST['ms_m_email'])) {

	if(!empty($_POST['ms_m_name']) && !empty($_POST['ms_m_vorname']) && !empty($_POST['ms_m_email']))
	{		
	  $name = $_POST['ms_m_name']; 
	  $vorname = $_POST['ms_m_vorname']; 
	  $email = $_POST['ms_m_email'];
	  $bild = $_POST['ms_m_bild'];
	
	$rows_affected = $wpdb->insert(MENTOR_TABLE, array( 'mentoren_name' => $name, 'mentoren_vorname' => $vorname, 'mentoren_email' => $email, 'mentoren_bild' => $bild, ) );
	
	} else {
		echo "<h3 class=\"ms_error_message\">".__('Bitte alle Pflichtfelder ausf&uumlllen!','mentoren-suche')."</h3>";
	}

	}
}
/**
* 
* Funktion speichert Mentees in die Mentee-Tabelle, nachdem 
* der submit-button bestätigt wurde
*
* Letzte Aenderung: 15.11.2012
*/
function ms_me_data_insert() {

	global $wpdb;
	

	if(isset($_POST['ms_me_matrikelnr']) and isset($_POST['ms_me_vorname']) and isset($_POST['ms_me_name']) and isset($_POST['ms_me_gruppe']) and isset($_POST['ms_me_mentoren'])) {
	
		if(!empty($_POST['ms_me_matrikelnr']) && !empty($_POST['ms_me_vorname']) && !empty($_POST['ms_me_name']) && !empty($_POST['ms_me_gruppe']) && !empty($_POST['ms_me_mentoren']))
			{
		
		if (strlen($_POST['ms_me_matrikelnr']) == 8){
		
			
		$mtrklnr = NULL;
		
		$my_result4 = $wpdb->get_results( 
		"
		SELECT mentees_matrikelnr
		FROM ".MENTEE_TABLE." WHERE mentees_matrikelnr = '".$_POST['ms_me_matrikelnr']."'");			

		foreach ( $my_result4 as $one_row ) 
		{
			$mtrklnr = $one_row->mentees_matrikelnr;		
		}
		
		if($mtrklnr == NULL) {
		$matrikelnr = $_POST['ms_me_matrikelnr'];
		$name = $_POST['ms_me_name']; 
		$vorname = $_POST['ms_me_vorname']; 
		$gruppe = $_POST['ms_me_gruppe']; 
		$mentor = $_POST['ms_me_mentoren'];

	$rows_affected = $wpdb->insert(MENTEE_TABLE, array( 'mentees_matrikelnr' => $matrikelnr, 'mentees_name' => $name, 'mentees_vorname' => $vorname, 'mentees_gruppe' => $gruppe, 'mentees_mid' => $mentor, ) );
	
			if ( $wpdb->query($sql) == false){
				if ( $wp_error ) {
					return new WP_Error( 'db_query_error',
						__( 'Could not execute query' ), $wpdb->last_error );
				}
			} else {
				echo "<h3 class=\"ms_info_message\">".__('Datensatz eingefuegt','mentoren-suche')."</h3>";
			}	
		
		
		} elseif($mtrklnr != NULL) {
      echo "<h3 class=\"ms_error_message\">".
			 sprintf( __('MatrikelNr %s bereits in der Datenbank vorhanden!','mentoren-suche'), $_POST['ms_me_matrikelnr'])	
			."</h3><br/>";	
		}
		
		
		} else {

		echo "<h3 class=\"ms_error_message\">".
			 sprintf( __('Bitte sorgen Sie daf&uuml;r, dass die Matrikelnr. achtstellig ist.','mentoren-suche'))."</h3><br/>";			

		
		}	
		
		} else {
			"<h3 class=\"ms_error_message\">".__('Bitte alle Pflichtfelder ausf&uumlllen!','mentoren-suche')."</h3>";
		}

		
	}
}


//Installation der Datenbank 1 und später 2
global $jal_db_version;
$jal_db_version = "1.0";


/**
* Erstellen der ms_mentoren-Tabellen mit dem jeweiligen 
* Praefix
*/
function mentor_db_create() {
   global $wpdb;
   global $jal_db_version;

     
   $sql = "CREATE TABLE ".MENTOR_TABLE." (
        mentoren_mid int(2) NOT NULL AUTO_INCREMENT,
        mentoren_name varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci
        NOT NULL,
        mentoren_vorname varchar(50) CHARACTER SET utf8 COLLATE 
        utf8_unicode_ci NOT NULL,
        mentoren_email varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci 
        NOT NULL,
        mentoren_bild text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
        PRIMARY KEY (`mentoren_mid`)
     );";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("jal_db_version", $jal_db_version);
}

/**
* Erstellen der ms_mentees-Tabellen mit dem jeweiligen 
* Praefix
*/
function mentees_db_create() {
   global $wpdb;
   global $mentees_db_version;

   //$table_name = $wpdb->prefix . "ms_mentees";
      
   $sql = "CREATE TABLE ".MENTEE_TABLE." (
     mentees_matrikelnr char(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci  
     NOT NULL,
     mentees_name varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci 
     NOT NULL,
     mentees_vorname varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci 
     NOT NULL,
     mentees_gruppe varchar(52) CHARACTER SET utf8 COLLATE utf8_unicode_ci 
     NOT NULL,
     mentees_mid int(2) NOT NULL,
     PRIMARY KEY (`mentees_matrikelnr`),
     KEY mentees_name (`mentees_name`),
     KEY mentees_mid (`mentees_mid`)
    );";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("mentees_db_version", $mentees_db_version);
}
/** 
* Nachdem Deaktivieren des Plugins, werden die beiden 
* Tabellen "ms_mentoren" und "ms_mentees", jeweils mit dem * * angelegten Prefix, gelöscht
*/
function pluginUninstall() {
	global $wpdb;
	
  //Angelegte Optionen loeschen:
	delete_option('mentees_db_version');
  delete_option('ms_frontend_searchform_url');
  delete_option('ms_frontend_searchform_urltext');
  delete_option('ms_frontend_mentDetails_url');
  delete_option('ms_frontend_mentDetails_urltext');
  delete_option('ms_error_kontakt_name');
  delete_option('ms_error_kontakt_email');
	
	//Tabellen loeschen:
  $sql = "DROP TABLE ".MENTOR_TABLE;
	$wpdb->query($sql);

	$sql = "DROP TABLE ".MENTEE_TABLE;
	$wpdb->query($sql);
}
/*EOF*/