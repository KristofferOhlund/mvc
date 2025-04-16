<?php

/**
 * Representing the Graphical part of a Card
 */

namespace App\Card;

class CardGraphic extends Card
{
    private array $spader = [
        "ess" => "🂡",
        "2" => "🂢",
        "3" => "🂣",
        "4" => "🂤",
        "5" => "🂥",
        "6" => "🂦",
        "7" => "🂧",
        "8" => "🂨",
        "9" => "🂩",
        "10" => "🂪",
        "knekt" => "🂫",
        "dam" => "🂭",
        "kung" => "🂮",
    ];

    private array $hjärter = [
        "ess" => "🂱",
        "2" => "🂲",
        "3" => "🂳",
        "4" => "🂴",
        "5" => "🂵",
        "6" => "🂶",
        "7" => "🂷",
        "8" => "🂸",
        "9" => "🂹",
        "10" => "🂺",
        "knekt" => "🂻",
        "dam" => "🂽",
        "kung" => "🂾",
    ];

    private array $ruter = [
        "ess" => "🃁",
        "2" => "🃂",
        "3" => "🃃",
        "4" => "🃄",
        "5" => "🃅",
        "6" => "🃆",
        "7" => "🃇",
        "8" => "🃈",
        "9" => "🃉",
        "10" => "🃊",
        "knekt" => "🃋",
        "dam" => "🃍",
        "kung" => "🃎",
    ];
    
    private array $klöver = [
        "ess" => "🃑",
        "2" => "🃒",
        "3" => "🃓",
        "4" => "🃔",
        "5" => "🃕",
        "6" => "🃖",
        "7" => "🃗",
        "8" => "🃘",
        "9" => "🃙",
        "10" => "🃚",
        "knekt" => "🃛",
        "dam" => "🃝",
        "kung" => "🃞",
    ];

    /**
     * Constructor calling the Card parents constructor
     */
    public function __construct(?string $cardValue = null, ?string $cardName = null)
    {
        parent::__construct($cardValue, $cardName);
    }

    public function getAsString(string $name, string $value) {
        return $this->$name[$value];
    }

}