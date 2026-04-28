<?php
namespace App\Enums;

enum TrainClass: string
{
    case ECONOMY  = 'economy ';
    case BUSINESS = 'business';
    case PREMIUM = 'premium';
}