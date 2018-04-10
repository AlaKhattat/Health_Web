<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21/03/2018
 * Time: 18:39
 */

namespace HealthAdvisorBundle\Entity;


class Type_Aliment
{

    public  static $type_aliment= array("matiereGrasse"=>0,
        "laitier"=>1,
        "legumes"=>2,
        "fruits"=>3,
        "viandes"=>4,
        "volailles"=>5,
        "poissons"=>6,
        "haricot_sec"=>7,
        "oeufs"=>8,
        "noix"=>9,
        "pains"=>10,
        "cacao"=>11,
        "cereales"=>12,
        "riz"=>13,
        "pates"=>14,
        "thes"=>15,
        "jus"=>16,
        "fruitsMer"=>17);

    private  $nomTypeAliment;
    /**
     * Type_Aliment constructor.
     */
    public function __construct($type_aliment)
    {
        $this->nomTypeAliment = $type_aliment;
    }

    /**
     * @return mixed
     */
    public function getNomTypeAliment()
    {
        return $this->nomTypeAliment;
    }

    public static function returnArrayTypeAliment($tableau)
    {
        $tab = array();
        foreach ($tableau as $element)
        {
           if(in_array($element,Type_Aliment::$type_aliment))
           {
               $tab[$element]=array($element=>Type_Aliment::$type_aliment[$element]);
           }
        }
        return $tab;
    }
   
}