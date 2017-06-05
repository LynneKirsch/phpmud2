<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Interfaces\Player;

class Communication extends ClientInterface
{
    function doOOC()
    {
        $this->toChar($this->ch, "`f[`aOOC`f] `aYou: '`f". $this->args . "`a'``");
        $this->toOthersGlobal("[`f[`aOOC`f] `a". $this->ch->data()->name . ": " . $this->args. "`a'``");
    }

    function doTitle()
    {
        $this->ch->data()->title = $this->args;
        $this->ch->data()->save();
        $this->ch->send("Title set.");
    }
}