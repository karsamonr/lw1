<?php
class Command {
    private $id;
    private $name;
    private $description;
    private $type;
    
    public function __construct($params) {
        $this->id=$params['id'];
        $this->name=$params['name'];
        $this->description=$params['description'];
        $this->type=$params['type'];
    }

    public function __destruct() {
        $this->id=null;
        $this->name=null;
        $this->description=null;
        $this->type=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['name'])) {
            $this->name=$params['name'];
        }
        if (isset($params['description'])) {
            $this->description=$params['description'];
        }
        if (isset($params['type'])) {
            $this->type=$params['type'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->name.
        '</br><b>Опис:</b> '.$this->description.
        '</br><b>Тип:</b> '.$this->type.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->name, $this->description, $this->type);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'name'=>$this->name, 'description'=>$this->description, 'type'=>$this->type);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->description.'</td>
                    <td>'.$this->type.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-command.php?id='.$this->id.'">Змінити</a><a class="btn btn-secondary btn-sm" href="command-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}