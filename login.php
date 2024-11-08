<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/login.min.css">
</head>
<body>
    <?php
        require_once('_user.php');
        require_once('common.php');
        require_once('header.php');

        use MyUsers\User as User;

        $error_message = null;
        $utente_salvato = false;
        $utente_caricato = false;

        if(!empty($_POST)){
            if($_GET['stato'] == 'signup'){
                $condizioni_valide = true;
                $file = './databases/Users.json';
                if(!(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']))){
                    $condizioni_valide = false;
                    $error_message = 'Errore: controlla di aver inserito tutti i campi';
                } elseif ($_POST['password'] != $_POST['confirm_password']){
                    $condizioni_valide = false;
                    $error_message = 'Errore: le password non coincidono';
                } elseif ($user->username_exists($_POST['username'], $file)){
                    $condizioni_valide = false;
                    $error_message = 'Errore: username già esistente';
                } elseif (!$user->set_username($_POST['username'])){
                    $condizioni_valide = false;
                    $error_message = 'Errore: username non valido';
                } elseif (!$user->set_password($_POST['password'])){
                    $condizioni_valide = false;
                    $error_message = 'Errore: password non valida';
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $condizioni_valide = false;
                    $error_message = 'Errore: email non valida';
                } elseif(!$user->set_birthDate($_POST['giorno'], $_POST['mese'], $_POST['anno'])){
                    $error_message = 'Errore: data di nascita non valida';
                } elseif($user->email_exists($_POST['email'], $file)){
                    $condizioni_valide = false;
                    $error_message = 'Errore: email già esistente';
                } elseif(!$user->set_email($_POST['email'])){
                    $condizioni_valide = false;
                    $error_message = 'Errore: email non valida';
                } elseif(!$user->set_name($_POST['name'])){
                    $condizioni_valide = false;
                    $error_message = 'Errore: formato nome non valido';
                } elseif(!$user->set_surname($_POST['surname'])){
                    $condizioni_valide = false;
                    $error_message = 'Errore: formato cognome non valido';
                } else {
                    $user->user_save($file);
                    $utente_salvato = true;
                }
            }

            elseif($_GET['stato'] == 'login'){
                $condizioni_valide = true;
                $file = './databases/users.json';
                $error_messages = [];
                if(!(isset($_POST['username']) && isset($_POST['password']))){
                    $condizioni_valide = false;
                    $error_message = 'Errore: controlla di aver inserito tutti i campi';
                } elseif (!$user->username_exists($_POST['username'], $file)){
                    $condizioni_valide = false;
                    $error_message = 'Errore: username non esistente';
                } elseif (!$user->check_login($_POST['username'], $_POST['password'], $file)) {
                    $condizioni_valide = false;
                    $error_message = 'Errore: password errata';
                }

                if ($condizioni_valide){
                    $UserLogged = true;
                    $utente_caricato = true;
                }
            }
        }
            
    ?>
    <main>
        <?php if($_GET['stato'] == 'logout') : ?>
            <div class='container'>
                <h1>Log Out avvenuto con successo!</h1>
                <p>Torna alla home oppure accedi con un altro utente</p>
                <?php
                    /* session_start(); */
                    $_SESSION = array();
                    session_destroy();
                ?>
                <a href="home.php">Torna alla home</a>
                <a href="login.php?stato=login" class='accedi'>Accedi</a>
            </div>
        <?php elseif($UserLogged && !$utente_caricato && !$utente_salvato ) : ?>
            <div class='container'>
                <h1>Hai già effettuato il Log In!</h1>
                <p>Clicca in alto a destra se vuoi effettuare il Log Out per accedere con un altro utente</p>
            </div>
        <?php elseif($utente_salvato) : ?>
            <div class='container'>
                <h1>Registrazione avvenuta con successo!</h1>
                <p>Effettua il Log In per accedere al tuo account</p>
                <a href="login.php?stato=login">Accedi</a>
            </div>
        <?php elseif($utente_caricato) : ?>
            <div class='container'>
                <h1>Log In avvenuto con successo!</h1>
                <p>Benvenuto <?php echo $user->get_name(); ?></p>
                <a href="home.php">Torna alla home</a>
            </div>
        <?php else: ?>
            <?php if($_GET['stato'] == 'signup') : ?>
                <form action="" method="POST" class='container'>
                    <h1>Registrati</h1>
                    <label for="name">Nome * :</label>
                    <input type="text" name="name" id="name" value="<?php echo $_POST['name'] ??  ''; ?>" required>
                    <label for="surname">Cognome * :</label>
                    <input type="text" name="surname" id="surname" value="<?php echo $_POST['surname'] ??  ''; ?>" required>
                    <label for="username">Username * : </label>
                    <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ??  ''; ?>" required>
                    <label for="email">Email * :</label>
                    <input type="email" name="email" id="email" value="<?php echo $_POST['email'] ??  ''; ?>" required>
                    <label for="password">Password * :</label>
                    <input type="password" name="password" id="password" required>
                    <label for="confirm_password">Conferma Password * :</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <label for="data">Data di nascita : </label>
                    <div>
                        <select name="giorno" id="data_giorno">
                            <option value="0">Giorno</option>
                            <?php for($i = 1; $i <= 31; $i++) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="mese" id="data_mese">
                            <option value="0">Mese</option>
                            <?php for($i = 1; $i <= 12; $i++) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="anno" id="data_anno">
                            <option value="0">Anno</option>
                            <?php for($i = date('Y'); $i >= 1900; $i--) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <input type="submit" value="Registrati">
                    <?php
                        if($error_message){
                            echo "<p class='errors'>$error_message</p>";
                        }
                    ?>
                    <p>Hai già un account?</p>
                    <a href="login.php?stato=login">Effettua il Loging</a>
                </form>
            <?php elseif($_GET['stato'] == 'login') : ?>
                <form action="" method='POST' class='container'>
                    <h1>Accedi</h1>
                    <label for="username">Username :</label>
                    <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ??  ''; ?>" required>
                    <label for="password">Password :</label>
                    <input type="password" name="password" id="password" required>
                    <input type="submit" value="Accedi">
                    <?php
                        if($error_message){
                            echo "<p class='errors'>$error_message</p>";
                        }
                    ?>
                    <p>Non hai un account?</p>
                    <a href="login.php?stato=signup">Iscriviti</a>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>