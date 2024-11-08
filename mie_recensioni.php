<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/home.min.css">
</head>
<body>
    <?php
        require_once('common.php');
        require_once('header.php');
        $file_recensioni = './databases/recensioni.json';
    ?>
    <main>
        <!-- inserire il form di inserimento della recensione -->
        <section>
            <form action="" method="POST">
                <label for="titolo">Titolo del libro</label>
                <input type="text" name="titolo" id="titolo" required>
                <label for="autore">Autore</label>
                <input type="text" name="autore" id="autore" required>
                <label for="valutazione">Valutazione</label>
                <select name="valutazione" id="valutazione" required>
                    <option value="1">1 Stella</option>
                    <option value="2">2 Stelle</option>
                    <option value="3">3 Stelle</option>
                    <option value="4">4 Stelle</option>
                    <option value="5">5 Stelle</option>
                </select>
                <label for="recensione">Recensione</label>
                <textarea name="recensione" id="recensione" required></textarea>
                <input type="submit" value="Aggiungi">
            </form>
        </section>
        <!-- inserire la gestione delle proprie recensioni -->

    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>