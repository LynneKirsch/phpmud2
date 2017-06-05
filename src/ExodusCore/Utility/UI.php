<?php
namespace ExodusCore\Utility;

class UI
{
    function doPrompt(\ExodusCore\Interfaces\Player $ch)
    {
        $max_hit = $ch->max_hit;
        $cur_hit = $ch->cur_hit;
        $max_ma = $ch->max_ma;
        $cur_ma = $ch->cur_ma;
        $max_mv = $ch->max_mv;
        $cur_mv = $ch->cur_mv;

        $room = new Room();
        $room->load($ch->pData->in_room);

        $ch->send("\n\r". self::colorize("[Health: `i$cur_hit``/`b$max_hit`` | Mana: `n$cur_ma``/`g$max_ma`` | Move: `j$cur_mv``/`c$max_mv`` ] - $room->name")." \n\r");
    }

    static function colorize($msg)
    {
        $colors = array(
            '`6' => '#000000',
            '`a' => '#808080',
            '`b' => '#800000',
            '`c' => '#008000',
            '`d' => '#808000',
            '`e' => '#000080',
            '`f' => '#800080',
            '`g' => '#008080',
            '`h' => '#c0c0c0',
            '`i' => '#ff0000',
            '`j' => '#00ff00',
            '`k' => '#ffff00',
            '`l' => '#0000ff',
            '`m' => '#ff00ff',
            '`n' => '#00ffff',
            '`o' => '#ffffff',
        );

        foreach($colors as $key => $color)
        {
            $msg = str_replace($key, '<span style="color: ' . $color . '">', $msg);
        }

        $msg = str_replace('``', '<span style="color: #eeeeee;">', $msg);
        return $msg;
    }

    function splitArgs($string)
    {
        $ret_obj = new \stdClass();

        $arg_array = explode(' ', $string);
        $ret_obj->command = $arg_array[0];
        unset($arg_array[0]);
        $ret_obj->command_string = implode(' ', $arg_array);

        return $ret_obj;
    }


}