<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion de regime</title>
</head>
<body>
    <h1>Suggestion de Regime</h1>
    <form action="">
        <!-- selection de l objectif -->
        <label for="input_objectifs"></label>
        <select name="objectifs" id="">
            <option value="">Diminuer</option>
            <option value="">Augmenter</option>
            <option value="">Ateindre IMC ideal</option>
        </select>

        <!-- selection du durrer -->
        <label for="input_durrer">Durer du regime</label>
        <input type="number" name="durrer" id="input_durrer">

        <!-- selection du type de proteinne preferer -->
         <h5>Proteine preferer</h5>
        <label for="radio_viande">viande</label>
        <input type="radio" name="preference" id="radio_viande" value="viande">

        <label for="radio_volaille">volaille</label>
        <input type="radio" name="preference" id="radio_volaille" value="volaille">

        <label for="radio_poisson">poisson</label>
        <input type="radio" name="preference" id="radio_poisson" value="poisson">

        <input type="submit" value="Rechercher">
    </form>
</body>
</html>