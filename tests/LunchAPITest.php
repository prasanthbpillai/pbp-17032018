<?php

/**
 * Created by PhpStorm.
 * User: prasanthpillai
 * Date: 17/3/18
 * Time: 11:42 AM
 */
class LunchAPITest extends TestCase
{

    public function testLunchAPI()
    {
        $this->json('GET', '/lunch')->seeJson(
            [
                'title' => 'Ham and Cheese Toastie'
            ]
        );

    }

    public function testLunchAPIWithPastUsedDateIngredient()
    {
        // test based on the used by date is over
        $this->json('GET', '/lunch')->seeJson(
            [
                'recipes' => ['Fry-up', 'Hotdog', 'Ham and Cheese Toastie']
            ]
        );
    }

    public function testLunchAPIWithPathBestBeforeIngredient()
    {
        // test based on the best before data
        $this->json('GET', '/lunch')->seeJson(
            [
                'recipes' => ['Fry-up', 'Hotdog', 'Ham and Cheese Toastie']
            ]
        );
    }
}
