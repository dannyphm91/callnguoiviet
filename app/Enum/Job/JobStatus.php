<?php

namespace App\Enum\Job;

enum JobStatus: string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case SOLD = 'sold';
    case DECLINED = 'declined';
}
