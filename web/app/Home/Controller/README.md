# 控制器说明

| 控制器名称 | 备注说明 |
| --- | --- |
| Api | 目前仅支持 JSON 格式的 API 数据输出 |
| Brand | 品牌 |
| Calc | 运费计算器 (已抛弃) |
| Cart | 购物车 |
| Checkout | 收银台 |
| Corn | 定时处理，通过首页访问来激活（多线程处理，待研究） |
| Faq | 常见问题，使用帮助等信息，类似 CMS 系统 |
| Follow | 关注功能 (待定案) |
| Goods | 商品 |
| Index | 首页 |
| Log | 系统记录 |
| Payment | 支付 |
| Product | 产品 (待定案) |
| Profile | 用户资料 |
| Quote | 预算 |
| Rank | 排行榜 |
| Receipt | 订单 |
| Reference | 参考资料 (比如 汇率，地理信息 等) |
| Request | 求购 |
| Search | 搜索 |
| User | 用户社交 |
| Username | 用户名更改 |
| Vendor | 供应商页面 |

\* 产品与商品的区别，任何物品都可以作为商品，产品必须要有二维码，生产厂商等信息。

## Api

总是使用 request_method 来进行 api 的操作，如果需要上传文件则使用 
[angular-file-upload](http://stackoverflow.com/questions/20487212/angularjs-file-upload-with-php) 
插件