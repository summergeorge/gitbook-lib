<style>
    body,ul,li,h1,h2,h3,h4,h5{margin:0;padding:0;list-style:none;}
    .header { height:75px;background-color:white;position: relative;border-bottom: 1px solid #eeeeee;z-index:99;}
    .header a {text-decoration: none;font-style: none;color: #333333;}
    .header a:hover {color: #375feb;}
    .header img {transition: all 0.3s ease;}
    .header a:hover img {transform: scale(1.1);}
    .open a{background: url(http://www.ec-os.cn/bundles/shopexwebonex/images/nav/ky_icon.png) no-repeat 0 -3px;padding-left: 40px;}
    .header .logo { float: left; display: block;width:260px;margin-left: 20px;margin-top: 25px;}
    .header .nav-menu { float: right;margin-right:150px;}
    .header .menu>li {float: left ;margin:0 25px;height: 75px;line-height: 75px;}
    .intro > a:after{content:'';background: url(http://www.ec-os.cn/bundles/shopexwebonex/images/nav/dot.png) no-repeat right center;transform: rotate(180deg);transition: all 0.3s ease;display: inline-block;width: 11px;height:11px;margin-left: 15px;}
    .intro > a:hover:after{transform: rotate(0deg);}
    .inner-wrap {width: 1230px;margin:0 auto;}
    .drop-sub {position: absolute;left:0;top:75px;right:0;overflow: hidden;box-shadow: 0 5px 10px #eeeeee;transition: all 0.3s ease;height:0;}
    .intro:hover .drop-sub {display: block;height: 300px;}
    .drop-sub .sub-cat {padding: 15px;}
    .drop-sub .sub-section { float: left;width: 24.8%;height:210px;border-right: 1px solid #eeeeee;padding: 20px 0;}
    .drop-sub .sub-section:last-child{border:none;}
    .drop-sub .sub-section h3 {height: 30px;line-height: 30px;text-align:center;font-size: 16px;}
    .drop-sub .sub-section li {line-height: 25px;padding: 5px 0;}
    .drop-sub .sub-section img {vertical-align: middle;margin-right: 10px;}
    .drop-sub .sub-section span {font-size: 12px;color:#999999;}
</style>
<div class="header">
    <a href="{{ $base_url or "#" }}" class="logo"><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/logo.png" alt=""></a>
    <div class="nav-menu">
        <ul class="menu">
            <li><a href="{{ $base_url or "#" }}">首页</a></li>
            <!--<li class="intro">-->
                <!--<a href="javascipt:;">产品介绍</a>-->
                <!--<div class="drop-sub" >-->
                    <!--<div class="inner-wrap">-->
                        <!--<div class="sub-section">-->
                            <!--<h3>高阶交易云</h3>-->
                            <!--<ul class="sub-cat">-->
                                <!--<li><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/b2c1.png" alt=""></i><a href="http://www.ec-os.cn/products/b2c" target="_blank">ECstore B2C <span>社区版</span></a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/b2c2.png" alt=""></i><a href="http://www.ec-os.cn/products/b2c" target="_blank">ECstore B2C <span>(PC+H5)</span></a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/bbc.png" alt=""></i><a href="http://www.ec-os.cn/products/b2b2c" target="_blank">ECstore B2B2C <span>(PC+APP+H5+小程序)</span></a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/b2b.png" alt=""></i><a href="http://www.ec-os.cn/products/b2b" target="_blank">ECstore B2B <span>(PC+H5)</span></a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/wsc.png" alt=""></i><a href="http://www.ec-os.cn/products/wsc" target="_blank">ECstore B2C <span>微商城增强版 (PC+H5)</span></a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--<div class="sub-section">-->
                            <!--<h3>入门交易云</h3>-->
                            <!--<ul class="sub-cat">-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/ecshop.png" alt=""></i><a href="http://www.ec-os.cn/products/ecshop" target="_blank">ECshop <span>(PC+APP+H5+小程序)</span></a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/ecmall.png" alt=""></i><a href="http://www.ec-os.cn/products/ecmall" target="_blank">ECmall <span>(PC+APP+H5)</span></a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--<div class="sub-section">-->
                            <!--<h3>社交零售</h3>-->
                            <!--<ul class="sub-cat">-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/s2b2c.png" alt=""></i><a href="http://www.ec-os.cn/products/s2b2c" target="_blank">ECstore S2B2C <span>(PC+APP+H5+小程序)</span></a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--<div class="sub-section">-->
                            <!--<h3>中台管理</h3>-->
                            <!--<ul class="sub-cat">-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/oms.png" alt=""></i><a href="http://www.ec-os.cn/products/oms" target="_blank">OMS</a></li>-->
                                <!--<li><i><img src="http://www.ec-os.cn/bundles/shopexwebonex/images/nav/erp.png" alt=""></i><a href="http://www.ec-os.cn/products/erp" target="_blank">ERP</a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</li>-->
            <li class="open"><a href="http://doc.ec-os.net/doc/" target="_blank">开源文档</a></li>
            <li><a href="http://www.ec-os.cn/help" target="_blank">帮助文档</a></li>
            <li><a href="http://www.ec-os.cn/empower" target="_blank">产品授权中心</a></li>
            <li><a href="http://fuwu.shopex.cn/" target="_blank">服务市场</a></li>
            <li class="open"><a href="http://bbs.ecshop.com/" target="_blank">开源社区</a></li>
        </ul>
    </div>
</div>

