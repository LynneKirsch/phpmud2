<?php

namespace ExodusCore\Game;

use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Model\Commands;
use ExodusCore\Model\Player;
use ExodusCore\Model\PlayerEQ;

class Login extends ClientInterface
{
    public function getName()
    {
        if (!isset($this->ch->tmp_data->name) || is_null($this->ch->tmp_data->name)) {
            $name = ucfirst($this->args);
            $player = Player::first(['name'=>$name]);

            if (!empty($player)) {
                $this->ch->tmp_data->player = $player;
                $this->verifyPassword();
            } else {
                $this->ch->send("Ah, a new soul! " . ucfirst($this->args) . " was it? (y/n)");
                $this->ch->tmp_data->name = ucfirst($this->args);
            }
        } else {
            if ($this->args == 'y') {
                $this->createNewPlayer($this->ch->tmp_data->name);
                $this->getPassword();
            } elseif ($this->args == 'n') {
                $this->ch->send("Oh, pardon me in my old age, could you repeat the name, then? ");
                $this->ch->resetTempData();
            } else {
                $this->ch->send("Please respond with a simple yes(y) or no(n).");
            }
        }
    }

    public function verifyPassword()
    {
        if($this->ch->conn_state == 'verifyPassword')
        {
            if(password_verify($this->args, $this->ch->tmp_data->player->password)) {
                $this->ch->setEntity($this->ch->tmp_data->player);
                $this->ch->conn_state = "CONNECTED";
                $this->ch->send("Connected.");
            } else {
                $this->ch->conn_state = 'getName';
                $this->ch->send("Incorrect password.\n");
                $this->ch->resetTempData();
                $this->ch->send("Who dares storm our wayward path? ");
            }
        } else {
            $this->ch->send("What is your password, soul? ");
            $this->ch->conn_state = "verifyPassword";
        }
    }

    public function getPassword()
    {
        if($this->ch->conn_state == 'getPassword') {
            if (!isset($this->ch->tmp_data->password) || is_null($this->ch->tmp_data->password)) {
                $this->ch->tmp_data->password = password_hash($this->args, PASSWORD_BCRYPT);
                $this->ch->send("Please confirm your password: ");
            } else {
                if (password_verify($this->args, $this->ch->tmp_data->password)) {
                    $this->ch->data()->password = $this->ch->tmp_data->password;
                    $this->ch->data()->save();
                    $this->ch->send("Password set.");
                    $this->ch->conn_state = 'getRace';
                } else {
                    $this->ch->send("Passwords do not match. Please give me a password: ");
                    $this->ch->tmp_data->password = null;
                }
            }
        } else {
            if (isset($this->ch->tmp_data->name) && !is_null($this->ch->tmp_data->name)) {
                $this->ch->send("Well met, " . ucfirst($this->ch->tmp_data->name) . "! Give me a password for this soul: ");
                $this->ch->conn_state = "getPassword";
            } else {
                $this->ch->send("I'm sorry, I seem to have forgotten your name already. What was it again? ");
                $this->ch->conn_state = 'getName';
            }
        }
    }

    public function getRace()
    {
    }

    public function createNewPlayer($name)
    {
        $player = new Player();
        $this->ch->setEntity($player);
        $this->ch->data()->name = $name;
        $this->ch->data()->level = 1;
        $this->ch->data()->cur_xp = 1;
        $this->ch->data()->xp_to_level = 1000;
        $this->ch->data()->save();
    }
}