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
  private $regime;
  private $nomRegime;
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
        /*$t = (array)Type_Aliment::$type_aliment;
        $this->regime = new Regime();
        $this->nomRegime = "";
        $this->alimentJour =  array();
        $this->Sport = array();
        $this->dateJour = new DateTime();
        $this->ptitDejGras= array();*/


        //);

    }




}