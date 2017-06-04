<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Interfaces\PlayerInterface;
use ExodusCore\Model\Classes;
use ExodusCore\Model\Equipment;
use ExodusCore\Model\PlayerEQ;
use ExodusCore\Model\Races;
use ExodusCore\Model\WearSlots;

class Info extends ClientInterface
{
    public function doEquipmentDisplay()
    {
        $slots = WearSlots::find('all');
        $buf = "";
        $line_format = "[%-10s]";

        foreach($slots as $slot) {
            $short = "Nothing";
            $player_eq = PlayerEQ::first(["conditions" => ["player_id = ? AND worn = ?", $this->ch->data()->id, $slot->id]]);

            if(!empty($player_eq)) {
                $eq = Equipment::first(["conditions" => ["id = ?", $player_eq->eq_id]]);
                $line_format = "[%-20s] ";

                if(!empty($eq)) {
                    if(!is_null($player_eq->short_override)) {
                        $short = $player_eq->short_override;
                    } else {

                        $short = $eq->short;
                    }
                }
            }

            $length = strlen($slot->display);
            $padding = str_repeat(" ", (20 - $length)/2);
            $buf .= sprintf($line_format, $padding.$slot->display) . $short . "\n";
        }

        $buf .= "\n You are carrying: \n";
        $buf .= $this->getInventory();
        $this->toChar($this->ch, $buf);

    }

    public function displayInventory()
    {
        $buf  = "You are carrying: \n";
        $buf .= $this->getInventory();
        $this->toChar($this->ch, $buf);
    }

    public function getInventory()
    {
        $player_inv = PlayerEQ::find('all', ["conditions" => ["player_id = ? AND worn IS NULL", $this->ch->data()->id]]);
        $inv_buf = "";
        print_r($player_inv);
        if(!empty($player_inv)) {
            foreach($player_inv as $inv_eq) {
                $short = null;
                $eq = Equipment::first(["conditions" => ["id = ?", $inv_eq->eq_id]]);

                if(!empty($eq)) {
                    if(!is_null($inv_eq->short_override)) {
                        $short = $inv_eq->short_override;
                    } else {
                        $short = $eq->short;
                    }
                }

                $inv_buf .= $short . "\n";
            }
        } else {
            $inv_buf .= "Nothing";
        }

        return $inv_buf;
    }

    public function doWho()
    {
        $players = array_reverse($this->game->players);
        $count = 0;

        $buf  = "";
        $buf .= "`a:`b----------------------------------------------------------------------------`a:`` \n";
        $buf .= "`d[`h\`d][`h/`d][`h\`d][`h/`d][`h\`d][`h/`d][`h\`d][`h/`d][`h\`d]`o Players in this Realm  `d[`h\`d][`h/`d][`h\`d][`h/`d][`h\`d][`h/`d][`h\`d][`h/`d][`h\`d]`` \n";
        $buf .= "`a:`b----------------------------------------------------------------------------`a:`` \n";

        /* @var $player PlayerInterface */
        foreach($players as $player)
        {
            if($player->conn_state == "CONNECTED")
            {
                $player_race = Races::first($player->data()->race_id);
                $player_class = Classes::first($player->data()->class_id);

                $line_format = "`b(`h%-2s `g%-10s %-15s`b)`` %s%s";
                $race_length = strlen($player_race->name);
                $race_pre = str_repeat(" ", (10 - $race_length)/2);
                $race = $race_pre.$player_race->name;
                $class_length = strlen($player_class->name);
                $class_pre = str_repeat(" ", (10 - $class_length)/2);
                $class = $class_pre.$player_class->who_display;
                $buf .= sprintf($line_format, $player->data()->level, $race, $class, $player->data()->name, $player->data()->title);
                $buf .= "\n";
                $count++;
            }
        }

        $buf .= "`a:`b----------------------------------------------------------------------------`a:`` \n";
        $buf .= " Players Found: ".$count." \n";
        $buf .= "`a:`b----------------------------------------------------------------------------`a:`` \n";
        $this->ch->send($buf);
    }
}