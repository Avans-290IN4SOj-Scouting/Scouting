<?php
namespace App\Viewmodels;


class ProductViewmodel
{
    public string $name;
    public array $priceForSize; // key = size, value = price
    public array $groups; // value = group
    public string $category; // productType (Heren, Dames, Unisex)

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

    public function setGroups($groups)
    {
        // Ensure that $groups is an array
        if (is_array($groups)) {
            $this->groups = $groups;
        } else {
            // Handle the case where a non-array value is passed
            // For example, you can convert the string to an array or handle it in another way based on your requirements
            $this->groups = [$groups]; // Convert the string to a single-element array
        }
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setPicture($image_path)
    {
        // Check if a file was uploaded
        if ($image_path) {
            $this->image_path = $image_path->getPathname();
        }
    }
    public function getPicture()
    {
        return $this->image_path;
    }

    public function setPriceForSize(mixed $priceForSize)
    {
        $this->priceForSize = $priceForSize;
    }



}

