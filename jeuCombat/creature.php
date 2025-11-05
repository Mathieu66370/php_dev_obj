<?php
class Creature
{
    protected string $name;
    protected int $health;
    protected int $strength;
    protected int $defense;

    public function __construct(string $name, int $health, int $strength, int $defense)
    {
        $this->name = $name;
        $this->health = $health;
        $this->strength = $strength;
        $this->defense = $defense;
    }

    // Méthode attaquer
    public function attack(Creature $opponent): void
    {
        $damage = max(0, $this->strength - $opponent->defense);
        echo "{$this->name} attaque {$opponent->name} et inflige {$damage} dégâts.<br>";
        $opponent->receiveDamage($damage);
    }

    // Méthode recevoir des dégâts
    public function receiveDamage(int $damage): void
    {
        $this->health -= $damage;
        if ($this->health < 0) $this->health = 0;
        echo "{$this->name} reçoit {$damage} dégâts. Santé restante : {$this->health}.<br>";
    }

    // Vérifie si la créature est en vie
    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    // Cri de la créature (à redéfinir)
    public function scream(): string
    {
        return "{$this->name} pousse un cri !";
    }

    // Affiche l'état
    public function displayStatus(): void
    {
        echo "{$this->name} → Santé: {$this->health}, Force: {$this->strength}, Défense: {$this->defense}<br>";
    }
}

