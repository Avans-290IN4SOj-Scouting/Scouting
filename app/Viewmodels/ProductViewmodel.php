<?php
namespace App\Viewmodels;


class ProductViewmodel
{
    public string $name;
    public array $priceForSize; // key = size, value = price
    public array $groups; // value = group
    public string $category; // productType (Heren, Dames, Unisex)
    public ?string $description;
    public string $image_path;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setPriceForSize(mixed $priceForSize)
    {
        $this->priceForSize = $priceForSize;
    }

    public function addPriceForSize($sizes, $prices)
    {
        if (!is_array($sizes) || !is_array($prices)) {
            return;
        }
        if (count($sizes) != count($prices)) {
            dd('The number of sizes and prices do not match', $sizes, $prices);
        }
        for ($i = 0; $i < count($sizes); $i++) {
            $this->priceForSize[$sizes[$i]] = $prices[$i];
        }
    }

    public function setGroups($groups)
    {
        if (is_array($groups)) {
            $this->groups = $groups;
        } else {
            $this->groups = [$groups]; // Convert the string to a single-element array
        }
    }
}
