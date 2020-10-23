<?php

namespace App\Controller;

use App\Model\PokemonManager;
use App\Controller\CartController;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $cartController = new CartController();
        $pokemonManager = new PokemonManager();
        $pokemons = $pokemonManager->selectAll();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!empty($_POST['search'])) {
                $pokemons = $pokemonManager->searchPokemon($_POST['search']);
            }
            if (!empty($_POST['add_pokemon'])) {
                $pokemon = $_POST['add_pokemon'];
                $cartController->addPokemon($pokemon);
            }
        }
        return $this->twig->render('Home/index.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    public function showPokemon($id)
    {
        $cartController = new CartController();
        $pokemonManager = new PokemonManager();
        $pokemon = $pokemonManager->selectOneById($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!empty($_POST['add_pokemon'])) {
                $pokemon = $_POST['add_pokemon'];
                $cartController->addPokemon($pokemon);
            }
        }
        return $this->twig->render('Home/show_pokemon.html.twig', ['pokemon' => $pokemon]);
    }

    public function cart()
    {
        $cartController = new CartController();
        $errorForm = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['delete_id'])) {
                $pokemon = $_POST['delete_id'];
                $cartController->deletePokemon($pokemon);
            }
            if (isset($_POST['payment'])) {
                if (!empty($_POST['name']) && !empty($_POST['address'])) {
                    $cartController->payment($_POST);
                } else {
                    $errorForm = "Tous les champs sont obligatoires !";
                }
            }
        }
        return $this->twig->render('Home/cart.html.twig', [
            'cartInfos' => $cartController->getCartInfos() ? $cartController->getCartInfos() : null,
            'total' => $cartController->getCartInfos() ? $cartController->getTotalCart() : null,
            'errorForm' => $errorForm
        ]);
    }

    public function success()
    {
        return $this->twig->render('Home/success.html.twig');
    }
}
