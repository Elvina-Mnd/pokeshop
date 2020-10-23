<?php

namespace App\Controller;

use App\Model\PokemonManager;
use App\Model\CommandManager;
use Stripe\Stripe;

class CartController extends AbstractController
{
    public function addPokemon($pokemon)
    {
        if (!empty($_SESSION['cart'][$pokemon])) {
            $_SESSION['cart'][$pokemon]++;
        } else {
            $_SESSION['cart'][$pokemon] = 1;
        }
        $_SESSION['count'] = $this->countPokemons();
        header('Location:/home/index');
    }

    function deletePokemon($pokemon)
    {
        $cart = $_SESSION['cart'];
        if (!empty($cart[$pokemon])) {
            unset($cart[$pokemon]);
        }
        $_SESSION['cart'] = $cart;
        header('Location:/home/cart');
    }

    function getCartInfos()
    {
        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            $cartInfos = [];
            $pokemonManager = new PokemonManager();
            foreach ($cart as $pokemon => $qty) {
                $infosPokemon = $pokemonManager->selectOneById(intval($pokemon));
                $infosPokemon['qty'] = $qty;
                $cartInfos[] = $infosPokemon;
            }
            return $cartInfos;
        } else {
            return false;
        }
    }

    function getTotalCart()
    {
        $total = 0;
        foreach ($this->getCartInfos() as $item) {
            $total += $item['qty'] * $item['price'];
        }
        return $total;
    }

    public function countPokemons()
    {
        $total = 0;
        foreach ($this->getCartInfos() as $item) {
            $total += $item['qty'];
        }
        return $total;
    }

    public function payment($infos)
    {
        $stripe = \Stripe\Stripe::setApiKey(API_KEY);
        $commandManager = new CommandManager();
        $data = [
            'name' => $infos['name'],
            'address' => $infos['address'],
            'total' => $this->getTotalCart(),
            'date' => date("Y-m-d")
        ];
        $commandManager->insert($data);
        try {
            //CUSTOMER
            $data = [
                'source' => $_POST['stripeToken'],
                'description' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $customer = \Stripe\Customer::create($data);
    
            // CHARGE
            $charge = \Stripe\Charge::create([
                'amount' => $this->getTotalCart(),
                'currency' => 'eur',
                'description' => 'Example charge',
                'customer' => $customer->id,
                'statement_descriptor' => 'Custom descriptor',
            ]);
            $transacUrl = $charge->receipt_url;
            unset($_SESSION['cart']);
            unset($_SESSION['count']);
            $_SESSION['transaction'] = $transacUrl;

            header('Location:/home/success');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $e->getError(); 
        }
    }
}
