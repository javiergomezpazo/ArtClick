<?php

/**
 * This file contains common functions used throughout the application.
 *
 * @package    Actions
 * @author     Javier Gomez <gomez.javiergomez11@gmail.com>
 */
spl_autoload_register(function ($class) {
    include_once $class . '.php';
});

use Clases\CentrosActividades\Instituciones as Instituciones;
use Clases\CentrosActividades\Empresa as Empresa;
use Clases\Users as Users;
use Clases\Posts as Posts;
use Clases\Bd as Bd;

require_once "Correo.php";

/**
 * Validate username and password
 *
 * @param string $username Partner username
 * @param string $password Partner password
 * @return boolean Return true or false
 */
function login($email, $password) {
    try {
        if (!comprobarSession()) {
            $bd = new Bd(3);
            if ($bd->getError() === true) {
                throw new PDOException("Se ha producido un error al conectarse a la base de datos.");
            } else {
                $statement = "SELECT password, role, user_name, idUsers, profile_photo, name FROM users WHERE email=:email";
                $param = array("email" => $email);

                $stmt = $bd->prepareQuery($statement, $param, 1);

                if ($stmt->rowCount() === 1) {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    if (password_verify($password, $data['password'])) {
                        return array('userName' => $data['user_name'], 'role' => $data['role'], 'id' => $data['idUsers'], 'name' => $data['name'], "profile_photo" => $data['profile_photo']);
                    } else {
                        return false; //Contraseña incorrecta
                    }
                } else {
                    return false; //Usuario no existe
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
 * Sign up a new user
 *
 * This method dont have parameter, because it is called by AJAX
 * 
 * @throws PDOException If a PDO object failed
 */
function signUp() {
    try {
        if (!comprobarSession()) {
            $bd = new Bd(3);
            if ($bd->getError() === true) {
                throw new PDOException("Se ha producido un error. Perdone las molestias");
            } else {
                $flag = true;
                $bd->startTransaction();
                $fecha_actual = new DateTime();
                $user = new Users("", $_POST["email"], $_POST["name"], 2, $_POST["user_name"], password_hash($_POST["password"], PASSWORD_DEFAULT), "profile_photo_default.jpg", 0, '', $_POST["location"], '', '', '', $fecha_actual->format("Y-m-d H:i:s"), "layout_default.jpg", '', '');
                if ($user->insertar($bd) !== false) {
                    if (enviar_correo($_POST["email"], "Lorem Ipsum is simply dummy text of "
                                    . "the printing and typesetting industry. Lorem Ipsum has been the "
                                    . "industry's standard dummy text ever since the 1500s, when an unknown "
                                    . "printer took a galley of type and scrambled it to make a type specimen book. "
                                    . "It has survived not only five centuries, but also the leap into electronic typesetting, "
                                    . "remaining essentially unchanged.", "Bienvenido a ArtClick") !== true) {
                        $flag = false;
                    }
                }
                if ($flag === false) {
                    echo "false";
                    $bd->getPdo()->rollBack();
                } else {
                    echo "true";
                    $bd->getPdo()->commit();
                }
            }
        }
    } catch (PDOException $pdoEx) {
        $bd->getPdo()->rollBack();
        $pdoEx->getMessage();
    } catch (Exception $ex) {
        $bd->getPdo()->rollBack();
        $eEx->getMessage();
    } finally {
        unset($bd);
    }
}

/**
 * Upload a new post
 *
 * This method dont have parameter, because it is called by AJAX
 * 
 * @throws PDOException If a PDO object failed
 */
function uploadPost() {
    try {
        if (comprobarSession()) { //change
            $bd = new Bd($_SESSION['user']['role']);
            $flag = true;
            if ($bd->getError() === false) {
                $date = new DateTime();
                $bd->startTransaction();
                if (!isset($_FILES['image_path']['error'])) {
                    throw new Exception("No se ha podido subir la imagen.");
                }
                switch ($_FILES['image_path']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new Exception("");
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new Exception("Imagen es demasiado grande");
                    default:
                        throw new Exception("Error desconocido.");
                }


                if ($_FILES['image_path']['size'] > 17000000) {
                    throw new Exception("Imagen excede tamaño maximo.");
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                $ext = array_search(finfo_file($finfo, $_FILES['image_path']['tmp_name']), array('jpg' => 'image/jpeg',
                    'png' => 'image/png', 'gif' => 'image/gif')
                );
                finfo_close($finfo);

                if ($ext == false) {
                    throw new Exception("No se reconece la imagen.");
                }
//                echo 'img/foto.' . $ext;
//                echo substr("00001", 0, 2);
//                echo "-" . substr("00001", 2, (strlen("00001") - 2));

                $post = new Posts("", "default", $_POST['title'], $_POST['description'], $date->format("Y-m-d H:i:s"), null, $_POST['category'], $_SESSION['user']['id']);
                if ($post->insertar($bd) === false) {
                    $flag = false;
                } else {
                    $idPost = $bd->getPdo()->lastInsertId();
                    $image_name = "stock" . substr($idPost, 0, (strlen($idPost) - 1)) . $_SESSION['user']['id'] . substr($idPost, (strlen($idPost) - 1), strlen($idPost));

                    $update = $bd->query("UPDATE posts SET image_path='" . $image_name . "." . $ext . "' WHERE idPost=" . $idPost);
                    if ($update === false) {
                        var_dump($bd->getPdo()->errorInfo());
                        $flag = false;
                    }
                }

                if (!$flag) {
                    throw new PDOException("Se ha producido un error");
                } else {
                    $res = move_uploaded_file($_FILES['image_path']['tmp_name'], 'img/stock/' . $image_name . '.' . $ext);
                    if (!$res) {
                        throw new Exception('A imaxe non puido ser movida.');
                    } else {
                        $bd->getPdo()->commit();
                        echo "true";
                    }
                }
            }
        }
    } catch (PDOException $pdoex) {
        $bd->getPdo()->rollBack();
        echo $pdoex->getMessage();
    } finally {
        unset($bd);
    }
}

/**
 * Update data user profile
 *
 * This method dont have parameter, because it is called by AJAX
 * 
 * @throws PDOException If a PDO object failed
 */
function updateProfile() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            $flag = true;
            if ($bd->getError() === false) {
                $date = new DateTime();
                $bd->startTransaction();
                $imageNames = [];
                $extension = [];
                if (isset($_FILES['img_profile'])) {
                    if ((!isset($_FILES['img_profile']['error']))) {
                        throw new Exception("No se ha podido subir la imagen.");
                    }
                    switch ($_FILES['img_profile']['error']) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new Exception("");
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            throw new Exception("Imagen es demasiado grande");
                        default:
                            throw new Exception("Error desconocido.");
                    }


                    if ($_FILES['img_profile']['size'] > 17000000) {
                        throw new Exception("Imagen excede tamaño maximo.");
                    }

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);

                    $ext = array_search(finfo_file($finfo, $_FILES['img_profile']['tmp_name']), array('jpg' => 'image/jpeg',
                        'png' => 'image/png', 'gif' => 'image/gif')
                    );
                    finfo_close($finfo);

                    if ($ext == false) {
                        throw new Exception("No se reconece la imagen.");
                    }
                    $img_sql = "UPDATE users SET profile_photo=:img_profile WHERE idUsers=%s";
                    $date = new DateTime();
                    array_push($extension, $ext);
                    array_push($imageNames, sprintf("profile_%s%s.%s", $_SESSION['user']['userName'], $date->getTimestamp(), $ext));
                    $img_params = array("img_profile" => $imageNames[0]);
                    $_SESSION['user']['profile_photo'] = $imageNames[0];
                } 
                    if (isset($_FILES['img_cabecera'])) {
                        if ((!isset($_FILES['img_cabecera']['error']))) {
                            throw new Exception("No se ha podido subir la imagen.");
                        }


                        switch ($_FILES['img_cabecera']['error']) {
                            case UPLOAD_ERR_OK:
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                throw new Exception("");
                            case UPLOAD_ERR_INI_SIZE:
                            case UPLOAD_ERR_FORM_SIZE:
                                throw new Exception("Imagen cabecera es demasiado grande");
                            default:
                                throw new Exception("Error desconocido.");
                        }

                        if ($_FILES['img_cabecera']['size'] > 17000000) {
                            throw new Exception("Imagen excede tamaño maximo.");
                        }

                        $finfo = finfo_open(FILEINFO_MIME_TYPE);

                        $ext_2 = array_search(finfo_file($finfo, $_FILES['img_cabecera']['tmp_name']), array('jpg' => 'image/jpeg',
                            'png' => 'image/png', 'gif' => 'image/gif')
                        );
                        finfo_close($finfo);

                        if ($ext_2 == false) {
                            throw new Exception("No se reconece la imagen.");
                        }
                        $img_sql = "UPDATE users SET image_layout=:image_layout WHERE idUsers=%s";
                        $date = new DateTime();
                        array_push($extension, $ext_2);
                        array_push($imageNames, sprintf("layout_%s%s.%s", $_SESSION['user']['userName'], $date->getTimestamp(), $ext_2));
                        $img_params = array("image_layout" => $imageNames[0]);
                    }
                

                if (isset($_FILES['img_profile']) && isset($_FILES['img_cabecera'])) {
                    $img_sql = "UPDATE users SET profile_photo=:img_profile, image_layout=:image_layout WHERE idUsers=%s";
                    $img_params = array("img_profile" => $imageNames[0], "image_layout" => $imageNames[1]);
                }

                $user = new Users($_SESSION['user']['id'], "", $_POST['name'], $_SESSION['user']['role'], $_POST['userName'], "", "", 0, $_POST['biography'], "", $_POST['instagram'], $_POST['facebook'], $_POST['twitter'], "", "", $_POST['web'], $_POST['about']);
                $params = array("name" => $_POST['name'], "user_name" => $_POST['userName'], "biography" => $_POST['biography'], "instagram" => $_POST['instagram'], "facebook" => $_POST['facebook'], "twitter" => $_POST['twitter'], "web" => $_POST['web'], "about" => $_POST['about']);
                if ($user->actualizar($bd, $params) === false) {
                    $flag = false;
                } else {
                    if (isset($_FILES['img_profile']) || isset($_FILES['img_cabecera'])) {
                        $aux = $bd->prepareQuery(sprintf($img_sql, $_SESSION['user']['id']), $img_params);
                        if ($aux == false) {
                            $flag = false;
                        }
                    }
                }

                if (!$flag) {
                    throw new PDOException("Se ha producido un error");
                } else {
                    if (count($imageNames) > 0) {
                        $flag = false;
                        $i=0;
                        foreach ($_FILES as $value) {
                                $res = move_uploaded_file($value['tmp_name'], 'img/stock/' . $imageNames[$i]);
                            if (!$res) {
                                throw new Exception('As imaxes non puideron ser movidas.');
                            } else {
                                $flag = true;
                            }
                            $i++;
                        }
                        if ($flag) {

                            $bd->getPdo()->commit();
                            echo "true";
                        }
                    } else {
                        $bd->getPdo()->commit();
                        echo "true";
                    }
                }
            }
        }
    } catch (PDOException $pdoex) {
        $bd->getPdo()->rollBack();
        echo $pdoex->getMessage();
    } finally {
        if (!$flag) {
            $_SESSION['user']['profile_photo'] = "profile_photo_default.jpg";
        }
        unset($bd);
    }
}

/**
 * Insert a new comment in BD and notify
 *
 * This method dont have parameter, because it is called by AJAX
 * 
 * @throws PDOException If a PDO object failed
 * @throws Exception If student have a movility in this moment
 */
function insertComment() {
    try {
        if (comprobarSession()) {
            $bd = new Bd(2);
            $flag = true;
            if ($bd->getError() === false) {
                $bd->startTransaction();
                $date = new DateTime();
                $id_user_post = $bd->query("SELECT Users_idUsers from posts as p where p.idPost=" . $_POST['id'] . " group by Users_idUsers");
                $user = $id_user_post->fetchAll();

                $stmt = $bd->prepareQuery("INSERT INTO comments(idUser, idPost, date, text) VALUES (:idUser, :idPost, :date, :text)", array("idUser" => $_SESSION['user']['id'], "idPost" => $_POST['id'], "date" => $date->format("Y-m-d H:i:s"), "text" => $_POST["text"]));

                if ($stmt === false) {
                    $flag = false;
                } else {
                    $aux = $bd->prepareQuery("INSERT INTO notifications ( message, date, Users_idUsers, image_path, readed) VALUES (:message, :date, :idUser, :image, :readed)", array("message" => "<a href='profile.html?id=" . $_SESSION['user']['id'] . "'>" . $_SESSION['user']['userName'] . "</a> write a new comment in " . $_POST['title'], "date" => $date->format("Y-m-d H:i:s"), "idUser" => $user[0][0], "image" => $_POST['image_post'], "readed" => 0));
                    if ($aux === false) {
                        $flag = false;
                    }
                }

                if (!$flag) {
                    throw new PDOException("Se ha producido un error");
                } else {
                    $bd->getPdo()->commit();

                    echo 'true';
                }
            }
        }
    } catch (PDOException $pdoex) {
        $bd->getPdo()->rollBack();
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        $bd->getPdo()->rollBack();
        echo $ex->getMessage();
    } finally {
        unset($bd);
    }
}

/**
 * User follow a other user
 *
 * This method dont have parameter, because it is called by AJAX
 */
function follow() {
    try {
        if (comprobarSession()) {
            $date = new DateTime();
            $bd = new Bd($_SESSION['user']['role']);
            $stmt = $bd->prepareQuery("INSERT INTO followers (id_user, id_follower) VALUES (:id_user,:id_follower)", array("id_user" => $_SESSION['user']['id'], "id_follower" => $_POST['idFollower']));

            if ($stmt === false) {
                $aux = $bd->prepareQuery("INSERT INTO notifications ( message, date, Users_idUsers, image_path, readed) VALUES (:message, :date, :idUser, :image, :readed)", array("message" => "<a href='Profile.html?id='></a>user_name" . " followed you.", "date" => $date->format("Y-m-d H:i:s"), "idUser" => $_POST['idFollower'], "image" => "img_profile", "readed" => 0));
                if ($aux === false) {
                    throw new Exception("1Se ha producido un error");
                } else {
                    echo "true";
                }
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
        echo "false";
    } catch (Exception $ex) {
        echo $ex->getMessage();
        echo "false";
    } finally {
        unset($bd);
    }
}

/**
 * 
 *
 * This method dont have parameter, because it is called by AJAX
 */
function unFollow() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            $stmt = $bd->prepareQuery("DELETE FROM followers WHERE id_user=" . $_SESSION['user']['id'] . " and id_follower=:idFollower", array("idFollower" => $_POST['idFollower']));

            if ($stmt === false) {
                echo "false";
            } else {
                echo "true";
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    } finally {
        unset($bd);
    }
}

/**
 * Update status notifications
 *
 * This method dont have parameter, because it is called by AJAX
 * 
 * @throws PDOException If a PDO object failed
 */
function updateNotificationStatus() {
    try {
        if (comprobarSession()) {
            $bd = new Bd($_SESSION['user']['role']);
            $flag = true;
            if ($bd->getError() === false) {
                $stmt = $bd->query("UPDATE notifications SET readed=1 WHERE Users_idUsers=" . $_SESSION['user']['id']);
                if ($stmt !== false) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    } catch (PDOException $pdoex) {
        echo $pdoex->getMessage();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    } finally {
        unset($bd);
    }
}
