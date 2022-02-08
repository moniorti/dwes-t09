<html>

<head>
    <title>T.09.DWES</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<?php
    $pokemon_abilities=array();
    $pokemon_type=array();
if($_SERVER['REQUEST_METHOD']==='POST'){
    //echo $_POST["name"];
    echo "&nbsp";
    $pokemon_name=$_POST["name"];
    //$pokemon_id=$_POST["id_pokemon"];

    $pokemon_list=file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemon_name");
    $pokemon_list=json_decode($pokemon_list,true);
    //$pokemon_type=$pokemon_list["types"][0]["type"]["name"];
    foreach($pokemon_list["types"] as $type){
        array_push($pokemon_type, $type["type"]["name"]);
    }
    foreach($pokemon_list["abilities"] as $ability){
        array_push($pokemon_abilities, $ability["ability"]["name"]);
    }
    //var_dump($pokemon_abilities);
    $pokemon_image=$pokemon_list["sprites"]["front_default"];
    //echo $pokemon_image;
}

?>
<body>
    <h2>Pokémon Encyclopedia</h2>
    <a href="https://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_National_Pok%C3%A9dex_number" target="_blank">Lista de Pokémon</a>
    <form action="" method="POST" class="container">
        <div class="form-group">
            <label class="form-label" for="name">Nombre del pokemon:</label>
            <input class="form-control" type="pokemon_name" name="name" id="name" value="<?= $_POST["name"]?>"/>
        </div>
        <div class="form-group">
            <label class="form-label" for="tipos">Tipo de pokemon:</label>
            <input class="form-control" type="pokemon_type" name="type" id="type" disabled="disabled" value="<?= implode(", ", $pokemon_type); ?>"/>
        </div>  
        <div class="form-group">
            <label class="form-label" for="abilities">Habilidades:</label>
            <input class="form-control" type="pokemon_abilities" name="abilities" id="abilities" disabled="disabled" value="<?= implode(", ", $pokemon_abilities); ?>"/>
        </div>
        <div class="form-group">
            <img src="<?= $pokemon_image?>"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="submit" value="Enviar"/>
        </div>
    </form>
</body>
<hr>
<footer class="page-footer font-small footer mt-5">
    <div class="container-fluid text-center text-md-center">
        <p> © Mónica Ordóñez Tirado</p>
    </div>
</footer>

</html>