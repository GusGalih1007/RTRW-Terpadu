<?php

namespace App\Enums;

enum UserStatusOption: string
{
    case Pending = 'pending';
    case Active = 'active';
    case InActive = 'inactive';
    case Rejected = 'rejected';
}
