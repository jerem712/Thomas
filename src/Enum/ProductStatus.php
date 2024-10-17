<?php
namespace App\Enum;

enum ProductStatus: String {
    case disponible = "disponible";
    case en_rupture = "en rupture";
    case en_precommande = "en precommande";
}