<?php

namespace Clases;

include_once "Interfaces\I_Crud.php";

use Interfaces\I_Crud as I_Crud;

class Posts implements I_Crud, \Iterator{
    
     /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue  */
    private $idPost;
    /** @ORM\Column(type="string") * */
    private $image_path;
    /** @ORM\Column(type="string") * */
    private $title;
    /** @ORM\Column(type="string") * */
    private $description;
    /** @ORM\Column(type="date") * */
    private $date_create;
    /** @ORM\Column(type="integer") * */
    private $price;
    private $category;
    private $user;
    private $iterator;
    
    function __construct($idPost, $image_path, $title, $description, $date_create, $price, $category, $user) {
        $this->idPost = $idPost;
        $this->image_path = $image_path;
        $this->title = $title;
        $this->description = $description;
        $this->date_create = $date_create;
        $this->price = $price;
        $this->category = $category;
        $this->user= $user;
        $this->iterator = array(
            'image_path' => $image_path,
            'title' => $title,
            'description' => $description,
            'date_create' => $date_create,
            'price' => $price,
            'category'=>$category,
            'user'=>$user
        );
    }

      
    function getIdPost() {
        return $this->idPost;
    }
    
    function getImage_path() {
        return $this->image_path;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate_create() {
        return $this->date_create;
    }

    function getLikes() {
        return $this->likes;
    }

    function getPrice() {
        return $this->price;
    }

    function setImage_path($image_path): void {
        $this->image_path = $image_path;
    }

    function setTitle($title): void {
        $this->title = $title;
    }

    function setDescription($description): void {
        $this->description = $description;
    }

    function setDate_create($date_create): void {
        $this->date_create = $date_create;
    }

    function setLikes($likes): void {
        $this->likes = $likes;
    }

    function setPrice($price): void {
        $this->price = $price;
    }


   /**
     * Update partener
     * 
     * This method update a partner.
     * 
     * @param PDO $bd Object PDO.
     * @param array $param Array with new data.
     * @return boolean Return true or false.
     */
    public function actualizar($bd, $param) {
        $statement = "UPDATE `socios` SET `NOMBRE_COMPLETO`=:nombre_completo,`TELEFONO`=:telefono,`FECHA_MODIFICACION`=:fecha_modificacion,`CARGO`=:cargo,`DEPARTAMENTO`=:departamento WHERE id_socio=$this->id_socio";
        $stmt = $bd->prepareQuery($statement, $param);
        if ($stmt !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete partener
     * 
     * @param PDO $bd Object PDO.
     * @return boolean Return true or false.
     */
    public function eliminar($bd) {
        $date = new DateTime();
        $statement = "UPDATE `socios` SET FECHA_BAJA=".$date->format("Y-m-d H:i:s")." WHERE id_socio=$this->id_socio";
        if($bd->query($statement)===false){
        return false;    
        }else{
            return true;
        }
        
    }

    /**
     * Sign Up partener
     * 
     * @param PDO $bd Object PDO.
     * @return boolean Return true or false.
     */
    public function insertar($bd) {
        $statement = "INSERT INTO posts (image_path, title, description, date_create, price, category, Users_idUsers) VALUES "
            ."(:image_path,:title,:description,:date_create,:price,:category, :user)";

        $stmt = $bd->prepareQuery($statement, $this);

        if ($stmt !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show partener
     * 
     * @param PDO $bd Object PDO.
     * @param array $param Array with new data.
     * @return PDOStatement Return object PDOStatement
     */
    public function mostrar($bd) {
        $statement = "SELECT usuario, nombre_completo, email, telefono, cargo, departamento, (SELECT nombre FROM paises WHERE id_pais=pais) FROM socios WHERE usuario=" . $_SESSION['user']['userName'];

        return $bd->query($statement, \PDO::FETCH_ASSOC);
    }
    
    /* Iterator */
    
    public function current() {
        return current($this->iterator);
    }

    public function next() {
        return next($this->iterator);
    }

    public function key() {
        return key($this->iterator);
    }

    public function valid() {
        $key = key($this->iterator);
        return ($key !== null && $key !== false);
    }

    public function rewind() {
        return reset($this->iterator);
    }
    
}
