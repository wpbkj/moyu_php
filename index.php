<?php
/**
*摸鱼办提醒（PHP版）
*
*@author    WPBKJ
*@copyright WPBKJ(www.wpbkj.com)
*@license   GNU General Public License 2.0
*@version   $Id:index.php 1.0.1 2022/7/4 10:00 $
*/

/** 载入农历支持 */
require_once('lunar.php');
$lunar=new Lunar();

/** 定义时间 */
$nowYear = date('Y');
$nextYear = $nowYear+1;
$nowDate = date("Y-m-d");
$nowWeek = date('N');

/** 将文本类型日期转换为时间戳方法 */
function changeDate($date){
    list($year,$month,$day) = explode('-',$date);
    return mktime(0,0,0,$month,$day,$year);
}

/** 计算两日期间隔时间（Y-m-d格式） */
function countDay($dateBegin,$dateEnd){
    $res = (changeDate($dateEnd) - changeDate($dateBegin)) / (3600*24);
    return $res;
}

/** 判断今年该日期是否已过并计算与当前相差时间（农历） */
function lunarDayJudge($month,$day){
    global $lunar;
    global $nowDate;
    global $nowYear;
    global $nextYear;
    $date = $lunar->convertLunarToSolar($nowYear,$month,$day);
    $date = $date[0].'-'.$date[1].'-'.$date[2];
    if(changeDate($nowDate) <= changeDate($date)){
        return countDay($nowDate,$date);
    }else{
        $date = $lunar->convertLunarToSolar($nextYear,$month,$day);
        $date = $date[0].'-'.$date[1].'-'.$date[2];
        return countDay($nowDate,$date);
    }
}

/** 判断今年该日期是否已过并计算与当前相差时间（公历） */
function dayJudge($month,$day){
    global $nowDate;
    global $nowYear;
    global $nextYear;
    $date = $nowYear.'-'.$month.'-'.$day;
    if(changeDate($nowDate) <= changeDate($date)){
        return countDay($nowDate,$date);
    }else{
        $date = $nextYear.'-'.$month.'-'.$day;
        return countDay($nowDate,$date);
    }
}

$vacDate = array();
$title = array();

/** 周末 */
if(6-$nowWeek <= 0){
    $vacDate['WEEKEND'] = 0;
}else{
    $vacDate['WEEKEND'] = 6-$nowWeek;
}

$title['WEEKEND'] = '周末';

/** 中秋节 */
$vacDate['MAF'] = lunarDayJudge(8,15);
$title['MAF'] = '中秋节';

/** 国庆节 */
$vacDate['ND'] = dayJudge(10,1);
$title['ND'] = '国庆节';

/** 元旦 */
$vacDate['NYD'] = dayJudge(1,1);
$title['NYD'] = '元旦';

/** 农历过年 */
$vacDate['LNY'] = lunarDayJudge(1,1);
$title['LNY'] = '过年';

/** 清明节 */
$vacDate['TSD'] = lunarDayJudge(4,5);
$title['TSD'] = '清明节';

/** 劳动节 */
$vacDate['ILD'] = dayJudge(5,1);
$title['ILD'] = '劳动节';

/** 端午节 */
$vacDate['DBF'] = lunarDayJudge(5,5);
$title['DBF'] = '端午节';

?>
<!DOCTYPE html>
<html>

<head>
    <title>摸鱼办</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="static/moyu.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/katex.min.css">

    <style>
        code[class*="language-"],
        pre[class*="language-"] {
            color: #333;
            background: none;
            font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
            text-align: left;
            white-space: pre;
            word-spacing: normal;
            word-break: normal;
            word-wrap: normal;
            line-height: 1.4;

            -moz-tab-size: 8;
            -o-tab-size: 8;
            tab-size: 8;

            -webkit-hyphens: none;
            -moz-hyphens: none;
            -ms-hyphens: none;
            hyphens: none;
        }

        /* Code blocks */
        pre[class*="language-"] {
            padding: .8em;
            overflow: auto;
            /* border: 1px solid #ddd; */
            border-radius: 3px;
            /* background: #fff; */
            background: #f5f5f5;
        }

        /* Inline code */
        :not(pre) > code[class*="language-"] {
            padding: .1em;
            border-radius: .3em;
            white-space: normal;
            background: #f5f5f5;
        }

        .token.comment,
        .token.blockquote {
            color: #969896;
        }

        .token.cdata {
            color: #183691;
        }

        .token.doctype,
        .token.punctuation,
        .token.variable,
        .token.macro.property {
            color: #333;
        }

        .token.operator,
        .token.important,
        .token.keyword,
        .token.rule,
        .token.builtin {
            color: #a71d5d;
        }

        .token.string,
        .token.url,
        .token.regex,
        .token.attr-value {
            color: #183691;
        }

        .token.property,
        .token.number,
        .token.boolean,
        .token.entity,
        .token.atrule,
        .token.constant,
        .token.symbol,
        .token.command,
        .token.code {
            color: #0086b3;
        }

        .token.tag,
        .token.selector,
        .token.prolog {
            color: #63a35c;
        }

        .token.function,
        .token.namespace,
        .token.pseudo-element,
        .token.class,
        .token.class-name,
        .token.pseudo-class,
        .token.id,
        .token.url-reference .token.variable,
        .token.attr-name {
            color: #795da3;
        }

        .token.entity {
            cursor: help;
        }

        .token.title,
        .token.title .token.punctuation {
            font-weight: bold;
            color: #1d3e81;
        }

        .token.list {
            color: #ed6a43;
        }

        .token.inserted {
            background-color: #eaffea;
            color: #55a532;
        }

        .token.deleted {
            background-color: #ffecec;
            color: #bd2c00;
        }

        .token.bold {
            font-weight: bold;
        }

        .token.italic {
            font-style: italic;
        }


        /* JSON */
        .language-json .token.property {
            color: #183691;
        }

        .language-markup .token.tag .token.punctuation {
            color: #333;
        }

        /* CSS */
        code.language-css,
        .language-css .token.function {
            color: #0086b3;
        }

        /* YAML */
        .language-yaml .token.atrule {
            color: #63a35c;
        }

        code.language-yaml {
            color: #183691;
        }

        /* Ruby */
        .language-ruby .token.function {
            color: #333;
        }

        /* Markdown */
        .language-markdown .token.url {
            color: #795da3;
        }

        /* Makefile */
        .language-makefile .token.symbol {
            color: #795da3;
        }

        .language-makefile .token.variable {
            color: #183691;
        }

        .language-makefile .token.builtin {
            color: #0086b3;
        }

        /* Bash */
        .language-bash .token.keyword {
            color: #0086b3;
        }

        /* highlight */
        pre[data-line] {
            position: relative;
            padding: 1em 0 1em 3em;
        }

        pre[data-line] .line-highlight-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            background-color: transparent;
            display: block;
            width: 100%;
        }

        pre[data-line] .line-highlight {
            position: absolute;
            left: 0;
            right: 0;
            padding: inherit 0;
            margin-top: 1em;
            background: hsla(24, 20%, 50%, .08);
            background: linear-gradient(to right, hsla(24, 20%, 50%, .1) 70%, hsla(24, 20%, 50%, 0));
            pointer-events: none;
            line-height: inherit;
            white-space: pre;
        }

        pre[data-line] .line-highlight:before,
        pre[data-line] .line-highlight[data-end]:after {
            content: attr(data-start);
            position: absolute;
            top: .4em;
            left: .6em;
            min-width: 1em;
            padding: 0 .5em;
            background-color: hsla(24, 20%, 50%, .4);
            color: hsl(24, 20%, 95%);
            font: bold 65%/1.5 sans-serif;
            text-align: center;
            vertical-align: .3em;
            border-radius: 999px;
            text-shadow: none;
            box-shadow: 0 1px white;
        }

        pre[data-line] .line-highlight[data-end]:after {
            content: attr(data-end);
            top: auto;
            bottom: .4em;
        }

        html body {
            font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, freesans, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            overflow: initial;
            box-sizing: border-box;
            word-wrap: break-word
        }

        html body > :first-child {
            margin-top: 0
        }

        html body h1,
        html body h2,
        html body h3,
        html body h4,
        html body h5,
        html body h6 {
            line-height: 1.2;
            margin-top: 1em;
            margin-bottom: 16px;
            color: #000
        }

        html body h1 {
            font-size: 2.25em;
            font-weight: 300;
            padding-bottom: .3em
        }

        html body h2 {
            font-size: 1.75em;
            font-weight: 400;
            padding-bottom: .3em
        }

        html body h3 {
            font-size: 1.5em;
            font-weight: 500
        }

        html body h4 {
            font-size: 1.25em;
            font-weight: 600
        }

        html body h5 {
            font-size: 1.1em;
            font-weight: 600
        }

        html body h6 {
            font-size: 1em;
            font-weight: 600
        }

        html body h1,
        html body h2,
        html body h3,
        html body h4,
        html body h5 {
            font-weight: 600
        }

        html body h5 {
            font-size: 1em
        }

        html body h6 {
            color: #5c5c5c
        }

       

        @media print {
            html body {
                background-color: #fff
            }

            html body h1,
            html body h2,
            html body h3,
            html body h4,
            html body h5,
            html body h6 {
                color: #000;
                page-break-after: avoid
            }

            html body blockquote {
                color: #5c5c5c
            }

            html body pre {
                page-break-inside: avoid
            }

            html body table {
                display: table
            }

            html body img {
                display: block;
                max-width: 100%;
                max-height: 100%
            }

            html body pre,
            html body code {
                word-wrap: break-word;
                white-space: pre
            }
        }

        .markdown-preview {
            width: 100%;
            height: 100%;
            box-sizing: border-box
        }

        .markdown-preview .pagebreak,
        .markdown-preview .newpage {
            page-break-before: always
        }

        .markdown-preview pre.line-numbers {
            position: relative;
            padding-left: 3.8em;
            counter-reset: linenumber
        }

        .markdown-preview pre.line-numbers > code {
            position: relative
        }

        .markdown-preview pre.line-numbers .line-numbers-rows {
            position: absolute;
            pointer-events: none;
            top: 1em;
            font-size: 100%;
            left: 0;
            width: 3em;
            letter-spacing: -1px;
            border-right: 1px solid #999;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .markdown-preview pre.line-numbers .line-numbers-rows > span {
            pointer-events: none;
            display: block;
            counter-increment: linenumber
        }

        .markdown-preview pre.line-numbers .line-numbers-rows > span:before {
            content: counter(linenumber);
            color: #999;
            display: block;
            padding-right: .8em;
            text-align: right
        }

        .markdown-preview .mathjax-exps .MathJax_Display {
            text-align: center !important
        }

        .markdown-preview:not([for="preview"]) .code-chunk .btn-group {
            display: none
        }

        .markdown-preview:not([for="preview"]) .code-chunk .status {
            display: none
        }

        .markdown-preview:not([for="preview"]) .code-chunk .output-div {
            margin-bottom: 16px
        }

        .scrollbar-style::-webkit-scrollbar {
            width: 8px
        }

        .scrollbar-style::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: transparent
        }

        .scrollbar-style::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: rgba(150, 150, 150, 0.66);
            border: 4px solid rgba(150, 150, 150, 0.66);
            background-clip: content-box
        }

        html body[for="html-export"]:not([data-presentation-mode]) {
            position: relative;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            overflow: auto
        }

        html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
            position: relative;
            top: 0
        }

        @media screen and (min-width: 914px) {
            html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
                padding: 2em calc(50% - 457px + 2em)
            }
        }

        @media screen and (max-width: 914px) {
            html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
                padding: 2em
            }
        }

        @media screen and (max-width: 450px) {
            html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
                font-size: 14px !important;
                padding: 1em
            }
        }

        @media print {
            html body[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn {
                display: none
            }
        }

        html body[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn {
            position: fixed;
            bottom: 8px;
            left: 8px;
            font-size: 28px;
            cursor: pointer;
            color: inherit;
            z-index: 99;
            width: 32px;
            text-align: center;
            opacity: .4
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] #sidebar-toc-btn {
            opacity: 1
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            padding: 32px 0 48px 0;
            font-size: 14px;
            box-shadow: 0 0 4px rgba(150, 150, 150, 0.33);
            box-sizing: border-box;
            overflow: auto;
            background-color: inherit
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar {
            width: 8px
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: transparent
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: rgba(150, 150, 150, 0.66);
            border: 4px solid rgba(150, 150, 150, 0.66);
            background-clip: content-box
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc a {
            text-decoration: none
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc ul {
            padding: 0 1.6em;
            margin-top: .8em
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc li {
            margin-bottom: .8em
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc ul {
            list-style-type: none
        }

        html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
            left: 300px;
            width: calc(100% - 300px);
            padding: 2em calc(50% - 457px - 150px);
            margin: 0;
            box-sizing: border-box
        }

        @media screen and (max-width: 1274px) {
            html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
                padding: 2em
            }
        }

        @media screen and (max-width: 450px) {
            html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
                width: 100%
            }
        }

        html body[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .markdown-preview {
            left: 50%;
            transform: translateX(-50%)
        }

        html body[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .md-sidebar-toc {
            display: none
        }
    </style>
</head>

<body for="html-export">
<div class="mume markdown-preview  ">
    <h1 align="center">摸鱼办公室</h1>
    <p align="center">
        <img src="static/moyu.gif" alt="">
    </p>
    <center>
        【摸鱼办提醒您】 今天是 <?php echo $nowDate;?>
        <br><br>
        <p>
            你好，摸鱼人，工作再累，一定不要忘记摸鱼哦 ！<br>
            有事没事起身去茶水间去廊道去天台走走，别老在工位上坐着。<br>
            多喝点水，钱是老板的，但命是自己的 !
        </p>

        <p>
        <?php
            foreach ($vacDate as $key => $value){
            ?>
            🐟 距离 <?php echo $title["{$key}"];?> 放假还有 <?php echo $value;?> 天<br>
        <?php }?>
        </p>


        <p>
            【友情提示】三甲医院 ICU 躺一天平均费用大概一万块。<br>
            你晚一天进 ICU，就等于为你的家庭多赚一万块。少上班，多摸鱼。<br>
            上班是帮老板赚钱，摸鱼是赚老板的钱！最后，祝愿天下所有摸鱼人，都能愉快的渡过每一天 !
        </p>


    </center>

    <br><br>
    <p align="right">摸鱼办 宣 </p>

</div>
</body>

</html>