<?php

class Serie
{
    public function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $image,
        private readonly string $releaseDate,
        private readonly string $genre
    )
    {
    }
}
