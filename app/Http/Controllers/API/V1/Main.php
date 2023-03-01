<?php

namespace App\Http\Controllers\API\V1;

class Main
{
    public function start()
    {
        $post1 = new Post1("Jonathan");
        $post2 = $post1;

        dd($post1->title, $post2->title);
    }
}
