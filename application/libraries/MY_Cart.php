<?php
class MY_Cart extends CI_Cart {

	function __construct() 
	{
		parent::__construct();
		$this->product_name_rules = '\d\D';
		//$this->product_name_rules    = '.+';
		//print_r($this->CI);
	}
	function _save_cart()
	{
		// Unset these so our total can be calculated correctly below
		unset($this->_cart_contents['total_items']);
		unset($this->_cart_contents['cart_total']);

		// Lets add up the individual prices and set the cart sub-total
		$total = 0;
		$items = 0;
		foreach ($this->_cart_contents as $key => $val)
		{
			// We make sure the array contains the proper indexes
			if ( ! is_array($val) OR ! isset($val['price']) OR ! isset($val['qty']))
			{
				continue;
			}

			$total += ($val['price'] * $val['qty']);
			$items += abs($val['qty']);

			// Set the subtotal
			$this->_cart_contents[$key]['subtotal'] = ($this->_cart_contents[$key]['price'] * $this->_cart_contents[$key]['qty']);
		}

		// Set the cart total and total items.
		$this->_cart_contents['total_items'] = $items;
		$this->_cart_contents['cart_total'] = $total;

		// Is our cart empty?  If so we delete it from the session
		if (count($this->_cart_contents) <= 2)
		{
			$this->CI->session->unset_userdata('cart_contents');

			// Nothing more to do... coffee time!
			return FALSE;
		}

		// If we made it this far it means that our cart has data.
		// Let's pass it to the Session class so it can be stored
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

		// Woot!
		return TRUE;
	}
	function _insert($items = array())
	{
		// Was any cart data passed? No? Bah...
		if ( ! is_array($items) OR count($items) == 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Does the $items array contain an id, quantity, price, and name?  These are required
		if ( ! isset($items['id']) OR ! isset($items['qty']) OR ! isset($items['price']) OR ! isset($items['name']))
		{
			log_message('error', 'The cart array must contain a product ID, quantity, price, and name.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the quantity. It can only be a number.  Duh...
		$items['qty'] = trim(preg_replace('/([^0-9\.\-])/i', '', $items['qty']));
		// Trim any leading zeros
		$items['qty'] = trim(preg_replace('/(^[0]+)/i', '', $items['qty']));

		// If the quantity is zero or blank there's nothing for us to do
		if ( ! is_numeric($items['qty']) OR $items['qty'] == 0)
		{
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product ID. It can only be alpha-numeric, dashes, underscores or periods
		// Not totally sure we should impose this rule, but it seems prudent to standardize IDs.
		// Note: These can be user-specified by setting the $this->product_id_rules variable.
		if ( ! preg_match("/^[".$this->product_id_rules."]+$/i", $items['id']))
		{
			log_message('error', 'Invalid product ID.  The product ID can only contain alpha-numeric characters, dashes, and underscores');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product name. It can only be alpha-numeric, dashes, underscores, colons or periods.
		// Note: These can be user-specified by setting the $this->product_name_rules variable.
		if ( ! preg_match("/^[".$this->product_name_rules."]+$/i", $items['name']))
		{
			log_message('error', 'An invalid name was submitted as the product name: '.$items['name'].' The name can only contain alpha-numeric characters, dashes, underscores, colons, and spaces');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the price.  Remove anything that isn't a number or decimal point.
		$items['price'] = trim(preg_replace('/([^0-9\.])/i', '', $items['price']));
		// Trim any leading zeros
		//$items['price'] = trim(preg_replace('/(^[0]+)/i', '', $items['price']));
		// Is the price a valid number?
		if ( ! is_numeric($items['price']))
		{
			log_message('error', 'An invalid price was submitted for product ID: '.$items['id']);
			return FALSE;
		}

		// --------------------------------------------------------------------

		// We now need to create a unique identifier for the item being inserted into the cart.
		// Every time something is added to the cart it is stored in the master cart array.
		// Each row in the cart array, however, must have a unique index that identifies not only
		// a particular product, but makes it possible to store identical products with different options.
		// For example, what if someone buys two identical t-shirts (same product ID), but in
		// different sizes?  The product ID (and other attributes, like the name) will be identical for
		// both sizes because it's the same shirt. The only difference will be the size.
		// Internally, we need to treat identical submissions, but with different options, as a unique product.
		// Our solution is to convert the options array to a string and MD5 it along with the product ID.
		// This becomes the unique "row ID"
		if (isset($items['options']) AND count($items['options']) > 0)
		{
			$rowid = md5($items['id'].implode('', $items['options']));
		}
		else
		{
			// No options were submitted so we simply MD5 the product ID.
			// Technically, we don't need to MD5 the ID in this case, but it makes
			// sense to standardize the format of array indexes for both conditions
			$rowid = md5($items['id']);
		}

		// --------------------------------------------------------------------

		// Now that we have our unique "row ID", we'll add our cart items to the master array

		// let's unset this first, just to make sure our index contains only the data from this submission
		unset($this->_cart_contents[$rowid]);

		// Create a new index with our new row ID
		$this->_cart_contents[$rowid]['rowid'] = $rowid;

		// And add the new items to the cart array
		foreach ($items as $key => $val)
		{
			$this->_cart_contents[$rowid][$key] = $val;
		}

		// Woot!
		return $rowid;
	}
	function _update($items = array())
	{
		// Without these array indexes there is nothing we can do
		if ( ! isset($items['qty']) OR ! isset($items['rowid']) OR ! isset($this->_cart_contents[$items['rowid']]))
		{
			return FALSE;
		}

		// Prep the quantity
		$items['qty'] = preg_replace('/([^0-9\.\-])/i', '', $items['qty']);

		// Is the quantity a number?
		if ( ! is_numeric($items['qty']))
		{
			return FALSE;
		}

		// Is the new quantity different than what is already saved in the cart?
		// If it's the same there's nothing to do
		if ($this->_cart_contents[$items['rowid']]['qty'] == $items['qty'])
		{
			return FALSE;
		}

		// Is the quantity zero?  If so we will remove the item from the cart.
		// If the quantity is greater than zero we are updating
		if ($items['qty'] == 0)
		{
			unset($this->_cart_contents[$items['rowid']]);
		}
		else
		{
			$this->_cart_contents[$items['rowid']]['qty'] = $items['qty'];
		}

		return TRUE;
	}
	public function find_by_id($product_id = null){
		//print_r($this->_cart_contents);
		if ($this->total_items() > 0)
		{
			$in_cart = array();
			foreach ($this->contents() AS $item)
			{
				$in_cart[$item['id']] = $item;
			}
			if ($product_id)
			{
				if (array_key_exists($product_id, $in_cart))
				{
					return $in_cart[$product_id];
				}
				return null;
			}
			else
			{
				return $in_cart;
			}
		}
		return null;
	}
	public function find_by_options($option_fild, $option_value){
		//print_r($this->_cart_contents);
		if ($this->total_items() > 0)
		{
			foreach ($this->contents() as $item)
			{
				if(isset($item['options'][$option_fild]) and ($item['options'][$option_fild]==$option_value)){
					return $item['id'];
				}
			}
			
		}
		return null;
	}
	public function update_price($items = array()){
		// Was any cart data passed?
		if ( ! is_array($items) OR count($items) == 0)
		{
			return FALSE;
		}

		// You can either update a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one.  The way we
		// determine the array type is by looking for a required array key named "id".
		// If it's not found we assume it's a multi-dimensional array
		$save_cart = FALSE;
		if (isset($items['rowid']) AND isset($items['price']))
		{
			$this->_cart_contents[$items['rowid']]['price'] = $items['price'];
			$save_cart = TRUE;
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) AND isset($val['rowid']) AND isset($val['price']))
				{
					$this->_cart_contents[$val['rowid']]['price'] = $val['price'];
				}
			}
			$save_cart = TRUE;
		}

		// Save the cart data if the insert was successful
		if ($save_cart == TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}
	
	function total_fara_transport(){
		$total_fara_transport = 0;
		$this->ci =& get_instance();
		$this->ci->config->load('carguard');
		$this->furnizori_asociati = $this->ci->config->item('furnizori_asociati');
		foreach ($this->contents() AS $c)
		{
			if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati))){
				$total_fara_transport += $c['subtotal']*(100+$this->ci->session->userdata('valoare_tva'))/100;
			}
		}
		return $total_fara_transport;
	}
}