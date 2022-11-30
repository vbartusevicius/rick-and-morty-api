<?php

declare(strict_types=1);

namespace App\Enum;

enum LocationTypeEnum: string
{
    case Planet = 'Planet';
    case Cluster = 'Cluster';
    case SpaceStation = 'Space station';
    case Microverse = 'Microverse';
    case TV = 'TV';
    case Resort = 'Resort';
    case FantasyTown = 'Fantasy town';
    case Dream = 'Dream';
    case Menagerie = 'Menagerie';
    case Game = 'Game';
    case Customs = 'Customs';
    case Daycare = 'Daycare';
    case Miniverse = 'Miniverse';
    case Teenyverse = 'Teenyverse';
    case Spacecraft = 'Spacecraft';
    case Arcade = 'Arcade';
    case Spa = 'Spa';
    case ArtificiallyGeneratedWorld = 'Artificially generated world';
    case DwarfPlanet = 'Dwarf planet (Celestial Dwarf)';
    case Dimension = 'Dimension';
}
