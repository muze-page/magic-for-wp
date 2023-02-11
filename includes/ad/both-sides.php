<?php
//两侧广告

//拿到设置

function magic_get_ad_both_sides($str)
{
    $arr = get_field('ad_both_sides', 'options');
    $v = $arr[$str];
    return $v;
}

//移动端关闭广告
if (wp_is_mobile()) {
    //移动设备

} else {
    //PC 端展示
    add_action('wp_footer', 'magick_ad_both_sides');
}

function magick_ad_both_sides($content)
{

    if (magic_get_ad_both_sides('both_sides_hide') == '1') {
        //开启广告
        echo magick_both_sides_content();

    } else {
        //关闭广告
        return;
    }
    ;

}

function magick_both_sides_content()
{
    //左边的内容
    $left = magic_get_ad_both_sides('left');
    //右边的内容
    $right = magic_get_ad_both_sides('right');
    //两端距离
    $sides = magic_get_ad_both_sides('sides');
    //顶部距离
    $top = magic_get_ad_both_sides('top');

    ?>
    <div id = 'magick_ad_both_sides' class = 'magick_ad_both_sides'>
    <div class = 'magick_ad_go-top magick_ad_left-s'>
    <?php echo $left ?>

    </div>

    <div class = 'magick_ad_go-top magick_ad_right-s'>
    <?php echo $right ?>
    </div>
    </div>
    </div>

    <style>
    .magick_ad_both_sides {
        opacity: 0;
    }

    .magick_ad_both_sides >.magick_ad_left-s {
        left: <?php echo $sides;
    ?>px;
    }

    .magick_ad_both_sides >.magick_ad_right-s {
        right: <?php echo $sides;
    ?>px;
    }

    .magick_ad_both_sides > .magick_ad_go-top {
        position: fixed;
        /* 设置fixed固定定位 */
        top: <?php echo $top;
    ?>px;
        /* 距离浏览器窗口下边框20px */
        word-break: break-all;
        max-width: 300px;

    }

    .magick_ad_both_sides > .magick_ad_go-top span {
        display: block;
        /* 将<a>标签设为块元素，用于美化样式 */
        text-decoration: none;
        /* 取消超链接下画线 */
        color: #333;
        /* 设置文本颜色 */
        background-color: #f2f2f2;
        /* 设置背景颜色 */
        border: 1px solid #ccc;
        /* 设置边框样式 */
        padding: 10px 20px;
        /* 设置内边距 */
        border-radius: 5px;
        /* 设置圆角矩形 */
        letter-spacing: 2px;
        /* 设置文字间距 */

        width: 180px;
        height: 500px;
    }

    .magick_ad_isashow {
        opacity: 1;
        animation: magick_ad_fadeIn 1s;
    }

    .magick_ad_noshow {
        opacity: 0;
        animation: magick_ad_fadeOut 1s;
    }

    @keyframes magick_ad_fadeOut {
        from {
            opacity: 1
        }

        to {
            opacity: 0
        }
    }

    @keyframes magick_ad_fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }
    </style>
    <script>

    //定时执行
    setTimeout( scoll, 1500 );

    function scoll() {
        window.onscroll = function () {
            scrollFunction() }
        }

        function scrollFunction() {

            if ( document.body.scrollTop > 300 || document.documentElement.scrollTop > 300 ) {
                //显示
                document.getElementById( 'magick_ad_both_sides' ).classList.add( 'magick_ad_isashow' );
                document.getElementById( 'magick_ad_both_sides' ).classList.remove( 'magick_ad_noshow' );
            } else {
                //隐藏
                document.getElementById( 'magick_ad_both_sides' ).classList.add( 'magick_ad_noshow' );
                document.getElementById( 'magick_ad_both_sides' ).classList.remove( 'magick_ad_isashow' );
            }
        }
        ;

        </script>
        <?php
}