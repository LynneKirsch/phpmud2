<?php
namespace ExodusCore\Objects;
class Room
{
    public $mobiles;
    public $items;

    public function __construct(\ExodusCore\Model\Rooms $room)
    {
        foreach($room as $key=>$val) {
            $this->{$key} = $val;
        }
    }

    public function attachMobile(\ExodusCore\Objects\Mobile $mob)
    {
        $this->mobiles[] = $mob;
    }
}