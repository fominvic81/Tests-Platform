<?php

namespace App\Enums;

enum Accessibility: int
{
    case Public = 0;
    case Hidden = 1;
    case Private = 2;
}