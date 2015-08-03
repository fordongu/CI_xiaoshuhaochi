<?php

class Goods_model extends CI_Model
{
    /**
     * 获取商品某天的库存
     *
     * @param int $goods_id 商品id
     * @param string $date
     */
    public function getStore($goods_id, $date, $week)
    {
        $sql = 'SELECT store FROM t_good_supplier_buildings WHERE good_id = ? AND (start_time <= ? AND end_time >= ?) AND week = ? LIMIT 1';
        $query = $this->db->query($sql, array($goods_id, $date, $week));
        $goods = $query->row();
        if (empty($goods)) {
            return 0;
        }
        return $goods->store;
    }

    public function getStoreList($goods_id_list, $date, $week)
    {
        //$sql = 'SELECT good_id, stock FROM t_good_supplier_buildings WHERE good_id in ? AND (start_time <= ? AND end_time >= ?) AND week = ?';
        $sql = 'SELECT good_id, stock FROM t_good_supplier_buildings WHERE good_id in ? AND (start_time <= ? AND end_time >= ?) AND FIND_IN_SET(?, week)';
        $query = $this->db->query($sql, array($goods_id_list, $date, $date, $week));
        $goods = $query->result();
        $store = [];
        for ($i = 0; $i < count($goods_id_list); $i++) {
            $store[$goods_id_list[$i]] = 0;
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                $store[$row->good_id] = $row->stock;
            }
        }
        return $store;
    }

    public function getGoodsInfo($goods_id)
    {
        $this->db->where('id',$goods_id);
        $query = $this->db->get('t_goods');
        $goods = $query->row();
        return $goods;
    }

    public function getGoodsTotal($params)
    {
         $where = '';
        $arr = [];
        if (array_key_exists('goods_id', $params) && !empty($params['goods_id'])) {
            $where .= ' AND id = ?';
            array_push($arr, $params['goods_id']);
        }

        if (array_key_exists('goods_id_list', $params) && !empty($params['goods_id_list'])) {
            $where .= ' AND id in (?)';
            array_push($arr, $params['goods_id_list']);
        }

        if (array_key_exists('status', $params)) {
            $where .= ' AND status in (?)';
            if (empty($params['status'])) {
                $params['status'] = 0;
            }
            array_push($arr, $params['status']);
        }

        $limit = '';
        if ($is_paging) {
            $limit .= ' LIMIT ?,?';
            array_push($arr, $offset);
            array_push($arr, $pagesize);
        }

        $sql = "SELECT count(*) as total FROM t_goods WHERE 1 = 1 $where $limit";
        $query = $this->db->query($sql, $arr);
        $result = $query->row();

        if (empty($result)) {
            return 0;
        }
        $total = $result->total;
        return $total;
    }

    public function getGoodsList($params, $is_paging = false, $offset = 1, $page_size = 10, $order = '')
    {
        $where = '';
        $arr = [];
        if (array_key_exists('goods_id', $params) && !empty($params['goods_id'])) {
            $where .= ' AND id = ?';
            array_push($arr, $params['goods_id']);
        }

        if (array_key_exists('goods_id_list', $params) && !empty($params['goods_id_list'])) {
            $where .= ' AND id in ?';
            array_push($arr, $params['goods_id_list']);
        }

        if (array_key_exists('status', $params)) {
            $where .= ' AND status in ?';
            if (empty($params['status'])) {
                $params['status'] = 0;
            }
            array_push($arr, $params['status']);
        }

        $limit = '';
        if ($is_paging) {
            $limit .= ' LIMIT ?,?';
            array_push($arr, $offset);
            array_push($arr, $pagesize);
        }

        $order_by = '';
        if ($order) {
            $order_by .= ' ORDER BY ?';
            array_push($arr, $order);
        }

        $sql = "SELECT * FROM t_goods WHERE 1 = 1 $where $limit $order_by";
        $query = $this->db->query($sql, $arr);

        $goods_list = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                $goods_list[$row->id] = $row;
            }
        }

        return $goods_list;
    }
    /*
     * 获取商品详情
     */
    public function getGoodDetail($good_id,$building_id){
        //先查询是否存在详情与供应商图片。
        $sql="select t_goods.name as goods_name,t_goods.*,t_good_supplier_buildings.*,t_supplier.*,t_supplier.name as supplier_name,t_supplier_image.* from
           t_goods,t_good_supplier_buildings,t_supplier,t_supplier_image where  t_goods.id=t_good_supplier_buildings.good_id
           and t_good_supplier_buildings.supplier_id=t_supplier.id and t_supplier.id=t_supplier_image.supplier_id and t_goods.id=? and t_good_supplier_buildings.building_id=?";
        $goods=$this->db->query($sql,array($good_id,$building_id))->row();
        if(!$goods){
             $sql="select t_goods.name as goods_name, t_goods.*,t_good_supplier_buildings.*,t_supplier.*,t_supplier.name as supplier_name from
           t_goods,t_good_supplier_buildings,t_supplier,t_supplier_image where t_goods.id=t_good_supplier_buildings.good_id
           and t_good_supplier_buildings.supplier_id=t_supplier.id and t_goods.id=? and t_good_supplier_buildings.building_id=?";
        $goods=$this->db->query($sql,array($good_id,$building_id))->row();
        }
        return $goods;
        }
}

