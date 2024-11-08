<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/contattaci.min.css">
</head>
<body>
    <?php
        require_once('common.php');
        require_once('header.php');
    ?>
    <main>
        <?php if(!empty($_POST)): ?>
            <?php
                $condizioni_valide = true;
                $file = './databases/messages.txt';
                if(!(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['argument']) && isset($_POST['message']))){
                    $condizioni_valide = false;
                }
                $name = htmlspecialchars(trim($_POST['name']));
                $surname = htmlspecialchars(trim($_POST['surname']));
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $condizioni_valide = false;
                }
                $message = htmlspecialchars($_POST['message']);
                if($condizioni_valide){
                    $message = 'Messaggio da: '.$name.' '.$surname.' - '.$_POST['email'].' - '.$_POST['argument'].' - '.$message;
                    file_put_contents($file, $message.PHP_EOL , FILE_APPEND | LOCK_EX);
                }
            ?>
            <?php if($condizioni_valide): ?>
                <div class='container'>
                    <h1>Messaggio inviato correttamente!</h1>
                    <p>Attendi 3-5 giorni e risponderemo ad ogni tuo dubbio!</p>
                </div>
            <?php else: ?>
                <div class='container'>
                    <h1 class='errore'>Errore nell'invio del messaggio</h1>
                    <p class='errore'>Controlla di aver inserito correttamente tutti i campi!</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class='container'>
            <form action="" method="post">
                <h1>Contattaci</h1>
                <label for="name">Nome :</label>
                <input type="text" name="name" id="name" required>
                <label for="surname">Cognome :</label>
                <input type="text" name="surname" id="surname" required>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
                <label for="argument">Seleziona l'argomento :</label>
                <select name="argument" id="argument">
                    <option value="info_request">Richiesta informazioni</option>
                    <option value="tech_assistant">Assistenza Tecnica</option>
                    <option value="other">Altro</option>
                </select>
                <label for="message">Messaggio</label>
                <textarea name="message" id="message" required></textarea>
                <input type="submit" value="Invia">
            </form>
            </div>
        <?php endif; ?>
    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>