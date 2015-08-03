<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->service('cart_service');
    }

    public function index()
    {
        //$this->load->service('cart_service');
        $goods_list = $this->cart_service->getCartInfo();
        $this->load->view('welcome_message');
    }

    public function getCart()
    {
        $goods_list = $this->cart_service->getCartInfo();
        echo json_encode($goods_list);
        exit;
    }

    public function getCartCount()
    {
        $count = $this->cart_service->getCartCount();
        echo $count;
        exit;
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

        $flag = $this->cart_service->addCart($goods_id, $date, $num, $type, $week_flag);
        echo json_encode(array('status' => 0, 'data' => $flag));
        exit;
    }

    public function delCart()
    {

    }

    public function clearCart()
    {
        $flag = $this->cart_service->clearCart();
        echo json_encode(array('status' => 0, 'date' => $flag));
        exit;
    }

    public function incrCart()
    {
        $goods_key = $this->input->post('goods_key');
        $goods_num = $this->input->post('goods_num');
        $week_flag = $this->input->post('week_flag');
        $flag = $this->cart_service->incrCart($goods_key, $goods_num, $week_flag);
        echo json_encode(array('status' => 0, 'data' => $flag));
        exit;
    }

    public function decrCart()
    {
        $goods_key = $this->input->post('goods_key');
        $goods_num = $this->input->post('goods_num');
        $week_flag = $this->input->post('week_flag');

        $flag = $this->cart_service->decrCart($goods_key, $goods_num, $week_flag);
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
            $flag = $this->cart_service->updateCartDate(strtotime($date), $week_flag);
            echo json_encode(array('status' => 0, 'data' => $flag));
            exit;
        } else {
            echo json_encode(array('status' => 102, 'error' => '点餐时间格式不正确'));
            exit;
        }
    }

    public function getDinnerTime()
    {
        $time_list = [];
        $week_array = array("日","一","二","三","四","五","六");
        $week_flag = (int)$this->input->post('week_flag');
        //$week_flag = 1;
        $ordering_time_arr = [0, 1];//暂时只支持本周和下周的点餐
        if (!in_array($week_flag, $ordering_time_arr)) {
            echo json_encode(array('status' => 101, 'error' => '暂时只支持本周和下周的点餐'));
            exit;
        }

        $hour = date('G');
        $week = date('w');

        if ($week_flag == 0) {
            $c = 0;
            for ($i = $week; $i <= 5; $i++) {
                if ($i == $week && $hour >= 10) {
                    continue;
                } elseif ($i == $week && $hour < 10) {
                    $key = date('Y-m-d');
                    $time_list[$key] = '星期'.$week_array[$i].' '.date('m/d');
                } else {
                    $c++;
                    $key = date('Y-m-d' ,strtotime("+$c day"));
                    $time_list[$key] = '星期'.$week_array[$i].' '.date('m/d' ,strtotime("+$c day"));
                }
            }
        } else {
            if ($week == 0) {
                for ($i = 1; $i <= 5; $i++) {
                    $key = date('Y-m-d' ,strtotime("+$i day"));
                    $time_list[$key] = '星期'.$week_array[$i].' '.date('m/d' ,strtotime("+$i day"));
                }
            } else {
                for ($i = 1; $i <= 5; $i++) {
                    $key = date('Y-m-d' ,($i-1)*24*3600 + strtotime("next Monday"));
                    $time_list[$key] = '星期'.$week_array[$i].' '.date('m/d' ,($i-1)*24*3600 + strtotime("next Monday"));
                }
            }
        }

        echo json_encode($time_list);
        exit;
    }
}
