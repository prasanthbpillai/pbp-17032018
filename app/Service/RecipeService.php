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
        $data = json_decode(file_get_contents(storage_path()."/app/recipes.json"));
        $this->recipes = $data->recipes;
    }


    /**
     * get the recipes based on the dates
     * @return mixed
     */
    public function getRecipes()
    {

        $ingredientService = new IngredientService();
        foreach ($this->recipes as $recipe){

            $hasIngredientPastUseBy = false;
            $hasIngredientPastBestBefore = false;

            // run through the recipes and check if the ingredients are past use by date or best before date
            foreach ($recipe->ingredients as $ingredient) {

                if ($ingredientService->isGoodIngredient($ingredient)) {
                    if ($ingredientService->isPastBestBeforeIngredient($ingredient)){
                        $hasIngredientPastBestBefore = true;
                        break;
                    }
                } else {

                    $hasIngredientPastUseBy = true;
                    break;
                }
            }

            // save and sort to show the recipes with good ingredients first
            if (!$hasIngredientPastUseBy && !$hasIngredientPastBestBefore) {
                $this->saveValidRecipe($recipe->title);
            } else if ($hasIngredientPastBestBefore) {
                $this->saveValidRecipe($recipe->title, 'end');
            }

        }

        return $this->validLunchRecipes;
    }

    /**
     * Save the valid recipes
     * @param $recipe
     * @param string $pos
     */
    private function saveValidRecipe($recipe, $pos = "start")
    {
        if (count($this->validLunchRecipes) == 0 ){
            $this->validLunchRecipes[] = $recipe;
        } else if ($pos == 'end') {
           array_push($this->validLunchRecipes, $recipe);
        } else {
            array_unshift($this->validLunchRecipes, $recipe);
        }
    }
}