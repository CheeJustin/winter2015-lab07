<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model {

    protected $xml = null;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    function getOrder($file)
    {
        $this->xml = simplexml_load_file(DATAPATH . $file . ".xml");
        
        $order = [];
        $burgers = $this->xml->burger;
        foreach ($burgers as $burg)
        {
            $burger = [];
            
            $burger['patty'] = $burg->patty["type"];
            
            $burger['top-cheese'] = $burg->cheeses['top'];
            $burger['bottom-cheese'] = $burg->cheeses['bottom'];
            
            $burger['topping'] = [];
            foreach ($burg->topping as $topping)
                $burger['topping'][] = $topping['type'];
            
            $burger['sauce'] = [];
            foreach ($burg->sauce as $sauce)
                $burger['sauce'][] = $sauce['type'];
            
            $burger['instructions'] = $burg->instructions;
            $order[] = $burger;
        }
        return $order;
    }
    
    function getOrderInfo($file)
    {
        $order = [];
        $this->xml = simplexml_load_file(DATAPATH . $file . ".xml");
        
        $order['customer'] = $this->xml->customer;
        $order['order'] = $file;
        $order['order-type'] = $this->xml['type'];
        $order['special'] = $this->xml->special;
        if (empty($order['special']))
            $order['special'] = "None";
        
        return $order;
    }
    
    function getBurgerTotal($burger)
    {
        $total = 0;
        $total += $this->menu->getPattyPrice($burger['patty']);
        
        if (isset($burger['top-cheese']))
            $total += $this->menu->getCheesePrice($burger['top-cheese']);
        if (isset($burger['bottom-cheese']))
            $total += $this->menu->getCheesePrice($burger['bottom-cheese']);
        
        foreach ($burger['topping'] as $topping)
            $total += $this->menu->getToppingPrice($topping);
        
        foreach ($burger['sauce'] as $sauce)
            $total += $this->menu->getSaucePrice($sauce);
        
        return $total;
    }
}
