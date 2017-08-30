<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
$this->title = '后台管理';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>后台管理</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<?= Html::cssFile("css/bootstrap.min.css")?>
	<?= Html::cssFile("css/bootstrap-responsive.min.css")?>
	<?= Html::cssFile("css/matrix-style.css")?>
	<?= Html::cssFile("css/matrix-media.css")?>
	<?= Html::cssFile("font-awesome/css/font-awesome.css")?>
</head>
<body>
    <!--Header-part-->
    <div id="header">
      <h1><a href="<?= Url::to(['site/index2']);?>">宅食后台</a></h1>
    </div>
    <!--close-Header-part-->

    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li  class="dropdown" id="profile-messages" >
                <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                    <i class="icon icon-user"></i>&nbsp;
                    <span class="text">欢迎你,<?= Yii::$app->user->identity->username ?></span>&nbsp;
                    <b class="caret"></b>
                </a>
            </li>
            <li class=""><a  href="<?= Url::toRoute('public/logout');?>"><i class="icon icon-share-alt"></i> <span class="text">&nbsp;退出系统</span></a></li>
        </ul>
    </div>
    <!--close-top-Header-menu-->

    <!--sidebar-menu-->
    <div id="sidebar" style="OVERFLOW-Y: auto; OVERFLOW-X:hidden;">
        <ul>
        	<li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['ADMIN']['INDEX']) || isset($access['ADMIN']['ROLE']) || isset($access['ADMIN']['AUTH']) || isset($access['ADMIN']['TEMPORARYAUTH'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>用户模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>用户模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <!-- <li><a class="menu_a" link="<?= Url::to(['admin/index']);?>"><i class="icon icon-caret-right"></i>管理员管理</a></li> -->
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['ADMIN']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['admin/index'])."><i class='icon icon-caret-right'></i>管理员管理</a></li>";
                            if(isset($access['ADMIN']['ROLE'])) echo "<li><a class='menu_a' link=". Url::to(['admin/role'])."><i class='icon icon-caret-right'></i>角色管理</a></li>";
                            if(isset($access['ADMIN']['AUTH'])) echo "<li><a class='menu_a' link=". Url::to(['admin/auth'])."><i class='icon icon-caret-right'></i>权限管理</a></li>";
                            if(isset($access['ADMIN']['TEMPORARYAUTH'])) echo "<li><a class='menu_a' link=". Url::to(['admin/temporaryauth'])."><i class='icon icon-caret-right'></i>临时授权</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['admin/index'])."><i class='icon icon-caret-right'></i>管理员管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['admin/role'])."><i class='icon icon-caret-right'></i>角色管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['admin/auth'])."><i class='icon icon-caret-right'></i>权限管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['admin/temporaryauth'])."><i class='icon icon-caret-right'></i>临时授权</a></li>";
                        }
                    ?>
              </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['USER']['MEMBERLIST']) || isset($access['USER']['MEMBERRANK']) || isset($access['USER']['COMPANY'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>会员模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>会员模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['USER']['MEMBERLIST'])) echo "<li><a class='menu_a' link=". Url::to(['user/memberlist'])."><i class='icon icon-caret-right'></i>会员列表</a></li>";
                            if(isset($access['USER']['MEMBERRANK'])) echo "<li><a class='menu_a' link=". Url::to(['user/memberrank'])."><i class='icon icon-caret-right'></i>会员等级</a></li>";
                            if(isset($access['USER']['COMPANY'])) echo "<li><a class='menu_a' link=". Url::to(['user/company'])."><i class='icon icon-caret-right'></i>合作伙伴</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['user/memberlist'])."><i class='icon icon-caret-right'></i>会员列表</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['user/memberrank'])."><i class='icon icon-caret-right'></i>会员等级</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['user/company'])."><i class='icon icon-caret-right'></i>合作伙伴</a></li>";
                        }
                    ?>
                </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['SHOP']['LIST']) || isset($access['SHOP']['MYSHOP']) || isset($access['SHOP']['DANGKOU']) || isset($access['SHOP']['TUANCAN'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>门店模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>门店模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['SHOP']['LIST'])) echo "<li><a class='menu_a' link=". Url::to(['shop/list'])."><i class='icon icon-caret-right'></i>门店列表</a></li>";
                            if(isset($access['SHOP']['MYSHOP'])) echo "<li><a class='menu_a' link=". Url::to(['shop/myshop'])."><i class='icon icon-caret-right'></i>我的门店</a></li>";
                             if(isset($access['SHOP']['DANGKOU'])) echo "<li><a class='menu_a' link=". Url::to(['shop/dangkou'])."><i class='icon icon-caret-right'></i>档口管理</a></li>";
                             if(isset($access['SHOP']['TUANCAN'])) echo "<li><a class='menu_a' link=". Url::to(['shop/tuancan'])."><i class='icon icon-caret-right'></i>团餐管理</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['shop/list'])."><i class='icon icon-caret-right'></i>门店列表</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['shop/myshop'])."><i class='icon icon-caret-right'></i>我的门店</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['shop/dangkou'])."><i class='icon icon-caret-right'></i>档口管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['shop/tuancan'])."><i class='icon icon-caret-right'></i>团餐管理</a></li>";
                            
                        }
                    ?>
                </ul>
            </li>
			
             <!--档口 start -->
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['DANGKOU']['INDEX'])||isset($access['DANGKOU']['FIXSTATUS'])||isset($access['DANGKOU']['OVERMENU'])||isset($access['DANGKOU']['SHOPDANGKOU'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>档口模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>档口模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['DANGKOU']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['dangkou/index'])."><i class='icon icon-caret-right'></i>我的订单</a></li>";
                              if(isset($access['DANGKOU']['SHOPDANGKOU'])) echo "<li><a class='menu_a' link=". Url::to(['dangkou/shopdangkou'])."><i class='icon icon-caret-right'></i>门店档口管理</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['dangkou/index'])."><i class='icon icon-caret-right'></i>我的订单</a></li>";
                             echo "<li><a class='menu_a' link=". Url::to(['dangkou/shopdangkou'])."><i class='icon icon-caret-right'></i>门店档口管理</a></li>";
                        }
                    ?>
                </ul>
            </li>
            
            <!--档口 end -->

			<!--配送员 start -->
			<li class="submenu">
                                <?php
                                    //判断权限,左侧菜单
                                    if (@$access = Yii::$app->params['access']) {
                                        if(isset($access['DISTRIBUTION']['INDEX']) || isset($access['DISTRIBUTION']['ME']) || isset($access['DISTRIBUTION']['ALL-ORDER']) || isset($access['DISTRIBUTION']['SHOP'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>配送员模块</span></a>';
                                ?>
                                <?php 
                                    } else {
                                ?>
                                    <a href="#">
                                        <i class="icon icon-info-sign"></i>
                                       <span>配送员模块</span>
                                    </a>
                                <?php
                                    }
                                ?>
                            
				 <ul>
                                    <?php
                                    //判断权限,左侧菜单
                                    if (@$access = Yii::$app->params['access']) {
                                        if(isset($access['DISTRIBUTION']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['distribution/index'])."><i class='icon icon-caret-right'></i>立即抢单</a></li>";
                                        
                                        if(isset($access['DISTRIBUTION']['ALL-ORDER'])) echo "<li><a class='menu_a' link=". Url::to(['distribution/all-order'])."><i class='icon icon-caret-right'></i>配送员配送情况</a></li>";
										if(isset($access['DISTRIBUTION']['SHOP'])) echo "<li><a class='menu_a' link=". Url::to(['distribution/shop'])."><i class='icon icon-caret-right'></i>门店配送员</a></li>";
                                    } else {
                                        echo "<li><a class='menu_a' link=". Url::to(['distribution/index'])."><i class='icon icon-caret-right'></i>立即抢单</a></li>";
                                       
                                        echo "<li><a class='menu_a' link=". Url::to(['distribution/all-order'])."><i class='icon icon-caret-right'></i>配送员配送情况</a></li>";
									    echo "<li><a class='menu_a' link=". Url::to(['distribution/shop'])."><i class='icon icon-caret-right'></i>门店配送员</a></li>";
                                    }
                                     ?>
				 </ul>
			</li>
			<!--配送员 end -->
            <!--服务员-->
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['WAITER']['INDEX'])||isset($access['WAITER']['MYWAITER'])||isset($access['WAITER']['WAITERORDER'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>服务员模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>服务员模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['WAITER']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['waiter/index'])."><i class='icon icon-caret-right'></i>门店服务员</a></li>";
                        
                        if(isset($access['WAITER']['WAITERORDER'])) echo "<li><a class='menu_a' link=". Url::to(['waiter/waiterorder'])."><i class='icon icon-caret-right'></i>服务员订单</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['waiter/index'])."><i class='icon icon-caret-right'></i>门店服务员</a></li>";
                           
                            echo "<li><a class='menu_a' link=". Url::to(['waiter/waiterorder'])."><i class='icon icon-caret-right'></i>服务员订单   </a></li>";
                        }
                    ?>
                </ul>
            </li>




            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['MENU']['LIST']) || isset($access['MENU']['SHOP-LIST'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>菜单模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>菜单模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['MENU']['LIST'])) echo "<li><a class='menu_a' link=". Url::to(['menu/list'])."><i class='icon icon-caret-right'></i>菜品列表</a></li>";
                            if(isset($access['MENU']['SHOP-LIST'])) echo "<li><a class='menu_a' link=". Url::to(['menu/shop-list'])."><i class='icon icon-caret-right'></i>我的商店</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['menu/list'])."><i class='icon icon-caret-right'></i>菜品列表</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['menu/shop-list'])."><i class='icon icon-caret-right'></i>我的商店</a></li>";
                        }
                    ?>
                </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['SERIES']['LIST'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>名厨模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>名厨模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['SERIES']['LIST'])) echo "<li><a class='menu_a' link=". Url::to(['series/list'])."><i class='icon icon-caret-right'></i>名厨列表</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['series/list'])."><i class='icon icon-caret-right'></i>名厨列表</a></li>";
                        }
                    ?>
                </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['ORDER']['INDEX']) || isset($access['ORDER']['SHOPORDER'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>订单模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>订单模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['ORDER']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['order/index'])."><i class='icon icon-caret-right'></i>订单列表</a></li>";
                            if(isset($access['ORDER']['SHOPORDER'])) echo "<li><a class='menu_a' link=". Url::to(['order/shoporder'])."><i class='icon icon-caret-right'></i>门店订单</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['order/index'])."><i class='icon icon-caret-right'></i>订单列表</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['order/shoporder'])."><i class='icon icon-caret-right'></i>门店订单</a></li>";
                        }

                    ?>
					
                </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['MARKET']['WALLET']) || isset($access['MARKET']['DISCOUNT']) || isset($access['MARKET']['SUBTRACT']) || isset($access['MARKET']['ADD']) || isset($access['MARKET']['COUPON']) || isset($access['MARKET']['GIFT'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>营销模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>营销模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['MARKET']['WALLET'])) echo "<li><a class='menu_a' link=". Url::to(['market/wallet'])."><i class='icon icon-caret-right'></i>红包管理</a></li>";
                            if(isset($access['MARKET']['DISCOUNT'])) echo "<li><a class='menu_a' link=". Url::to(['market/discount'])."><i class='icon icon-caret-right'></i>折扣管理</a></li>";
                            if(isset($access['MARKET']['SUBTRACT'])) echo "<li><a class='menu_a' link=". Url::to(['market/subtract'])."><i class='icon icon-caret-right'></i>满减管理</a></li>";
                            if(isset($access['MARKET']['ADD'])) echo "<li><a class='menu_a' link=". Url::to(['market/add'])."><i class='icon icon-caret-right'></i>满赠管理</a></li>";
                            if(isset($access['MARKET']['COUPON'])) echo "<li><a class='menu_a' link=". Url::to(['market/coupon'])."><i class='icon icon-caret-right'></i>优惠券管理</a></li>";
                            if(isset($access['MARKET']['GIFT'])) echo "<li><a class='menu_a' link=". Url::to(['market/gift'])."><i class='icon icon-caret-right'></i>赠品管理</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['market/wallet'])."><i class='icon icon-caret-right'></i>红包管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['market/discount'])."><i class='icon icon-caret-right'></i>折扣管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['market/subtract'])."><i class='icon icon-caret-right'></i>满减管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['market/add'])."><i class='icon icon-caret-right'></i>满赠管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['market/coupon'])."><i class='icon icon-caret-right'></i>优惠券管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['market/gift'])."><i class='icon icon-caret-right'></i>赠品管理</a></li>";
                        }
                    ?> 
                </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['OPERATE']['INDEX']) || isset($access['OPERATE']['STAT-MENU']) || isset($access['OPERATE']['SERIES'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>运营模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>运营模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['OPERATE']['INDEX'])) echo "<li><a class='menu_a' link=". Url::to(['operate/index'])."><i class='icon icon-caret-right'></i>门店财务统计</a></li>";
                            if(isset($access['OPERATE']['STAT-MENU'])) echo "<li><a class='menu_a' link=". Url::to(['operate/stat-menu'])."><i class='icon icon-caret-right'></i>菜单数据统计</a></li>";
                            if(isset($access['OPERATE']['SERIES'])) echo "<li><a class='menu_a' link=". Url::to(['operate/series'])."><i class='icon icon-caret-right'></i>分类数据统计</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['operate/index'])."><i class='icon icon-caret-right'></i>门店财务统计</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['operate/stat-menu'])."><i class='icon icon-caret-right'></i>菜单数据统计</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['operate/series'])."><i class='icon icon-caret-right'></i>分类数据统计</a></li>";
                        }
                    ?>
              </ul>
            </li>
            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['SYSTEM']['GROUP']) || isset($access['SYSTEM']['IMAGELIST']) || isset($access['SYSTEM']['RECHARGE'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>系统模块</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>系统模块</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['SYSTEM']['GROUP'])) echo "<li><a class='menu_a' link=". Url::to(['system/group'])."><i class='icon icon-caret-right'></i>轮播组管理</a></li>";
                            if(isset($access['SYSTEM']['IMAGELIST'])) echo "<li><a class='menu_a' link=". Url::to(['system/imagelist'])."><i class='icon icon-caret-right'></i>轮播图管理</a></li>";
                            if(isset($access['SYSTEM']['RECHARGE'])) echo "<li><a class='menu_a' link=". Url::to(['system/recharge'])."><i class='icon icon-caret-right'></i>充值管理</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['system/group'])."><i class='icon icon-caret-right'></i>轮播组管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['system/imagelist'])."><i class='icon icon-caret-right'></i>轮播图管理</a></li>";
                            echo "<li><a class='menu_a' link=". Url::to(['system/recharge'])."><i class='icon icon-caret-right'></i>充值管理</a></li>";
                        }
                    ?>
                </ul>
            </li>

            <li class="submenu">
                <?php
                    //判断权限,左侧菜单
                    if (@$access = Yii::$app->params['access']) {
                        if(isset($access['PRINT']['GET-SHOP-PRINT'])) echo '<a href="#"><i class="icon icon-info-sign"></i><span>打印机设置</span></a>';
                ?>
                <?php 
                    } else {
                ?>
                    <a href="#">
                        <i class="icon icon-info-sign"></i>
                        <span>打印机设置</span>
                    </a>
                <?php
                    }
                ?>
                <ul>
                    <?php
                        //判断权限,左侧菜单
                        if (@$access = Yii::$app->params['access']) {
                            if(isset($access['PRINT']['GET-SHOP-PRINT'])) echo "<li><a class='menu_a' link=". Url::to(['print/get-shop-print'])."><i class='icon icon-caret-right'></i>打印机设置</a></li>";
                        } else {
                            echo "<li><a class='menu_a' link=". Url::to(['print/get-shop-print'])."><i class='icon icon-caret-right'></i>打印机设置</a></li>";
                           
                        }
                    ?>
                </ul>
            </li>


        </ul>
    </div>
    <!--sidebar-menu-->

    <!--main-container-part-->
    <div id="content">
        <!--breadcrumbs-->
       <!--  <div id="content-header">
         <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
       </div> -->
        <!--End-breadcrumbs-->
        <iframe src="<?= Url::to(['site/index2']);?>" id="iframe-main" frameborder='0' style="width:100%;"></iframe>
    </div>
    <!--end-main-container-part-->
	<?= Html::jsFile("js/excanvas.min.js")?>
	<?= Html::jsFile("js/jquery.min.js")?>
	<?= Html::jsFile("js/jquery.ui.custom.js")?>
	<?= Html::jsFile("js/bootstrap.min.js")?>
	<?= Html::jsFile("js/nicescroll/jquery.nicescroll.min.js")?>
	<?= Html::jsFile("js/matrix.js")?>


    <script type="text/javascript">

    //初始化相关元素高度
    function init(){
        $("body").height($(window).height()-80);
        $("#iframe-main").height($(window).height()-90);
        $("#sidebar").height($(window).height()-50);
    }

    $(function(){
        init();
        $(window).resize(function(){
            init();
        });
    });

    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage (newURL) {
        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {
            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-" ) {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }

    // uniform使用示例：
    // $.uniform.update($(this).attr("checked", true));
    </script>
</body>
</html>
