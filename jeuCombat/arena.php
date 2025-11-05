<?php
require_once 'creature.php';

class Arena
{
    private Creature $fighter1;
    private Creature $fighter2;

    public function __construct(Creature $fighter1, Creature $fighter2)
    {
        $this->fighter1 = $fighter1;
        $this->fighter2 = $fighter2;
    }

    public function launchFight(): void
    {
        echo "<h2>Combat : {$this->fighter1->scream()} vs {$this->fighter2->scream()}</h2><br>";

        $round = 1;
        while ($this->fighter1->isAlive() && $this->fighter2->isAlive()) {
            echo "<h4>Tour $round</h4>";

            // Fighter1 attaque Fighter2
            if ($this->fighter1->isAlive()) {
                $this->fighter1->attack($this->fighter2);
            }

            // Fighter2 attaque Fighter1 si encore en vie
            if ($this->fighter2->isAlive()) {
                $this->fighter2->attack($this->fighter1);
            }

            // Affichage des statuts
            $this->fighter1->displayStatus();
            $this->fighter2->displayStatus();
            echo "<hr>";

            $round++;
        }

        // Affichage du résultat
        if ($this->fighter1->isAlive()) {
            echo "<h3>{$this->fighter1->scream()} et remporte le combat !</h3>";
        } elseif ($this->fighter2->isAlive()) {
            echo "<h3>{$this->fighter2->scream()} et remporte le combat !</h3>";
        } else {
            echo "<h3>Match nul !</h3>";
        }
    }
}


