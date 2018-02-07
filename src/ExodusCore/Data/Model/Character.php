<?php
namespace ExodusCore\Data\Model;

/**
 * ExodusCore/Data/Model/Command.php
 *
 * @Entity @Table(name="`commands`")
 */
class Command
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $command_id;

    /** @Column(type="string", length=100, nullable=false) * */
    private $command;

    /** @Column(type="string", length=100, nullable=false) * */
    private $class;

    /** @Column(type="string", length=100, nullable=false) * */
    private $action;

    /**
     * @return mixed
     */
    public function getCommandId()
    {
        return $this->command_id;
    }

    /**
     * @param mixed $command_id
     */
    public function setCommandId($command_id)
    {
        $this->command_id = $command_id;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


}