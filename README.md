# 开源范米粒

开源范米粒是基于 ThinkPHP 框架制作的电商项目，主要面向中小型电商商户。

## 版本

Single, 该版本采用单模块方式来开发，适合小型电商的搭建。

## 技术说明

- ThinkPHP 3.2  
- heroku  

\* 本项目支持 heroku 部署

## 开发进度表
| 模块           | 组件与功能 | 目前进度 |
| ---            | --- | --- |
| 首页           | 产品列表、分类列表、品牌列表、搜索条 | 数据绑定 |
| 搜索结果       | 与首页类似的页面（备注搜索结果信息） | 数据绑定 |
| 产品详情       | 产品图片、产品名称、产品来源、产品自定义属性、产品详细描述 | 线框制作 |
| 购物车         | 产品图片、产品名称、产品数量、产品价格、单笔价格、全部价格 | 线框制作 |
| 选择买手       | 买手 | 线框制作 |
| 收件地址       | 收件人、收件人地址、收件人身份证、身份证图片、收件人  | 线框制作 |
| 运送方案       | 方案名称、方案详情（预计时间）、运费价格 | 线框制作 |
| 生成订单       | 订单号、订单日期、订单状态、订单详情(见草稿版本） | 线框制作 |
| 订单跟踪       | 订单号、物流运送单号 | 线框制作 |
| 收件反馈       | 收件 | 线框制作 |
| 基本资料       | 账户、密码、邮箱 | 线框制作 |
| 财务管理       | 充值余额 | 线框制作 |
| 订单记录       | 订单号、订单记录、订单状态 | 线框制作 |
| 地址簿         | 收件人、收件人地址、地址邮编、收件人电话 | 线框制作 |
| 买手页面       | 选择产品、佣金、增值服务、押金（押金量代表等级） | 未开始 |
| 代购管理       | 订单号、物流编号 | 未开始 |
| 资质管理       | 保障金、商户级别 | 未开始 |
| 产品管理       | 产品上架功能（必须通过审核才能上架） | 未开始 |
| 总管理后台首页 | 添加产品、添加分类、用户列表、订单列表 | 未开始 |
| 产品管理       | 产品图片、产品名称、产品来源、产品自定义属性、产品详细描述 | 未开始 |
| 标签管理       | 产品标签 | 未开始 |
| 订单管理       | 添加运单号、修改价格 | 未开始 |
| 用户管理       | 账户、密码、邮箱 | 未开始 |
| 消费税管理     | 采购城市、消费税 | 未开始 |
| 运送关税管理   | 产品标签、运送公司、关税 | 未开始 |
| 物流公司管理   | 物流公司名称、收费描述、收费规则、物流政策 | 未开始 |

\* 开发流程步骤

1. 设计  
只要在进度表中的，就表示已经是加入到设计中的功能，有任何新的想法，或者功能请求，可以在[讨论组](https://github.com/dotku/openfml/issues)中提出。
1. 线框制作  
各个功能的布局设计
1. 功能开发  
1. 数据绑定  
1. 测试
1. 发布  
目前只有 master 分支，直到 1.0 版本发布后，将以 dev 和 master 分离方式来开发。

\* 参与方式  

请通过 Pork 方式来复制本项目到自己的仓库，进过你的测试开发之后，无误情况下，再通过 Pull Request 方式来提交你的更新。

## 协议
MIT 开源，免费，署名