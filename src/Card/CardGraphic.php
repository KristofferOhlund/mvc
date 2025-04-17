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
    public function __construct(?string $color = null, ?string $stringValue = null)
    {
        parent::__construct($color, $stringValue);
    }


    /**
     * Method to get symbol for a specifik card.
     * @return string symbol in utf-8 format
     */
    public function getSymbol()
    {
        $color = $this->getCardColor();
        $stringValue = $this->getCardStringValue();
        return $this->$color[$stringValue];
    }
}
