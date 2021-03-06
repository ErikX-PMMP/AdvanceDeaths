<?php

namespace ErikPDev\AdvanceDeaths;
use ErikPDev\AdvanceDeaths\DeathTypes;
use ErikPDev\AdvanceDeaths\Main;
use pocketmine\Player;
class DeathContainer {
    /** @var Main */
    private $plugin;
    /** @var Array */
    private $KeyWords;
    function __construct($plugin) {
        $this->plugin = $plugin;
        $this->KeyWords = array(
            "{name}" => '$entity->getName',
            "{killer}" => '',
            "{killerCurrentHealth}" => '$entity->getLastDamageCause()->getDamager()->getHealth',
            "{killerMaxHealth}" => '$entity->getLastDamageCause()->getDamager()->getMaxHealth',
            "{weapon}" => '$entity->getLastDamageCause()->getDamager()->getInventory()->getItemInHand()->getName',
        );

    }
    /**
	* Convert variables to proper Data
	*
	* @param \pocketmine\entity\Entity|Player $entity
    * @param string $keyWord
	*
	* @return string 
	*/
    function ExecuteHelper($entity, $keyWord){
        /** @param EntityDamageByEntityEvent $entity->GetLastDamageCause() */
        switch( strtolower($keyWord) ){
            case "{name}":
                if(!$entity instanceof Player){
                    return $entity->getNameTag();
                }
                return $entity->getName();
            case "{killer}":
                if(!$entity->getLastDamageCause()->getDamager() instanceof Player){
                    return $entity->getLastDamageCause()->getDamager()->getNameTag();
                }
                return $entity->getLastDamageCause()->getDamager()->getName();
            case "{killercurrenthealth}":
                return $entity->getLastDamageCause()->getDamager()->getMaxHealth();
            case "{killermaxhealth}":
                return $entity->getLastDamageCause()->getDamager()->getMaxHealth();
            case "{weapon}":
                return $entity->getLastDamageCause()->getDamager()->getInventory()->getItemInHand()->getName();
        }
        return "?";
    }
    /**
	* This will return the complete translation with KeyWords and proper formatting from the config.
	*
	* @param string $translate
    * @param \pocketmine\entity\Entity $entity
	*
	* @return string | NULL
	*/

    public function Translate($translate, $entity){
        

        $DeathTypes = new DeathTypes($this->plugin);
        $DeathMessage = $DeathTypes->DeathConverter($translate);
        $PlayerName = $entity->getName();
        foreach($this->KeyWords as $keyWord => $variable){
            if ( strpos( strtolower($DeathMessage) , strtolower($keyWord) ) !== false ){
                $DeathMessage = str_replace( $keyWord, $this->ExecuteHelper($entity, $keyWord) , $DeathMessage );
            }
        }
        
        return $DeathMessage;
    }


}
