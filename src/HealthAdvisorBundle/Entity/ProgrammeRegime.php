<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 22/03/2018
 * Time: 14:20
 */

namespace HealthAdvisorBundle\Entity;


use Symfony\Component\Validator\Constraints\DateTime;

class ProgrammeRegime
{

  //array
  private $alimentJour;
  //array
  private $Sport;
  private $dateJour;
  //array
  private $ptitDejGras;
  //array
  private $dejDense;
  //array
  private $gouterSucree;
  //array
  private $dinerLeger;
  //array
  private $proteines;
  //array
  private $calories;

    /**
     * ProgrammeRegime constructor.
     * @param $regime
     * @param $nomRegime
     * @param $alimentJour
     * @param $Sport
     * @param $dateJour
     * @param $ptitDejGras
     * @param $dejDense
     * @param $gouterSucree
     * @param $dinerLeger
     * @param $proteines
     * @param $calories
     */

    public function __construct()
    {
        $this->ptitDejGras = array(
            "matiereGrasse"=>Type_Aliment::$type_aliment['matiereGrasse'],
            "cacao"=>Type_Aliment::$type_aliment['cacao'],
            "pains"=>Type_Aliment::$type_aliment['pains'],
            "thes"=>Type_Aliment::$type_aliment['thes']
        );

        $this->dejDense = array(
          "oeufs"=>Type_Aliment::$type_aliment['oeufs'],
          "poissons"=>Type_Aliment::$type_aliment['poissons'],
          "viandes"=>Type_Aliment::$type_aliment['viandes'],
          "pates"=>Type_Aliment::$type_aliment['pates'],
          "laitier"=>Type_Aliment::$type_aliment['laitier'],
        );
        $this->gouterSucree = array(
           "fruits"=>Type_Aliment::$type_aliment['fruits'],
           "noix"=>Type_Aliment::$type_aliment['noix'],
           "jus"=>Type_Aliment::$type_aliment['jus'],
        );
        $this->dinerLeger = array(
          "fruitsMer"=>Type_Aliment::$type_aliment['fruitsMer'],
          "volailles"=>Type_Aliment::$type_aliment['volailles'],
          "legumes"=>Type_Aliment::$type_aliment['legumes'],
          "haricot_sec"=>Type_Aliment::$type_aliment['haricot_sec']
        );
        $this->proteines = array(
            "cereales"=>Type_Aliment::$type_aliment['cereales'],
            "laitier"=>Type_Aliment::$type_aliment['laitier'],
            "oeufs"=>Type_Aliment::$type_aliment['oeufs'],
            "poissons"=>Type_Aliment::$type_aliment['poissons'],
            "viandes"=>Type_Aliment::$type_aliment['viandes'],
            "volailles"=>Type_Aliment::$type_aliment['volailles'],
            "riz"=>Type_Aliment::$type_aliment['riz']
        );
        $this->calories = array(
             "fruits"=>Type_Aliment::$type_aliment['fruits'],
             "cereales"=>Type_Aliment::$type_aliment['cereales'],
             "jus"=>Type_Aliment::$type_aliment['jus'],
             "matiereGrasse"=>Type_Aliment::$type_aliment['matiereGrasse'],
             "legumes"=>Type_Aliment::$type_aliment['legumes'],
             "oeufs"=>Type_Aliment::$type_aliment['oeufs'],
             "poissons"=>Type_Aliment::$type_aliment['poissons'],


        );
    }

    public function trieAliment($aliments)
    {
        $tabTriee = array("ptitDejGras"=>array(),
                           "dejDense"=>array(),
                           "gouterSucree"=>array(),
                           "dinerLeger"=>array(),
                           "proteines"=>array(),
                           "calories"=>array()
                        );
        $a = new Aliment();
        foreach ($aliments as $aliment)
        {
            $tab = $aliment->explodeAliment($aliment->getTypeAliment());
            foreach ($tab as $element)
            {
               // var_dump($this->ptitDejGras);
                //var_dump($tab);
                if(array_key_exists($element,$this->ptitDejGras))
                {
                   $tabPtitDej= $tabTriee["ptitDejGras"];
                   $tabPtitDej[mt_rand(1,199)]=$aliment;
                   $tabTriee["ptitDejGras"]=$tabPtitDej;

                }
                if(array_key_exists($element,$this->dejDense))
                {
                    $tabDejDense= $tabTriee["dejDense"];
                    $tabDejDense[mt_rand(200,399)]=$aliment;
                    $tabTriee["dejDense"]=$tabDejDense;

                }
                if(array_key_exists($element,$this->gouterSucree))
                {
                    $tabGouterSucree= $tabTriee["gouterSucree"];
                    $tabGouterSucree[mt_rand(400,599)]=$aliment;
                    $tabTriee["gouterSucree"]=$tabGouterSucree;

                }
                if(array_key_exists($element,$this->dinerLeger))
                {
                    $dinerLeger= $tabTriee["dinerLeger"];
                    $dinerLeger[mt_rand(600,799)]=$aliment;
                    $tabTriee["dinerLeger"]=$dinerLeger;
                }
                if(array_key_exists($element,$this->proteines))
                {
                    $proteines= $tabTriee["proteines"];
                    $proteines[mt_rand(800,999)]=$aliment;
                    $tabTriee["proteines"]=$proteines;
                }
                if(array_key_exists($element,$this->calories))
                {
                    $calories= $tabTriee["calories"];
                    $calories[mt_rand(1000,1199)]=$aliment;
                    $tabTriee["calories"]=$calories;
                }
            }
        }
        return $tabTriee;
    }
    public  function regimeDissocie($aliments)
    {
        $listAliments = $this->grouperAlimentParFamille($aliments);
        $groupeAliment="";
        $maxRand = 0;
        foreach ($listAliments as $list)
        {
            if(array_keys($list)[0]>$maxRand)
            {
                $maxRand = array_keys($list)[0];
                $groupeAliment=array_search($list,$listAliments);
            }
        }
        $tab = $listAliments[$groupeAliment][$maxRand];
        return $tab;
    }
    public function  regimeMicronutrition($aliments)
    {
        $dailyAliment = array("petit dejeuner"=>array(),
                               "dejeuner"=>array(),
                               "gouter"=>array(),
                               "diner"=>array());
       // var_dump($aliments);

        foreach (array_keys($aliments) as $index)
        {
            $tab = $aliments[$index];
             krsort($tab);       //trie les aliments par la plus grande probabilite
            if($index=="ptitDejGras")
            {

                if(sizeof($tab)>=2)
                {
                  $dailyAliment['petit dejeuner'] =array(array_values($tab)[0],array_values($tab)[1]);
                }
                else
                {
                    $dailyAliment['petit dejeuner']=array_values($tab);
                }
            }
            elseif ($index=="dejDense")
            {

                if(sizeof($tab)>=2)
                {
                    $dailyAliment['dejeuner'] =array(array_values($tab)[0],array_values($tab)[1]);
                }
                else
                {
                    $dailyAliment['dejeuner']=array_values($tab);
                }
            }
            elseif ($index=="gouterSucree")
            {

                if(sizeof($tab)>=2)
                {
                    $dailyAliment['gouter'] =array(array_values($tab)[0],array_values($tab)[1]);
                }
                else
                {
                    $dailyAliment['gouter']=array_values($tab);
                }
            }
          elseif ($index=="dinerLeger")
          {

              if(sizeof($tab)>=2)
              {
                  $dailyAliment['diner'] =array(array_values($tab)[0],array_values($tab)[1]);
              }
              else
              {
                  $dailyAliment['diner']=array_values($tab);
              }
          }

        }
      return $dailyAliment;
    }

    public function regimeHyperProteine($aliments)
    {
        $dailyAliment = array("proteines"=>array());
        // var_dump($aliments);

        foreach (array_keys($aliments) as $index)
        {
            $tab = $aliments[$index];
            krsort($tab);       //trie les aliments par la plus grande probabilite
            if($index=="proteines")
            {
                if(sizeof($tab)>=5)
                {
                    $dailyAliment['proteines'] =array(array_values($tab)[0],array_values($tab)[1],array_values($tab)[2],array_values($tab)[3],array_values($tab)[4]);
                }
                else
                {
                    $dailyAliment['proteines']=array_values($tab);
                }
            }

        }
        return $dailyAliment;
    }
    public  function  regimeHypoCalorique($aliments)
    {
        $dailyAliment = array("calories"=>array());
        // var_dump($aliments);

        foreach (array_keys($aliments) as $index)
        {
            $tab = $aliments[$index];
            krsort($tab);       //trie les aliments par la plus grande probabilite
            if($index=="calories")
            {
                if(sizeof($tab)>=5)
                {
                    $dailyAliment['calories'] =array(array_values($tab)[0],array_values($tab)[1],array_values($tab)[2],array_values($tab)[3],array_values($tab)[4]);
                }
                else
                {
                    $dailyAliment['calories']=array_values($tab);
                }
            }

        }
        var_dump($dailyAliment);
        return $dailyAliment;
    }
                                      //aliments array        //  allergiesAliment array
    public function trieAlergiesAliment( $aliments, $allergiesAliment)
    {
        $aliment = new Aliment();
         foreach ($aliments as $aliment)
         {
             $tab=$aliment->explodeAliment($aliment->getTypeAliment());
             foreach ($tab as $element)
             {
                 foreach ( array_keys($allergiesAliment) as $allergie)
                 {

                    if($element==$allergie)
                   {
                           unset($aliments[array_search($aliment,$aliments)]);
                   }

                 }
             }
         }
         return $aliments;
    }
    public function recupererTabRegime($aliments,$infoRegime)
    {
        $regimes=array();
        foreach ($aliments as  $aliment)
        {
            foreach ($aliment->getIdRegime()->toArray() as  $regime)
            {
                if(sizeof($regimes)==0)
                {
                    $reg = new Regime();
                    $reg->setIdRegime($regime->getIdRegime());
                    $reg->getNomAliment()->add($aliment);
                    $description = $infoRegime[array_search($regime,$infoRegime)]->getDescriptionRegime();
                    $reg->setDescriptionRegime($description);
                    $reg = array($regime->getIdRegime() => $reg);
                    $regimes[$regime->getIdRegime()]=$reg;

                }
                else
                {

                    if(array_key_exists($regime->getIdRegime(),$regimes)==false)
                    {
                        $reg = new Regime();
                        $reg->setIdRegime($regime->getIdRegime());
                        $reg->getNomAliment()->add($aliment);
                        $description = $infoRegime[array_search($regime,$infoRegime)]->getDescriptionRegime();
                        $reg->setDescriptionRegime($description);
                        $reg = array($regime->getIdRegime() => $reg);
                        $regimes[$regime->getIdRegime()]=$reg;

                    }
                    else
                    {
                        $req = $regimes[$regime->getIdRegime()];
                        if($req[$regime->getIdRegime()]->getNomAliment()->contains($aliment)==false)
                        {
                            $req[$regime->getIdRegime()]->getNomAliment()->add($aliment);
                            $regimes[$regime->getIdRegime()]=$req;
                        }

                    }
                }
            }
        }
         return $regimes;
    }

    public function grouperAlimentParFamille($aliments)
    {
        $alimentDuJour = array();
        foreach ( array_keys($aliments) as $aliment)
        {
            if(arsort($aliments[$aliment]))
            {
                foreach ($aliments[$aliment] as $item)
                {
                    $listTypeAliment =$item->explodeAliment($item->getTypeAliment());
                    foreach ($listTypeAliment as $typeAliment)
                    {
                        if (sizeof($alimentDuJour) == 0)
                        {
                            $alimentDuJour[$typeAliment] = array(mt_rand(1199, 2000) => array($item->getNomAliment() => $item));

                        }
                        else
                        {
                            if (array_key_exists($typeAliment, $alimentDuJour))
                            {
                                $tableau = $alimentDuJour[$typeAliment];
                                $indexRandom = array_keys($tableau);//recuperation du random number
                                $tableauAliment = $tableau[$indexRandom[0]];
                                $tableauAliment[$item->getNomAliment()] = $item;
                                $tableau[$indexRandom[0]] = $tableauAliment; //tableau de random number reçoit la nouvelle valeur et j'affecte sa dans le tableau aliment du jour
                                $alimentDuJour[$typeAliment] = $tableau;
                            }
                            else
                            {
                                if($typeAliment!='')
                                {
                                    $alimentDuJour[$typeAliment] = array(mt_rand(1199, 2000) => array($item->getNomAliment() => $item));
                                }
                            }
                        }
                    }
                }
            }

        }
        return $alimentDuJour;
   }

    public function splitDailyAliment($aliments)
    {
      $ch = "";
      foreach (array_keys($aliments) as $alimentkey)
      {
          $ch .=$alimentkey.':';
          foreach ($aliments[$alimentkey] as $aliment)
          {
              $ch.=$aliment->getNomAliment().',';
          }
          $ch.='|';

      }
      var_dump($ch);
      return $ch;
    }
    public  function  retournerListeDailyAliment($chaine,$aliments)
    {
        //on a une chaine du type
        // 'petit dejeuner:café,thé,|dejeuner:beurre,viande maigre,|gouter:fruits de mer,fruits secs,|diner:poulet,escaloppe,|'
        $splitCategorieRepas = explode('|',$chaine); //decouppement des differents repas contidien
        $tab = array();
        foreach ($splitCategorieRepas as $categorieRepa)
        {
            if($categorieRepa!="")
            {
               $nomRepas = explode(':',$categorieRepa);   //decoupement du nom du repas[0] et le nom repas[1] en deux sous chaine
               if($nomRepas!="")
               {
                   $nomAliment = explode(',',$nomRepas[1]); //decoupement des nom des repas separer par des ,
                   foreach ($nomAliment as $item)
                   {
                       if($item!="")
                       {

                          $aliment = $this->retournerAliment($item,$aliments);
                          if($aliment!=null)
                          {
                              if(array_key_exists($nomRepas[0],$tab))
                              {
                                  $inter = $tab[$nomRepas[0]];
                                  $inter[$item]=$aliment;
                                  $tab[$nomRepas[0]]=$inter;
                              }
                              else
                              {
                                      $tab[$nomRepas[0]]=array($item=>$aliment);

                              }
                          }
                       }
                   }
               }

            }
        }
        var_dump($tab);
        return $tab;
    }

    public function retournerListeSports($tabNomSport,$listSports)
    {
        $sports = array();
        foreach ($tabNomSport as $nomSport)
        {
            $sport = $this->retournerSport($nomSport,$listSports);
            if($sport!=null)
            {
                $sports[$sport->getNomSport()] = $sport;
            }
        }
        return $sports;
    }
    public function retournerAliment($nomAliment,$listAliments)
    {
        foreach ($listAliments as $aliment)
        {
            if($aliment->getNomAliment()==$nomAliment)
            {
                return $aliment;
            }
        }
        return null;
    }
    public  function  retournerSport($nomSport,$listSports)
    {
        foreach ($listSports as $sport)
        {
            if($sport->getNomSport()==$nomSport)
            {
                return $sport;
            }
        }
        return null;
    }

}