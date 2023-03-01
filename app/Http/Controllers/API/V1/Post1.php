<?php

namespace App\Http\Controllers\API\V1;

readonly class Post1
{

    public function __construct(
        public string $title
    )
    {
    }

    public function setTitle(string $tilte)
    {
        $this->title = $tilte;
    }
}
