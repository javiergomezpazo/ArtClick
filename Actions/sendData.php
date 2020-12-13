<?php

/**
 * This file contains common functions used throughout the application.
 *
 * @package    Actions
 * @author     Javier Gomez <gomez.javiergomez11@gmail.com>
 */
spl_autoload_register(function ($class) {
    include "" . $class . '.php';
});

use Clases\Bd as Bd;


/**
 * Get business
 *
 * This method send array categories like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getCategories() {
    try {
        if (comprobarSession()) { 
           $bd = new Bd($_SESSION['user']['role']);
            if ($bd->getError() === false) {
                $stmt = $bd->query("SELECT idCategorie, name FROM categories");
                if ($stmt === false) {
                    throw new Exception("Se ha producido un error.");
                } else {
                    $empresa = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $array_utf8 = utf8Convert($empresa);
                    echo(json_encode($array_utf8));
                }
            } else {
                throw new Exception("Se ha producido un error.");
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get a data post user
 *
 * This method send array businnes like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getPost() {
    try {
        //change
        //$bd = new Bd($_SESSION['user']['rol']);
        $bd = new Bd(2);
        if ($bd->getError() === false) {
            if (comprobarSession()) {
                $sql = "SELECT image_path, Users_idUsers, title, description, date_create, price, (SELECT name from categories where category = idCategorie) as category, category as idCategory, u.name as name_user , u.user_name, u.profile_photo, count(c.idComment) as number_comment, (SELECT count(*) from likes as l where l.Posts_idPost=p.idPost) as likes, (SELECT l.Users_idUsers from likes as l where l.Posts_idPost=p.idPost and l.Users_idUsers=" . $_SESSION['user']['id'] . ") as liked, (SELECT count(*) from followers as ff where ff.id_follower=Users_idUsers and ff.id_user=" . $_SESSION['user']['id'] . ") as you_follower, (SELECT fff.id_user from followers as fff where fff.id_follower=Users_idUsers and fff.id_user=" . $_SESSION['user']['id'] . ") as you_id FROM posts as p inner join users as u on idUSers=Users_idUsers inner join comments as c on p.idPost=c.idPost WHERE p.idPost=:id";
            } else {
                $sql = "SELECT image_path, Users_idUsers, title, description, date_create, price, (SELECT name from categories where category = idCategorie) as category, category as idCategory, u.name as name_user , u.user_name, u.profile_photo, count(c.idComment) as number_comment, (SELECT count(*) from likes as l where l.Posts_idPost=p.idPost) as likes, (SELECT l.Users_idUsers from likes as l where l.Posts_idPost=p.idPost and l.Users_idUsers=null) as liked, (SELECT count(*) from followers as ff where ff.id_follower=Users_idUsers and ff.id_user=null) as you_follower, (SELECT fff.id_user from followers as fff where fff.id_follower=Users_idUsers and fff.id_user=null) as you_id FROM posts as p inner join users as u on idUSers=Users_idUsers inner join comments as c on p.idPost=c.idPost WHERE p.idPost=:id";
            }

            $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));
            if ($stmt === false) {
                throw new Exception("Se ha producido un error.");
            } else {
                $post = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                $array_utf8 = utf8Convert($post);
                echo(json_encode($array_utf8));
            }
        } else {
            throw new Exception("Se ha producido un error.");
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get all post the user
 *
 * This method send array institution like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getAllPostsUsers() {
    try {
        $bd = new Bd(2);
        $sql = "SELECT idPost, image_path, title, (SELECT count(*) from likes where Posts_idPost=idPost) as likes, (SELECT count(*) from likes as l where l.Users_idUsers= p.Users_idUsers) as liked, (SELECT count(*) from comments as c where c.idPost=p.idPost) as comments, (SELECT count(*) from likes as l where l.Posts_idPost=p.idPost and l.Users_idUsers=Users_idUsers) as you_like FROM posts as p WHERE Users_idUsers=:id order by date_create desc";


        $json = array();
        if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
            $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));

            $total_rows = $stmt->rowCount();

            $number_page = ceil($total_rows / 15);

            $json = array('number_page' => $number_page);
        }

        $page = $_POST['page'];

        $sql = $sql . " LIMIT " . (($page - 1) * 15) . ", 15";

        $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($array === false) {
            new PDOException("Error");
        } else {
            $array_utf8 = utf8Convert($array);
            if ($array_utf8 !== false) {
                array_push($json, $array_utf8);
                echo json_encode($json);
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get notifications
 *
 * This method send array institution like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getNotifications() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            if ($bd->getError() === false) {
                $sql = "SELECT message, date, image_path, readed FROM notifications WHERE Users_idUsers=:id order by date DESC";


                $json = array();
                if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
                    $stmt = $bd->prepareQuery($sql, array("id" => $_SESSION['user']['id']));

                    $total_rows = $stmt->rowCount();

                    $number_page = ceil($total_rows / 15);

                    $json = array('number_page' => $number_page);
                }

                $page = $_POST['page'];

                $sql = $sql . " LIMIT " . (($page - 1) * 15) . ", 15";

                $stmt = $bd->prepareQuery($sql, array("id" => $_SESSION['user']['id']));
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($array === false) {
                    new PDOException("Error");
                } else {
                    $array_utf8 = utf8Convert($array);
                    if ($array_utf8 !== false) {
                        array_push($json, $array_utf8);
                        echo json_encode($json);
                    }
                }
            } else {
                throw new Exception("Se ha producido un error.");
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get comments
 *
 * This method send array student like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getComments() {
    try {

        $sql = "SELECT idComment, date, text, name, user_name, profile_photo, idUser FROM comments inner join users on idUser=idUsers WHERE idPost=:id group by idComment order by date desc";
        $bd = new Bd(2);


        $json = array();
        if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
            $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));

            $total_rows = $stmt->rowCount();

            $number_page = ceil($total_rows / 5);

            $json = array('number_page' => $number_page);
        }

        $page = $_POST['page'];

        $sql = $sql . " LIMIT " . (($page - 1) * 5) . ", 5";

        $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($array === false) {
            new PDOException("Error");
        } else {
            $array_utf8 = utf8Convert($array);
            if ($array_utf8 !== false) {
                array_push($json, $array_utf8);
                echo json_encode($json);
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get data user profile
 *
 * This method send array student like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function getUserProfile() {
    try {
        if (comprobarSession()) {
            $sql = "SELECT idUsers,name, user_name, profile_photo, location, instagram, facebook, twitter, web, image_layout, (SELECT count(*) from followers where id_user=idUsers) as following, (SELECT count(*) from followers where idUsers=id_follower) as followers, (SELECT count(*) from posts where Users_idUsers=idUsers) as num_post, about, (SELECT count(*) from followers as ff where ff.id_follower=idUsers and ff.id_user=" . $_SESSION['user']['id'] . ") as you_follower, (select uu.idUsers from users as uu where uu.idUsers=" . $_SESSION['user']['id'] . " limit 0,1) as you_id FROM users WHERE idUsers=:id";
        } else {
            $sql = "SELECT idUsers,name, user_name, profile_photo, location, instagram, facebook, twitter, web, image_layout, (SELECT count(*) from followers where id_user=idUsers) as following, (SELECT count(*) from followers where idUsers=id_follower) as followers, (SELECT count(*) from posts where Users_idUsers=idUsers) as num_post, about, (SELECT count(*) from followers as ff where ff.id_follower=idUsers and ff.id_user=null) as you_follower, (SELECT uu.idUsers from users as uu where uu.idUsers=null limit 0,1) as you_id FROM users WHERE idUsers=:id";
        }
        //$bd = new Bd($_SESSION['user']['rol']);
        $bd = new Bd(2);
        if ($bd->getError() === false) {
            if((!isset($_POST['id']))&&isset($_SESSION['user'])){
	$id=$_SESSION['user']['id'];
}else{
	$id=$_POST['id'];

}
            $stmt = $bd->prepareQuery($sql, array("id" =>$id));
            if ($stmt === false) {
                throw new Exception("Se ha producido un error.");
            } else {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $array_utf8 = utf8Convert($data);
                echo(json_encode($array_utf8));
            }
        } else {
            throw new Exception("Se ha producido un error.");
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * 
 *
 * This method send array business like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function utf8Convert($array) {
    if (array_walk_recursive($array, function (&$item, $key) {
                if (!mb_detect_encoding($item)) {
                    $item = utf8_encode($item);
                }
            })) {
        return $array;
    } else {
        return false;
    }
}

/* * **************************************************************** */

/* Paises Tipo_Institucion */

/**
 * Get country
 *
 * This method send array country like JSON
 */
function getPaises() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['rol']);
        } else {
            $bd = new Bd(3);
        }
        if ($bd->getError() === true) {
            
        } else {
            $stmt = $bd->query("SELECT nombre, id_pais FROM paises");
            if ($stmt === false) {
                
            } else {
                $paises = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $array_utf8 = utf8Convert($paises);
                echo(json_encode($array_utf8));
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get following user
 *
 * This method send array type of institution like JSON
 */
function getFollowing() {
    try {
        if (comprobarSession()) {
            $sql = "SELECT u.name, u.profile_photo, u.idUsers, u.user_name, (SELECT count(*) from followers as ff where ff.id_follower=f.id_follower and ff.id_user=" . $_SESSION['user']['id'] . ") as you_follower, (SELECT uu.idUsers from users as uu where uu.idUsers=" . $_SESSION['user']['id'] . " limit 0,1) as you_id FROM followers as f inner join users as u on id_follower=u.idUsers WHERE id_user=:id";
        } else {
            $sql = "SELECT u.name, u.profile_photo, u.idUsers, u.user_name, (SELECT count(*) from followers as ff where ff.id_follower=f.id_follower and ff.id_user=null) as you_follower, (SELECT uu.idUsers from users as uu where uu.idUsers=null limit 0,1) as you_id FROM followers as f inner join users as u on id_follower=u.idUsers WHERE id_user=:id";
        }
        $bd = new Bd(2);


        $json = array();
        if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
            $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));

            $total_rows = $stmt->rowCount();

            $number_page = ceil($total_rows / 15);

            $json = array('number_page' => $number_page);
        }

        $page = $_POST['page'];

        $sql = $sql . " LIMIT " . (($page - 1) * 15) . ", 15";

        $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($array === false) {
            new PDOException("Error");
        } else {
            $array_utf8 = utf8Convert($array);
            if ($array_utf8 !== false) {
                array_push($json, $array_utf8);
                echo json_encode($json);
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Get followers users
 *
 * This method send array type of institution like JSON
 */
function getFollowers() {
    try {
        if (comprobarSession()) {
            $sql = "SELECT u.name, u.profile_photo, u.idUsers, u.user_name, (SELECT count(*) from followers as ff where ff.id_follower=f.id_user and ff.id_user=" . $_SESSION['user']['id'] . ") as you_follower, (SELECT uu.idUsers from users as uu where uu.idUsers=" . $_SESSION['user']['id'] . " limit 0,1) as you_id FROM followers as f inner join users as u on f.id_user=u.idUsers WHERE f.id_follower=:id";
        } else {
            $sql = "SELECT u.name, u.profile_photo, u.idUsers, u.user_name, (SELECT count(*) from followers as ff where ff.id_follower=f.id_user and ff.id_user=null) as you_follower, (SELECT  uu.idUsers from users as uu where uu.idUsers=null limit 0,1) as you_id FROM followers as f inner join users as u on f.id_user=u.idUsers WHERE f.id_follower=:id";
        }
        $bd = new Bd(2);



        $json = array();
        if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
            $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));

            $total_rows = $stmt->rowCount();

            $number_page = ceil($total_rows / 15);

            $json = array('number_page' => $number_page);
        }

        $page = $_POST['page'];

        $sql = $sql . " LIMIT " . (($page - 1) * 15) . ", 15";

        $stmt = $bd->prepareQuery($sql, array("id" => $_POST['id']));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($array === false) {
            new PDOException("Error");
        } else {
            $array_utf8 = utf8Convert($array);
            if ($array_utf8 !== false) {
                array_push($json, $array_utf8);
                echo json_encode($json);
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}


/**
 * Get posts in section Home
 *
 * This method send array partner like JSON, and used in profile.
 */
function getPostsHome() {

    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);

            $sql = "SELECT p.image_path, p.title, p.idPost, p.date_create, u.idUsers, u.user_name, u.profile_photo, (SELECT count(*) from likes where Posts_idPost=p.idPost) as numberLikes, (SELECT count(*) from comments where idPost=p.idPost) as numberComment, (SELECT count(*) from likes as l where l.Posts_idPost=p.idPost and l.Users_idUsers=f.id_user) as you_like FROM posts as p inner join followers as f on f.id_follower=p.Users_idUsers inner join users as u on u.idUsers=f.id_follower WHERE f.id_user=:id order by p.date_create desc ";

            $json = array();
            if ($_POST['page'] == 1) { //Se é igual a 1, primeira 'interaccion'
                $stmt = $bd->prepareQuery($sql, array("id" => $_SESSION['user']['id']));

                $total_rows = $stmt->rowCount();

                $number_page = ceil($total_rows / 15);

                $json = array('number_page' => $number_page);
            }

            $page = $_POST['page'];

            $sql = $sql . " LIMIT " . (($page - 1) * 15) . ", 15";

            $stmt = $bd->prepareQuery($sql, array("id" => $_SESSION['user']['id']));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($array === false) {
                new PDOException("Error");
            } else {
                $array_utf8 = utf8Convert($array);
                if ($array_utf8 !== false) {
                    array_push($json, $array_utf8);
                    echo json_encode($json);
                }
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}


/**
 * Get s number like post
 *
 * This method send array messages like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function like() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            if ($bd->getError() === false) {
                $flag = true;
                $bd->startTransaction();
                $date = new DateTime();
                $statement = "INSERT INTO likes (Users_idUsers, Posts_idPost) VALUES (:id_user,:id_post)";

                $stmt = $bd->prepareQuery($statement, array("id_user" => $_SESSION['user']['id'], "id_post" => $_POST['id']));
                if ($stmt === false) {
                    $flag = false;
                } else {
                    $user = $bd->prepareQuery("SELECT idUsers, (SELECT title from posts where idPost=:id) as title FROM users where idUsers=(SELECT Users_idUsers from posts where idPost=:id)", array("id" => $_POST['id'], "id" => $_POST['id']));
                    if ($user == false) {
                        $flag = false;
                    } else {
                        $array = $user->fetchAll(PDO::FETCH_ASSOC);
                       
                        $aux = $bd->prepareQuery("INSERT INTO notifications ( message, date, Users_idUsers, image_path, readed) VALUES (:message, :date, :idUser, :image, :readed)", array("message" => "<a href='profile.html?id=" . $_SESSION['user']['id'] . "'>" . $_SESSION['user']['userName'] . "</a> like your work <a href='post.html?id=" . $_POST['id'] . "'>" . $array[0]['title'] . "</a>", "date" => $date->format("Y-m-d H:i:s"), "idUser" => $array[0]['idUsers'], "image" => $_SESSION['user']['profile_photo'], "readed" => 0));
                        ;
                        if ($aux === false) {
                            $flag = false;
                        } else {
                            $flag = true;
                        }
                    }
                }

                if ($flag === false) {
                    echo "false";
                    $bd->getPdo()->rollBack();
                } else {
                    echo "true";
                    $bd->getPdo()->commit();
                }
            } else {
                throw new Exception("Se ha producido un error.");
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Delete a like 
 *
 * This method send array messages like JSON
 * 
 * @throws Exception  If a PDO object failed
 */
function unLike() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            if ($bd->getError() === false) {
                $statement = "DELETE FROM likes WHERE Users_idUsers=:idUser and Posts_idPost=:idPost";

                $stmt = $bd->prepareQuery($statement, array("idUser" => $_SESSION['user']['id'], "idPost" => $_POST['id']));
                if ($stmt === false) {
                    throw new Exception("Se ha producido un error.");
                } else {
                    echo "true";
                }
            } else {
                throw new Exception("Se ha producido un error.");
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Validation notification
 *
 * This method send true if user have a notification or false
 * 
 * @throws Exception  If a PDO object failed
 */
function haveNotification() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            if ($bd->getError() === false) {
                $statement = "SELECT * FROM notifications WHERE readed=0 and Users_idUsers=:id limit 0,1";

                $stmt = $bd->prepareQuery($statement, array("id" => $_SESSION['user']['id']));
                if ($stmt === false) {
                    throw new Exception("Se ha producido un error.");
                } else {
                    if ($stmt->rowCount() == 1) {
                        echo "true";
                    } else {
                        echo "false";
                    }
                }
            } else {
                throw new Exception("Se ha producido un error.");
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
