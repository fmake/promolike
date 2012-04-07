<?PHP



// Класс корзинки покупателя
class utlBasket {

        public $items = array(); // Массив товаров
        
        function addItemAsArray($arrItem) { // Добавить товар в корзику (вставляем массив)
			if(isset($this->items[$arrItem['id']])){ 
				//$this->items[$arrItem['id']]->count++;
			}
			else
				$this->items[$arrItem['id']] = new BasketItem($arrItem['id'], $arrItem['caption'], $arrItem['price']);
        }

		function setItemCount($id, $count) {
			settype($count, "integer");
			$this->items[$id]->count = $count;
		}

        function delItem($id) { // Удалить товар из корзинки
			if(isset($this->items[$id]))
				unset($this->items[$id]);
        }

        function getItems() { // Взять товары из корзинки
			return $this->items;
        }
		
        function emptyBasket() { // Очистить корзинку
            $this->items = array();
        }
        
        function getBasketCount() { // Взять количество товаров в корзинке
			$count = 0;
            foreach($this->items as $item)
				$count = $count + $item->count;

            return $count;
        }

        function getBasketTotal() { // Взять количество товаров в корзинке
			$total = 0;
            foreach($this->items as $item)
				$total = $total + ($item->price * $item->count);

            return $total;
        }

        function getBasketWeight() { // Взять количество товаров в корзинке
			$total = 0;
            foreach($this->items as $item) {
            $item->weight = str_replace(",", ".", $item->weight);
				$total = $total + ($item->weight * $item->count);
			}

            return $total;
        }

}


class BasketItem {

		public $id = null;
		public $caption = null;
		public $price = null;
		public $count = null;

		function __construct ($id, $caption, $price) {
			$this->id = $id;
			$this->caption = $caption;
			$this->price = $price;
			$this->count = 1;

			return $this;	
		}
}

class utlBasketSess extends utlBasket{

		function  __construct(){
			session_start();
		}

		function loadBasket () {
			if(isset($_SESSION['basket']))
				$this->items = unserialize($_SESSION['basket']);
		}

		function clearBasket () {
			unset($_SESSION['basket']);
			$this->emptyBasket();
		}

		function saveBasket () {
			$_SESSION['basket'] = serialize($this->items);
		}
}

?>