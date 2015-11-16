<?php
/**
 * Created by PhpStorm.
 * User: inszva
 * Date: 15-11-3
 * Time: 下午8:17
 */
/*
1	待支付
2	已支付
3	技师出发
4	正在服务
5	服务完成
6	已评价
7	订单取消
8	订单过期

状态码	定义
9	已退款
10	退款中
11	退款失败
12	待服务方确认
13	服务方已确认
14	服务方已拒绝
15	订单失败,退款中(点评内部状态)
16	支付失败,退款中(点评内部状态)
 */
const WAIT_FOR_PAY = 1,
      PAYED = 2,
      TECHNICIAN_SET_OUR = 3,
      IN_SERVICE = 4,
      SERVICE_FINISHED = 5,
      COMMENTED = 6,
      CANCEL = 7,
      OUT_OF_DATE = 8,
      REFUNDED = 9,
      REFUNDING = 10,
      REFUND_FAILED = 11,
      WAIT_SERVER_CONFIRM = 12,
      SERVER_CONFIRMED = 13,
      SERVER_REFUSED = 14;
/*
返回结果状态码定义:
code	定义
0	成功
1	未知原因失败
10001	签名验证失败
10002	第三方内部错误
10003	参数不合法
10004	订单id不存在

20001	不在服务范围内
20002	库存不足
20003	无技师列表
20004	技师已被占用
20005	当前服务不支持该车型
 */

const SUCCESS = 0,
      FAILED = 1,
      SIGN_FAILED = 10001,
      INNER_ERROR = 10002,
      PARAM_ILLEGAL = 10003,
      ORDER_ID_NOT_FOUND = 10004,
      NOT_IN_SERVICE_ARRANGE = 20001,
      LOW_STOCKS = 20002,
      NO_TECHNICIAN_LIST = 20003,
      TECHNICIAN_NOT_AVAILABLE = 20004;