<?php
class Example {
    private $id;
    private $example_code;
    private $command;
    private $command_id;

    public function __construct($params) {
        $this->id=$params['id'];
        $this->example_code=$params['example_code'];
        $this->command=$params['command'];
        $this->command_id=$params['command_id'];
    }

    public function __destruct() {
        $this->id=null;
        $this->example_code=null;
        $this->command=null;
        $this->command_id=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['example_code'])) {
            $this->example_code=$params['example_code'];
        }
        if (isset($params['command'])) {
            $this->command=$params['command'];
        }
        if (isset($params['command'])) {
            $this->command_id=$params['command'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->example_code.'</br>'.$this->command.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->example_code, $this->command, $this->command_id);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'example_code'=>$this->example_code, 'command'=>$this->command, 'command_id'=>$this->command_id);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->example_code.'</td>
                    <td>'.$this->command.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-example.php?id='.$this->id.'">Змінити</a><a class="btn btn-secondary btn-sm" href="example-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}