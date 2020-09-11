<?php
namespace ErikX\AdvanceDeaths;
use pocketmine\Player;

class DeathTranslation{
  private $main;
  private $player;
  public function __construct(Main $main, Player $player){
    $this->main = $main;
    $path = $this->getPath();
    if(!is_file($path)){
        return;
    }

    $data = yaml_parse_file($path);
    $this->rewards = $data["rewards"];

  }

  public function getPath() : string{
    return $this->main->getDataFolder() . "config.yml";
  }

  public function LoadLanguageFile() : string{
    return $this->main->getDataFolder() . "config.yml";
  }


}
