<?php
/**
 * OKEX V3 PHP REST 合约API
 *
 * @version 0.1
 * @api  https://www.okex.com/docs/zh/#futures-README
 * @authour luochao@iponycar.com
 */


namespace okv3;

class SwapApi extends Utils {

    # future api
    const SWAP_POSITION = '/api/swap/v3/position';
    const SWAP_SPECIFIC_POSITION = '/api/swap/v3/';
    const SWAP_ACCOUNTS = '/api/swap/v3/accounts';
    const SWAP_COIN_ACCOUNT = '/api/swap/v3/accounts/';
    const SWAP_GET_LEVERAGE = '/api/swap/v3/';
    const SWAP_SET_LEVERAGE = '/api/swap/v3/accounts/';
    const SWAP_LEDGER = '/api/swap/v3/accounts/';
    const SWAP_DELETE_POSITION = '/api/swap/v3/cloFse_all_orders';
    const SWAP_ORDER = '/api/swap/v3/order';
    const SWAP_ORDERS = '/api/swap/v3/orders';
    const SWAP_REVOKE_ORDER = '/api/swap/v3/cancel_order/';
    const SWAP_REVOKE_ORDERS = '/api/swap/v3/cancel_batch_orders/';
    const SWAP_ORDERS_LIST = '/api/margin/v3/orders';
    const SWAP_ORDER_INFO = '/api/swap/v3/orders/';
    const SWAP_FILLS = '/api/swap/v3/fills';
    const SWAP_PRODUCTS_INFO = '/api/swap/v3/instruments';
    const SWAP_DEPTH = '/api/swap/v3/instruments/';
    const SWAP_TICKER = '/api/swap/v3/instruments/ticker';
    const SWAP_SPECIFIC_TICKER = '/api/swap/v3/instruments/';
    const SWAP_TRADES = '/api/swap/v3/instruments/';
    const SWAP_KLINE = '/api/swap/v3/instruments/';
    const SWAP_INDEX = '/api/swap/v3/instruments/';
    const SWAP_RATE = '/api/swap/v3/rate';
    const SWAP_ESTIMAT_PRICE = '/api/swap/v3/instruments/';
    const SWAP_HOLDS = '/api/swap/v3/instruments/';
    const SWAP_LIMIT = '/api/swap/v3/instruments/';
    const SWAP_LIQUIDATION = '/api/swap/v3/instruments/';
    const SWAP_MARK = '/api/swap/v3/instruments/';
    const HOLD_AMOUNT = '/api/swap/v3/accounts/';
    const CURRENCY_LIST = '/api/swap/v3/instruments/currencies/';


    // 获取合约账户所有的持仓信息
    public function getPosition()
    {
        return $this->request(self::SWAP_POSITION, [], 'GET');
    }

    // 单个合约持仓信息
    public function getSpecificPosition($instrument_id)
    {
        return $this->request(self::SWAP_SPECIFIC_POSITION.$instrument_id.'/position', [], 'GET');
    }

    // 获取所有币种的合约账户信息
    public function getAccounts()
    {
        return $this->request(self::SWAP_ACCOUNTS, [], 'GET');
    }

    // 单个币种合约账户信息
    public function getCoinAccounts($instrument_id)
    {
//        return $this->request(self::SWAP_COIN_ACCOUNT.$symbol, [], 'GET');

        return $this->request(self::SWAP_GET_LEVERAGE.$instrument_id.'/accounts', [], 'GET');


    }

    // 获取合约账户币种杠杆倍数
    public function getLeverage($symbol)
    {
        return $this->request(self::SWAP_GET_LEVERAGE.$symbol.'/leverage', [], 'GET');
    }

    // 设定合约币种杠杆倍数
    public function setLeverage($symbol, $instrument_id='', $direction='', $leverage=10)
    {
        $params = [
            'instrument_id' =>  $instrument_id,
            'direction' => $direction,
            'leverage' => $leverage
        ];

        if ($symbol)
            return $this->request(self::SWAP_SET_LEVERAGE.$symbol.'/leverage', $params, 'POST');
        else
            return $this->request(self::SWAP_SET_LEVERAGE.'leverage', $params, 'POST');
    }

    // 账单流水查询 默认第一页 100条
    public function getLedger($symbol)
    {
        return $this->request(self::SWAP_LEDGER.$symbol.'/ledger', [], 'GET');
    }

    // 下单
    public function takeOrder($client_oid, $instrument_id, $otype, $price, $size, $match_price, $leverage, $order_type)
    {
        $params = [
            'client_oid' => $client_oid,
            'instrument_id'=> $instrument_id,
            'type' => $otype,
            'price' => $price,
            'size' => $size,
            'match_price' => $match_price,
            'leverage' => $leverage,
            'order_type' => $order_type
        ];

        return $this->request(self::SWAP_ORDER, $params, 'POST');
    }

    // 批量下单
    public function takeOrders($instrument_id, $orders_data, $leverage)
    {
        $params = [
            'instrument_id' => $instrument_id,
            'orders_data' => $orders_data,
            'leverage' => $leverage
        ];

        return $this->request(self::SWAP_ORDERS, $params, 'POST');
    }

    // 撤销指定订单
    public function revokeOrder($instrument_id, $order_id)
    {
        return $this->request(self::SWAP_REVOKE_ORDER.$instrument_id.'/'.$order_id, [], 'POST');
    }

    // 批量撤销订单
    public function revokeOrders($instrument_id, $order_ids)
    {
        $params = ['order_ids' => $order_ids];

        return $this->request(self::SWAP_REVOKE_ORDERS.$instrument_id, $params, 'POST');
    }

    // 获取订单列表
    public function getOrderList($status, $froms, $to, $limit, $instrument_id='')
    {
        $params = ['status' => $status, 'instrument_id' => $instrument_id];

        if ($froms) $params['from'] = $froms;
        if ($to) $params['to'] = $to;
        if ($limit) $params['limit'] = $limit;
        if ($instrument_id) $params['instrument_id'] = $instrument_id;

        return $this->request(self::SWAP_ORDERS_LIST, $params, 'GET');
    }

    // 获取订单信息
    public function getOrderInfo($order_id, $instrument_id)
    {
        return $this->request(self::SWAP_ORDER_INFO.$instrument_id.'/'.$order_id, [], 'GET');
    }

    // 获取成交明细
    public function getFills($order_id, $instrument_id, $froms, $to, $limit)
    {
        $params = [
            'order_id' => $order_id,
            'from' => $froms,
            'to' => $to,
            'limit' => $limit,
            'instrument_id' => $instrument_id
        ];

        return $this->request(self::SWAP_FILLS, $params, 'GET');
    }

    // 获取合约信息
    public function getProducts()
    {
        return $this->request(self::SWAP_PRODUCTS_INFO, [], 'GET');
    }

    // 获取深度
    public function getDepth($instrument_id, $size)
    {
        $params = ['size' => $size];

        return $this->request(self::SWAP_DEPTH.$instrument_id.'/book', $params, 'GET');
    }

    // 获取全部ticker信息
    public function getTicker()
    {
        return $this->request(self::SWAP_TICKER, [], 'GET');
    }

    // 获取某个ticker信息
    public function getSpecificTicker($instrument_id)
    {
        return $this->request(self::SWAP_SPECIFIC_TICKER.$instrument_id.'/ticker', [], 'GET');
    }

    // 获取成交数据
    public function getTrades($instrument_id, $froms=0, $to=0, $limit=0)
    {
        $params = ['instrument_id' => $instrument_id];
        if ($froms) $params['from'] = $froms;
        if ($to) $params['to'] = $to;
        if ($limit) $params['limit'] = $limit;

        return $this->request(self::SWAP_TRADES.$instrument_id.'/trades', $params, 'GET', True);
    }

    // 获取K线数据
    public function getKline($instrument_id, $granularity, $start='', $end='')
    {
        $params = [
            'granularity' => $granularity,
            'start' => $start,
            'end' => $end
        ];

        return $this->request(self::SWAP_KLINE.$instrument_id.'/candles', $params, 'GET');
    }

    // 获取指数信息
    public function getIndex($instrument_id)
    {
        return $this->request(self::SWAP_INDEX.$instrument_id.'/index', [], 'GET');
    }

    // 获取法币汇率
    public function getRate()
    {
        return $this->request(self::SWAP_RATE, [], 'GET');
    }

    // 获取预估交割价
    public function getEstimatedPrice($instrument_id)
    {
        return $this->request(self::SWAP_ESTIMAT_PRICE.$instrument_id.'/estimated_price', [], 'GET');
    }

    // 获取平台总持仓量
    public function getHolds($instrument_id)
    {
        return $this->request(self::SWAP_HOLDS.$instrument_id.'/open_interest', [], 'GET');
    }

    // 获取当前限价
    public function getLimit($instrument_id)
    {
        return $this->request(self::SWAP_LIMIT.$instrument_id.'/price_limit', [], 'GET');
    }

    // 获取爆仓单
    public function getLiquidation($instrument_id, $status, $froms = 0, $to = 0, $limit = 0)
    {
        $params = ['instrument_id' => $instrument_id, 'status' => $status];

        if ($froms) $params['from'] = $froms;
        if ($to) $params['to'] = $to;
        if ($limit) $params['limit'] = $limit;

        return $this->request(self::SWAP_LIQUIDATION.$instrument_id.'/liquidation', $params, 'GET');
    }

    // 获取合约挂单冻结数量
    public function getHoldsAmount($instrument_id)
    {
        return $this->request(self::HOLD_AMOUNT.$instrument_id.'/holds', [], 'GET');
    }

}
