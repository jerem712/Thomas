<?php
namespace App\Enum;

enum OrderStatus: String {
    case en_preparation = "en preparation";
    case expediee = "expediee";
    case livree = "livree";
    case annulee = "annulee";
}
