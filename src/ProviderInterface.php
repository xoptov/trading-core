<?php

namespace Xoptov\TradingCore;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Order;
use Xoptov\TradingCore\Model\Account;
use Xoptov\TradingCore\Response\Ticker\Response as TickerResponse;
use Xoptov\TradingCore\Response\Balance\Response as BalanceResponse;
use Xoptov\TradingCore\Response\OrderBook\Response as OrderBookResponse;
use Xoptov\TradingCore\Response\Currencies\Response as CurrenciesResponse;
use Xoptov\TradingCore\Response\MarketData\Response as MarketDataResponse;
use Xoptov\TradingCore\Response\OpenOrders\Response as OpenOrdersResponse;
use Xoptov\TradingCore\Response\PlaceOrder\Response as PlaceOrderResponse;
use Xoptov\TradingCore\Response\TradeHistory\Response as TradeHistoryResponse;
use Xoptov\TradingCore\Response\CurrencyPairs\Response as CurrencyPairsResponse;

interface ProviderInterface
{
    /**
     * @return CurrenciesResponse
     */
    public function currencies();

    /**
     * @param SplDoublyLinkedList $currencies
     * @return CurrencyPairsResponse
     */
    public function currencyPairs(SplDoublyLinkedList $currencies);

    /**
     * @return MarketDataResponse
     */
    public function marketData();

    /**
     * @return TickerResponse
     */
    public function ticker();

    /**
     * @return TradeHistoryResponse
     */
    public function tradeHistory();

    /**
     * @return OrderBookResponse
     */
    public function orderBook();

    /**
     * @param Account $account
     * @return BalanceResponse
     */
    public function balance(Account $account);

    /**
     * @param Account $account
     * @return OpenOrdersResponse
     */
    public function openOrders(Account $account);

    /**
     * @param Order $order
     * @param Account $account
     * @return PlaceOrderResponse
     */
    public function placeOrder(Order $order, Account $account);

    /**
     * @param int $orderId
     * @param Account $account
     * @return bool
     */
    public function cancelOrder($orderId, Account $account);
}