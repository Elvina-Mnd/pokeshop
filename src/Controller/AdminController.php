<?php

namespace App\Controller;

use App\Model\PokemonManager;
use App\Model\CommandManager;

class AdminController extends AbstractController
{
    public function index()
    {
        $commandManager = new CommandManager();
        $pokemonManager = new PokemonManager();
        $pokemons = $pokemonManager->selectAll();
        $commands = $commandManager->selectAll();
        return $this->twig->render('Admin/index.html.twig', [
            'pokemons' => $pokemons,
            'commands' => $commands
        ]);
    }

    public function editPokemon($id = null)
    {
        $pokemonManager = new PokemonManager();
        $errorForm = null;
        $pokemon = null;
        if ($id != null){
            $pokemon = $pokemonManager->selectOneById($id);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['name']) && !empty($_POST['img']) && !empty($_POST['content']) && !empty($_POST['price']) ) {
                $data = [
                    'id' => $id ? $id : '',
                    'name' => $_POST['name'],
                    'img' => $_POST['img'],
                    'content' => $_POST['content'],
                    'price' => $_POST['price']
                ];
                if (isset($_POST['id']) && !empty($_POST['id'])) {
                    $pokemonManager->update($data);
                    header('Location:/admin/index');
                } else {
                    $pokemonManager->insert($data);
                    header('Location:/admin/index');
                }
            } else {
                $errorForm = 'Tous les champs sont obligatoires.';
            }
        }
        return $this->twig->render('Admin/edit_pokemon.html.twig', [
            'pokemon' => $pokemon ? $pokemon : null,
            'errorForm' => $errorForm
        ]);
    }

    public function deletePokemon($id)
    {
        $pokemonManager = new PokemonManager();
        $pokemonManager->delete($id);
        header('Location:/admin/index');
    }

    public function deleteCommand($id)
    {
        $commandManager = new CommandManager();
        $commandManager->delete($id);
        header('Location:/admin/index');
    }
}
