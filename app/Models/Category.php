<?php

namespace App\Models;

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
