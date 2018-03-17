<?php
/**
 * Created by PhpStorm.
 * User: prasanthpillai
 * Date: 17/3/18
 * Time: 11:49 AM
 */

namespace App\Http\Controllers;

use App\Service\RecipeService;

/**
 * Class LunchController
 * Controller to deal with all the api request to the lunch API end point
 * @package App\Http\Controllers
 * @author Prasanth Pillai  <prasanthbpillai@gmail.com>
 *
 */
class LunchController extends Controller
{
    /**
     * Function to fetch the recipes based on the request received
     *
     */
    public function listAll(RecipeService $recipeService)
    {
        $recipes = $recipeService->getRecipes();

        return response()->json($recipes);
    }
}