<?php

/**
 * Created by PhpStorm.
 * User: prasanthpillai
 * Date: 17/3/18
 * Time: 7:15 PM
 */

namespace App\Service;

/**
 * Class RecipeService
 * Manage the business logic related to Lunch and associated objects.
 *
 * @package App\Service
 */
class RecipeService
{

    private $recipes;
    private $validLunchRecipes;

    /**
     * LunchService constructor.
     */
    public function __construct()
    {
        $this->loadRecipes();
    }


    /**
     * load the recipes from JSON files
     *
     */
    private function loadRecipes()
    {
        $this->recipes = json_decode(file_get_contents(storage_path()."/app/recipes.json"));

    }


    /**
     * get the recipes based on the dates
     * @return mixed
     */
    public function getRecipes()
    {

        $ingredientService = new IngredientService();
        foreach ($this->recipes as $recipe){

            foreach ($recipe->ingredients as $ingredient) {
                if ($ingredientService->isGoodIngredient($ingredient)) {
                    if ($ingredientService->isPastBestBeforeIngredient($ingredient)){
                        // push to the last
                        array_push($this->validLunchRecipes,$ingredient);
                    } else {
                        // add to main list
                        array_unshift($this->validLunchRecipes, $ingredient);

                    }
                }
            }

        }
        return $this->validLunchRecipes;
    }

}