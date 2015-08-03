<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends Controller {
    public function __construct() {
        parent::__construct();
        //$this->load->helper('curl');
        $this->load->model('cart_model');
    }

    public function addCart()
    {
        $goods_id = (int)$this->input->post('goods_id');
        $date = $this->input->post('date');
        $num = (int)$this->input->post('num');
        $type = (int)$this->input->post('goods_type');
        $week_flag = (int)$this->input->post('week_flag');

        $goods_type_arr = [0];//暂时只支持普通商品类型(0:普通商品，1:赠品，2:组合商品)
        $ordering_time_arr = [0, 1];//暂时只支持本周和下周的点餐

        $error = [];
        if ($date) {
            $date = $is_date = @strtotime($date) ? @strtotime($date) : FALSE;
            if (!$is_date) {
                array_push($error, '点餐时间格式不正确');
            }
        }

        if ($num <= 0) {
            array_push($error, '点餐份数必须大于0');
        }

        if (!in_array($type, $goods_type_arr)) {
            array_push($error, '商品类型不正确');
        }

        if (!in_array($week_flag, $ordering_time_arr)) {
            array_push($error, '只能点本周和下周的午餐');
        }

        if (!empty($error)) {
            echo json_encode(array('status' => 101, 'error' => $error));
            exit;
        }

        $flag = $this->cart_model->addCart($goods_id, $date, $num, $type, $week_flag);
        echo json_encode(array('status' => 0, 'data' => $flag));
        exit;
    }

    public function getCart()
    {
        $goods_list = $this->cart_model->getCartInfo();

        $this->load->model('date_model');
        $this_dinner_dates = $this->date_model->getDinnerDate(0);
        $next_dinner_dates = $this->date_model->getDinnerDate(1);
        //echo json_encode($goods_list);exit;
        echo json_encode(array('goods_list' => $goods_list, 'this_dinner_dates' => $this_dinner_dates, 'next_dinner_dates' => $next_dinner_dates));
        exit;
    }

    public function getCartCount()
    {
        $count = $this->cart_model->getCartCount();
        echo $count;
        exit;
    }

    public function incrCart()
    {
        $goods_key = $this->input->post('goods_key');
        $goods_num = $this->input->post('goods_num');
        $week_flag = $this->input->post('week_flag');
        $flag = $this->cart_model->incrCart($goods_key, $goods_num, $week_flag);
        echo json_encode(array('status' => 0, 'data' => $flag));
        exit;
    }

    public function decrCart()
    {
        $goods_key = $this->input->post('goods_key');
        $goods_num = $this->input->post('goods_num');
        $week_flag = $this->input->post('week_flag');

        $flag = $this->cart_model->decrCart($goods_key, $goods_num, $week_flag);
        echo json_encode(array('status' => 0, 'data' => $flag));
        exit;
    }

    public function updateCartDate()
    {
        //$date = '2015-5-5';
        $date = $this->input->post('date');
        $week_flag = (int)$this->input->post('week_flag');
        $is_date = @strtotime($date) ? @strtotime($date) : FALSE;
        $ordering_time_arr = [0, 1];//暂时只支持本周和下周的点餐
        if (!in_array($week_flag, $ordering_time_arr)) {
            echo json_encode(array('status' => 101, 'error' => '暂时只支持本周和下周的点餐'));
            exit;
        }
        if ($is_date) {
            $flag = $this->cart_model->updateCartDate(strtotime($date), $week_flag);
            echo json_encode(array('status' => 0, 'data' => (int)$flag));
            exit;
        } else {
            echo json_encode(array('status' => 102, 'error' => '点餐时间格式不正确'));
            exit;
        }
    }
}
