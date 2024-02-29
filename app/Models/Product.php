<?php

    class Product extends Model
    {
        private string $name;
        private array $priceForSize;
        private $category;
        private $picture;

        public function __construct($name, $category, $picture)
        {
            $this->name = $name;
            $this->priceForSize = [];
            $this->groups = [];
            $this->category = $category;
            $this->picture = $picture;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName(string $name)
        {
            $this->name = $name;
        }

        public function getPriceForSize()
        {
            return $this->priceForSize;
        }

        public function addPriceForSize(string $size, string $price)
        {
            $this->priceForSize[$size] = $price;
        }

        public function setPriceForSize(array $priceForSize)
        {
            $this->priceForSize = $priceForSize;
        }

        public function getGroups()
        {
            return $this->groups;
        }

        public function addGroup($group)
        {
            $this->groups[] = $group;
        }

        public function setGroups(array $groups)
        {
            $this->groups = $groups;
        }

        public function getCategory()
        {
            return $this->category;
        }

        public function setCategory($category)
        {
            $this->category = $category;
        }

        public function getPicture()
        {
            return $this->picture;
        }

        public function setPicture($picture)
        {
            $this->picture = $picture;

        }
    }
