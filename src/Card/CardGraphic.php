<?php

/**
 * Representing the Graphical part of a French Card Game
 */

namespace App\Card;

class CardGraphic extends Card
{
    /**
     * Array with all symbols
     */
    private array $symbols = [
        "spader" => [
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
        ],
        "hjärter" => [
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
        ],
        "ruter" => [
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
        ],
        "klöver" => [
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
        ]
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
        return $this->symbols[$color][$stringValue];
    }
}
