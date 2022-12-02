<?php
require_once 'models/User.php';

class UsersController implements Controller
{
    /**
     * Index que determina si vas o al error o a otra página (login)
     */
    public static function index()
    {
        $user = new User();

        try {
            // Solo lo hace cuando es administrador
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                echo $GLOBALS["twig"]->render(
                    'users/index.twig',
                    [
                        'users' => $user->findAll(),
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Crear usuarios
     */
    public static function create()
    {
        try {
            // Mira si es admin para poder ir a crear y demás
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                echo $GLOBALS["twig"]->render(
                    'users/create.twig',
                    [
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Muestra al usuario seleccionado
     */
    public static function show()
    {
        $user = new User();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                $user->setId_usuario($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'users/show.twig',
                    [
                        'user' => $user->findById(),
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Edita usuario seleccionado
     */
    public static function edit()
    {
        $user = new User();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                $user->setId_usuario($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'users/edit.twig',
                    [
                        'user' => $user->findById(),
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Guardar usuarios creados
     */
    public static function save()
    {
        $user = new User();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                $user->setNombre($_POST['nombre']);
                $user->setEmail($_POST['email']);
                $user->setId_rol($_POST['id_rol']);
                if (isset($_POST['password'])) {
                    $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
                }
                $user->save($user);
                header('Location: ' . url . 'users/index');

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Actualiza el usuario seleccionado
     */
    public static function update()
    {
        $user = new User();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                $user->setId_usuario($_POST['id']);
                $user->setNombre($_POST['nombre']);
                $user->setEmail($_POST['email']);
                $user->setId_rol($_POST['id_rol']);
                if (isset($_POST['password'])) {
                    $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
                }
                $user->update();
                header('Location: ' . url . 'users/index');

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Eliminado usuario seleccionado
     */
    public static function delete()
    {
        $user = new User();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                $user->setId_usuario($_GET['id']);
                $user->delete();
                header('Location: ' . url . 'users/index');

                // Si no tiene permiso, te dirige al error 403
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'error/_403');

                // Te dirige al login
            } else {
                header('Location: ' . url . 'auth/login');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>