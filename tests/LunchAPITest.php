<?php

/**
 * Created by PhpStorm.
 * User: prasanthpillai
 * Date: 17/3/18
 * Time: 11:42 AM
 */
class LunchAPITest extends TestCase
{

    public function testLunchAPIWithPastUsedDateIngredient()
    {
        // test based on the used by date is over
        $this->json('GET', '/lunch')->seeJson(
            array("Hotdog"),
            array("Fry-up"),
            array("Ham and Cheese Toastie"));
    }

    public function testLunchAPIWithPathBestBeforeIngredient()
    {
        // test based on the best before data
        $this->json('GET', '/lunch')->seeJson(
            array("Hotdog"),
            array("Fry-up"),
            array("Ham and Cheese Toastie")

        );
    }
}
