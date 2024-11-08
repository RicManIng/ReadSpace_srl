<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/recensioni.min.css">
</head>
<body>
    <?php
        require_once('common.php');
        require_once('header.php');
        $file_recensioni = './databases/recensioni.json';
        $recensioni_array = json_decode(file_get_contents($file_recensioni), true);
    ?>
    <main>
        <?php foreach($recensioni_array as $key=>$recensione): ?>
        <?php if($key == 0): ?>
            <section class='first'>
        <?php elseif($key == (count($recensioni_array) - 1)): ?>
            <section class='last'>
        <?php else: ?>
            <section>
        <?php endif; ?>
                <h1>Titolo : <?php echo $recensione['Titolo del libro']; ?></h1>
                <p>Autore : <?php echo $recensione['Autore']; ?></p>
                <p>User : <?php echo $recensione['Username']; ?></p>
                <div class='container'>
                    <?php for($i=0; $i<$recensione['Valutazione']; $i++): ?>
                        <div class='sfera'></div>
                    <?php endfor; ?>
                </div>
                <p> 
                    <?php echo $recensione['Recensione']; ?>
                </p>
            </section> 
        <?php endforeach; ?>
    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>