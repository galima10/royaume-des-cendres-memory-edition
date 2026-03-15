<?php

$enemies = [
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Alcoolique",
      "label" => "alcoolique",
      "img" => "./assets/images/alcoolique/normal.png",
      "music" => "./assets/audios/music/alcoolique.mp3",
      "sound" => "./assets/audios/sounds/poing.mp3",
      "health" => 1,
      "hit" => 0.5
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "L'amie",
      "label" => "amie",
      "img" => "./assets/images/amie/normal.png",
      "music" => "./assets/audios/music/alcoolique.mp3",
      "sound" => "./assets/audios/sounds/poing.mp3",
      "health" => 1.5,
      "hit" => 0.5
    ]
  ],

  [
    "type" => "enemy",
    "infos" => [
      "name" => "Gobelin",
      "label" => "gobelin",
      "img" => "./assets/images/gobelin/normal.png",
      "music" => "./assets/audios/music/gobelin.mp3",
      "sound" => "./assets/audios/sounds/poing.mp3",
      "health" => 2.5,
      "hit" => 0.5
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Squelette",
      "label" => "squelette",
      "img" => "./assets/images/squelette/normal.png",
      "music" => "./assets/audios/music/squelette.mp3",
      "sound" => "./assets/audios/sounds/simple.mp3",
      "health" => 3,
      "hit" => 1
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Barld",
      "label" => "barld",
      "img" => "./assets/images/barld/normal.png",
      "music" => "./assets/audios/music/barld.mp3",
      "sound" => "./assets/audios/sounds/poing.mp3",
      "health" => 2,
      "hit" => 0.5
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Garde",
      "label" => "garde",
      "img" => "./assets/images/garde/normal.png",
      "music" => "./assets/audios/music/garde.mp3",
      "sound" => "./assets/audios/sounds/poing.mp3",
      "health" => 3,
      "hit" => 1
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Astrid",
      "label" => "astrid",
      "img" => "./assets/images/astrid/normal.png",
      "music" => "./assets/audios/music/astrid.mp3",
      "sound" => "./assets/audios/sounds/simple.mp3",
      "health" => 3,
      "hit" => 1
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Roi",
      "label" => "roi",
      "img" => "./assets/images/roi/normal.png",
      "music" => "./assets/audios/music/roi.mp3",
      "sound" => "./assets/audios/sounds/simple.mp3",
      "health" => 4,
      "hit" => 1.5
    ]
  ],
  [
    "type" => "enemy",
    "infos" => [
      "name" => "Clint",
      "label" => "clint",
      "img" => "./assets/images/clint/normal.png",
      "music" => "./assets/audios/music/clint.mp3",
      "sound" => "./assets/audios/sounds/simple.mp3",
      "health" => 4.5,
      "hit" => 1
    ]
  ],
];

$attacks = [
  "normal" => [
    "type" => "attack",
    "infos" => [
      "name" => "Normal",
      "img" => "./assets/images/items/normal.png",
      "hit" => 1
    ]
  ],
  "special" => [
    "type" => "attack",
    "infos" => [
      "name" => "Spécial",
      "img" => "./assets/images/items/special.png",
      "hit" => 2
    ]
  ]
];

$items = [
  "heart" => [
    "type" => "heart",
    "infos" => [
      "name" => "Cœur",
      "img" => "./assets/images/items/fullheart.png",
      "regen" => 1,
    ]
  ],
  "torch" => [
    "type" => "torch",
    "infos" => [
      "name" => "Torche",
      "img" => "./assets/images/items/torch.png",
      "heat" => 1,
    ]
  ],
];

function createArrayBoard($enemies, $attacks, $items, $enemyCounter)
{
  $allItems = ["heart", "heart", "torch", "torch"];
  $arrayBoard = [];
  foreach ($enemies as $enemy) {
    $arrayBoard[] = [
      "element" => $enemy,
      "selected" => false,
      "found" => false,
    ];
  }
  $arrayBoard[] = [
    "element" => $attacks["normal"],
    "selected" => false,
    "found" => false,
  ];
  $arrayBoard[] = [
    "element" => $attacks["normal"],
    "selected" => false,
    "found" => false,
  ];
  foreach ($allItems as $item) {
    $arrayBoard[] = [
      "element" => $items[$item],
      "selected" => false,
      "found" => false,
    ];
  }
  $arrayBoard[] = [
    "element" => $enemies[$enemyCounter],
    "selected" => false,
    "found" => false,
  ];
  return $arrayBoard;
}

function randomizeArray($array)
{
  $count = count($array);
  for ($i = $count - 1; $i > 0; $i--) {
    $j = rand(0, $i);
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
  }
  return $array;
}

function attachId($array)
{
  $finalBoard = [];
  for ($i = 0; $i < count($array); $i++) {
    $finalBoard[] = $array[$i] + ["id" => $i + 1];
  }
  return $finalBoard;
}
