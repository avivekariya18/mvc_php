<?php 
class Admin_Model_Csv extends Core_Model_Abstract{
    public function exportCsv($Model)
    {
        // Get order collection
        // $orderModel = Mage::getModel("sale/order"); // Adjust model path as needed
        $collection = $Model->getCollection();
        $data = $collection->getData();

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Create output stream
        $output = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($output, array_keys($data[0]->getData()));
        
        foreach ($data as $order) {
            fputcsv($output,$order->getData());
        }

        // Close the stream
        fclose($output);

        // Exit to prevent any additional output
        // exit();
    }
}
?>