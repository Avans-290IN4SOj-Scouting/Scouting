<?php
namespace App\Viewmodels;


class ProductViewmodel
{
    public string $name;
    public array $priceForSize; // key = size, value = price
    public array $groups; // value = group
    public string $category; // productType (Heren, Dames, Unisex)

    public $image_path;

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
        $this->category = $category ?? '';
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setPicture($image_path)
    {
        // Check if a file was uploaded
        if ($image_path) {
            // Save the uploaded file or its path as needed
            // For example:
            // $this->picture = $picture->store('uploads'); // Save uploaded file to storage/uploads directory
            $this->image_path = $image_path->getPathname(); // Save the path of the uploaded file
        } else {
            // Handle the case where no file was uploaded
            $this->image_path = ''; // Or any default value you prefer
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

}

