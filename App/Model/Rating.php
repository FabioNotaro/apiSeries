<?php

class Rating
{
    public function __construct(
        private readonly string $user,
        private readonly string $serie,
        private readonly int $rating,
        private readonly string $comment
    )
    {

    }
}
