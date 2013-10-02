<?php
require_once('mentoren-suche.php');

/**
* Zeigt die Suchmaske fuer das Frontend an.
*/
function showSearchArea()
{ 
  $send_mentorenSearch = $_POST['send_mentorSearch']; 
  $name=$_POST['mentee_name'];
  $matrikelNr=$_POST['matrikelNr'];
  
  //Entsch&auml;rfung der HTML-&PHP-Tags
  $matrikelNr=strip_tags(htmlspecialchars($matrikelNr));
  $name=strip_tags(htmlspecialchars($name));
  
    
  if(isset($send_mentorenSearch))
  {
     if(!empty($name) && !empty($matrikelNr))
    {
        //LUDGER - 15.11.2012: CSS-Klasse f&uuml;r fetten Text eingef&uuml;hrt (text_bold)
        echo "<div class=\"ms_submitted_data\"><h3>".__('Sie haben folgende Daten eingegeben:')
         ."</h3><span class=\"text_bold\">".
            __('Ihre Matrikelnummer:','mentoren-suche')."</span>&nbsp$matrikelNr<br /><span class=\"text_bold\">".
            __('Ihr Name:','mentoren-suche')."</span>&nbsp;$name";
         echo "</div>";
         getSearchResults($name,$matrikelNr);
     } else echo  "<p class=\"ms_error_message\">".
       __('Bitte f&uuml;llen Sie alle Felder'           
          .' aus!','mentoren-suche')."<br /> <br />
          <a href=\"".$_SERVER['REQUEST_URI']."\">".__('Zur&uuml;ck '
          .'zur Suche','mentoren-suche')."</a></p>";     
 }
 else{
   echo "<div class=\"ms_searchbox\">";
   echo "<h3>".
     __('Um Ihren/Ihre Mentor/in zu finden, geben Sie bitte Ihre '. 
     'Matrikelnummer und Ihren Nachnamen in die entsprechenden '.  
     'Felder.','mentoren-suche')."</h3>";
  echo "<div class=\"ms_searchbox_form\">
        <form action=\" \" method=\"post\">
          <p align=\"left\" class=\"label_matrikelnr\">".
           __('Matrikelnummer:','mentoren-suche')."
            <input type=\"text\" name=\"matrikelNr\" size=\"10\" 
            maxlength=\"8\" id=\"matrikelNr\"/>
          </p>   
          <p align=\"left\" class=\"label_name\">".
             __('Ihr Nachname:','mentoren-suche')."
             <input type=\"text\" name=\"mentee_name\" size=\"30\" 
             maxlength=\"50\" id=\"mentee_name\"/>
          </p>
         <p align=\"center\">
         <input type=\"submit\" name=\"send_mentorSearch\" 
                 id=\"send_mentorSearch\" 
                 value=\"".__('Suchen','mentoren-suche')."\"/></td>
         </p>   
    </form>
  </div>";
  echo "<div class=\"ms_searchform_url\">";
    echo "<a href=\""?><?php echo  
         get_option('ms_frontend_searchform_url');?><?php echo "\">"; ?>
         <?php echo  
         get_option('ms_frontend_searchform_urltext');?>
   <?php
   echo "
         </a>";
  echo "</div>";
  echo "</div>";
 }
}

/**
* Fuehrt die Suche auf der Datenbank aus und stellt das Ergebnis im 
* Frontend dar.
* @param $name Name des Mentees
* @param $matrikelNr Matrikelnummer des Mentees
*/
function getSearchResults($name="",$matrikelNr="")
{
  global $wpdb;
  
 
    $sql="SELECT ms.mentees_matrikelnr, ms.mentees_name, ms.mentees_vorname, "
                    ."ms.mentees_gruppe,me.mentoren_name,me.mentoren_vorname,me.mentoren_email, "
                    ."me.mentoren_bild FROM ".MENTEE_TABLE." ms JOIN ".MENTOR_TABLE." me ON "  
                    ."ms.mentees_mid=me.mentoren_mid "
                    ."WHERE ms.mentees_name=%s AND "  
                    ."ms.mentees_matrikelnr=%s";
    $result=$wpdb->get_row( $wpdb->prepare($sql,
                    $name,$matrikelNr));
  
   if($result !=null) //es gibt einen Datensatz
   { 
      echo "<br /><h3 id=\"ms_result_caption\">".__('Ihr(e) Mentor(in)   ist:','mentoren-suche')."</h3>";
     echo "<div id=\"ms_result_print_container\">
           <div id=\"ms_results_columnnames\"><b>". 
            __('Name:','mentoren-suche')."</b><br /><b>". 
            __('Vorname:','mentoren-suche')."</b><br /><b>".         
            __('Kontakt:','mentoren-suche')."</b><br /><br /><b>".
            __('Gruppe:','mentoren-suche')."</b><br />".
         "</div>
       <div id=\"ms_results_values\">".
        $result->mentoren_name."<br />". 
        $result->mentoren_vorname."<br />".
        str_replace ('@','[at]', $result->mentoren_email)."<br /><br />".
        $result->mentees_gruppe
      ."</div>
      <div id=\"ms_result_mentorimage\">
      <img src=\"".$result->mentoren_bild."\" title=\"".$result->mentoren_name.", ".$result->mentoren_vorname."\" alt=\"".$result->mentoren_name.", ".$result->mentoren_vorname."\"/>
   </div>
   </div>";
    echo "<div class=\"ms_result_url\">";
    echo "<a href=\""?><?php echo  
         get_option('ms_frontend_mentDetails_url');?><?php echo "\">"; ?>
         <?php echo  
         get_option('ms_frontend_mentDetails_urltext');?>
   <?php
   echo "
         </a>";
  echo "</div>";
  }
    else echo "<p class=\"ms_error_message\">".
         sprintf(__('Kein Datensatz mit der angegebenen '.   
              'Matrikelnummer und Namen vorhanden!- Bitte pr&uuml;fen Sie, 
               ob Sie sich vertippt haben.  
               Sollte dies nicht der Fall sein, kontaktieren Sie bitte 
               ','mentoren-suche').'%s (%s)',
               get_option('ms_error_kontakt_name'),
               get_option('ms_error_kontakt_email')
               ).".<br /><br />
               <a href=\"".$_SERVER['REQUEST_URI']."\">".__('Zur&uuml;ck zur Suche','mentoren-suche')."</a>
              </p>";
}

/*EOF*/