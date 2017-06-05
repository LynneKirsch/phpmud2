<?php
namespace ExodusCore\Objects;
use ExodusCore\Model\Rooms;

class World
{
    public $rooms;
    public $players_in_combat;
    public $mobiles_in_combat;

    public function __construct()
    {
        $rooms = Rooms::find('all');
        $world_room_array = [];

        foreach($rooms as $room) {
            $world_room_array[$room->id] = new Room($room);
        }

        $this->rooms = $world_room_array;
    }

    public function getRoom($room_id): Room
    {
        if(isset($this->rooms[$room_id])) {
            return $this->rooms[$room_id];
        }
    }
}