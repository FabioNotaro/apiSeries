<?php

namespace App\Models;

class Task
{
    public function __construct(
        private string $title,
        private string $description,
        private string $status,
        private string $createdAt,
        private string $updatedAt,
        private string $userId,
        private string $projectId,
        private string $dueDate,
        private string $priority,
        private string $tags,
        private string $comments,
        private string $attachments
    )
    {

    }

}
