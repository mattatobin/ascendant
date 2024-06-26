<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$PAGE_TITLE} - {$SITE_NAME}</title>
    <link rel="stylesheet" href="{$SKIN_PATH}/webfonts/red-hat-font.css" />
    <style>
      body {
        margin: 0px;
        background-color: #404040;
        background-image: radial-gradient(circle at 50% 85%, #dee6e8 0%, #c6ced1 80%, #b8cacc 100%),
                          radial-gradient(ellipse at 50% 100%, #ecf2f0 0%, #ecf2f080 50%, #00000000 100%);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position-x: center;
      }

      body, td, th {
        font-family: "RedHatText";
        font-size: 12pt;
        color: #000000;
      }

      /* ========================================================================== */

      a:link, a:active, a:visited {
        color: #0066cc;
        text-decoration: none;
      }

      a:hover {
        text-decoration: underline;
        color: #cc0000;
      }

      hr {
        border-top: 1px dotted #000;
        border-bottom: 0px #000;
        border-left: 0px #000;
        border-right: 0px #000;
        border-width: 1px;
      }

      .alignleft {
        float: left;
        text-align: left;
        margin-right: 10px;
      }

      .alignright {
        float: right;
        text-align: right;
        margin-left: 10px;
      }

      .aligncenter {
        display:block;
        margin-left:auto;
        margin-right:auto;
      }

      h1, h2, h3 {
        font-family: "RedHatDisplay";
        line-height: 100%;
        padding-bottom: 2px;
        margin: 0.5em auto;
      }

      h1, h2 {
        border-bottom: 1px solid #d6e5f5;
      }

      h1:first-of-type {
        margin-top: 10px;
      }

      /* ========================================================================== */

      .binoc-dwm-surface {
        background-color: #29456a !important;
      }

      /* ========================================================================== */

      #binoc-window {
        width: 1200px;
        min-width: 1200px;
        max-width: 1200px;
        margin: 0 auto;
        margin-top: 32px;
        border: 1px solid #5e81a6;
        box-shadow: inset 0px 0px 1px #212424;
        box-shadow: 0px 0px 20px rgba(0,0,0,0.40);
        transition: all 0.2s linear;
        padding: 0px;
      }

      /* ========================================================================== */

      #binoc-caption {
        height: 32px;
        margin-top: 0px;
        margin-left: 8px;
        margin-right: 8px;
        line-height: inital;
        text-align: left;
        color: #fff;
        font-size: 10pt;
        text-shadow: 0px 2px 2px black, 0px 1px 1px #000;
        overflow: hidden;
      }

      #binoc-caption p {
        margin: 0px;
        padding-top: 6px;
        font-size: 10pt;
        font-weight: bold;
      }

      /* ========================================================================== */

      #binoc-client {
        background-color: #fcfcfc;
        border-left: 1px solid #5e81a6;
        border-right: 1px solid #5e81a6;
        border-top: 1px solid #5e81a6;
        margin-top: 0px;
        margin-left: 2px;
        margin-right: 2px;
        margin-bottom: 0px;
        padding: 0px;
        overflow-x: hidden;
        min-height: 634px;
        height: 634px;
      }

      #binoc-client p {
        line-height: 125%;
      }

      /* ========================================================================== */

      #binoc-commandbar {
        height: 30px;
        max-height: 30px;
        background-color: #f5f6f7 !important;
        border-bottom: 1px solid #d7d7d7;
        margin: 0px;
        padding-top: 0px;
        font-size: 10pt;
        color: #1e395b;
        /* text-shadow: 0px 2px 2px black, 0px 1px 1px #000; */
        font-family: "RedHatDisplay";
      }

      #binoc-commandbar > ul {
        display: table;
        margin: 0px;
        padding: 0px;
      }

      #binoc-commandbar > ul > li {
        float: left;
        list-style: none;
        margin-top: 6px;
        margin-left: 12px;
        margin-bottom: 0px;
      }

      #binoc-commandbar > ul > li > a,
      #binoc-commandbar > ul > li > a:visited,
      #binoc-commandbar > ul > li > a:hover,
      #binoc-commandbar > ul > li > a:active {
        text-decoration: none;
      }

      #binoc-commandbar > ul > li > a,
      #binoc-commandbar > ul > li > a:visited {
        color: #1e395b;
        border: 1px solid transparent;
        padding-top: 2px;
        padding-left: 12px;
        padding-right: 12px;
        padding-bottom: 2px;
      }

      #binoc-commandbar > ul > li > a:hover {
        border: 1px solid #6dbde4;
        background-color: #dcebf4;
      }

      #binoc-commandbar > ul > li > a:active {
        border: 1px solid #26a0da;
        background-color: #c3e1f0;
      }

      #binoc-commandbar > ul > li > ul,
      #binoc-commandbar > ul > li > p {
        display: none;
      }

      /* ========================================================================== */

      #binoc-body {
        margin: 0px;
        display: table;
        width: 100%;
      }

      /* ========================================================================== */

      #binoc-content {
        display: table-cell;
        vertical-align: top;
        overflow-x: hidden;
        padding-top: 0px;
        padding-left: 12px;
        padding-right: 12px;
        padding-bottom: 0px;
      }

      /* ========================================================================== */

      #binoc-sidebar {
        display: table-cell;
        vertical-align: top;
        overflow-x: hidden;
        border-left: 1px solid #d6e5f5;
        min-height: 400px;
        min-width: 220px;
        max-width: 220px;
        width: 220px;

        padding-top: 0px;
        padding-left: 12px;
        padding-right: 12px;
        padding-bottom: 12px;
      }

      #binoc-sidebar > ul {
        list-style: none;
        padding-left: 0px;
      }

      #binoc-sidebar > ul > li {
        margin-bottom: 2px;
      }

      /* ========================================================================== */

      #binoc-statusbar {
        height: 20px;
        min-height: 20px;
        max-height: 20px;
        background-color: #f0f0f0 !important;
        border-top: 1px solid #d7d7d7;
        margin: 0px;
        font-size: 9pt;
        color: #000;
        font-family: "RedHatDisplay";
        border-left: 1px solid #5e81a6;
        border-right: 1px solid #5e81a6;
        border-bottom: 1px solid #5e81a6;
        margin-top: 0px;
        margin-left: 2px;
        margin-right: 2px;
        margin-bottom: 2px;
        padding-top: 2px;
        padding-left: 4px;
        padding-right: 4px;
      }

      /* ========================================================================== */

      #binoc-copyright {
        margin: 0 auto;
        font-size: 10pt;
        line-height: inital;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 1200px;
        min-width: 1200px;
        text-align: center;
        font-weight: bold;
        font-family: "RedHatDisplay";
        color: #fff;
        text-shadow: 0px 2px 2px black, 0px 1px 1px #000;
      }

      /* ========================================================================== */

      .fadeIn {
        animation: fade 0.4s;
      }

      @keyframes fade {
        from { opacity: 0; }
        to { opacity: 1; }
      }

      /* ========================================================================== */

      .special-textbox {
        width: 1190px;
        max-width: 1190px;
        height: 597px;
        max-height: 597px;
        margin: 0px;
        margin-left: -12px;
        padding: 0px;
        padding-top: 6px;
        padding-left: 6px;
        background-color: transparent;
        border: none;
        box-sizing: content-box !important;
        resize: none;
      }

      /* ========================================================================== */

      .clearfix:after {
        content: ".";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
      }
    </style>
  </head>
  <body>
    <div id="binoc-window" class="binoc-dwm-surface">
      <div id="binoc-caption">
        <p>{$PAGE_TITLE}</p>
      </div>
      <div id="binoc-client">
        <div id="binoc-commandbar"><ul>{$SITE_MENU}</ul></div>
        <div id="binoc-body"><div id="binoc-content" class="fadeIn">{$PAGE_CONTENT}</div></div>
      </div>
      <div id="binoc-statusbar">
        <span id="binoc-statustext" class="alignleft">{$PAGE_STATUS}</span>
        <span class="alignright" style="border-left: 1px solid #d7d7d7; padding-left: 2px; color: #a4a4a4"><em>{$SOFTWARE_VENDOR} {$SOFTWARE_NAME} {$SOFTWARE_VERSION}</em></span>
      </div>
    </div>
  </body>
</html>