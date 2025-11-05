<?php

require_once 'creature.php';

// Guerrier
class Warrior extends Creature
{
    public function __construct(string $name)
    {
        parent::__construct($name, 150, 20, 10);
    }

    public function scream(): string
    {
        return "{$this->name} crie 'Les assassins sont les plus dangereux'";
    }
}

// Mage
class Mage extends Creature
{
    public function __construct(string $name)
    {
        parent::__construct($name, 100, 30, 5);
    }

    // Inflige +10 dégâts
    public function attack(Creature $opponent): void
    {
        $damage = max(0, ($this->strength + 10) - $opponent->defense);
        echo "{$this->name} lance un sort sur {$opponent->name} et inflige {$damage} dégâts.<br>";
        $opponent->receiveDamage($damage);
    }

    public function scream(): string
    {
        return "{$this->name} crie 'La magie l'emportera toujours face à la force'";
    }
}

// Archer
class Archer extends Creature
{
    public function __construct(string $name)
    {
        parent::__construct($name, 120, 15, 8);
    }

    // 30% chance d'esquiver
    public function receiveDamage(int $damage): void
    {
        if (rand(1, 100) <= 30) {
            echo "{$this->name} a esquivé l'attaque !<br>";
            return;
        }
        parent::receiveDamage($damage);
    }

    public function scream(): string
    {
        return "{$this->name} crie  'Ne soyez pas trop à découvert ...'";
    }
}
