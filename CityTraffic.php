<?php 

function GraphChallenge($strArr) {

  // code goes here

  $objetoArray = array();

  for($i=0;$i<count($strArr);$i++){
    $temp = $strArr[$i];
    $temp = explode(":",$temp);

    $ciudad= $temp[0];

    $temp = str_replace("[","",$temp[1]);
    $temp = str_replace("]","",$temp);
    $temp = explode(",", $temp);

    $objetoArray[$ciudad] = $temp;

  }
  
  $ciudadesRutas = array();
  foreach($objetoArray as $key => $value) {
    $fromPath=array();
    
    $excluir = array();
    $sumPorRuta=array();
    for($i=0;$i<count($value);$i++){
      
      if(array_key_exists($value[$i], $objetoArray)){
        $excluir[$key] =$key;
        $fromPath[$value[$i]]= searchPath($objetoArray, $value[$i], $excluir, []);
        //$sumPorRuta[$value[$i]]=array_sum($fromPath[$value[$i]]);
        $sumPorRuta[]=array_sum($fromPath[$value[$i]]);
      }

    }
   
    $ciudadesRutas[$key]=max($sumPorRuta);
  }

  ksort($ciudadesRutas);
  $strArr="";
  foreach($ciudadesRutas as $x => $x_value) {
    
    $strArr.=$x.':'.$x_value.",";
  }
  return trim($strArr,',');

}

function searchPath($ABase, $needle, $AExcluir, $resultado){
 
 //print_r($AExcluir);echo "\n";
  if(array_key_exists($needle, $AExcluir)){
        
        return $resultado;
  }else{
    if(array_key_exists($needle, $ABase)){
      for($i=0;$i<count($ABase[$needle]);$i++){
        //echo "\n".$needle."-".$ABase[$needle][$i];
        $newKey=$needle."_".$ABase[$needle][$i];
        $resultado[$needle]=$needle;
        if(!array_key_exists($ABase[$needle][$i], $AExcluir)){
          $AExcluir[$needle]=$ABase[$needle][$i];
          $resultado=searchPath($ABase, $ABase[$needle][$i], $AExcluir, $resultado);
        
        }
      }
     
    }
  }
  return $resultado;    
}




   
// keep this function call here  
echo GraphChallenge(fgets(fopen('php://stdin', 'r')));  

?>
