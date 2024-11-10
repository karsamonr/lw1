<?php
class Type {
    private $id;
    private $name;

    public function __construct($params) {
        $this->id=$params['id'];
        $this->name=$params['name'];
    }

    public function __destruct() {
        $this->id=null;
        $this->name=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['name'])) {
            $this->name=$params['name'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->name.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->name);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'name'=>$this->name);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-type.php?id='.$this->id.'">Змінити</a><a class="btn btn-secondary btn-sm" href="type-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}