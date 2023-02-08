<?php
//两侧广告

//拿到设置

function magic_get_ad_jwai( $str ) {
    $arr = get_field( 'ad_jwai', 'options' );
    $arr = $arr[ $str ];
    return $arr;
}

add_action( 'wp_footer', 'magick_ad_both_sides' );

function magick_ad_both_sides( $content ) {
    if ( magic_get_ad_jwai( 'both_sides_hide' ) == '1' ) {
        //关闭弹窗
        echo magick_both_sides_content();

    } else {
        return;
    }
    ;

}

function magick_both_sides_content() {
    //左边的内容
    $left = magic_get_ad_jwai( 'left' );
    //右边的内容
    $right = magic_get_ad_jwai( 'right' );
    //两端距离
    $sides = magic_get_ad_jwai( 'sides' );
    //顶部距离
    $top = magic_get_ad_jwai( 'top' );

    ?>
    <div id = 'add' class = 'add'>
    <div class = 'go-top left-s'>
    <?php  echo $left ?>

    </div>

    <div class = 'go-top right-s'>
    <?php  echo $right ?>
    </div>
    </div>
    </div>

    <style>
    .add {
        opacity: 0;
    }

    .left-s {
        left: <?php echo $sides;
        ?>px;
    }

    .right-s {
        right: <?php echo $sides;
        ?>px;
    }

    .go-top {
        position: fixed;
        /* 设置fixed固定定位 */
        top: <?php echo $top;
        ?>px;
        /* 距离浏览器窗口下边框20px */
        word-break: break-all;
        /*自动换行*/

    }

    .go-top a {
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
        height: auto;
    }

    .isashow {
        opacity: 1;
        animation: fadeIn 1s;
    }

    .noshow {
        opacity: 0;
        animation: fadeOut 1s;
    }

    @keyframes fadeOut {
        from {
            opacity: 1
        }

        to {
            opacity: 0
        }
    }

    @keyframes fadeIn {
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
                document.getElementById( 'add' ).classList.add( 'isashow' );
                document.getElementById( 'add' ).classList.remove( 'noshow' );
            } else {
                //隐藏
                document.getElementById( 'add' ).classList.add( 'noshow' );
                document.getElementById( 'add' ).classList.remove( 'isashow' );
            }
        }
        ;

        </script>
        <?php
    }