<?php


        require_once("../config/main.php");

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $b_name = $_POST['b_name'] ?? null;
            $b_items_count = $_POST['b_items_count'] ?? 1;
            $b_avg_price_per_item = $_POST['b_avg_price_per_item'] ?? null;
            $b_purchase_date = $_POST['b_purchase_date'] ?? null;
            $b_description = $_POST['b_description'] ?? null;
            $b_status = $_POST['b_status'] ?? 'available';
            $b_stock_quantity = $_POST['b_stock_quantity'] ?? 1;



            $save = $db->query("INSERT INTO `bails` (`b_name`, `b_items_count`, `b_avg_price_per_item`, `b_purchase_date`, `b_description`, `b_status`, `b_stock_quantity`) 
            VALUES ('$b_name', '$b_items_count', '$b_avg_price_per_item', '$b_purchase_date', '$b_description', '$b_status', '$b_stock_quantity')");
            
            if ($save) echo 1;
            else echo 2;
        }
