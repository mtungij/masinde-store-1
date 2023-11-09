<?php
use Mpdf\Mpdf;
 
class Reports extends CI_Controller {
 
 public function mainstore_product($branch_id)
 {
       $main_products = $this->db->get("product")->result();
        $branch_name = $this->db->get_where("branch", ['id' => $branch_id])->row()->name;
        $mainbranch_products = $this->db->select("p.*, bp.branchId, bp.quantity as branch_quantity, bp.inventory as branch_inventory, bp.damages as branch_damages, bp.stockLimit as branch_stockLimit, bp.id as branch_product_id, bp.updatedAt as last_updated")
                                ->from("product p")
                                ->join("branchproduct bp", "p.id = bp.productId")
                                ->where("bp.branchId", $branch_id)
                                ->get()
                            ->result();


        $data = [
            "main_products" => $main_products,
            "mainbranch_products" => $mainbranch_products,
            "branch_name" => $branch_name,
            "branch_id" => $branch_id,
            "active_tab" => "active",
        ];
     //    echo "<pre>";
     //    print_r($data);
     //    echo "</pre>";
     //    die();
        $this->load->view("reports/mainstore.php", $data);

        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
      $html = $this->load->view('reports/mainstore.php',[],true);
      $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
      $mpdf->WriteHTML($html);
      $mpdf->Output(); // opens in browser
      //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
 }
 
}

