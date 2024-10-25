<?php

class Product
{
    public $name;
    public $description;
    protected $price;

    public function __construct($name, $price, $description)
	 {
        $this->name = $name;
        $this->setPrice($price);
        $this->description = $description;
    }

    public function setPrice($price)
	 {
        if ($price < 0)
		  {
            throw new Exception("Ціна не може бути негативною.");
        }
        $this->price = $price;
    }

    public function getInfo()
	 {
        return "Назва: {$this->name}\nЦіна: {$this->price}\nОпис: {$this->description}\n";
    }
}

class DiscountedProduct extends Product
{
    private $discount;

    public function __construct($name, $price, $description, $discount)
	 {
        parent::__construct($name, $price, $description);
        $this->discount = $discount;
    }

    public function getDiscountedPrice()
	 {
        return $this->price * (1 - $this->discount / 100);
    }

    public function getInfo()
	 {
        $discountedPrice = $this->getDiscountedPrice();
        return parent::getInfo() . "Знижка: {$this->discount}%\nНова ціна: {$discountedPrice}\n";
    }
}

class Category
{
    public $name;
    public $products = [];

    public function __construct($name)
	 {
        $this->name = $name;
    }

    public function addProduct($product)
	 {
        $this->products[] = $product;
    }

    public function getProductsInfo() 
	{
        echo "Категорія: {$this->name}\n";
        foreach ($this->products as $product)
		  {
            echo $product->getInfo() . "\n";
        }
    }
}

try
{
    $product1 = new Product("Крейдяна Людина", 270, "палітурка, 288 c., 135х205 мм");
    $product2 = new Product("Інститут", 360, "палітурка, 608 c., 135х205 мм");
    $discountedProduct = new DiscountedProduct("Під куполом", 540, "палітурка, 1024 c., 135х205 мм", 5);

    $category = new Category("Книги");
    $category->addProduct($product1);
    $category->addProduct($product2);
    $category->addProduct($discountedProduct);

    $category->getProductsInfo();
}
catch (Exception $e)
{
    echo "Помилка: " . $e->getMessage();
}

?>
