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
          "oeufs"=>Type_Aliment::$type_aliment['oeufs']
        );
    }

    public function trieAliment($aliments)
    {
        $tabTriee = array("ptitDejGras"=>array(),
                           "dejDense"=>array(),
                           "gouterSucree"=>array(),
                           "dinerLeger"=>array(),
                           "proteines"=>array());
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
                   $tabPtitDej[$aliment->getNomAliment()]=$aliment;
                   $tabTriee["ptitDejGras"]=$tabPtitDej;

                }
                if(array_key_exists($element,$this->dejDense))
                {
                    $tabDejDense= $tabTriee["dejDense"];
                    $tabDejDense[$aliment->getNomAliment()]=$aliment;
                    $tabTriee["dejDense"]=$tabDejDense;

                }
                if(array_key_exists($element,$this->gouterSucree))
                {
                    $tabGouterSucree= $tabTriee["gouterSucree"];
                    $tabGouterSucree[$aliment->getNomAliment()]=$aliment;
                    $tabTriee["gouterSucree"]=$tabGouterSucree;

                }
                if(array_key_exists($element,$this->dinerLeger))
                {
                    $dinerLeger= $tabTriee["dinerLeger"];
                    $dinerLeger[$aliment->getNomAliment()]=$aliment;
                    $tabTriee["dinerLeger"]=$dinerLeger;
                }
                if(array_key_exists($element,$this->proteines))
                {
                    $proteines= $tabTriee["proteines"];
                    $proteines[$aliment->getNomAliment()]=$aliment;
                    $tabTriee["proteines"]=$proteines;
                }
            }
        }
        return $tabTriee;
    }
    public  function regimeDissocie($aliments)
    {
        var_dump($aliments);
        foreach ($aliments as $aliment)
        {

        }
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



}