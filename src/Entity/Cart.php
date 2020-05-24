<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;
use \BenMajor\ExchangeRatesAPI\ExchangeRatesAPI;
use \BenMajor\ExchangeRatesAPI\Response;
use \BenMajor\ExchangeRatesAPI\Exception;
/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    private $Products = array();
    private $quantity = array();

    public function getProducts() {
        return $this->Products;
    }

    /**
     * removes product and quantity from the array and rearranges
     * the array so that there are no null values
     * @param Product $product
     */
    public function removeProduct(Product $product) {
        for($i = 0; $i < count($this->Products); $i++)
        {
            if($this->Products[$i] == $product) {
                if($i == count($this->Products)-1) {
                    array_pop($this->Products);
                    array_pop($this->quantity);
                }
                else {
                    //moves array indexes
                    for ($g = $i; $g < count($this->Products)-1; $g++) {
                        $this->Products[$i] = $this->Products[$i+1];
                        $this->quantity[$i] = $this->quantity[$i+1];
                    }
                    array_pop($this->Products);
                    array_pop($this->quantity);
                }
            }
        }
    }

    /**
     * adds product to array and if product already exists increments the quantity
     * if not then quantity array is expanded
     * @param Product $product
     * @return int
     */
    public function addProduct(Product $product){
        for($i = 0; $i < count($this->Products); $i++)
        {
            if($this->Products[$i] == $product) {
                $this->quantity[$i]++;
                $num = count($this->quantity);
                return $num;
            }
        }
        $num = array_push($this->Products, $product);
        array_push($this->quantity, 1);
        return $num;

    }

    public function getQuantityOfProduct(Product $product) {
        for($i = 0; $i < count($this->Products); $i++)
        {
            if($this->Products[$i] == $product) {
                return $this->quantity[$i];
            }
        }
        return null;
    }

    /**
     * return the number of stored products in Cart
     * @return int
     */
    public function getCount() {
        $sum = 0;
        for($i = 0; $i < count($this->quantity); $i++) {
            $sum += $this->quantity[$i];
        }
        return $sum;
    }
    /**
     * increases product quantity by one
     * @param Product $product
     * @return int
     */
    public function incrementQuantity(Product $product) {
        for($i = 0; $i < count($this->Products); $i++)
        {
            if($this->Products[$i] == $product) {
                return $this->quantity[$i]++;
            }
        }
        return -1;
    }

    /**
     * decreases product quantity by one
     * @param Product $product
     * @return int
     */
    public function decrementQuantity(Product $product) {
        for($i = 0; $i < count($this->Products); $i++)
        {
            if($this->Products[$i] == $product) {
                if($this->quantity[$i] > 1) {
                    return $this->quantity[$i]--;
                }
                else {
                    $this->removeProduct($product);
                }
            }
        }
        return -1;
    }

    /**
     * return the total price of products multiplied by their quantity
     * @return float|int
     */
    public function getPrice() {
        $sum = 0;
        for($i = 0; $i < count($this->Products); $i++)
        {
            $sum += $this->Products[$i]->getPrice(1) * $this->quantity[$i];
        }
        return $sum;
    }
}
