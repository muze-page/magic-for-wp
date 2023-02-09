<?php
//底部横栏广告

//获取选项配置

function magic_get_ad_bottom_bar( $str ) {
    $arr = get_field( 'ad_bottom_bar', 'options' );
    $a = $arr[ $str ];
    return $a;
}

//载入弹窗

add_action( 'wp_footer', 'magick_ad_bottom_bar' );

function magick_ad_bottom_bar( $content ) {

    if ( magic_get_ad_bottom_bar( 'bottom_hide' ) == '1' ) {
        //开启广告
        echo magick_bottom_bar_content();

    } else {
        //关闭广告
        return;
    }
    ;

}




//准备内容

function magick_bottom_bar_content() {
    //广告内容
    $content = magic_get_ad_bottom_bar( 'bottom_content' );
    //弹出周期
    $eject = magic_get_ad_bottom_bar( 'bottom_eject' );
    //清理Cookie
    $debug = magic_get_ad_bottom_bar( 'bottom_bar_debug' );
    ?>
    <div id = 'magcik_ad_bottom_bar'>
    <button

    class = 'ad-bar-button'
    :class = "{ 'ad-bar-actives': show}" 
    @click = 'switchButton'
    v-html = 'msg'
    >
   </button>
        <transition name = 'ad-bar-fade'>
        <div class = 'bottom-bar-box' v-if = 'show'>
        <div class = 'bottom-bar-content'>
        <?php //echo $content;
        ?>
       
        <a href = 'https://dongbd.com/wp-content/uploads/app/0329/index.html' target = '_blank'>
        <img src = 'https://dongbd.com/wp-content/uploads/2022/10/1665676987.gif' />
        </a>
       
        </div>
        </div>
        </transition>
        <?php 
  if( $debug == "1" ) {
      echo "<button @click='clearAdBootomBarCookie()'>清理底部广告Cookie</button>";
  }
  
  ?>
  
        </div>


        <script>
        const App = Vue.createApp( {
            setup() {
                //初始化
                let msg = Vue.ref( '<i class="dashicons dashicons-arrow-down-alt2"></i>' );
                let show = Vue.ref( true );

                //单击按钮触发的方法
                const switchButton = () => {
                    show.value = !show.value
                    //判断
                    if ( show.value == true ) {
                        //关闭广告
                        msg.value = '<i class="dashicons dashicons-arrow-down-alt2"></i>'
                    } else {
                        //开启广告
                        msg.value = '<i class="dashicons dashicons-arrow-up-alt2"></i>'
                    }
                }

                //根据状态设定图标
                Vue.onBeforeUpdate(()=>{
                    if ( show.value == true ) {
                        //关闭广告
                        msg.value = '<i class="dashicons dashicons-arrow-down-alt2"></i>'
                    } else {
                        //开启广告
                        msg.value = '<i class="dashicons dashicons-arrow-up-alt2"></i>'
                    }
                })

                //准备Cookie

                      //删除Cookie
      const clearAdBootomBarCookie = () => {
        document.cookie =
          "adBottomBarCookie=show;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          location.reload(true);//刷新页面
      };


                function openAd(){
          if (getCookie("adBottomBarCookie") == "") {
            //没有adCookie就添加一个adCookie
            //document.cookie = "adCookie = show";
            //设置过期时间
            let d = new Date();

            d.setTime(d.getTime() + <?php echo $eject; ?>*24 * 60 * 60 * 1000);//24小时
            document.cookie ="adBottomBarCookie = show;path=/;expires= " + d.toUTCString();
              //设置显示广告
              showAd.value = true;
          } else {
            //有Cookie就隐藏广告
            show.value = false;
          }
            
  
             
        }

              //延时加载
     setTimeout(function () {
        openAd();
      },3000);

                      //拿到Cookie
      const getCookie = (Name) => {
        //cookie
        var search = Name + "=";
        var returnValue = "";
        if (document.cookie.length > 0) {
          var offset = document.cookie.indexOf(search);
          if (offset !== -1) {
            offset += search.length;
            var end = document.cookie.indexOf(";", offset);
            if (end == -1) {
              end = document.cookie.length;
            }
            returnValue = decodeURIComponent(
              document.cookie.substring(offset, end)
            );
          }
        }
        return returnValue;
      }

                return {
                    msg,
                    show,
                    switchButton,
                    clearAdBootomBarCookie,
                }
            }
        }
    )
    App.mount( '#magcik_ad_bottom_bar' )
    </script>
    <style>
    #magcik_ad_bottom_bar {
        /*按钮动画*/
        /*广告内容样式*/
    }
    #magcik_ad_bottom_bar .bottom-bar-box {
        display: block;
        width: 100% !important;
        height: auto;
        bottom: 0px;
        clear: none !important;
        float: none !important;
        left: 0px;
        margin: 0px !important;
        max-height: none !important;
        max-width: none !important;
        opacity: 1;
        overflow: visible !important;
        padding: 0px !important;
        position: fixed;
        right: auto !important;
        top: auto !important;
        visibility: visible !important;
        z-index: 2147483647;
        background: #fafafa !important;
        /*核心内容框动画*/
        animation: BarBoxA 0.1s;
        display: flex;
        justify-content: center;
        /*align-items: center;
        */
        line-height: 38px;
    }
    #magcik_ad_bottom_bar .bottom-bar-content {
        max-width: 720px;
        max-height: 90px;
        margin: 0 auto;
        display: table-cell;
        vertical-align: middle;
    }
    #magcik_ad_bottom_bar .ad-bar-button {
        bottom: 10px;
        position: fixed;
        animation: BottomBarButton 0.1s;
        padding: 5px 15px;
        cursor: pointer;
        left: 0px;
        border: 0px;
    }
    @keyframes BottomBarButton {
        from {
            bottom: 70px;
            padding: 10px 20px;
        }
        to {
            bottom: 10px;
            padding: 5px 15px;
        }
    }
    #magcik_ad_bottom_bar .ad-bar-actives {
        animation: adBarAc 0.1s;
        bottom: 80px;
        position: fixed;
        padding: 10px 20px;
        cursor: pointer;
        left: 0px;
        border: 0px;
    }
    @keyframes adBarAc {
        from {
            bottom: 10px;
            padding: 5px 15px;
        }
        to {
            bottom: 70px;
            padding: 10px 20px;
        }
    }
    @keyframes BarBoxA {
        from {
            height: 0px;
        }
        to {
            height: 70px;
        }
    }
    #magcik_ad_bottom_bar .ad-bar-fade-enter-from {
        height: 0px;
    }
    #magcik_ad_bottom_bar .ad-bar-fade-enter-active {
        transition: all 0.1s ease;
    }
    #magcik_ad_bottom_bar .ad-bar-fade-enter-to {
        height: 70px;
    }
    #magcik_ad_bottom_bar .ad-bar-fade-leave-from {
        height: 70px;
    }
    #magcik_ad_bottom_bar .ad-bar-fade-leave-active {
        transition: all 0.1s ease;
    }
    #magcik_ad_bottom_bar .ad-bar-fade-leave-to {
        height: 0px;
    }
    #magcik_ad_bottom_bar .bottom-bar-content img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        image-rendering: -webkit-optimize-contrast;
        border: 0;
        /*vertical-align: baseline;
        */
    }
    /*移动端优化样式*/
    @media screen and ( min-width: 768px ) {
        .ad-bar-actives {
            bottom: 90px;
        }
        @keyframes BottomBarButton {
            from {
                bottom: 90px;
            }
            to {
                bottom: 10px;
            }
        }
        @keyframes adBarAc {
            from {
                bottom: 10px;
            }
            to {
                bottom: 90px;
            }
        }
        @keyframes BarBoxA {
            from {
                height: 0px;
            }
            to {
                height: 90px;
            }
        }
        .ad-bar-fade-enter-to {
            height: 90px;
        }
        .ad-bar-fade-leave-from {
            height: 90px;
        }
    }

    </style>

    <?php

}