<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Model\Carte;
use App\View\PlateauVue;

$plateauVue = new PlateauVue();
$plateauVue->jeu();