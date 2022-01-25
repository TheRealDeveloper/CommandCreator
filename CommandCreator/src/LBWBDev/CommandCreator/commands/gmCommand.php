<?php

/*
    CommandCreator:

    Copyright (C) 2022 LBWBDev
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace LBWBDev\CommandCreator\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use LBWBDev\CommandCreator\CommandCreator;

class gmCommand extends Command {

    private $plugin;
    private $execute;

    public function __construct(CommandCreator $plugin, string $name, string $description, string $execute, string $usage, string $permission, array $alias)
    {
        $this->execute = $execute;
        parent::__construct($name, $description, $usage, $alias);
        if($permission != "none") {
            $this->setPermission($permission);
        }
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($this->getPermission() != null) {
            if (!$sender->hasPermission($this->getPermission())) {
                $sender->sendMessage("§cYou do not have permission to use this command");
                return;
            }
        }
        $this->plugin->getServer()->broadcastMessage($this->format_gm($sender, $args, $this->execute));
    }

    private function format_gm(CommandSender $sender, array $args, string $toFormat) {
        if(isset($args[0])) {
            $toFormat = str_replace("{ARGS_0}", $args[0], $toFormat);
            $toFormat = str_replace("{ARGS_ALL}", implode(" ", $args), $toFormat);
        }
        if(isset($args[1])) {
            $toFormat = str_replace("{ARGS_1}", $args[1], $toFormat);
        }
        if(isset($args[2])) {
            $toFormat = str_replace("{ARGS_2}", $args[2], $toFormat);
        }
        if(isset($args[3])) {
            $toFormat = str_replace("{ARGS_3}", $args[3], $toFormat);
        }
        if(isset($args[4])) {
            $toFormat = str_replace("{ARGS_4}", $args[4], $toFormat);
        }
        if(isset($args[5])) {
            $toFormat = str_replace("{ARGS_5}", $args[5], $toFormat);
        }
        $toFormat = str_replace("{PLAYER_NAME}", $sender->getName(), $toFormat);

        return $toFormat;

    }

}