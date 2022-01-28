<?php

declare(strict_types = 1);

namespace LBWBDev\CommandCreator;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use LBWBDev\CommandCreator\commands\cecCommand;
use LBWBDev\CommandCreator\commands\gmCommand;
use LBWBDev\CommandCreator\commands\mtsCommand;
use LBWBDev\CommandCreator\commands\pecCommand;

class CommandCreator extends PluginBase {

    public function onEnable()
    {
        $this->saveDefaultConfig();
        $this->saveResource("commands.yml");
        $this->init();
    }

    private function init() {
        $commandsConfig = new Config($this->getDataFolder()."commands.yml", Config::YAML);
        foreach ($commandsConfig->getNested("commands") as $command => $attribute) {

            $name = (string) $command;
            $alias = (array) $attribute["alias"];
            $description = (string) $attribute["description"];
            $type = (string) $attribute["type"];
            $permission = (string) $attribute["permission"];
            $usage = (string) $attribute["usage"];
            $execute = (string) $attribute["execute"];

            if($type === "mts") {
                $this->getServer()->getCommandMap()->register($name, new mtsCommand($this, $name, $description, $execute, $usage, $permission, $alias));
            } else if($type === "gm") {
                $this->getServer()->getCommandMap()->register($name, new gmCommand($this, $name, $description, $execute, $usage, $permission, $alias));
            } else if($type === "cec") {
                $this->getServer()->getCommandMap()->register($name, new cecCommand($this, $name, $description, $execute, $usage, $permission, $alias));
            } else if($type === "pec") {
                $this->getServer()->getCommandMap()->register($name, new pecCommand($this, $name, $description, $execute, $usage, $permission, $alias));
            }

        }
    }

}
