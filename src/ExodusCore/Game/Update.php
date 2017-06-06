<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Model\Mobiles;
use ExodusCore\Objects\Mobile;

class Update extends ClientInterface
{
    function start()
    {
        $this->game->getLoop()->addPeriodicTimer(45, function () {
            $this->doTick();
        });

        $this->game->getLoop()->addPeriodicTimer(2, function () {
            $this->doBeat();
        });
    }

    function doBeat()
    {

    }

    function doTick()
    {
        $this->doRegeneration();
        $this->controlWeather();

        $mob_model = Mobiles::find(1);
        $mobile = new Mobile($mob_model, 1);
        $mobile->spawn();
    }

    function doLevel(\ExodusCore\Objects\Char $ch)
    {
        $hp = rand(5, 10);
        $ma = rand(8, 13);
        $mv = rand(10, 15);

        $ch->data()->max_hp = $ch->data()->max_hp + $hp;
        $ch->data()->max_ma = $ch->data()->max_ma + $ma;
        $ch->data()->max_mv = $ch->data()->max_mv + $mv;
        $ch->data()->level = $ch->data()->level + 1;
        $ch->save();
        $ch->send("You gain a level! You gained: " . $hp . "HP, " . $ma . " MA, and " . $mv . " MV. You are now level " . $ch->data()->level);
    }

    function gainExperience(\ExodusCore\Objects\Char $ch, $xp)
    {
        $cur_xp = $ch->data()->cur_xp;
        $new_xp = $cur_xp + $xp;

        while ($new_xp >= $ch->data()->xp_to_level) {
            $new_xp = $new_xp - $ch->data()->xp_to_level;
            $this->doLevel($ch);
        }

        $ch->data()->cur_xp = $new_xp;
        $ch->data()->save();
    }

    function doRegeneration()
    {
        /* @var $player \ExodusCore\Objects\Char */
        foreach ($this->getGame()->players as $player) {
            if ($player->conn_state == "CONNECTED") {
                $cur_hp = $player->data()->cur_hp;
                $max_hp = $player->data()->max_hp;

                if ($cur_hp < $max_hp) {
                    $regenerate = rand(1, 8);
                    $new_hp = $cur_hp + $regenerate;
                    if ($max_hp < $new_hp) {
                        $player->data()->cur_hp = $max_hp;
                    } else {
                        $player->data()->cur_hp = $cur_hp + $regenerate;
                    }
                }
                $player->save();
            }
        }
    }

    function controlWeather()
    {
        $current_weather = $this->getGame()->weather;
        $num = rand(0, 4);
        $weather_conditions = ["Sunny", "Rainy", "Stormy", "Windy", "Cloudy"];

        $new_weather = $weather_conditions[$num];

        if ($num != $current_weather) {
            /* @var $player \ExodusCore\Objects\Char */
            foreach ($this->getGame()->players as $player) {
                if ($player->conn_state == "CONNECTED") {
                    switch ($new_weather) {
                        case "Sunny":
                            $player->send("The sun breaks out from the clouds and shines upon you.");
                            break;
                        case "Rainy":
                            $player->send("A light drizzle begins to fall from the sky.");
                            break;
                        case "Stormy":
                            $player->send("Black clouds form overhead and spark with lightning.");
                            break;
                        case "Windy":
                            $player->send("Black clouds form overhead and spark with lightning.");
                            break;
                        case "Cloudy":
                            $player->send("It's fucking cloudy now, whatever.");
                            break;
                    }
                }
            }

            $this->getGame()->weather = $num;
        }
    }
}