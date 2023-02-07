<?php

namespace App\Config;

enum User
{
    public const DEFAULT_BALANCE = 100_000;

    public const EMAIL_VERIFIED = 'verified';
    public const EMAIL_NOT_VERIFIED = 'not_verified';

    public const BANNED = 'banned';
    public const NOT_BANNED = 'not_banned';
}