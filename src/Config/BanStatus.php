<?php

namespace App\Config;

enum BanStatus: string
{
    const NOT_BANNED = 'not_banned';
    const BANNED = 'banned';
}