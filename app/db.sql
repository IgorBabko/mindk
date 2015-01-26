-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Янв 26 2015 г., 04:17
-- Версия сервера: 5.5.34
-- Версия PHP: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `mindk`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'HTML'),
(2, 'CSS'),
(3, 'JavaScript'),
(5, 'PHP');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_title`, `author`, `text`, `created_date`) VALUES
(161, 'csss2', 'igor', '<br>\n            ', '2015-01-25 16:40:17'),
(162, 'csss2', 'igor', '<br>\n            ', '2015-01-25 16:40:19'),
(163, 'Convert HEX to RGB', 'igor', 'Well done!<br>\n            ', '2015-01-26 03:22:23'),
(160, 'csss2', 'igor', 'r\n            ', '2015-01-25 16:40:13'),
(159, 'csss2', 'igor', '\n            ', '2015-01-25 16:40:06');

-- --------------------------------------------------------

--
-- Структура таблицы `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `small_text` text NOT NULL,
  `text` text NOT NULL,
  `posted_date` datetime NOT NULL,
  `amount_of_comments` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `category`, `title`, `small_text`, `text`, `posted_date`, `amount_of_comments`) VALUES
(9, 'HTML', 'HTML5 Page Structure', '&lt;img src=&quot;/web/images/post_images/1.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;br /&gt;\r\n&lt;p&gt;Basic HTML5 document structure.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/1.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;br /&gt;\r\n&lt;p&gt;Basic HTML5 document structure.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;!DOCTYPE HTML&gt;\r\n\r\n&lt;html&gt;\r\n\r\n&lt;head&gt;\r\n	&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;\r\n	&lt;title&gt;Your Website&lt;/title&gt;\r\n&lt;/head&gt;\r\n\r\n&lt;body&gt;\r\n\r\n	&lt;header&gt;\r\n		&lt;nav&gt;\r\n			&lt;ul&gt;\r\n				&lt;li&gt;Your menu&lt;/li&gt;\r\n			&lt;/ul&gt;\r\n		&lt;/nav&gt;\r\n	&lt;/header&gt;\r\n	\r\n	&lt;section&gt;\r\n	\r\n		&lt;article&gt;\r\n			&lt;header&gt;\r\n				&lt;h2&gt;Article title&lt;/h2&gt;\r\n				&lt;p&gt;Posted on &lt;time datetime=&quot;2009-09-04T16:31:24+02:00&quot;&gt;September 4th 2009&lt;/time&gt; by &lt;a href=&quot;#&quot;&gt;Writer&lt;/a&gt; - &lt;a href=&quot;#comments&quot;&gt;6 comments&lt;/a&gt;&lt;/p&gt;\r\n			&lt;/header&gt;\r\n			&lt;p&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/p&gt;\r\n		&lt;/article&gt;\r\n		\r\n		&lt;article&gt;\r\n			&lt;header&gt;\r\n				&lt;h2&gt;Article title&lt;/h2&gt;\r\n				&lt;p&gt;Posted on &lt;time datetime=&quot;2009-09-04T16:31:24+02:00&quot;&gt;September 4th 2009&lt;/time&gt; by &lt;a href=&quot;#&quot;&gt;Writer&lt;/a&gt; - &lt;a href=&quot;#comments&quot;&gt;6 comments&lt;/a&gt;&lt;/p&gt;\r\n			&lt;/header&gt;\r\n			&lt;p&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/p&gt;\r\n		&lt;/article&gt;\r\n		\r\n	&lt;/section&gt;\r\n\r\n	&lt;aside&gt;\r\n		&lt;h2&gt;About section&lt;/h2&gt;\r\n		&lt;p&gt;Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.&lt;/p&gt;\r\n	&lt;/aside&gt;\r\n\r\n	&lt;footer&gt;\r\n		&lt;p&gt;Copyright 2009 Your name&lt;/p&gt;\r\n	&lt;/footer&gt;\r\n\r\n&lt;/body&gt;\r\n\r\n&lt;/html&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 00:47:59', 0),
(10, 'CSS', 'Common Unicode Icons', '&lt;img src=&quot;/web/images/post_images/2.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;br /&gt;\r\n&lt;p&gt;Some examples of common unicode icons.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/2.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;br /&gt;\r\n&lt;p&gt;Basic HTML5 document structure.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;h4&gt;CSS&lt;/h4&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;style&gt;\r\na[href^=&quot;mailto:&quot;]:before { content: &quot;\\2709&quot;; }\r\n.phone:before             { content: &quot;\\2706&quot;; }\r\n.important:before         { content: &quot;\\27BD&quot;; }\r\nblockquote:before         { content: &quot;\\275D&quot;; }\r\nblockquote:after          { content: &quot;\\275E&quot;; }\r\n.alert:before             { content: &quot;\\26A0&quot;; }\r\n&lt;/style&gt;\r\n&lt;/textarea&gt;\r\n&lt;h4&gt;HTML&lt;/h4&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;p&gt;\r\n  &lt;a href=&quot;mailto:chriscoyier@gmail.com&quot;&gt;\r\n    chriscoyier@gmail.com\r\n  &lt;/a&gt;\r\n&lt;/p&gt;\r\n\r\n&lt;p class=&quot;phone&quot;&gt;\r\n    555-555-5555\r\n&lt;/p&gt;\r\n\r\n&lt;p class=&quot;important&quot;&gt;\r\n  REMEMBER: drink slushies too fast.\r\n&lt;/p&gt;\r\n\r\n&lt;blockquote&gt;\r\n   Designers tend to whisper, ad agencies tend to shout.\r\n&lt;/blockquote&gt;\r\n\r\n&lt;p class=&quot;alert&quot;&gt;\r\n   Stranger Danger!\r\n&lt;p&gt;\r\n&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 02:07:58', 0),
(11, 'CSS', 'CSS Font Families', '&lt;img src=&quot;/web/images/post_images/3.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Some examples of CSS Font Families.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/css/css-font-families/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/3.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Some examples of CSS Font Families.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n\r\n&lt;h4&gt;Sans-Serif&lt;/h4&gt;\r\n\r\nArial, sans-serif;\r\nHelvetica, sans-serif;\r\nGill Sans, sans-serif;\r\nLucida, sans-serif;\r\nHelvetica Narrow, sans-serif;\r\nsans-serif;\r\n\r\n&lt;h4&gt;Serif&lt;/h4&gt;\r\n\r\nTimes, serif;\r\nTimes New Roman, serif;\r\nPalatino, serif;\r\nBookman, serif;\r\nNew Century Schoolbook, serif;\r\nserif;\r\n\r\n&lt;h4&gt;Monospace&lt;/h4&gt;\r\n\r\nAndale Mono, monospace;\r\nCourier New, monospace;\r\nCourier, monospace;\r\nLucidatypewriter, monospace;\r\nFixed, monospace;\r\nmonospace;\r\n\r\n&lt;h4&gt;Cursive&lt;/h4&gt;\r\n\r\nComic Sans, Comic Sans MS, cursive;\r\nZapf Chancery, cursive;\r\nCoronetscript, cursive;\r\nFlorence, cursive;\r\nParkavenue, cursive;\r\ncursive;\r\n\r\n&lt;h4&gt;Fantasy&lt;/h4&gt;\r\n\r\nImpact, fantasy;\r\nArnoldboecklin, fantasy;\r\nOldtown, fantasy;\r\nBlippo, fantasy;\r\nBrushstroke, fantasy;\r\nfantasy;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/css/css-font-families/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 02:29:07', 0),
(12, 'CSS', 'CSS Triangle', '&lt;img src=&quot;/web/images/post_images/4.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Learn to make triangles using CSS.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/css/css-triangle/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/4.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Learn to make triangles using CSS.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;h4&gt;HTML&lt;/h4&gt;\r\n&lt;p&gt;You can make them with a single div. It&#039;s nice to have classes for each direction possibility. &lt;/p&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;div class=&quot;arrow-up&quot;&gt;&lt;/div&gt;\r\n&lt;div class=&quot;arrow-down&quot;&gt;&lt;/div&gt;\r\n&lt;div class=&quot;arrow-left&quot;&gt;&lt;/div&gt;\r\n&lt;div class=&quot;arrow-right&quot;&gt;&lt;/div&gt;&lt;/textarea&gt;\r\n&lt;h4&gt;CSS&lt;/h4&gt;\r\n&lt;p&gt;The idea is a box with zero width and height. The actual width and height of the arrow is determined by the width of the border. In an up arrow, for example, the bottom border is colored while the left and right are transparent, which forms the triangle.&lt;/p&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;style&gt;\r\n.arrow-up {\r\n	width: 0; \r\n	height: 0; \r\n	border-left: 5px solid transparent;\r\n	border-right: 5px solid transparent;\r\n	\r\n	border-bottom: 5px solid black;\r\n}\r\n\r\n.arrow-down {\r\n	width: 0; \r\n	height: 0; \r\n	border-left: 20px solid transparent;\r\n	border-right: 20px solid transparent;\r\n	\r\n	border-top: 20px solid #f00;\r\n}\r\n\r\n.arrow-right {\r\n	width: 0; \r\n	height: 0; \r\n	border-top: 60px solid transparent;\r\n	border-bottom: 60px solid transparent;\r\n	\r\n	border-left: 60px solid green;\r\n}\r\n\r\n.arrow-left {\r\n	width: 0; \r\n	height: 0; \r\n	border-top: 10px solid transparent;\r\n	border-bottom: 10px solid transparent; \r\n	\r\n	border-right:10px solid blue; \r\n}\r\n&lt;/style&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/css/css-triangle/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 02:42:39', 0),
(13, 'JavaScript', '“Go Back” Button', '&lt;img src=&quot;/web/images/post_images/5.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Creating &quot;go back&quot; button using JavaScript.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/go-back-button/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/5.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Creating &quot;go back&quot; button using JavaScript.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;p&gt;Browsers already have &quot;back&quot; buttons, so you&#039;d better have a darn good reason for needing to put one on your page!&lt;/p&gt;\r\n&lt;h4&gt;Input button with inline JavaScript&lt;/h4&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;input type=&quot;button&quot; value=&quot;Go Back From Whence You Came!&quot; onclick=&quot;history.back(-1)&quot; /&gt;&lt;/textarea&gt;\r\n&lt;p&gt;This is totally obtrusive, but you could fix that by only appending this button through JavaScript.&lt;/p&gt;\r\n&lt;h4&gt;PHP&lt;/h4&gt;\r\n&lt;p&gt;If JavaScript isn&#039;t a possibility, you could use the HTTP_REFERER, sanitize it, and echo it out via PHP.&lt;/p&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;?php\r\n  $url = htmlspecialchars($_SERVER[&#039;HTTP_REFERER&#039;]);\r\n  echo &quot;&lt;a href=&#039;$url&#039;&gt;back&lt;/a&gt;&quot;; \r\n?&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/go-back-button/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 02:52:28', 0),
(14, 'JavaScript', 'Cookie Getter/Setter', '&lt;img src=&quot;/web/images/post_images/6.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Making cookie Getters/Setters&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/cookie-gettersetter/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/6.jpg&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Basic HTML5 document structure.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\n/**\r\n * Gets or sets cookies\r\n * @param name\r\n * @param value (null to delete or undefined to get)\r\n * @param options (domain, expire (in days))\r\n * @return value or true\r\n */\r\n_.cookie = function(name, value, options)\r\n{\r\n    if (typeof value === &quot;undefined&quot;) {\r\n        var n, v,\r\n            cookies = document.cookie.split(&quot;;&quot;);\r\n        for (var i = 0; i &lt; cookies.length; i++) {\r\n            n = $.trim(cookies[i].substr(0,cookies[i].indexOf(&quot;=&quot;)));\r\n            v = cookies[i].substr(cookies[i].indexOf(&quot;=&quot;)+1);\r\n            if (n === name){\r\n                return unescape(v);\r\n            }\r\n        }\r\n    } else {\r\n        options = options || {};\r\n        if (!value) {\r\n            value = &quot;&quot;;\r\n            options.expires = -365;\r\n        } else {\r\n            value = escape(value);\r\n        }\r\n        if (options.expires) {\r\n            var d = new Date();\r\n            d.setDate(d.getDate() + options.expires);\r\n            value += &quot;; expires=&quot; + d.toUTCString();\r\n        }\r\n        if (options.domain) {\r\n            value += &quot;; domain=&quot; + options.domain;\r\n        }\r\n        if (options.path) {\r\n            value += &quot;; path=&quot; + options.path;\r\n        }\r\n        document.cookie = name + &quot;=&quot; + value;\r\n    }\r\n};\r\n&lt;/script&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/cookie-gettersetter/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 02:58:52', 0),
(15, 'JavaScript', 'Format Currency', '&lt;img src=&quot;/web/images/post_images/7.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Function for format currency.&lt;/p&gt;\r\n&lt;p&gt;This function will round numbers to two decimal places, and ensure that the returned value has two decimal places. For example 12.006 will return 12.01, .3 will return 0.30, and 5 will return 5.00&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/format-currency/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/7.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Function for format currency.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\nfunction CurrencyFormatted(amount) {\r\n	var i = parseFloat(amount);\r\n	if(isNaN(i)) { i = 0.00; }\r\n	var minus = &#039;&#039;;\r\n	if(i &lt; 0) { minus = &#039;-&#039;; }\r\n	i = Math.abs(i);\r\n	i = parseInt((i + .005) * 100);\r\n	i = i / 100;\r\n	s = new String(i);\r\n	if(s.indexOf(&#039;.&#039;) &lt; 0) { s += &#039;.00&#039;; }\r\n	if(s.indexOf(&#039;.&#039;) == (s.length - 2)) { s += &#039;0&#039;; }\r\n	s = minus + s;\r\n	return s;\r\n}\r\n&lt;/script&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/javascript/format-currency/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 03:05:27', 0),
(16, 'PHP', 'Build a Calendar Table', '&lt;img src=&quot;/web/images/post_images/8.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Buildng a calendar table using PHP.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n\r\n&lt;a href=&quot;http://css-tricks.com/snippets/php/build-a-calendar-table/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/8.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;Buildng a calendar table using PHP.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;?php\r\n\r\nfunction build_calendar($month,$year,$dateArray) {\r\n\r\n     // Create array containing abbreviations of days of week.\r\n     $daysOfWeek = array(&#039;S&#039;,&#039;M&#039;,&#039;T&#039;,&#039;W&#039;,&#039;T&#039;,&#039;F&#039;,&#039;S&#039;);\r\n\r\n     // What is the first day of the month in question?\r\n     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);\r\n\r\n     // How many days does this month contain?\r\n     $numberDays = date(&#039;t&#039;,$firstDayOfMonth);\r\n\r\n     // Retrieve some information about the first day of the\r\n     // month in question.\r\n     $dateComponents = getdate($firstDayOfMonth);\r\n\r\n     // What is the name of the month in question?\r\n     $monthName = $dateComponents[&#039;month&#039;];\r\n\r\n     // What is the index value (0-6) of the first day of the\r\n     // month in question.\r\n     $dayOfWeek = $dateComponents[&#039;wday&#039;];\r\n\r\n     // Create the table tag opener and day headers\r\n\r\n     $calendar = &quot;&lt;table class=&#039;calendar&#039;&gt;&quot;;\r\n     $calendar .= &quot;&lt;caption&gt;$monthName $year&lt;/caption&gt;&quot;;\r\n     $calendar .= &quot;&lt;tr&gt;&quot;;\r\n\r\n     // Create the calendar headers\r\n\r\n     foreach($daysOfWeek as $day) {\r\n          $calendar .= &quot;&lt;th class=&#039;header&#039;&gt;$day&lt;/th&gt;&quot;;\r\n     } \r\n\r\n     // Create the rest of the calendar\r\n\r\n     // Initiate the day counter, starting with the 1st.\r\n\r\n     $currentDay = 1;\r\n\r\n     $calendar .= &quot;&lt;/tr&gt;&lt;tr&gt;&quot;;\r\n\r\n     // The variable $dayOfWeek is used to\r\n     // ensure that the calendar\r\n     // display consists of exactly 7 columns.\r\n\r\n     if ($dayOfWeek &gt; 0) { \r\n          $calendar .= &quot;&lt;td colspan=&#039;$dayOfWeek&#039;&gt;&amp;nbsp;&lt;/td&gt;&quot;; \r\n     }\r\n     \r\n     $month = str_pad($month, 2, &quot;0&quot;, STR_PAD_LEFT);\r\n  \r\n     while ($currentDay &lt;= $numberDays) {\r\n\r\n          // Seventh column (Saturday) reached. Start a new row.\r\n\r\n          if ($dayOfWeek == 7) {\r\n\r\n               $dayOfWeek = 0;\r\n               $calendar .= &quot;&lt;/tr&gt;&lt;tr&gt;&quot;;\r\n\r\n          }\r\n          \r\n          $currentDayRel = str_pad($currentDay, 2, &quot;0&quot;, STR_PAD_LEFT);\r\n          \r\n          $date = &quot;$year-$month-$currentDayRel&quot;;\r\n\r\n          $calendar .= &quot;&lt;td class=&#039;day&#039; rel=&#039;$date&#039;&gt;$currentDay&lt;/td&gt;&quot;;\r\n\r\n          // Increment counters\r\n \r\n          $currentDay++;\r\n          $dayOfWeek++;\r\n\r\n     }\r\n     \r\n     \r\n\r\n     // Complete the row of the last week in month, if necessary\r\n\r\n     if ($dayOfWeek != 7) { \r\n     \r\n          $remainingDays = 7 - $dayOfWeek;\r\n          $calendar .= &quot;&lt;td colspan=&#039;$remainingDays&#039;&gt;&amp;nbsp;&lt;/td&gt;&quot;; \r\n\r\n     }\r\n     \r\n     $calendar .= &quot;&lt;/tr&gt;&quot;;\r\n\r\n     $calendar .= &quot;&lt;/table&gt;&quot;;\r\n\r\n     return $calendar;\r\n\r\n}\r\n\r\n?&gt;&lt;/textarea&gt;\r\n&lt;h4&gt;Usage&lt;/h4&gt;\r\n&lt;p&gt;Build a calendar of the current month:&lt;/p&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;?php\r\n\r\n     $dateComponents = getdate();\r\n\r\n     $month = $dateComponents[&#039;mon&#039;]; 			     \r\n     $year = $dateComponents[&#039;year&#039;];\r\n\r\n     echo build_calendar($month,$year,$dateArray);\r\n\r\n?&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/php/build-a-calendar-table/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 03:11:10', 0),
(17, 'PHP', 'Convert HEX to RGB', '&lt;img src=&quot;/web/images/post_images/9.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;HEX to RGB conversion.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/php/convert-hex-to-rgb/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '&lt;img src=&quot;/web/images/post_images/9.png&quot; class=&quot;post-image&quot;/&gt;\r\n&lt;p&gt;HEX to RGB conversion.&lt;/p&gt;\r\n&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;\r\n&lt;p&gt;Give function hex code (e.g. #eeeeee), returns array of RGB values.&lt;/p&gt;\r\n&lt;textarea class=&quot;codeEditor&quot;&gt;\r\n&lt;?php\r\nfunction hex2rgb( $colour ) {\r\n        if ( $colour[0] == &#039;#&#039; ) {\r\n                $colour = substr( $colour, 1 );\r\n        }\r\n        if ( strlen( $colour ) == 6 ) {\r\n                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );\r\n        } elseif ( strlen( $colour ) == 3 ) {\r\n                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );\r\n        } else {\r\n                return false;\r\n        }\r\n        $r = hexdec( $r );\r\n        $g = hexdec( $g );\r\n        $b = hexdec( $b );\r\n        return array( &#039;red&#039; =&gt; $r, &#039;green&#039; =&gt; $g, &#039;blue&#039; =&gt; $b );\r\n}\r\n?&gt;&lt;/textarea&gt;\r\n&lt;a href=&quot;http://css-tricks.com/snippets/php/convert-hex-to-rgb/&quot; target=&quot;_blank&quot; class=&quot;source-link&quot;&gt;&lt;i&gt;Source link&lt;/i&gt;&lt;/a&gt;', '2015-01-26 03:20:14', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `role` enum('GUEST','USER','ADMIN') NOT NULL DEFAULT 'GUEST',
  `joined_date` datetime NOT NULL COMMENT 'Дата регистрации пользователя',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `picture_path`, `role`, `joined_date`) VALUES
(1, 'igor', 'igor@gmail.com', '9917142328fd36b9752158574cf4e90198b588d9af058877afc293ec027ac352', 'STAEeERkD2ezQhfGt888assiFaQZaHiS', NULL, 'ADMIN', '2015-01-25 20:11:03');
