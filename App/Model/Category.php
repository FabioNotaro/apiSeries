<?php

namespace App\Model;

class Category
{
    public function __construct(
        private string $name,
        private string $description,
        private string $color,
        private string $createdAt,
        private string $updatedAt
    )
    {
    }

}
