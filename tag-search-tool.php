<html lang="es-ES">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Curacion de discusion | Rockdio Radio </title> 

<meta name="Content-Type" content="text/html; charset=utf-8" />
<meta name="Content-language" content="es-ES" />
<meta name="organization" content="RockDio"/>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="styles/all.css" />


</head>
<?php
/*header('Content-Type: text/html; charset=ISO-8859-1');*/
date_default_timezone_set('Europe/Warsaw');

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
$cont=0;
$intro=0;
$repo=0;


$patron= 'tag'; // tag o foll
$precandidates=array();	  // pre-construccion para analisis mas profundo
//Parametros de Followers Lista a los seguidores de
$upto=200;
$menosque=20;
$benefactor="bebeth";

//echo $today; // future $benefactor    = $_POST['benefactor'];

// Tags settings analisys
$today= time();


//post a excluir
$serie=array('uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte');

$numeros=array('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20');
//${$serie[0]}++;
//echo ${$serie[0]};



if (!isset($_POST["edad"])) 
{
    $edad= "5";               // Maximo dias desde publicado
} else 
{
    $edad=$_POST["edad"];
}

if (!isset($_POST["etiqueta"])) 
{
    $etiqueta="castellano";   // La etiqueta a analizar
} else 
{
    $etiqueta=$_POST["etiqueta"];
}

if (!isset($_POST["cuenta"])) 
{
    $eti_count="100";         // Cuantos posts analizamos
} else 
{
    $eti_count=$_POST["cuenta"];
}

if (!isset($_POST["numvotos"])) 
{
    $vote_count="1000";        // Maximo numero de votos
} else 
{
    $vote_count=$_POST["numvotos"];        // Maximo numero de votos
}

if (!isset($_POST["maxsbd"])) 
{
    $max_money= "2";        // Maximo SBD prometido
} else 
{
    $max_money=$_POST["maxsbd"];        // Maximo SBD prometido
}


if (!isset($_POST["mincomentarios"])) 
{
    $min_children= "0";       // Minimo de comentarios
} else 
{
    $min_children=$_POST["mincomentarios"];       // Minimo de comentarios
}


if (isset($_POST["excluir"])) {
    $excluir=explode(",", strtolower($_POST["excluir"]));
    $existeExcluir=true;
} else
{
    $excluir=array();
    $existeExcluir=false;
}

if (isset($_POST["ultimopost"])) {
    $ultimoPost=$_POST["ultimopost"];
} else
{
    $ultimoPost=0;
}

if (isset($_POST["ultimoautor"])) {
    $ultimoAutor=$_POST["ultimoautor"];
} else
{
    $ultimoAutor="";
}

if (isset($_POST["mostrar"])) {
    $mostrar=$_POST["mostrar"];
} else
{
    $mostrar="si";
}

if (isset($_POST["resultados"])) {
    $resultados=$_POST["resultados"];
} else
{
    $resultados="10";
}


if ($patron==='tag'){
  
/*  if ($ultimoPost>0)
  {
    $curl = curl_init("https://api.steemjs.com/get_discussions_by_children?query=%7B%22tag%22%3A%22$etiqueta%22%2C%20%22limit%22%3A%20%22$eti_count%22%2C%20%22start_permlink%22%3A%20%22$ultimoPost%22%2C%20%22start_author%22%3A%20%22$ultimoAutor%22%2C%20%22sort%22%3A%20%22author%22%7D");
  } else
    {
        $curl = curl_init("https://api.steemjs.com/get_discussions_by_children?query=%7B%22tag%22%3A%22$etiqueta%22%2C%20%22limit%22%3A%20%22$eti_count%22%2C%20%22sort%22%3A%20%22author%22%7D");       
    } 
*/  
        $curl = curl_init("https://api.steemjs.com/get_discussions_by_children?query=%7B%22tag%22%3A%22$etiqueta%22%2C%20%22limit%22%3A%20%22$eti_count%22%2C%20%22sort%22%3A%20%22author%22%7D");       
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  // Send the request
  $result = curl_exec($curl);
  // Free up the resources $curl is using
  curl_close($curl);
  $steemdat = json_decode($result);
  //print_r($result);
  $cn = -1;
  $match = 0;
  $posts_found = count($steemdat); 
  ?>
  
  <div id="pagina">
  
  <div></div>
  
  <div class="forma">
  <div class="logo">
    <img src="reveur.png" />
  </div>
    <form action="spanishh.php" method="post" class="forma">
        <label>Máximo días desde publicado: </label>
        <input class="entrada" type="text" name="edad" value="<?php echo $edad; ?>" /><br/>
        <label>Etiqueta a analizar: </label>
        <input class="entrada" type="text" name="etiqueta" value="<?php echo $etiqueta; ?>" /><br/>
        <label>Máximo posts a analizar: </label>
        <input class="entrada" type="text" name="cuenta" value="<?php echo $eti_count; ?>" /><br/>
        <label>Número máximo de votos: </label>
        <input class="entrada" type="text" name="numvotos" value="<?php echo $vote_count; ?>" /><br/>
        <label>Máximo SBD: </label>
        <input class="entrada" type="text" name="maxsbd" value="<?php echo $max_money; ?>" /><br/>
        <label>Mínimo de comentarios: </label>
        <input class="entrada" type="text" name="mincomentarios" value="<?php echo $min_children; ?>" /><br/>
        <label>Etiquetas a revisar: </label>
        <input class="entrada" type="text" name="excluir" value="<?php echo $_POST['excluir']; ?>" /><br/>
        <label>¿Mostrar?: </label>
        Si <input class="entrada" type="radio" name="mostrar" value="si" <?php if ($mostrar=="si") echo "checked"; ?>/>
        No <input class="entrada" type="radio" name="mostrar" value="no" <?php if ($mostrar=="no") echo "checked"; ?> /><br/>
      
        <!--label>Resultados por página: </label>
        10 <input class="entrada" type="radio" name="resultados" value="10" <?php if ($resultados=="10") echo "checked"; ?>/>
        20 <input class="entrada" type="radio" name="resultados" value="20" <?php if ($resultados=="20") echo "checked"; ?>/>
        50 <input class="entrada" type="radio" name="resultados" value="50" <?php if ($resultados=="50") echo "checked"; ?> /><br/ -->
        <label> </label><input class="boton" type="submit" name="soloenviar"/>
  </div>

<?php
  if (isset($_POST['soloenviar']))
  {
  ?>
  
  <div class="titulo-principal">
  <h1><?php echo($etiqueta); ?></h1>
  </div>
  
  <div class="tabla">
    <div class="header">
        <div class="titulo-tabla">Artículos que cumplen con los parámetros</div>
        <div class="titulo-tabla">de un máximo</div>
    </div>
    <div class="linea">
        <div class="celda"><?php echo $posts_found; ?></div>
        <div class="celda"><?php echo $eti_count; ?></div>
    </div>

  </div>

  <div class="tabla1">
    <div class="header">
        <div class="titulo-tabla">Antiguedad</div>
        <div class="titulo-tabla">Max Votos</div>
        <div class="titulo-tabla">Max Recompensa</div>
        <div class="titulo-tabla">Min de commentarios</div>
    </div>
    <div class="linea">
        <div class="celda"><?php echo $edad; ?></div>
        <div class="celda"><?php echo $vote_count; ?></div>
        <div class="celda"><?php echo $max_money; ?></div>
        <div class="celda"><?php echo $min_children; ?></div>
    </div>

</div>


<?php

  
 	echo "<br/>***<br/>`Nota: Edad = Antiguedad en dias | V = Votos | C = Comentarios o respuestas | T = Tipo`<br/><br/>";
?>
  <div class="tabla2">
    <div class="header">
        <div class='titulo-tabla'><titulo>Titulo</titulo></div>
        <div class='titulo-tabla'><autor>Autor</autor></div>
        <div class='titulo-tabla'><recompensa>Recompensa</recompensa></div>
        <div class='titulo-tabla'><vo>Vo</vo></div>
        <div class='titulo-tabla'><com>Com</com></div>
   </div>

<?php
    $contador=0;
    $excluidos=0;
    $ultimoPost=0;
    
    
  foreach ($steemdat as $comkey) {
    $cn++;
    $pos="--";
    $vida=$today-strtotime($steemdat[$cn]->created);
	$vida = round($vida/86400,4);
//    $title=iconv("UTF-8", "ISO-8859-1//TRANSLIT",$steemdat[$cn]->title);
    $title=$steemdat[$cn]->title;
	$recompensa= round(preg_replace("/[^0-9,.]/", "", $steemdat[$cn]->pending_payout_value),2);
	$enlace=$steemdat[$cn]->author."/".$steemdat[$cn]->permlink;
        if ($vida < $edad && $steemdat[$cn]->net_votes < $vote_count && $recompensa < $max_money && $steemdat[$cn]->children > $min_children)
        {
        
        $ultimoPost++;

        if ($existeExcluir)
        {
            $pos=strpos_array(strtolower($title), $excluir);
            if ( $pos > -1 )
            {
                $excluidos++;
                ${$serie[$pos]}++;
            }
        }
        
// Contest & Introduce & report  Filter
		if (strpos(strtolower($steemdat[$cn]->title), 'concurso') !== false) { $cont++; $tipo= "C";continue;}	
	    elseif (strpos(strtolower($steemdat[$cn]->title), 'repor') !== false) { $repo++; $tipo= "R";continue;}
	    elseif (strpos(strtolower($steemdat[$cn]->title), 'steem-pays') !== false) { $repo++; $tipo= "R";continue;}
	    elseif (strpos(strtolower($steemdat[$cn]->title), 'votados por') !== false) { $repo++; $tipo= "R";continue;}
	    elseif (strpos(strtolower($steemdat[$cn]->title), 'bienvenida a los usuarios') !== false) { $repo++; $tipo= "R";continue;}
	    elseif (strpos($steemdat[$cn]->json_metadata, 'introduce') !== false) { $intro++; $tipo= "I";}
    
	    else { $tipo= "P";} 
        
    $preselection[$cn]=array('Author'=>$steemdat[$cn]->author,'Title'=>str_replace("|", "", $title),'link'=>$enlace,'Age'=>round($vida,1),'Reward'=>$recompensa,'Votes'=>$steemdat[$cn]->net_votes,'Comments'=>$steemdat[$cn]->children,'tipo'=>$tipo);
    
    $url="<a href=\"https://steemit.com/@$enlace\" target='_blank'  >" . substr($preselection[$cn]['Title'],0,45) . "</a>";
 
 //   echo ("--" . $_POST['mostrar'] . " -$pos- <br/>");
    $ultimoAutor=$preselection[$cn]['Author'];
    if ($mostrar=="si" or ( $mostrar=="no" and !in_array($pos, $numeros) ))
    {
        $contador++;

        if ($contador%2 == 0)
        {
        $estilo='bg-par';
        } else
        {
        $estilo='bg-impar';
        }
        echo("<div class='linea " .$estilo."'>");

            echo "<div class='celda'><titulo>$url</titulo></div>";
            echo "<div class='celda'><autor>@".$ultimoAutor."</autor></div>";
            echo "<div class='celda'><recompensa>".$preselection[$cn]['Reward']."</recompensa></div>";
            echo "<div class='celda'><vo>".$preselection[$cn]['Votes']."</vo></div>";
            echo "<div class='celda'><com>".$preselection[$cn]['Comments']."</com></div>";
        echo("</div>");
//    } else if($_POST['mostrar']=="si" and $pos>-1)
//    {
    }
	// construccion para analisis mas profundo
	$precandidates[$steemdat[$cn]->author]=$steemdat[$cn]->permlink;
	$match++; //Var de cuantos cumplieron el gran condicional
	}
	
//	if($contador == $_POST['resultados']) break;
 }
 echo("Excluidos: $excluidos<br />");
 $cuenta=-1;
 foreach ($excluir as $n)
 {
    $cuenta++;
    if (!empty(${$serie[$cuenta]}))
    {
        $cantidad=${$serie[$cuenta]};
    } else
    {
        $cantidad=0;
    }
    
    echo ("$n -> $cantidad <br/>");
 }
 
 ?>
</div>

<input name="ultimopost" type="hidden" value="<?php echo $ultimoPost ?>" />
<input name="ultimoautor" type="hidden" value="<?php echo $ultimoAutor ?>" />

</form>
</div>

<br />

<?php
	echo "<div style=\"clear: both;\"></div><hr/>***<br/>## De: ".($cn+1). " articulos; $match cumplen con el criterio, <br/>*** <br/>De los cuales: $intro son presentaciones, $cont Son concursos y $repo son Reportes <br/> ### Estos no se muestran para evitar promocionarlos <br/>Ya que con estos reportes buscamos darle valor al esfuerzo individual de los autores cuyo contenido se ve escondido.<br/> *** <br/><br/>";//    pre:<br/>".print_r($preselection);
	//die;    // print_r($precandidates); 
}
// echo("i: " . $_GET['inicio'] . " - f: " . $_GET['fin'] . "<br/> 0--");

} //fin de if isset($_POST['soloenviar'])
?>

<?php
function strpos_array($cadena, $busca) {
    if ( is_array($busca) ) {
        $numero=-1;
        foreach ($busca as $str) {
            $numero++;
            if ( is_array($str) ) {
                $pos = strpos_array($cadena, trim($str));
            } else {
                $pos = strpos($cadena, trim($str));
            }
            if ($pos !== FALSE) {
                return $numero;
            }
        }
    } else {
        return strpos($cadena, $busca);
    }
}
?>
