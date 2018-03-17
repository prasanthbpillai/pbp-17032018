<?php
/**
 * Created by PhpStorm.
 * User: prasanthpillai
 * Date: 17/3/18
 * Time: 6:54 PM
 */

namespace App\Service;

/**
 * Class IngredientService
 * @package App\Service
 */
class IngredientService
{

    private $ingredients;

    private $pastBestBeforeIngredients = [];

    private $pastUseBeforeIngredients = [];


    /**
     * IngredientService constructor.
     */
    public function __construct()
    {
        $this->loadIngredients();

    }

    /**
     * load the ingredients and the respective arrays for best before and use before
     */
    private function loadIngredients()
    {
        $data = json_decode(file_get_contents(storage_path() . "/app/ingredients.json"));
        $this->ingredients = $data->ingredients;


        foreach ($this->ingredients as $ingredient) {

            $useByDate = new \DateTime($ingredient->{'use-by'});
            $bestBeforeDate = new \DateTime($ingredient->{'best-before'});

            $today = new \DateTime();

            if ($useByDate < $today) {
                $this->pastUseBeforeIngredients[] = $ingredient->title;
                continue;
            }
            if ($bestBeforeDate < $today) {
                $this->pastBestBeforeIngredients[] = $ingredient->title;
            }
        }
    }

    /**
     * Check if the ingredient is before the use by date
     *
     * @param $ingredient
     * @return bool
     */
    public function isGoodIngredient($ingredient)
    {
        if ($this->isPastUseBeforeIngredient($ingredient)) {
            return false;
        } else {
            return true;
        }
    }


    public function isPastBestBeforeIngredient($ingredient)
    {
        if (in_array($ingredient, $this->pastBestBeforeIngredients)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the ingredient is before the use by date
     *
     * @param $ingredient
     * @return bool
     */
    private function isPastUseBeforeIngredient($ingredient)
    {
        if (in_array($ingredient, $this->pastUseBeforeIngredients)) {
            return true;
        } else {
            return false;
        }
    }
}