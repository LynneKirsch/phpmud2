<?php
namespace ExodusCore\Objects;
use ExodusCore\Model\PlayerEQ;
use ExodusCore\Model\WearSlots;
use ExodusCore\Utility\UI;
use \ActiveRecord\Model;
use \Ratchet\ConnectionInterface;
class Char
{
    public $client;
    public $conn_state = 'getName';
    public $tmp_data;
    public $entity;
    public $eq;

    function __construct(ConnectionInterface $client)
    {
        $this->client = $client;
        $this->tmp_data = new \stdClass();
        $this->fighting = null;
    }

    function send($data)
    {
        $UI = new UI();
        $this->client->send($UI->colorize($data));

        if($this->conn_state == 'CONNECTED') {
            $prompt = $this->getPrompt();
            $this->client->send($UI->colorize($prompt));
        }
    }

    function setEntity(Model $entity)
    {
        $this->entity = $entity;
    }

    function data():Model
    {
        return $this->entity;
    }

    function save()
    {
        $this->data()->save();
    }

    function resetTempData()
    {
        $this->tmp_data = new \stdClass();
    }

    function eqSlotArray()
    {
        $slot_array = [];
        $slots = WearSlots::find('all');

        foreach($slots as $slot) {
            $eq = PlayerEQ::first(["conditions" => ["player_id = ? AND worn = ?", $this->data()->id, $slot->id]]);
            $slot_array[$slot->display] = !empty($eq) ? $eq : null;
        }

        return $slot_array;
    }

    function getPrompt()
    {
        $prompt = "\n\n[HP: ".$this->data()->cur_hp."/".$this->data()->max_hp." | MA: ".$this->data()->cur_ma."/".$this->data()->max_ma." | MV: 300/300] - The First Room \n\n";
        return $prompt;
    }
}