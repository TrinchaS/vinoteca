<?php

namespace App\Traits;

use Exception;

trait CartActions
{
    public function addProductToCart(): void{
        $wineId = request()->input('wine_id');
        $quantity = request()->input('quantity',default:1);

        $wine = $this->repository->find($wineId);
        $this->cart->add($wine,$quantity);
    }

    public function incrementProductQuantity():void{
        $wine = $this->repository->find(request('wine:id'));
        try{
            $this->cart->increment($wine);
            session()->flash('success','Cantidad incrementada');
        }catch(Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }

    public function decrementProductQuantity(): void{
        $this->cart->decrement(request('wine_id'));
    }

    public function removeProduct(): void{
        $this->cart->remove(request('wine_id'));
    }

    public function clearCart():void {
        $this->cart->clear();
    }
}
