<?php
/*弹窗功能代码*/


//开关 - $ad_pop['ad_notification_switch']
//时间 - $ad_pop['ad_notification_cycle']
//标题 - $ad_pop['ad_notification_title']
//内容 - $ad_pop['ad_notification_content']
//调试按钮 - $ad_pop['ad_notification_debug']

//获取选项配置
function magic_get_pop( $str ) {
    $arr = get_field('ad_notification', 'options');
    $arr = $arr[ $str ];
    return $arr;
}





    
//载入弹窗
 
add_action('wp_footer', 'magick_ad_pop_notification');









function magick_ad_pop_notification($content){
    
    if(magic_get_pop( 'ad_notification_switch' ) == '0') {
        //关闭弹窗
	    echo "";
        
    };
    
    if(magic_get_pop( 'ad_notification_switch' ) == '1') {
        //简洁弹窗
	    echo magick_output_pop_concise();
        
    };
    
    if(magic_get_pop( 'ad_notification_switch' ) == '2') {
        //谷歌弹窗
        	 echo magick_output_pop_google();
    };
    

};





//简洁弹窗
function magick_output_pop_concise() {

 ?>
 
 <!--
<script src="https://cdn.staticfile.org/vue/3.2.45/vue.global.js"></script>
-->
<div id="magick_pop_concise">
  <div class="magick_main" v-show="showAd">
    <div class="sec">
      <div class="set">
        <!--关闭按钮-->
        <span class="dashicons dashicons-dismiss offAd" @click="offAd()"></span>
      </div>

      <div class="ad_box">
        <div class="ad_main">
          
              <?php echo "<h2>".magic_get_pop( 'ad_notification_title'."</h2>" ); ?>
          
          <span>
              <?php echo magic_get_pop( 'ad_notification_content' ); ?>
          </span>
        </div>
      </div>
    </div>
    
  </div>
  <?php 
  if( magic_get_pop( 'ad_notification_debug' ) == "1" ) {
      echo "<button @click='clearCookie()'>显示简洁弹窗</button>";
  }
  
  ?>
  
</div>

<script>
  const App_pop_concise = Vue.createApp({
    setup() {
      //////////////////////////////////////////
      //删除Cookie
      const clearCookie = () => {
        document.cookie =
          "adCookie=show;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          location.reload(true);//刷新页面
      };
      //////////////////////////////////////////
      //默认不显示广告
      const showAd = Vue.ref(false);

      
      function openAd(){
          
          
                    
        if (getCookie("adCookie") == "") {
          //没有adCookie就添加一个adCookie
          //document.cookie = "adCookie = show";
          //设置过期时间
          let d = new Date();
          // d.setTime(d.getTime() + 24 * 60 * 60 * 1000);//24小时
          // d.setTime(d.getTime() + 1 * 60 * 60 * 1000);//1小时
          //d.setTime(d.getTime() + 1 * 60 * 1000);//1分钟
          // ad=popup-ad   键值对形式：name=key   expires 有效期
          //d.setTime(d.getTime() + 24 * 60 * 60 * 1000); //生成距现在24小时后的时间
          //d.setTime(d.getTime() + 1 * 5 * 1000); //1分钟
          d.setTime(d.getTime() + <?php echo magic_get_pop( 'ad_notification_cycle' ); ?>*24 * 60 * 60 * 1000);//24小时
          document.cookie =
            "adCookie = show;path=/;expires= " + d.toUTCString();
            
            showAd.value = true;
        } else {
          //有adCookie就隐藏广告
          showAd.value = false;
        }
          

           
      }
      
      //延时加载
     setTimeout(function () {
        openAd();
      },2000);


      //关闭广告方法
      const offAd = () => {
        showAd.value = false;
      };
      //挂载广告前判断cookie


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
      };

      return {
        showAd,
        offAd,
        clearCookie,
      };
    },
  });
  App_pop_concise.mount("#magick_pop_concise");
</script>

<style>
  .magick_main {
    display: flex;
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 9999;
    justify-content: center;
    transition: 0.3s ease-out;
    flex-direction: column;
    align-items: center;
    background: var(--heo-maskbgdeep);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: blur(20px);
  }

  .magick_main .sec {
    width: 80%;
    /*height: 500px;*/
    margin: 0.9rem auto;
  }
  
  .magick_main .sec .set {
     width: 60%;
    display: block;
    margin: auto;
    overflow: hidden;
  }
  
    @media screen and (max-width: 768px){
     .magick_main .sec .set {
    width: 100%;
      }
  }

  .magick_main .sec .set .offAd {
    width: 48px;
    height: 48px;
    right: 50px;
    top: auto;
    font-size: 35px;
    color: var(--heo-fontcolor);
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    padding: 1px 8px;
    float: right;
  }

  .magick_main .sec .ad_box {
    width: 60%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    /*height: 100%;*/
    overflow: hidden;
  }
  

 
  .magick_main .sec .ad_main {
    background: var(--card-bg);
    border-radius: 12px;
    overflow: hidden;
    border: var(--style-border);
    box-shadow: var(--heo-shadow-border);
    padding: 40px;
  }

  .magick_main {
    --card-bg: #fff;
    --style-border: 1px solid var(--heo-card-border);
    --heo-card-border: #e3e8f7;
    --heo-shadow-border: 0 8px 16px -4px #2c2d300c;
    --heo-fontcolor: #363636;
    --heo-maskbgdeep: rgba(255, 255, 255, 0.85);
  }
  
    @media screen and (max-width: 768px){
      .magick_main .sec .ad_box {
    width: 100%;
      }
      
      .magick_main .sec .ad_main{
          padding: 6px!important;
      }
      
.magick_main .sec {
    width: 96%;
}

}
/*临时修改*/
.magick_main {
    background: none!important;
    backdrop-filter: none!important;
}
.magick_main .sec .ad_main {
    background-color: #fff!important;
}


</style>



<?php 
  
    
};    //end concise




//谷歌弹窗
function magick_output_pop_google() {
 ?>
 
  

  
 <!--<button onclick="offUp()">打开弹窗</button>
 
 <script src="https://unpkg.com/vue@next"></script>
 -->

<div id="magick_pop" >
               <?php 
  if( magic_get_pop( 'ad_notification_debug' ) == "1" ) {
      echo "<button @click='clearCookie()'>显示谷歌弹窗</button>";
  }
  
  ?>
  
  
    <div class="magick_pop" v-show="showAd">
  <div class="box-content" >
    <!--顶部-->
    <div class="top-box">
      <div class="left-box">
        <div class="text">广告</div>
      </div>
      <div class="right-box" onclick="openFeed()">
        <svg viewBox="0 0 14 24" fill="none">
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M2 8C3.1 8 4 7.1 4 6C4 4.9 3.1 4 2 4C0.9 4 0 4.9 0 6C0 7.1 0.9 8 2 8ZM2 10C0.9 10 0 10.9 0 12C0 13.1 0.9 14 2 14C3.1 14 4 13.1 4 12C4 10.9 3.1 10 2 10ZM0 18C0 16.9 0.9 16 2 16C3.1 16 4 16.9 4 18C4 19.1 3.1 20 2 20C0.9 20 0 19.1 0 18Z"
            fill="#5F6368"
          ></path>
        </svg>
      </div>
    </div>
    <!--底部-->
    <div class="button-box">
      <div class="content-top">
        <div class="title">
            <?php echo magic_get_pop( 'ad_notification_title' ); ?>
        </div>
        <div class="content">
            <?php echo magic_get_pop( 'ad_notification_content' ); ?>
        </div>
        </div>
        <div class="content-button">
          <div class="t-logo">
              <img src="<?php echo magic_get_pop( 'ad_notification_logo' ); ?>" />
              
          </div>
          <div class="t-button" @click="offAd()" >
            <span>关闭</span>
          </div>
          <div class="t-button style-button" onclick="openUrl()">
            <span>
                <!--打开按钮-->
                <a href="<?php echo magic_get_pop( 'ad_notification_button-link' ); ?>" target="_blank">
                    <?php echo magic_get_pop( 'ad_notification_button-text' ); ?>
                </a>
                
            </span>
          </div>
        </div>
        
      </div>
      <!--反馈-->
      <div id="feedback" class="feedback" style="display: none;">
        <div class="survey-bg"></div>
        <div class="feed-menu">
            <div class="feed-box">
                <a href="#">
                    <div class="p-img">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAQAAAD9CzEMAAAAlElEQVR4Ae3SMQ4CMQxEUZ9myQWn50BIAQ62oA0lYArkagRNJiIS9u/nNba8mQ47HLHBO7vhjAKLDNGCC1zUFYWBA1zYiYFVCjQG7nBlDDwSUAD2LoEPJfD8ByD6FZBAvqnPAHAJzAu00UAdC6xYxgENNea/AXuYJAZ4Xg/EvB7geT0Q83qA5tUAzasB/XwAkhLo6AUCK6P+GIvGtgAAAABJRU5ErkJggg==" />
                    </div>
                    <span>有关此广告的反馈</span>
                </a>
                <a href="#">
                    <div class="p-img">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAQAAAD9CzEMAAACI0lEQVR4Ae3XTUtUURjA8TOkjeBLqYTOZ1CcRW8IWiQuwjaJm6AW9QEiMP7MpIsiiqhFLVq1qRZDw8yHiAQrENpFFFSbGuZKSC+6SEOfJGQYDs95HPTMIvD+Vxee4Xe5M/fcM+5/OfYO3iBeC7hGcjRSBlHqjweMqsBIPOCSClyMB9xWgVvxgLIKlHYGTLBEibHaeQ93WVGBFe7QXZsbo8R3JrYD0nxG/vWeaXo4zxJi9I1z9HKVD1vnn0jbwDWkrjVEz5jKW0CGZWSXLZMJA0+RCD0JAUfZiAJscEQDUrxGIvVKA6YQs6/kGCC92SB5KojZJD7AKVaRYAXacXV1UDSmVzmpfQfDwesqkMJ5pYLEF46FfkV9zKk3px2n1ElVmX7OIetBa+E+4pXDBZpBvO6xb/vFzl8cBoLAkDeZNLaarnsfSweBNm/yT7OBNQMwbtFgEMh6k9XtgVYeIl75IDCLeD2gxV5N5xH8KnTglLpIlOk5+kLAKFVErag+aGVErcKwBoybr5cind7Vl81XkLJUnEXMqswwRNtmWWZJELMz2i2aRyL1AqcBhyO9cNbJ6oDjcRTgES68mv5CdtkPezXNIXX9RuyUqWmcBezn49bgWy5zkCkWEaOESbq5wrvadq3VBhynWaRQtzU/wM3Abukn1+mqzZ3gGQnjO9v8llSg0Ozt+41m/wG5EA8YUYHj8YB+FeiNBzgWEK+XuGiA3h4Qqb+5VDM8HRjcGAAAAABJRU5ErkJggg==" >
                    </div>
                    <span>查看我的 Google 广告设置</span>
                    </a>

                    <a href="#" onclick="closeFeed()"><span>关闭</span></a>
            </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <style>
    #magick_pop .magick_pop {
      position: fixed;
      height: 100vh;
      width: 100vw;
      top: 0;
      left: 0;

      display: flex;
      align-items: center;
      justify-content: center;

      background: rgba(52, 58, 65, 0.6);
      
      z-index: 999;
    }
    #magick_pop .box-content {
      background-color: #fff;
      border-radius: 6px;
      padding: 0 6px 1px;
      position: relative;
      box-shadow: 0px 8px 12px rgb(60 64 67 / 15%),
        0px 4px 4px rgb(60 64 67 / 30%);

       max-width: 80%;
       min-width: 500px;
    }
    #magick_pop .top-box {
      width: 100%;
      display: table;
      height: 24px;
      background-color: #fff;
    }
    #magick_pop .top-box .left-box {
      font-size: 12px;
      font-weight: 700;
      font-family: "Roboto", arial, sans-serif;
      color: #202124;
      position: relative;
      height: 25px;
      padding: 12px 16px 0;
      float: left;

      display: table;
    }
    #magick_pop .top-box .right-box {
      opacity: 0.55;
      padding: 12px 2px 0;
      float: right;
      cursor: pointer;
      visibility: visible;
    }
    #magick_pop .top-box svg {
      height: 1.5em;
      width: 1.5em;
      margin-left: -0.3em;
      margin-right: -0.3em;
      vertical-align: middle;
      padding-bottom: 1px;
    }
    /*底部*/
    #magick_pop .button-box {
      /*width: 746px;*/
    }
    #magick_pop .button-box .content-top {
      padding: 11.84px 17px;
    }
    /*标题*/
    #magick_pop .button-box .title {
      font-size: 50px;
      color: rgba(0, 0, 0, 0.79);
      font-weight: 500;
      line-height: 1.3;
      letter-spacing: 0.02em;
    }
    /*内容*/
    #magick_pop .button-box .content {
      font-size: 28px;
      padding: 11.84px 0 0;
      color: rgba(0, 0, 0, 0.6);
      letter-spacing: 0.02em;
    }
    /*内如底部*/
    #magick_pop .button-box .content-button {
      display: flex;
      align-items: center;
      padding: 23.68px 18px 28px;
    }

    /*品牌LOGO*/
    #magick_pop .button-box .t-logo {
      width: 100%;
      
    }
    
    #magick_pop .button-box .t-logo img {
        max-height: 48px;
    }

    /*按钮*/
    #magick_pop .button-box .t-button {
      font-size: 16px;
      
      height: 40px;
      line-height: 40px;
      max-height: 40px;
      

      border-radius: 4px;
      box-shadow: 0 6px 12px rgb(134 140 150 / 65%);
      cursor: pointer;
      background-color: #fff;
      outline: none;

      box-sizing: border-box;
      font-weight: 400;
      text-align: center;
      width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;

      margin-left: 20px;
    }
    #magick_pop .button-box .style-button {
      color: white;
      background-color: #0088ff;
    }
    
    #magick_pop a {
        color: inherit;
        text-decoration: none;
        vertical-align: top;
    }
    /*反馈*/
    #magick_pop .box-content .survey-bg {
    background-color: rgba(0, 0, 0, 0.8);
    bottom: 0px;
    opacity: 1;
    overflow-y: auto;
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    z-index: 10000;
    }
    #magick_pop  .feed-menu {
    position: absolute;
    z-index: 10000;
    top: 15px;
    left: 15px;
    }
    #magick_pop  .feed-box {
    padding: 5px 0;
    margin: 0;
    box-shadow: 0 0 3px 3px rgb(0 0 0 / 20%);
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    background-color: #ffffff;
    }

    #magick_pop  .feed-box a{
    box-sizing: border-box;
    display: table;
    padding: 0 14px;
    width: 100%;
    }
    #magick_pop  .feed-box a div {
    display: table-cell;
    vertical-align: middle;
    }
    #magick_pop .feed-box .p-img{
        width: 35px;
    }
    #magick_pop .feed-box  img {
    height: 21px;
    margin: 3px 14px 0 0;
    }

    #magick_pop .feed-box a span {
        display: inline-block;
        color: #212121;
        font-family: "Roboto-Regular", arial, sans-serif;
        font-size: 14px;
        margin: 11px 0;
        max-width: 224px;
    }
  </style>
</div>

<script>

    //弹窗默认隐藏，点击开启弹窗
    const offUp=()=>{
       let p =document.getElementById("pop");
       p.style.cssText = ""; 
    };

    //点击关闭弹窗
    const closePop=()=>{
        let pd =document.getElementById("pop");
        pd.style.display = "none"; 
    };

    const openUrl=()=> {
        //打开的链接
        location.href = "#";
    };

    //点击开启反馈
    const openFeed=()=>{
        let pa =document.getElementById("feedback");
        pa.style.cssText = "";
    };
    
    //点击关闭反馈
    const closeFeed=()=>{
        let pb =document.getElementById("feedback");
        pb.style.display = "none"; 
    };



</script>

<script>
  const App_pop_google = Vue.createApp({
    setup() {
      //////////////////////////////////////////
      //删除Cookie
      const clearCookie = () => {
        document.cookie =
          "adCookie=show;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          location.reload(true);//刷新页面
      };
      //////////////////////////////////////////
      //默认显示广告
      const showAd = Vue.ref(true);
      //关闭广告方法
      const offAd = () => {
        showAd.value = false;
      };
      //挂载广告前判断cookie
      Vue.onBeforeMount(() => {
        if (getCookie("adCookie") == "") {
          //没有adCookie就添加一个adCookie
          //document.cookie = "adCookie = show";
          //设置过期时间
          let d = new Date();
          // d.setTime(d.getTime() + 24 * 60 * 60 * 1000);//24小时
          // d.setTime(d.getTime() + 1 * 60 * 60 * 1000);//1小时
          //d.setTime(d.getTime() + 1 * 60 * 1000);//1分钟
          // ad=popup-ad   键值对形式：name=key   expires 有效期
          //d.setTime(d.getTime() + 24 * 60 * 60 * 1000); //生成距现在24小时后的时间
          //d.setTime(d.getTime() + 1 * 5 * 1000); //1分钟
          d.setTime(d.getTime() + <?php echo magic_get_pop( 'ad_notification_cycle' ); ?>*24 * 60 * 60 * 1000);//24小时
          document.cookie =
            "adCookie = show;path=/;expires= " + d.toUTCString();
        } else {
          //有adCookie就隐藏广告
          showAd.value = false;
        }
      });

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
      };

      return {
        showAd,
        offAd,
        clearCookie,
      };
    },
  });
  App_pop_google.mount("#magick_pop");
</script>

 
 <?php
    
};    //end Google











