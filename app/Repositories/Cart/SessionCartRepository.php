<?php

namespace App\Repositories\Cart;

use App\Models\Wine;
use App\Traits\WithCurrencyFormatter;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class SessionCartRepository implements CartRepositoryInterface
{
    use WithCurrencyFormatter;

    const SESSION = 'cart';

    public function __construct()
    {
        if(!Session::has(self::SESSION)){
            Session::put(self::SESSION,collect());
        }
    }

    public function add(Wine $wine, int $quantity): void{
        $cart = $this->getCart();
        if($cart->has($wine->id)){
            $cart->get($wine->id)['quantity'] += $quantity;
        }else{
            $cart->put($wine->id, [
                'product' => $wine,
                'quantity' => $quantity
            ]);
        }
        $this->updateCart($cart);
    }

    //incrementa un producto del carrito, se pasa wine para saber el stock
    public function increment(Wine $wine): void{
        $cart = $this->getCart();
        if($cart->has($wine->id)){
            if(data_get($cart->get($wine->id),'quantity') >= $wine->stock){
                throw new Exception('No hay suficiente stock para incrementat la cantidad de ' . $wine->name);
            }
            $wineInCart = $cart->get($wine->id);
            $wineInCart['quantity']++;
            $cart->put($wine->id,$wineInCart);
            $this->updateCart($cart);
        }
    }

    //decrementa un producto del carrito
    public function decrement(int $wineId): void{
        $cart = $this->getCart();
        if($cart->has($wineId)){
            $wineInCart = $cart->get($wineId);
            $wineInCart['quantity']--;
            $cart->put($wineId,$wineInCart);
            if(data_get($cart->get($wineId),'quantity') <= 0){
                $cart->forget($wineId);
            }
            $this->updateCart($cart);
        }
    }

    //remueve un producto del carrito
    public function remove(int $wineId): void{
        $cart = $this->getCart();
        $cart->forget($wineId);
        $this->updateCart($cart);
    }

    //numero de elementos en el carrito del vino que estamos pasando
    public function getTotalQuantityForWine(Wine $wine): int{
        $cart = $this->getCart();
        if($cart->has($wine->id)){
            return data_get($cart->get($wine->id),'quantity');
        }
        return 0;
    }

    //Coste total para el producto dado y un bool para saber si lo queremos formateado o no
    public function getTotalCostForWine(Wine $wine, bool $formatted): float|string{
        $cart = $this->getCart();
        $total = 0;
        if($cart->has($wine->id)){
            $total = data_get($cart->get($wine->id),'quantity') * $wine->price;
        }
        return $formatted ? $this->formatCurrency($total) : $total;
    }

    //el numero total de productos en el carrito
    public function getTotalQuantity(): int{
        $cart = $this->getCart();
        return $cart->sum('quantity');
    }

    //el costo total del carrito
    public function getTotalCost(bool $formatted): float|string{
        $cart = $this->getCart();
        $total = $cart->sum(function ($item){
            return data_get($item,'quantity') * data_get($item,'product.price');
        });
        return $formatted ? $this->formatCurrency($total) : $total;
    }

    //nos dice si el producto esta en el carrito
    public function hasProduct(Wine $wine): bool{
        $cart = $this->getCart();
        return $cart->has($wine->id);
    }

    //nos devuelve los elementos del carrito
    public function getCart(): Collection{
        return Session::get(self::SESSION);
    }

    //nos dice si el carrito esta vacio
    public function isEmpty(): bool{
        return $this->getTotalQuantity() === 0;
    }

    //vacia el carrito
    public function clear(): void{
        Session::forget(self::SESSION);
    }

    private function updateCart(Collection $cart): void{
        Session::put(self::SESSION,$cart);
    }
}
