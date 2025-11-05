<?php
require_once 'creature.php';

class Arena
{
    private Creature $fighter1;
    private Creature $fighter2;

    // Définir les combattants au début
    public function __construct(Creature $fighter1, Creature $fighter2)
    {
        $this->fighter1 = $fighter1;
        $this->fighter2 = $fighter2;
    }

    // Lancer le combat
    public function launchFight(): void
    {
        echo "<h2>Combat : {$this->fighter1->scream()} vs {$this->fighter2->scream()}</h2><br>";

        $round = 1;
        while ($this->fighter1->isAlive() && $this->fighter2->isAlive()) {
            echo "<h4>Tour $round</h4>";

            foreach ([$this->fighter1, $this->fighter2] as $attacker) {
                $defender = $attacker === $this->fighter1 ? $this->fighter2 : $this->fighter1;
                if ($attacker->isAlive() && $defender->isAlive()) {
                    $attacker->attack($defender);
                }
            }

            $this->fighter1->displayStatus();
            $this->fighter2->displayStatus();
            echo "<hr>";

            $round++;
        }

        if ($this->fighter1->isAlive()) echo "<h3>{$this->fighter1->scream()} et remporte le combat !</h3>";
        elseif ($this->fighter2->isAlive()) echo "<h3>{$this->fighter2->scream()} et remporte le combat !</h3>";
        else echo "<h3> Match nul !</h3>";
    }
}


