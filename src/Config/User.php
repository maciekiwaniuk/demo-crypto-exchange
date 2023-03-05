<?php

namespace App\Config;

enum User
{
    // balance
    public const DEFAULT_BALANCE = 100_000;

    // email verification status
    public const EMAIL_VERIFIED = 'verified';
    public const EMAIL_NOT_VERIFIED = 'not_verified';

    // account ban status
    public const BANNED = 'banned';
    public const NOT_BANNED = 'not_banned';

    // roles
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    // default fields for account with administrative permission - for development
    public const DEFAULT_ADMIN_EMAIL = 'test1234@wp.pl';
    public const DEFAULT_ADMIN_USERNAME = 'test1234@wp.pl';
    public const DEFAULT_ADMIN_PASSWORD = 'test1234@wp.pl';

    // default field for account with user permission
    public const DEFAULT_USER_EMAIL = 'test4321@wp.pl';
    public const DEFAULT_USER_USERNAME = 'test4321@wp.pl';
    public const DEFAULT_USER_PASSWORD = 'test4321@wp.pl';
}