<?php
error_reporting(0);




class Colors {
 private $foreground_colors = array();
 private $background_colors = array();
 
 public function __construct() {
 // Set up shell colors
 $this->foreground_colors['black'] = '0;30';
 $this->foreground_colors['dark_gray'] = '1;30';
 $this->foreground_colors['blue'] = '0;34';
 $this->foreground_colors['light_blue'] = '1;34';
 $this->foreground_colors['green'] = '0;32';
 $this->foreground_colors['light_green'] = '1;32';
 $this->foreground_colors['cyan'] = '0;36';
 $this->foreground_colors['light_cyan'] = '1;36';
 $this->foreground_colors['red'] = '0;31';
 $this->foreground_colors['light_red'] = '1;31';
 $this->foreground_colors['purple'] = '0;35';
 $this->foreground_colors['light_purple'] = '1;35';
 $this->foreground_colors['brown'] = '0;33';
 $this->foreground_colors['yellow'] = '1;33';
 $this->foreground_colors['light_gray'] = '0;37';
 $this->foreground_colors['white'] = '1;37';
 
 $this->background_colors['black'] = '40';
 $this->background_colors['red'] = '41';
 $this->background_colors['green'] = '42';
 $this->background_colors['yellow'] = '43';
 $this->background_colors['blue'] = '44';
 $this->background_colors['magenta'] = '45';
 $this->background_colors['cyan'] = '46';
 $this->background_colors['light_gray'] = '47';
 }
 
 // Returns colored string
 public function getColoredString($string, $foreground_color = null, $background_color = null) {
 $colored_string = "";
 
 // Check if given foreground color found
 if (isset($this->foreground_colors[$foreground_color])) {
 $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
 }
 // Check if given background color found
 if (isset($this->background_colors[$background_color])) {
 $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
 }
 
 // Add string and end coloring
 $colored_string .=  $string . "\033[0m";
 
 return $colored_string;
 }
 
 // Returns all foreground color names
 public function getForegroundColors() {
 return array_keys($this->foreground_colors);
 }
 
 // Returns all background color names
 public function getBackgroundColors() {
 return array_keys($this->background_colors);
 }
 }

/**
* Décryptage md5 par BruteForce
*
* @copyright Copyright (C) 2014 Sergent Brico http://www.sergentbrico.com
*/ 
/* Debut Configuration */
  // Tableau contenant la liste des md5 à décrypter




  $tab_md5=array( 
    "900150983cd24fb0d6963f7d28e17f72", // = "abc"
    "5d41402abc4b2a76b9719d911017c592", // = "hello"
    "011134986548f3458aa3e7e2a7fceb8d", // = "cfg"
    "47bce5c74f589f4867dbd57e9ca9f808", // = "aaa"
    "001cbc059a402b3be7c99be558eaaf73", // = "bed"
    "e0554c47283b1c9f77ac5909bc8f5f10", // = "zwan"
    "af3692f22addb6d89aacf25a0c03282f" // = "vauban123"
  );

function getmtime()
{
    $temps = explode(' ',  microtime());
    return $temps[1] + $temps[0];
}


function replaceOut($str, $resend=false)
{
    echo "\033[K";
    $numNewLines = substr_count($str, "\n");
    echo chr(27) . "[0G"; // Set cursor to first column
    echo $str;
    echo "\033[K";
    echo chr(27) . "[" . $numNewLines ."A"; // Set cursor up x lines
    if($resend == true){
      echo $str;
    }
}

function recurs($longueur, $position, $base, $task)
{
  global $charset, $tab_md5, $cs_debut, $cpt, $tab2_md5, $total, $task;
  foreach($charset as $char)
  {
    $decrypte=$base.chr($char);
    if ($position < $longueur - 1) 
    {
      recurs($longueur, $position + 1, $decrypte);
    }
    else
    {
      $cpt++;
      // Affichage de la progression au fur et à mesure
      if($cpt%10000==0)
      {
        $temps=round(getmtime() - $cs_debut,2);
        $vitesse=round($cpt/$temps);
        $pourcentage=round($cpt*100/$total);
        $temps_restant=round( ($total*$temps/$cpt)-$temps);
        replaceOut("Thread $task : ".iconv('ASCII', 'UTF-8//IGNORE', $decrypte)." ".$temps."s ".$vitesse."mdp/s. ".$pourcentage."% Restant : ".round($temps_restant/60)." min = (".round($temps_restant/60/60).") heures = (".round($temps_restant/60/60/24).") jours\n", false);
        flush();
        ob_flush(); 
      }
      $crypte=md5($decrypte);

      // Si la chaine cryptée existe
      if( isset($tab2_md5[$crypte]) )
      {
        if(isset( $decrypte{$longueur-1} ) && $longueur-$position<3) 
        { 
        $temps=round(getmtime() - $cs_debut,2);
        if($temps == NULL){
          $temps = "< 0";
         }
         // Create new Colors class
         $colors = new Colors();
         $fgs = $colors->getForegroundColors();
         $nbresult = $nbresult+1;
        if ($nbresult == 1){
        echo $result = "\n  ".$colors->getColoredString("Hash trouver => md5(".$decrypte.") = ".$crypte." en ".$temps."s", "blue", "black")."\n";
         } else {
        echo $result =  replaceOut("  ".$colors->getColoredString("Hash trouver => md5(".$decrypte.") = ".$crypte." en ".$temps."s", "blue", "black")."\n", true);
        }
        }
      }
    }
  $nbresult++;
  }
}


$tasks = array('1','2', '3');
foreach($tasks as $task) {
    $pid = pcntl_fork();

    if($pid == -1) {
            exit("Error forking...\n");
    } else if($pid == 0) {

          if($task == 1){

  // Nombre de caractères minimum et maximum à tester
  $min=1; // Minimum
  $max=2; // Maximum
  // Définition du charset à utiliser
  $alpha_min_task1  = 1; // Lettres minuscules, 0 ou 1
  $chiffres_task1   = 1; // Chiffres, 0 ou 1
  $alpha_maj_task1  = 1; // Lettres majuscules, 0 ou 1
  $alpha_acc_task1  = 0; // Lettres accentuées
  $tous_task1   = 0; // Tous caractères
/*************************/

$cs_debut = getmtime(); // Initialisation du compteur durée
 
$tab2_md5 = array_fill_keys($tab_md5, '');
 
$charset=array();
if($alpha_min_task1==1)   $charset=array_merge($charset,range(97, 122));
if($chiffres_task1==1)  $charset=array_merge($charset,range(48, 57));
if($alpha_maj_task1==1)   $charset=array_merge($charset,range(65, 90));
if($alpha_acc_task1==1)   $charset=array_merge($charset,range(192, 255));
if($tous_task1==1)    $charset=array_merge($charset,range(1, 255));
 
// Calcul du nombre total de mots de passe à générer
$total=0; 
for($i=$max;$i>=$min;$i--)
{
  $total+=pow(count($charset),$i);
}
echo "Nombre total de possibilités : ".$total."\n";
 
$cpt=0; // Initiatlisation du compteur de mots de passe générés
$nbresult = 0;

// Génération des mots de passe
for($longueur = $min; $longueur <= $max; ++$longueur)
{
  recurs($longueur, 0, '', $task); 
}
//echo "\n\n".'Fin Hash Test pass1 : '.round(getmtime() - $cs_debut,2).' s.avec '.$cpt.' tentatives.'."\n\n";
//echo "\n\n>> Fin du Thread 1 << \n\n";
pcntl_wait($status); //Protect against Zombie children
exit;
}
 
if($task == 2){
  // Nombre de caractères minimum et maximum à tester
  $min=3; // Minimum
  $max=4; // Maximum
  // Définition du charset à utiliser
  $alpha_min  = 1; // Lettres minuscules, 0 ou 1
  $chiffres   = 1; // Chiffres, 0 ou 1
  $alpha_maj  = 1; // Lettres majuscules, 0 ou 1
  $alpha_acc  = 0; // Lettres accentuées
  $tous   = 0; // Tous caractères
/*************************/

$cs_debut = getmtime(); // Initialisation du compteur durée
 
$tab2_md5 = array_fill_keys($tab_md5, '');
 
$charset=array();
if($alpha_min==1)   $charset=array_merge($charset,range(97, 122));
if($chiffres==1)  $charset=array_merge($charset,range(48, 57));
if($alpha_maj==1)   $charset=array_merge($charset,range(65, 90));
if($alpha_acc==1)   $charset=array_merge($charset,range(192, 255));
if($tous==1)    $charset=array_merge($charset,range(1, 255));
 
// Calcul du nombre total de mots de passe à générer
$total=0; 
for($i=$max;$i>=$min;$i--)
{
  $total+=pow(count($charset),$i);
}
//echo "Nombre total de possibilités : ".$total."\r\n";
 
$cpt=0; // Initiatlisation du compteur de mots de passe générés
$nbresult = 0;

// Génération des mots de passe
for($longueur = $min; $longueur <= $max; ++$longueur)
{
  recurs($longueur, 0, '', $task); 
}
pcntl_wait($status); //Protect against Zombie children
exit;
}

if($task == 3){
  // Nombre de caractères minimum et maximum à tester
  $min=5; // Minimum
  $max=6; // Maximum
  // Définition du charset à utiliser
  $alpha_min  = 1; // Lettres minuscules, 0 ou 1
  $chiffres   = 1; // Chiffres, 0 ou 1
  $alpha_maj  = 1; // Lettres majuscules, 0 ou 1
  $alpha_acc  = 0; // Lettres accentuées
  $tous   = 0; // Tous caractères
/*************************/

$cs_debut = getmtime(); // Initialisation du compteur durée
 
$tab2_md5 = array_fill_keys($tab_md5, '');
 
$charset=array();
if($alpha_min==1)   $charset=array_merge($charset,range(97, 122));
if($chiffres==1)  $charset=array_merge($charset,range(48, 57));
if($alpha_maj==1)   $charset=array_merge($charset,range(65, 90));
if($alpha_acc==1)   $charset=array_merge($charset,range(192, 255));
if($tous==1)    $charset=array_merge($charset,range(1, 255));
 
// Calcul du nombre total de mots de passe à générer
$total=0; 
for($i=$max;$i>=$min;$i--)
{
  $total+=pow(count($charset),$i);
}
//echo "Nombre total de possibilités : ".$total."\r\n";
 
$cpt=0; // Initiatlisation du compteur de mots de passe générés
$nbresult = 0;

// Génération des mots de passe
for($longueur = $min; $longueur <= $max; ++$longueur)
{
  recurs($longueur, 0, '', $task); 
}
pcntl_wait($status); //Protect against Zombie children
exit;
}
}
}
while(pcntl_waitpid(0, $status) != -1);
?>
