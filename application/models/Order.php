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
            
            $burger['cheeses'] = [];
            $burger['cheeses'][] = $burg->cheeses['top'];
            $burger['cheeses'][] = $burg->cheeses['bottom'];
            
//            if (!empty($topCheese) && !empty($bottomCheese))
//                $burger['cheeses'] = $topCheese . " (top), " . $bottomCheese . " (bottom)";
//            else if (!empty($topCheese))
//                $burger['cheeses'] = $topCheese . " (top)";
//            else if (!empty($bottomCheese))
//                $burger['cheeses'] = $bottomCheese . " (bottom)";
//            else
//                $burger['cheeses'] = "";
            
            $burger['topping'] = [];
            foreach ($burg->topping as $topping)
            {
//                $burger['topping'] .= ", " . $topping['type'];
                $burger['topping'][] = $topping['type'];
            }
//            $burger['topping'] = substr($burger['topping'], 2);
            
            $burger['sauce'] = [];
            foreach ($burg->sauce as $sauce)
            {
//                $burger['sauce'] .= ", " . $sauce['type'];
                $burger['sauce'][] = $sauce['type'];

            }
//            $burger['sauce'] = substr($burger['sauce'], 2);
            
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
        
        foreach ($burger['cheeses'] as $cheese)
            $total += $this->menu->getCheesePrice($cheese);
        
        foreach ($burger['topping'] as $topping)
            $total += $this->menu->getToppingPrice($topping);
        
        foreach ($burger['sauce'] as $sauce)
            $total += $this->menu->getSaucePrice($sauce);
        
        return $total;
    }
}
