<?php

class ProductViewmodel
{
    public string $name;
    public array $priceForSize; // key = size, value = price
    public array $groups; // value = group
    public string $category; // productType (Heren, Dames, Unisex)
    public string $picture; // link to? (not implemented)
}
