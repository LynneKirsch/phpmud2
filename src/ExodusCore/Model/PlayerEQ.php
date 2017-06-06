<?php
namespace ExodusCore\Model;
use ActiveRecord\Model;
class PlayerEQ extends Model
{
    static $table_name = 'player_eq';

    static $belongs_to = array(
        array('player', 'class_name' => 'Char')
    );
}