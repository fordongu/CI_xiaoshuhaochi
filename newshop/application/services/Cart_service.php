<?php

class Cart_service extends MY_Service {

    private $this_cart_info = [];
    private $next_cart_info = [];

    public function __construct() {
        $this->load->helper('cookie');
        $this->this_cart_info = $this->deCart(0);
        $this->next_cart_info = $this->deCart(1);
        $this->initCart();
    }

    /**
     * 初始化购物车
     *
     */
    public function initCart() {
        $type_arr = [0]; //暂时只支持普通商品
        $invalid_time = '10:00:00'; //10点后商品无效

        if (!empty($this->this_cart_info)) {
            $w = date('w');
            $h = date('H');
            if ($w > 5 || $w == 0 || ($w == 5 && $h >= 10)) {
                $this->this_cart_info = [];
            }
            foreach ($this->this_cart_info as $k => $goods) {
                $goods_key = $k;
                $temp_arr = explode('_', $goods_key);

                $goods_id = $temp_arr[0];
                $date = $temp_arr[1];
                $type = $temp_arr[2];
                $num = $goods['num'];
                $join_time = $goods['join_time'];

                if (!empty($date)) {
                    if (strtotime(date('Y-m-d')) == $date && time() >= strtotime(date("Y-m-d $invalid_time"))) {
                        $this->delCart($goods_id, $date, $type, 0);
                    }
                }
                //通过时间判断本周有该菜
                //删除不符合规范的商品数据
                if (!in_array($type, $type_arr) || $num <= 0 || (int) $goods_id <= 0) {
                    $this->delCart($goods_id, $date, $type, 0);
                }
            }
        }

        if (!empty($this->next_cart_info)) {
            foreach ($this->next_cart_info as $k => $goods) {
                $goods_key = $k;
                $temp_arr = explode('_', $goods_key);

                $goods_id = $temp_arr[0];
                $date = $temp_arr[1];
                $type = $temp_arr[2];
                $num = $goods['num'];
                $join_time = $goods['join_time'];
                //通过时间判断下周有该菜
                //删除不符合规范的商品数据
                if (!in_array($type, $type_arr) || $num <= 0 || (int) $goods_id <= 0) {
                    $this->delCart($goods_id, $date, $type, 1);
                }
            }
        }
    }

    /**
     * 获取购物车商品数量
     *
     */
    public function getCartCount() {
        $count = 0;
        if (!empty($this->this_cart_info)) {
            foreach ($this->this_cart_info as $k => $goods) {
                $count += $goods['num'];
            }
        }

        if (!empty($this->next_cart_info)) {
            foreach ($this->next_cart_info as $k => $goods) {
                $count += $goods['num'];
            }
        }

        return $count;
    }

    /**
     * 获取购物车信息
     *
     */
    public function getCartInfo() {
        $this_goods_list = [];
        $next_goods_list = [];

        if (empty($this->this_cart_info) && empty($this->next_cart_info)) {
            return [
                'total_price' => '0.00',
                'goods_count' => 0,
                'cart_goods' => [[], []]
            ];
        }

        $total_price = 0;
        $goods_count = 0;

        if (!empty($this->this_cart_info)) {
            $this_goods_list = $this->getGoodsList($this->this_cart_info);
            foreach ($this_goods_list as $k => $goods) {
                $total_price += $goods['price'] * $goods['goods_num'];
                $goods_count += $goods['goods_num'];
            }
        }

        if (!empty($this->next_cart_info)) {
            $next_goods_list = $this->getGoodsList($this->next_cart_info);
            foreach ($next_goods_list as $k => $goods) {
                $total_price += $goods['price'] * $goods['goods_num'];
                $goods_count += $goods['goods_num'];
            }
        }
       
      $this_week_promote = $this->promote_price($this_goods_list, 0);
      $next_week_promote = $this->promote_price($next_goods_list, 1);
        return [
            'promote' => $this_week_promote+$next_week_promote,
            'order_price' => $total_price,
            'total_price' => $total_price-$this_week_promote-$next_week_promote,
            'goods_count' => $goods_count,
            'cart_goods' => [$this_goods_list, $next_goods_list]
        ];
         //$price=$total_price-$this_week_promote-$next_week_promote;
     //   echo $price;exit;
    }
       
    /**
     * 获取购物车的商品信息
     *
     */
    private function getGoodsList($cart_info) {
        $goods_id_list = [];
        $date = 0;
        if (empty($cart_info)) {
            return [];
        }
        foreach ($cart_info as $k => $thing) {
            $goods_key = $k;
            $temp_arr = explode('_', $goods_key);
            $goods_id = $temp_arr[0];
            $date = $temp_arr[1];
            $goods_id_list[] = $goods_id;
        }

        if (empty($goods_id_list)) {
            return [];
        }
        //获取商品信息
        $this->load->service('goods_service');
        $temp_goods_list = $this->goods_service->getGoodsList(array('goods_id_list' => $goods_id_list));

        $temp_store_list = [];
        if ($date) {
            //获取商品库存
            $temp_store_list = $this->goods_service->getGoodsStore($goods_id_list, date('Y-m-d', $date));
        }

        $goods_list = [];

        foreach ($cart_info as $key => $val) {
            $goods_key = $key;
            $temp_arr = explode('_', $goods_key);
            $goods_id = $temp_arr[0];
            $date = $temp_arr[1];
            $type = $temp_arr[2];

            foreach ($temp_goods_list as $k => $goods) {
                if ($goods_id == $k) {
                    $goods_list[] = array(                      
                        'goods_id' => $goods_id,
                        'cate_id' => $goods->cate_id,
                        'goods_name' => $goods->name,
                        'price' => $goods->price,
                        'old_price' => $goods->old_price,
                        'goods_type' => $type,
                        'goods_num' => $val['num'],
                        'goods_key' => $goods_key,
                        'date' => $date ? date('Y-m-d', $date) : 0,
                        'store' => empty($temp_store_list) ? 0 : $temp_store_list[$k] - $val['num']
                    );
                }
            }
        }
        return $goods_list;
    }

    /**
     * 加入购物车
     *
     */
    public function addCart($goods_id, $date = 0, $num = 1, $type = 0, $week_flag = 0) {
        if ($week_flag == 0) {
            $cart_info = $this->this_cart_info;
        } elseif ($week_flag == 1) {
            $cart_info = $this->next_cart_info;
        } else {
            return FALSE;
        }
        $exist = FALSE;
        $current_time = time();

        $goods_key = $goods_id . '_' . $date . '_' . $type;

        if (!empty($cart_info)) {
            foreach ($cart_info as $k => $goods) {
                $temp_arr = explode('_', $k);
                $temp_goods_id = $temp_arr[0];
                $temp_date = $temp_arr[1];
                $temp_type = $temp_arr[2];
                $temp_key = $temp_goods_id . '_' . $date . '_' . $temp_type;
                if ($goods_key == $temp_key) {
                    $goods_num = $num + $goods['num'];
                    $cart_info[$k]['num'] = $goods_num;
                    $exist = TRUE;
                }
                if ($temp_date != 0) {
                    $date = $temp_date;
                }
            }
        }

        if (!$exist) {
            $goods_key = $goods_id . '_' . $date . '_' . $type;
            $cart_info[$goods_key] = array('num' => $num, 'join_time' => $current_time);
        }

        if ($week_flag == 0) {
            $this->this_cart_info = $cart_info;
        } elseif ($week_flag == 1) {
            $this->next_cart_info = $cart_info;
        }

        self::enCart($week_flag);
        return TRUE;
    }

    /**
     * 增加商品数量
     *
     */
    public function incrCart($goods_key, $num = 1, $week_flag = 0) {
        if ($week_flag == 0) {
            $cart_info = $this->this_cart_info;
        } elseif ($week_flag == 1) {
            $cart_info = $this->next_cart_info;
        } else {
            return FALSE;
        }

        $exist = FALSE;
        if (!empty($cart_info)) {
            foreach ($cart_info as $k => $goods) {
                if ($goods_key == $k) {
                    $goods_num = $num + $goods['num'];
                    $cart_info[$k]['num'] = $goods_num;
                    $exist = TRUE;
                }
            }
        }

        if (!$exist) {
            return 6;
        }

        if ($week_flag == 0) {
            $this->this_cart_info = $cart_info;
        } elseif ($week_flag == 1) {
            $this->next_cart_info = $cart_info;
        }
        self::enCart($week_flag);
        return TRUE;
    }

    /**
     * 减少商品数量
     *
     */
    public function decrCart($goods_key, $num = 1, $week_flag = 0) {
        if ($week_flag == 0) {
            $cart_info = $this->this_cart_info;
        } elseif ($week_flag == 1) {
            $cart_info = $this->next_cart_info;
        } else {
            return FALSE;
        }

        $exist = FALSE;

        if (!empty($cart_info)) {
            foreach ($cart_info as $k => $goods) {
                if ($goods_key == $k) {
                    $goods_num = $goods['num'] - $num;
                    if ($goods_num < 0) {
                        return FALSE;
                    }
                    $cart_info[$k]['num'] = $goods_num;
                    $exist = TRUE;
                }
            }
        }
        if (!$exist) {
            return FALSE;
        }

        if ($week_flag == 0) {
            $this->this_cart_info = $cart_info;
        } elseif ($week_flag == 1) {
            $this->next_cart_info = $cart_info;
        }
        self::enCart($week_flag);
        return TRUE;
    }

    /**
     * 删除购物车的商品
     *
     */
    public function delCart($goods_id, $date = 0, $type = 0, $week_flag = 0) {
        if ($week_flag == 0) {
            $cart_info = $this->this_cart_info;
        } elseif ($week_flag == 1) {
            $cart_info = $this->next_cart_info;
        } else {
            return FALSE;
        }


        $exist = FALSE;
        if (!empty($cart_info)) {
            foreach ($cart_info as $k => $goods) {
                $goods_key = $goods_id . '_' . $date . '_' . $type;
                if ($goods_key == $k) {
                    unset($cart_info[$k]);
                    $exist = TRUE;
                }
            }
        }

        if ($exist) {
            if ($week_flag == 0) {
                $this->this_cart_info = $cart_info;
            } elseif ($week_flag == 1) {
                $this->next_cart_info = $cart_info;
            }
            self::enCart($week_flag);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 更新购物车商品的时间
     *
     */
    public function updateCartDate($date, $week_flag = 0) {
        if ($week_flag == 0) {
            $cart_info = $this->this_cart_info;
        } elseif ($week_flag == 1) {
            $cart_info = $this->next_cart_info;
        } else {
            return FALSE;
        }

        if (empty($cart_info)) {
            return FALSE;
        }
        $time = time();
        //$update_time = strtotime($date);
        //判断更新时间是本周/下周
        $week = date('w', $time);
        //周一到周五供应
        $service_week_arr = [1, 2, 3, 4, 5];

        if (!in_array($week, $service_week_arr)) {
            return FALSE;
        }

        if ($week == 1) {
            $cflag = '+0';
            $lflag = '-1';
        } else {
            $cflag = '-1';
            $lflag = '-2';
        }
        //本周一零点的时间戳
        $curr_start_week = strtotime(date('Y-m-d', strtotime("$cflag week Monday", $time)));
        //本周末零点的时间戳
        $curr_end_week = $curr_start_week + 6 * 24 * 3600;
        //下周末零点的时间戳
        $next_end_week = $curr_end_week + 7 * 24 * 3600;

        if ($week_flag == 0) {
            if ($date < $curr_start_week || $date >= $curr_end_week) {
                //$this->clearCart(0);
                return FALSE;
            }
            //今天的时间大于10点，也不能更新
            if ($date == strtotime(date('Y-m-d')) && $time > $date + 36000) {
                return FALSE;
                ;
            }
        } elseif ($week_flag == 1) {
            if ($date <= $curr_end_week || $date >= $next_end_week) {
                //$this->clearCart(1);
                return FALSE;
                ;
            }
        }

        foreach ($cart_info as $k => $goods) {
            $goods_key = $k;
            $temp_arr = explode('_', $goods_key);
            $goods_id = $temp_arr[0];
            $type = $temp_arr[2];
            /* if ($flag == $week_flag) {
              $new_key = $goods_id.'_'.$date.'_'.$type.'_'.$week_flag;
              unset($cart_info[$k]);
              $cart_info[$new_key] = $goods;
              } */
            $new_key = $goods_id . '_' . $date . '_' . $type;
            unset($cart_info[$k]);
            $cart_info[$new_key] = $goods;
        }

        if ($week_flag == 0) {
            $this->this_cart_info = $cart_info;
        } elseif ($week_flag == 1) {
            $this->next_cart_info = $cart_info;
        }
        self::enCart($week_flag);
        return TRUE;
    }

    /**
     * 清空购物车
     *
     */
    public function clearCart($week_flag = 'all') {
        if ($week_flag === 0) {
            delete_cookie("this_week_cart");
        } elseif ($week_flag == 1) {
            delete_cookie("next_week_cart");
        } else {
            delete_cookie("this_week_cart");
            delete_cookie("next_week_cart");
        }
        return TRUE;
    }

    /**
     * 反序列化购物车数据
     *
     */
    private function deCart($week_flag = 0) {
        $cart = '{}';
        if ($week_flag == 0) {
            $cart = get_cookie('this_week_cart');
        } elseif ($week_flag == 1) {
            $cart = get_cookie('next_week_cart');
        }
        $cart_info = json_decode($cart, TRUE);
        return $cart_info;
    }

    /**
     * 序列化购物车数据
     *
     */
    private function enCart($week_flag = 0) {
        //$cart = json_encode($cart_info);
        if ($week_flag == 0) {
            $cart = json_encode($this->this_cart_info);
            set_cookie("this_week_cart", $cart, 24 * 3600);
        } elseif ($week_flag == 1) {
            $cart = json_encode($this->next_cart_info);
            set_cookie("next_week_cart", $cart, 24 * 3600);
        }
    }

    function promote_price($cart_goods="", $k) {
        //算法的精髓是饮料与饭分开，由于后来加入了冬瓜茶 单独的做了冬瓜茶的算法，计算出每天可优惠的商品1,2,3,4，5
        //饮料套餐的算法
        header("Content-type: text/html; charset=utf-8");
        //$goods = $this->_get_cookie_good_detail('wechat', array());
        //$cart_goods = $goods['cart_goods'];
        $promote_tea = 0;
        $promote = 0;
        $product = 0;
        $tea = 0;
        foreach ($cart_goods as $key => $val) {
           
            if ($val["goods_id"] == 46) {
                $promote_tea = $promote_tea + $val["goods_num"];
                continue;
            }
                     
            if ($val["cate_id"] == 19) {
               
                $promote = $promote + $val["goods_num"];
                
            } else {
                $product = $product + $val["goods_num"];
            }               
        }
        
        //当前周
        if ($product >= $promote) {
            $count = $promote;
        } else {
            $count = $product;
        }
           
        $left = $product - $promote;
        if ($left > 0 && ($left >= $promote_tea)) {
            $tea = $promote_tea;
        } else if ($left > 0 && ($left < $promote_tea)) {
            $tea = $left;
        }
        //
        $total_count = $count;
     
        $price = $total_count * 6 + $tea * 3;
        return $price;
    }
    
}
