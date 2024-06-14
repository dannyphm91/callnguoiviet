<?php

namespace App\Enum;

enum Social: string
{
    case FACEBOOK = 'facebook';
    case YOUTUBE = 'youtube';
    case TWITTER = 'twitter';
    case INSTAGRAM = 'instagram';
    case LINKEDIN = 'linkedin';
    case REDDIT = 'reddit';
    case GITHUB = 'github';
    case OTHER = 'other';
}
