<?php

class Episode
{
    public function __construct(
        private readonly string $name,
        private readonly string $resume,
        private readonly string $duration
    )
    {

    }
}
