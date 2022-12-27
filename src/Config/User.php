<?php

namespace App\Config;

enum User
{
    const DEFAULT_BALANCE = 100_000;

    const EMAIL_VERIFIED = 'verified';
    const EMAIL_NOT_VERIFIED = 'not_verified';
}