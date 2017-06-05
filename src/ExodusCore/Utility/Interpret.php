<?php
namespace ExodusCore\Utility;
use ExodusCore\Objects\Player;
use ExodusCore\Model\Commands;

class Interpret
{
    function __construct(Player $ch, $args)
    {
        $this->ch = $ch;
        $arg_array = explode(' ', $args);
        $this->command_string = $arg_array[0];
        unset($arg_array[0]);
        $this->args = implode(' ', $arg_array);
    }

    function interpret()
    {
        $command = Commands::first(["conditions"=>"command LIKE '" . $this->command_string . "%'"]);

        if(!empty($command)) {
            $class = '\\ExodusCore\\Game\\'.$command->class;
            $action = $command->action;
            $object = new $class($this->ch, $this->args);
            $object->{$action}();
        } else {
            $this->ch->send("Huh?\n");
        }
    }
}