<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/mie_recensioni.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
        require_once('common.php');
        require_once('header.php');
        $file_recensioni = './databases/recensioni.json';

        if(isset($_POST['funzione']) && $_POST['funzione'] == 'Elimina'){
            $user->user_elimina_recensione($file_recensioni, $_POST['titolo']);
        }
        elseif(isset($_POST['funzione']) && $_POST['funzione'] == 'Aggiungi'){
            $user->user_aggiungi_recensione($file_recensioni, $_POST['titolo'], $_POST['autore'], $_POST['valutazione'], $_POST['recensione']);
        }
    ?>
    <main>
        <!-- inserire il form di inserimento della recensione -->
        <section class='first'>
            <form action="" method="POST" class="inserisci">
                <h1>Aggiungi la tua recensione</h1>
                <label for="titolo" class='label'>Titolo del libro :</label>
                <input type="text" name="titolo" id="titolo" required>
                <label for="autore" class='label'>Autore :</label>
                <input type="text" name="autore" id="autore" required>
                <label for="valutazione" class='label val'>Valutazione :</label>
                <div class="rating">
                    <input type="radio" name="valutazione" id="valutazione-1" value="1" required>
                    <label for="valutazione-1" class="ball"></label>
                    <input type="radio" name="valutazione" id="valutazione-2" value="2">
                    <label for="valutazione-2" class="ball"></label>
                    <input type="radio" name="valutazione" id="valutazione-3" value="3">
                    <label for="valutazione-3" class="ball"></label>
                    <input type="radio" name="valutazione" id="valutazione-4" value="4">
                    <label for="valutazione-4" class="ball"></label>
                    <input type="radio" name="valutazione" id="valutazione-5" value="5">
                    <label for="valutazione-5" class="ball"></label>
                </div>
                <label for="recensione" class='label'>Recensione : </label>
                <textarea name="recensione" id="recensione" required></textarea>
                <input type="submit" name="funzione" value="Aggiungi">
            </form>
        </section>
        <!-- inserire la gestione delle proprie recensioni -->
        <?php if($user->user_ha_recensito($file_recensioni)): ?>
            <section class="last">
                <h1>Le tue recensioni</h1>
                <?php $recensioni_array = json_decode(file_get_contents($file_recensioni), true); ?>
                <?php foreach($recensioni_array as $key => $recensione): ?>
                    <?php if($recensione['Username'] == $user->get_username()): ?>
                        <div class='recensione'>
                            <h2><?php echo $recensione['Titolo del libro']; ?></h2>
                            <p>Autore : <?php echo $recensione['Autore']; ?></p>
                            <div class="valutazione-container">
                                <p class="valutazione">Valutazione : </p>
                                <div class='container'>
                                    <?php for($i=0; $i<$recensione['Valutazione']; $i++): ?>
                                        <div class='sfera'></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p>Recensione : <?php echo $recensione['Recensione']; ?></p>
                            <form action="" method="POST" class="recensioni">
                                <input type="hidden" name="titolo" value="<?php echo $recensione['Titolo del libro']; ?>">
                                <input type="submit" name="funzione" value="Elimina">
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>