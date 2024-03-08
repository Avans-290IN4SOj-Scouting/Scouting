<?php

class ProductViewmodel
{
    public string $name;
    public array $priceForSize; // key = size, value = price
    public array $groups; // value = group
    public string $category;
    public string $picture;
}
