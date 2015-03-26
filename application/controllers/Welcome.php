<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
	$this->load->helper('directory');
        $files = directory_map('./data/');
        $xmlFiles = [];
        
        foreach ($files as $file)
        {
            $ext = pathinfo($file);
            $fileName = $ext['filename'];
            
            if ($ext['extension'] == "xml" && strcasecmp(substr($ext['filename'], 0, 5), "order") == 0)
            {
                $customer = $this->order->getOrderInfo($fileName)['customer'];
                $xmlFiles[] = array('filename' => $fileName,
                                    'order' => $fileName . " ($customer)");
            }
        }
        
        $this->data['orders'] = $xmlFiles;
	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
	
	// Present the list to choose from
        $orderInfo = $this->order->getOrderInfo($filename);
        
        $this->data['order'] = ucfirst($orderInfo['order']);
        $this->data['order-type'] = $orderInfo['order-type'];
        $this->data['customer'] = $orderInfo['customer'];
        $this->data['special'] = $orderInfo['special'];
        
        $burgers = $this->order->getOrder($filename);
        for ($i = 0; $i < count($burgers); $i++)
        {
            $burgers[$i]['count'] = $i + 1;
            
//            if (empty($burgers[$i]['cheeses']))
//                $burgers[$i]['cheeses'] = "";
//            else
//                $burgers[$i]['cheeses'] = "<li>Cheese: " . $burgers[$i]['cheeses'] . "</li>";
            
            $burgers[$i]['toppingList'] = $this->getTopping($burgers[$i]['topping']);
            $burgers[$i]['sauceList'] = $this->getSauce($burgers[$i]['sauce']);
            
            if (empty($burgers[$i]['instructions']))
                $burgers[$i]['instructions'] = "";
            else
                $burgers[$i]['instructions'] = "<br/>Instructions: <i>" . $burgers[$i]['instructions'] . "</i>";
            
            $burgers[$i]['total'] = $this->order->getBurgerTotal($burgers[$i]);
             
        }
        $this->data['burgers'] = $burgers;

        
        $this->data['pagebody'] = 'justone';
	$this->render();
    }
    
    function getSauce($sauces)
    {
        $sauceList = "";
        foreach($sauces as $sauce)
            $sauceList .= ", " . $this->menu->getSauceName($sauce);
        
        if (empty($sauceList))
            $sauceList = "None";
        else
            $sauceList = substr($sauceList, 2);
        
       return $sauceList;
    }
    
    function getTopping($toppings)
    {
        $toppingList = "";
        foreach($toppings as $topping)
            $toppingList .= ", " . $this->menu->getToppingName($topping);
        
        if (empty($toppingList))
            $toppingList = "None";
        else
            $toppingList = substr($toppingList, 2);
        
       return $toppingList;
    }
    
    
    
    function getSpace($count)
    {
        $space = "";
        while ($count > 0)
        {
            $space .= "&nbsp";
            $count--;
        }
        return $space;
    }

}
