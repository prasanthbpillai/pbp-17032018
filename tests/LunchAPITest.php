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

    }

    public function testLunchAPIWithPathBestBeforeIngredient()
    {

    }
}
