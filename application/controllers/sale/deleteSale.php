<?php

class DeleteSale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!empty($_GET['vno'])) {

            $vno = $this->input->get('vno');

            $where = [
                'voucher_no' => $vno,
                'trash'      => 0,
            ];

            $itemInfo = get_result('sapitems', $where, ['stock_id', 'quantity']);

            if (!empty($itemInfo)) {
                foreach ($itemInfo as $key => $item) {

                    $stockWhere = ['id' => $item->stock_id, 'trash' => 0];

                    // get stock info
                    $stockInfo = get_row('stock', $stockWhere, 'quantity');

                    if (!empty($stockInfo)) {

                        $quantity = $stockInfo->quantity + $item->quantity;

                        // update stock
                        save_data('stock', ['quantity' => $quantity], $stockWhere);
                    }
                }
            }

            $data = ['trash' => 1];

            // update saprecords, sapitems, sapmeta, partytransaction, sale_return
            save_data('saprecords', $data, $where);
            save_data('sapitems', $data, $where);
            save_data('sapmeta', $data, $where);
            save_data('partytransaction', $data, ['relation' => 'sales:' . $vno, 'trash' => 0]);
            //save_data('sale_return', $data, $where);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Sale delete successfully!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('sale/searchSale', 'refresh');
    }

}
