# seckill 秒杀系统

## 环境
* PHP原生代码编写，没有基于框架，主要让用户了解秒杀原理。
* php5.6 + phpredis扩展
* redis服务
* apache2
* mysql：table 商品表(goods) + 订单表（order）

### 实现功能：
1. 基于redis队列，防止高并发的超卖
2. 基于mysql的事务加排它锁，防止高并发的超卖

### 基于redis队列工作流程：
1. 管理员根据goods表中的库存，创建redis商品库存队列
2. 客户端访问秒杀API
3. web服务器先从redis的商品库存队列中查询剩余库存
4. redis队列中有剩余，则在mysql中创建订单，去库存，抢购成功
5. redis队列中没有剩余，则提示库存不足，抢购失败

### 基于mysql事务和排它锁工作流程：
1：开启事务
2：查询库存，并显示的设置写锁（排他锁）：SELECT * FROM goods WHERE id = 1 FOR UPDATE
3：生成订单
4：去库存，隐示的设置写锁（排他锁）：UPDATE goods SET counts = counts – 1 WHERE id = 1
5：commit，释放锁
注意：第二步不可以设置共享锁，不然有可能会造成死锁。

### 压测工具：
apache自带ab测试工具 ./ab -n1000 -c100 http://host/seckill/buy_mysql.php
apache自带ab测试工具 ./ab -n1000 -c100 http://host/seckill/buy_redis.php
apache自带ab测试工具 ./ab -n1000 -c100 http://host/seckill/buy_transaction.php
