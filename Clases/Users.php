<?php

namespace Clases;

include_once "Interfaces\I_Crud.php";

use Interfaces\I_Crud as I_Crud;


class Users implements I_Crud, \Iterator{
    
     /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue  */
    private $idUsers;
    /** @ORM\Column(type="string") * */
    private $email;
    /** @ORM\Column(type="string") * */
    private $name;
    /** @ORM\Column(type="integer") * */
    private $role;
    /** @ORM\Column(type="string") * */
    private $user_name;
    /** @ORM\Column(type="string") * */
    private $password;
    /** @ORM\Column(type="string") * */
    private $profile_photo;
    /** @ORM\Column(type="integer") * */
    private $user_premium;
    /** @ORM\Column(type="string") * */
    private $biography;
    /** @ORM\Column(type="string") * */
    private $location;
    /** @ORM\Column(type="string") * */
    private $instagram;
    /** @ORM\Column(type="string") * */
    private $facebook;
    /** @ORM\Column(type="string") * */
    private $twitter;
    private $entry_date;
    private $image_layout;
    private $web;
    private $about;
    private $iterator;
    
    function __construct($idUsers, $email, $name, $role, $user_name, $password, $profile_photo, $user_premium, $biography, $location, $instagram, $facebook, $twitter, $entry_date, $image_layout, $web, $about) {
        $this->idUsers = $idUsers;
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->profile_photo = $profile_photo;
        $this->user_premium = $user_premium;
        $this->biography = $biography;
        $this->location = $location;
        $this->instagram = $instagram;
        $this->facebook = $facebook;
        $this->twitter = $twitter;
        $this->image_layout= $image_layout;
        $this->web= $web;
        $this->about= $about;
        if ($entry_date == null) {
            $date = new \DateTime();
            $this->entry_date = $date->format("Y-m-d H:i:s");
            unset($date);
        } else {
            $this->entry_date = $entry_date;
        }
        unset($date);
        $this->iterator = array(
            'email' => $email,
            'name' => $name,
            'role' => $role,
            'user_name' => $user_name,
            'password' => $password,
            'profile_photo' => $profile_photo,
            'user_premium' => $user_premium,
            'biography' => $biography,
            'location' => $location,
            'instagram' => $instagram,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'entry_date' => $entry_date,
             'image_layout' => $image_layout,
            'web'=>$web,
            'about'=>$about
        );
    }

    
    function getIdUsers() {
        return $this->idUsers;
    }
   
    function getEmail() {
        return $this->email;
    }

    function getName() {
        return $this->name;
    }

    function getRole() {
        return $this->role;
    }

    function getUser_name() {
        return $this->user_name;
    }

    function getPassword() {
        return $this->password;
    }

    function getProfile_photo() {
        return $this->profile_photo;
    }

    function getUser_premium() {
        return $this->user_premium;
    }

    function getBiography() {
        return $this->biography;
    }

    function getPlace() {
        return $this->place;
    }

    function getInstagram() {
        return $this->instagram;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getTwitter() {
        return $this->twitter;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setRole($role): void {
        $this->role = $role;
    }

    function setUser_name($user_name): void {
        $this->user_name = $user_name;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setProfile_photo($profile_photo): void {
        $this->profile_photo = $profile_photo;
    }

    function setUser_premium($user_premium): void {
        $this->user_premium = $user_premium;
    }

    function setBiography($biography): void {
        $this->biography = $biography;
    }

    function setPlace($place): void {
        $this->place = $place;
    }

    function setInstagram($instagram): void {
        $this->instagram = $instagram;
    }

    function setFacebook($facebook): void {
        $this->facebook = $facebook;
    }

    function setTwitter($twitter): void {
        $this->twitter = $twitter;
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
        $statement = "UPDATE users SET name=:name,user_name=:user_name,biography=:biography,instagram=:instagram,facebook=:facebook,twitter=:twitter,web=:web,about=:about WHERE idUsers=$this->idUsers";
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
        $statement = "INSERT INTO users (email, name, role, user_name, password, profile_photo, user_premium, biography, location, instagram, facebook, twitter, entry_date, image_layout, web, about) "
                . "values (:email,:name,:role,:user_name,:password,:profile_photo,:user_premium,:biography, :location, :instagram,:facebook,:twitter, :entry_date, :image_layout, :web, :about)";

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

