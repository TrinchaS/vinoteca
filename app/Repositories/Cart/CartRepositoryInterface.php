<?php

namespace App\Repositories\Cart;

use App\Models\Wine;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
    //añade un producto al carrito
    public function add(Wine $wine, int $quantity): void;

    //incrementa un producto del carrito, se pasa wine para saber el stock
    public function increment(Wine $wine): void;

    //decrementa un producto del carrito
    public function decrement(int $wineId): void;

    //remueve un producto del carrito
    public function remove(int $wineId): void;

    //numero de elementos en el carrito del vino que estamos pasando
    public function getTotalQuantityForWine(Wine $wine): float;

    //Coste total para el producto dado y un bool para saber si lo queremos formateado o no
    public function getTotalCostForWine(Wine $wine, bool $formatted): float|string;

    //el numero total de productos en el carrito
    public function getTotalQuantity(): int;

    //el costo total del carrito
    public function getTotalCost(bool $formatted): float|string;

    //nos dice si el producto esta en el carrito
    public function hasProduct(Wine $wine): bool;

    //nos devuelve los elementos del carrito
    public function getCart(): Collection;

    //nos dice si el carrito esta vacio
    public function isEmpty(): bool;

    //vacia el carrito
    public function clear(): void;
}
