-- phpMyAdmin SQL Dump
-- version 2.11.9.6
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Июл 04 2012 г., 14:11
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `promolike`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_modul`
--

CREATE TABLE IF NOT EXISTS `admin_modul` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `caption` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `redir` varchar(255) NOT NULL default '',
  `users` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `showinmenu` enum('1','0') NOT NULL default '1',
  `active` enum('1','0') NOT NULL default '1',
  `position` int(11) NOT NULL default '0',
  `template` varchar(255) default '',
  `index` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Дамп данных таблицы `admin_modul`
--

INSERT INTO `admin_modul` (`id`, `parent`, `caption`, `text`, `redir`, `users`, `file`, `showinmenu`, `active`, `position`, `template`, `index`) VALUES
(1, 0, 'Управление сайтом', '', 'start', 'God', '', '1', '1', 2, 'configs', '0'),
(2, 1, 'Раздeлы', '', 'sitemods', 'God::manager', 'site_mods', '1', '1', 3, 'simple_table_act', '1'),
(3, 1, 'Параметры', '', 'siteconfigs', 'God::manager', 'site_configs', '1', '1', 45, '', '0'),
(5, 1, 'Администраторы', '', 'admins', 'God', 'mod_admins', '1', '1', 7, '', '0'),
(6, 0, 'Смена пароля', '', 'set_pass', 'God::manager', 'set_pass', '0', '', 10, '', '0'),
(25, 1, 'Меню', '', '', 'God::manager', '', '1', '1', 0, '', '0'),
(43, 3, 'Таблица параметров', '', 'site_configs_table', 'God::manager', 'site_configs_table', '1', '1', 44, '', '0'),
(44, 1, 'Основные параметры', '', '', 'God::manager', '', '1', '1', 43, '', '0'),
(42, 50, 'Шаблоны', '', 'template', 'God::manager', 'mod_patern', '1', '1', 53, '', '0'),
(50, 0, 'Разработка', '<h1>Выберите нужный пункт слева</h1>', 'options', 'God', '', '1', '1', 52, 'simple', '0'),
(51, 50, 'Редактирования файлов', '', '', 'God', '', '1', '1', 49, '', '0'),
(52, 50, 'Управление CMS', '', '', 'God', '', '1', '1', 46, '', '0'),
(53, 50, 'Редактирование разделов', '', 'cms_content', 'God', 'simple_admin', '1', '1', 48, 'simple_table_act', '0'),
(54, 50, 'Модули', '', 'moduls_template', 'God', 'mod_patern_modules', '1', '1', 51, '', '0'),
(55, 50, 'Классы', '', 'includes_template', 'God', 'mod_patern_includes', '1', '1', 50, '', '0'),
(74, 5, 'Роли пользователей', '', 'role', 'God', 'role', '1', '1', 56, 'simple_table', '0'),
(75, 1, 'Права доступа', '', '', '', '', '1', '1', 4, '', '0'),
(76, 1, 'Дополнительные модули', '', '', '', '', '1', '1', 47, '', '0'),
(81, 1, 'Разделы новостей', '', 'section', '', 'adm_section', '1', '1', 57, 'simple_table', '0'),
(80, 1, 'Новости', '', 'news', '', 'adm_news', '1', '1', 58, 'simple_table', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_modul_acces`
--

CREATE TABLE IF NOT EXISTS `admin_modul_acces` (
  `id` int(11) NOT NULL auto_increment,
  `id_modul` int(11) NOT NULL default '0',
  `id_role` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `admin_modul_acces`
--

INSERT INTO `admin_modul_acces` (`id`, `id_modul`, `id_role`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, -1, 1),
(4, 25, 1),
(8, 25, 2),
(6, 2, 1),
(7, 2, 2),
(9, 73, 1),
(10, 73, 2),
(11, 75, 1),
(12, 5, 1),
(13, 74, 1),
(14, 44, 1),
(15, 44, 2),
(16, 3, 1),
(17, 3, 2),
(18, 43, 1),
(19, 50, 1),
(20, 52, 1),
(21, 53, 1),
(22, 76, 1),
(23, 76, 2),
(24, 77, 1),
(25, 77, 2),
(26, 78, 1),
(27, 78, 2),
(28, 79, 1),
(29, 79, 2),
(30, 80, 1),
(31, 80, 2),
(32, 81, 1),
(33, 81, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `admin_modul_configs`
--

CREATE TABLE IF NOT EXISTS `admin_modul_configs` (
  `id_admin_modul` int(11) NOT NULL auto_increment,
  `data` text NOT NULL,
  `active` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id_admin_modul`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `admin_modul_configs`
--

INSERT INTO `admin_modul_configs` (`id_admin_modul`, `data`, `active`) VALUES
(1, '<?xml version="1.0" encoding="UTF-8"?>\r\n<modul>\r\n	<fields>\r\n		<field>\r\n			<name>id</name>\r\n			<type>int</type>\r\n		</field>\r\n		<field>\r\n			<name>parent</name>\r\n			<type>int</type>\r\n		</field>\r\n		<field>\r\n			<name>caption</name>\r\n			<type>varchar</type>\r\n			<show>\r\n				<typeSearch>input</typeSearch>\r\n			</show>\r\n		</field>\r\n		<field>\r\n			<name>title</name>\r\n			<type>varchar</type>\r\n		</field>\r\n		<field>\r\n			<name>keywords</name>\r\n			<type>varchar</type>\r\n		</field>\r\n		<field>\r\n			<name>description</name>\r\n			<type>varchar</type>\r\n		</field>\r\n		<field>\r\n			<name>text</name>\r\n			<type>text</type>\r\n		</field>\r\n		<field>\r\n			<name>url</name>\r\n			<type>varchar</type>\r\n			<show>\r\n				<typeSearch>input</typeSearch>\r\n			</show>\r\n		</field>\r\n		<field>\r\n			<name>file</name>\r\n			<type>varchar</type>\r\n		</field>\r\n		<field>\r\n			<name>position</name>\r\n			<type>int</type>\r\n		</field>\r\n		<field>\r\n			<name>index</name>\r\n			<type>int</type>\r\n		</field>\r\n		<field>\r\n			<name>inmenu</name>\r\n			<type>int</type>\r\n		</field>\r\n		<field>\r\n			<name>active</name>\r\n			<type>int</type>\r\n		</field>\r\n	</fields>\r\n	<groupCheckbox>\r\n		<action>Все</action>\r\n		<action>Избранные</action>\r\n		<action>Выключенные</action>\r\n		<action>Включенные</action>\r\n	</groupCheckbox>\r\n	<groupActions>\r\n		<action>\r\n			<name>active</name>\r\n			<caption>Активировать</caption>\r\n		</action>\r\n		<action>\r\n			<name>inmenu</name>\r\n			<caption>Добавить в меню</caption>\r\n		</action>\r\n		<action>\r\n			<name>inmenu</name>\r\n			<caption>Удалить</caption>\r\n		</action>\r\n		<hide>\r\n			<action>\r\n				<name>archive</name>\r\n				<caption>Убрать в архив</caption>\r\n			</action>\r\n			<action>\r\n				<name>published</name>\r\n				<caption>Опубликовать</caption>\r\n			</action>\r\n		</hide>\r\n	</groupActions>\r\n	<actions>\r\n		<action>\r\n			<name>active</name>\r\n			<caption>Включить</caption>\r\n			<captionInvert>Выключить</captionInvert>\r\n		</action>\r\n		<action>\r\n			<name>inmenu</name>\r\n			<caption>Добавить в меню</caption>\r\n			<captionInvert>Убрать из меню</captionInvert>\r\n		</action>\r\n		<action>\r\n			<name>edit</name>\r\n			<caption>Редактировать</caption>\r\n		</action>\r\n	</actions>	\r\n</modul>', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `id_balance` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `unique_key` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_balance`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `balance`
--


-- --------------------------------------------------------

--
-- Структура таблицы `balance_history`
--

CREATE TABLE IF NOT EXISTS `balance_history` (
  `id_transaction` int(11) NOT NULL auto_increment,
  `id_balance` int(11) NOT NULL,
  `date_transaction` datetime NOT NULL,
  `message` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  PRIMARY KEY  (`id_transaction`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `balance_history`
--


-- --------------------------------------------------------

--
-- Структура таблицы `filter`
--

CREATE TABLE IF NOT EXISTS `filter` (
  `id_filter` int(11) NOT NULL auto_increment COMMENT 'id Фильтра',
  `id_user` int(11) NOT NULL default '0' COMMENT 'id пользователя',
  `caption` varchar(155) default NULL COMMENT 'название',
  `comparison_friends` int(1) NOT NULL COMMENT 'cравнение количества  друзей',
  `count_friends` int(11) NOT NULL COMMENT 'количество друзей',
  `comparison_messages` int(1) NOT NULL COMMENT 'сравнение количества сообщений',
  `count_messages` int(11) NOT NULL COMMENT 'количество сообщений',
  `activity` int(1) NOT NULL COMMENT 'активность',
  `budget` int(11) NOT NULL COMMENT 'бюджет',
  `usercoef` int(11) NOT NULL default '0' COMMENT 'коеффицент пользователя',
  `status` int(11) NOT NULL default '0' COMMENT 'Статус фильтры',
  `date` int(11) NOT NULL default '0' COMMENT 'дата создания',
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_filter`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Тут дописать все параметры необходимые для фильтра' AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `filter`
--

INSERT INTO `filter` (`id_filter`, `id_user`, `caption`, `comparison_friends`, `count_friends`, `comparison_messages`, `count_messages`, `activity`, `budget`, `usercoef`, `status`, `date`, `active`, `delete`) VALUES
(1, 6, 'новый фильтр', 0, 1000, 0, 300, 0, 1000, 0, 0, 1306135854, '1', '0'),
(2, 1, 'Мой первый фильтр', 1, 100, 0, 300, 0, 300, 0, 0, 1306864773, '1', '0'),
(3, 6, 'тестовый фильтр', 0, 150, 0, 2, 0, 1000, 0, 0, 1306905178, '1', '0'),
(4, 6, 'тестовый фильтр', 0, 150, 0, 2, 0, 1000, 0, 0, 1306905398, '1', '0'),
(5, 6, '', 0, 0, 0, 0, 0, 0, 0, 0, 1306906108, '1', '0'),
(6, 6, '''', 0, 0, 0, 0, 0, 0, 0, 0, 1306906155, '1', '0'),
(7, 6, '', 0, 0, 0, 0, 0, 0, 0, 0, 1306906169, '1', '0'),
(8, 5, 'qwerty', 0, 12, 1, 12, 0, 200, 0, 0, 1309604509, '1', '0'),
(9, 5, '12345', 0, 1, 0, 0, 0, 1000, 0, 0, 1309720432, '1', '0'),
(10, 5, '123', 0, 0, 0, 0, 0, 10, 0, 0, 1309759058, '1', '0'),
(11, 6, '7658678', 0, 45, 0, 56, 0, 567567, 0, 0, 1309776916, '1', '0'),
(12, 6, '11111111', 0, 0, 0, 0, 0, 0, 0, 0, 1309777083, '1', '0'),
(13, 1, 'Новый фильтр', 1, 100, 0, 2000, 0, 2000, 0, 0, 1309801135, '1', '0'),
(14, 6, 'facebook', 0, 0, 0, 56, 0, 1000, 0, 0, 1311137601, '1', '0'),
(15, 5, 'asd', 0, 1, 0, 2, 0, 333, 0, 0, 1311187498, '1', '0'),
(16, 5, 'qwertyuiop', 0, 3, 0, 4, 0, 100, 0, 0, 1311187679, '1', '0'),
(17, 5, 'тест', 0, 1000, 0, 1000, 0, 1000000, 0, 0, 1315951337, '1', '0'),
(18, 5, 'новый фильтр', 1, 12, 1, 50, 2, 1, 0, 0, 1316016960, '1', '0'),
(19, 5, 'еще один фильтр', 0, 2, 0, 6, 0, 2, 0, 0, 1316017005, '1', '0'),
(20, 5, 'new', 0, 3, 0, 4, 1, 125, 0, 0, 1316075227, '1', '0'),
(21, 5, 'фильтр 2', 0, 12, 0, 1, 0, 123, 0, 0, 1316075325, '1', '0'),
(22, 5, 'фильтр 3', 0, 1, 1, 2, 0, 444, 0, 0, 1316077857, '1', '0'),
(23, 1, 'Начальный фильтр', 1, 300, 1, 2334, 2, 3000, 0, 0, 1316099734, '1', '0'),
(24, 1, 'Фильтр', 1, 222, 0, 3232, 1, 4, 0, 0, 1316099802, '1', '0'),
(25, 6, 'новый фильтр 1', 0, 0, 0, 34, 1, 567567, 0, 0, 1317723566, '1', '0'),
(26, 6, '4764567', 0, 400, 0, 0, 0, 436, 0, 0, 1317723669, '1', '0'),
(27, 5, 'aaaa', 0, 1, 0, 2, 1, 333, 0, 0, 1317725657, '1', '0'),
(28, 6, '10.11', 1, 890, 0, 377, 2, 100, 0, 0, 1320935613, '1', '0'),
(29, 5, 'aaaaaaaaaaaaa', 0, 123, 0, 33, 1, 234, 0, 0, 1321097800, '1', '0'),
(30, 5, 'qq', 0, 1, 0, 1, 0, 1, 0, 0, 1322215653, '1', '0'),
(31, 5, 'qqqqqqqqqqqqqqqqqqqqqq', 0, 2, 0, 2, 1, 44, 0, 0, 1322215692, '1', '0'),
(32, 5, 'wghgjyuisd', 0, 1, 0, 1, 0, 2222, 0, 0, 1322215922, '1', '0'),
(33, 5, 'jjjjjjjjjjjjjjjjjjjjj', 0, 2, 0, 2, 0, 333333, 0, 0, 1322215995, '1', '0'),
(34, 5, 'asdfghjkl', 0, 23, 0, 2, 0, 444, 0, 0, 1322216053, '1', '0'),
(35, 5, 'минимальный фильтр', 0, 2, 0, 3, 1, 1000, 0, 0, 1322227153, '1', '0'),
(36, 6, 'новый фильтр 3', 0, 56, 1, 97, 1, 567567, 0, 0, 1322562523, '1', '0'),
(37, 5, 'тестовый фильтр 6', 0, 2, 1, 2, 1, 1111, 0, 0, 1322569243, '1', '0'),
(38, 5, 'тестовый фильтр 7', 0, 1, 0, 1, 0, 222, 0, 0, 1322569287, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `id_like` int(11) NOT NULL auto_increment COMMENT 'id Лайка',
  `id_place` int(11) NOT NULL default '0' COMMENT 'id место размещения',
  `id_user_place` int(11) NOT NULL COMMENT 'id user публикации лайка',
  `id_page` int(11) NOT NULL default '0' COMMENT 'id Страницы',
  `id_text_like` int(11) NOT NULL default '0' COMMENT 'id Текста',
  `status` int(11) NOT NULL default '0' COMMENT 'Статус лайка',
  `url` varchar(255) NOT NULL COMMENT 'URL лайка',
  `like_text` text NOT NULL COMMENT 'текст лайка',
  `date_creation` int(11) NOT NULL COMMENT 'Дата создания',
  `date_placed` int(11) NOT NULL default '0' COMMENT 'дата размещения',
  `count` int(11) NOT NULL default '0' COMMENT 'количество переходов по лайку',
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_like`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Лайк' AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `like`
--

INSERT INTO `like` (`id_like`, `id_place`, `id_user_place`, `id_page`, `id_text_like`, `status`, `url`, `like_text`, `date_creation`, `date_placed`, `count`, `active`, `delete`) VALUES
(1, 2, 5, 8, 28, 4, '45622', 'Минтранс исключает версию крушения Як-42 из-за не отключённого тормоза', 1331477489, 1331477489, 0, '1', '0'),
(2, 0, 0, 8, 28, 2, '45622aa', 'Минтранс исключает версию крушения Як-42 из-за не отключённого тормоза', 1335124410, 0, 0, '1', '0'),
(3, 2, 1, 23, 17, 3, 'qwerty2', 'документы, регулирующие отношения между .masterhost и клиентами.', 1335009598, 1335128683, 0, '1', '0'),
(4, 2, 12, 23, 18, 3, 'qwerty2', 'в этом разделе мы рекомендуем вам удобное и проверенное в работе программное обеспечение известных фирм, а также, собственные утилиты для облегчения вашей работы над проектами.', 1335009598, 1335128683, 0, '1', '0'),
(5, 3, 5, 25, 19, 3, 'qwerty45', 'список клиентов, приглашенных вами по акции «Хостинг для настоящих друзей».', 1335009599, 1335128683, 0, '1', '0'),
(7, 2, 5, 25, 21, 3, 'qwerty45', 'список клиентов, приглашенных вами по акции «Хостинг для настоящих друзей».', 1335009600, 1335128683, 0, '1', '0'),
(8, 2, 1, 22, 16, 3, 'Array', 'qqqqqqqq wwwwwwwwwww', 1335012988, 1335128683, 0, '1', '0'),
(10, 0, 0, 8, 28, 2, '45622aa', 'Минтранс исключает версию крушения Як-42 из-за не отключённого тормоза', 1335124410, 0, 0, '1', '0'),
(11, 0, 0, 8, 29, 2, '45622aa', 'Вратарь Габулов дебютирует за ЦСКА в матче Лиги чемпионов с "Лиллем"', 1335124497, 0, 0, '1', '0'),
(20, 3, 5, 51, 67, 3, 'http://oriflame-klass.ru/', 'Скидки 23%! Акции! Заработок с Орифлейм здесь! Сделаем бизнес вместе!', 1341394098, 1341395548, 0, '1', '0'),
(21, 3, 0, 51, 67, 1, '', '', 1341394098, 0, 0, '1', '0'),
(13, 3, 5, 1, 64, 3, 'http://yandex.ru hh', 'В сегодняшнем номере газеты \\"Коммерсантъ\\" опубликовано интервью с председателем Центризбиркома Владимиром Чуровым. Он рассказал о явке избирателей, своем отношении к интернет-голосованию и агитации, и наотрез отказался отвечать на вопросы, связанные, на', 1335132022, 1338815660, 0, '1', '0'),
(14, 3, 5, 1, 25, 3, 'http://yandex.ru hh', 'Рижское «Динамо» начало сезон КХЛ с поражения', 1335279763, 1338815660, 0, '1', '0'),
(15, 2, 17, 53, 69, 3, 'http://oriflame-klass.ru/nasha-komanda/', 'Скидки 23%! Акции! Стань консультантом! Поможем зарабатывать с Oriflame!', 1338815518, 1340720482, 0, '1', '0'),
(16, 2, 0, 53, 69, 2, '', '', 1338815518, 0, 0, '1', '0'),
(17, 2, 5, 53, 69, 3, 'http://oriflame-klass.ru/nasha-komanda/', 'Скидки 23%! Акции! Стань консультантом! Поможем зарабатывать с Oriflame!', 1338815518, 1340720483, 0, '1', '0'),
(18, 2, 0, 53, 69, 2, '', '', 1338815518, 0, 0, '1', '0'),
(19, 2, 0, 53, 69, 2, '', '', 1338815518, 0, 0, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `like_history`
--

CREATE TABLE IF NOT EXISTS `like_history` (
  `id_likehistory` int(11) NOT NULL auto_increment,
  `id_like` int(11) NOT NULL COMMENT 'id Лайка',
  `id_place` int(11) NOT NULL default '0' COMMENT 'id место размещения',
  `id_user_place` int(11) NOT NULL COMMENT 'id user публикации лайка',
  `id_page` int(11) NOT NULL default '0' COMMENT 'id Страницы',
  `id_text_like` int(11) NOT NULL default '0' COMMENT 'id Текста',
  `status` int(11) NOT NULL default '0' COMMENT 'Статус лайка',
  `url` varchar(255) NOT NULL COMMENT 'URL лайка',
  `like_text` text NOT NULL COMMENT 'текст лайка',
  `date_creation` int(11) NOT NULL COMMENT 'Дата создания',
  `date_placed` int(11) NOT NULL default '0' COMMENT 'дата размещения',
  `count` int(11) NOT NULL default '0' COMMENT 'количество переходов по лайку',
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_likehistory`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='История изменений лайков' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `like_history`
--

INSERT INTO `like_history` (`id_likehistory`, `id_like`, `id_place`, `id_user_place`, `id_page`, `id_text_like`, `status`, `url`, `like_text`, `date_creation`, `date_placed`, `count`, `active`, `delete`) VALUES
(1, 13, 3, 5, 1, 64, 3, 'http://yandex.ru hh', 'В сегодняшнем номере газеты "Коммерсантъ" опубликовано интервью с председателем Центризбиркома Владимиром Чуровым. Он рассказал о явке избирателей, своем отношении к интернет-голосованию и агитации, и наотрез отказался отвечать на вопросы, связанные, на', 1335132022, 1338815660, 0, '1', '0'),
(2, 14, 3, 5, 1, 25, 3, 'http://yandex.ru hh', 'Рижское «Динамо» начало сезон КХЛ с поражения', 1335279763, 1338815660, 0, '1', '0'),
(3, 15, 2, 17, 53, 69, 3, 'http://oriflame-klass.ru/nasha-komanda/', 'Скидки 23%! Акции! Стань консультантом! Поможем зарабатывать с Oriflame!', 1338815518, 1340720482, 0, '1', '0'),
(4, 17, 2, 5, 53, 69, 3, 'http://oriflame-klass.ru/nasha-komanda/', 'Скидки 23%! Акции! Стань консультантом! Поможем зарабатывать с Oriflame!', 1338815518, 1340720483, 0, '1', '0'),
(5, 20, 3, 5, 51, 67, 3, 'http://oriflame-klass.ru/', 'Скидки 23%! Акции! Заработок с Орифлейм здесь! Сделаем бизнес вместе!', 1341394098, 1341395548, 0, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id_page` int(11) NOT NULL auto_increment COMMENT 'id Страницы',
  `id_project` int(11) NOT NULL default '0' COMMENT 'id Проекта',
  `id_user` int(11) NOT NULL default '0' COMMENT 'id пользователя',
  `caption` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL COMMENT 'Адрес страницы',
  `text` text NOT NULL,
  `position` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `active` enum('1','0') NOT NULL default '0',
  `delete_page` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Страницы проектов' AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id_page`, `id_project`, `id_user`, `caption`, `url`, `text`, `position`, `date`, `active`, `delete_page`) VALUES
(1, 1, 5, 'текстовая страинца', 'http://yandex.ru hh', '', 1, 0, '1', '0'),
(2, 2, 6, 'Главная страница', 'http://mediamove.ru/', '', 2, 0, '0', '0'),
(3, 3, 1, 'Первая страница', 'http://www.yandex.ru/', '', 3, 0, '0', '0'),
(4, 5, 6, 'Страница новой кампании', 'Тут типа адрес', '', 4, 0, '0', '0'),
(5, 2, 6, 'ачаитчатап', 'чартвартьвпрь', '', 5, 0, '0', '0'),
(6, 4, 6, '346573567', '56гу56735', '', 6, 0, '0', '0'),
(7, 1, 5, 'aaa', 'aaaaaaaaaaaaaaaaaaaaaaaa', '', 7, 0, '0', '1'),
(8, 1, 5, 'qwerty11', '45622aa', '', 8, 0, '0', '0'),
(9, 1, 5, 'asd', '', '', 9, 0, '0', '1'),
(10, 6, 9, 'Моя страница', 'http://promolike.ru/project.php?id_project=6&action=add_page', '', 10, 0, '0', '0'),
(11, 6, 9, 'а ', 'а ', '', 11, 0, '0', '0'),
(12, 1, 5, 'test 2', 'test 2 url', '', 12, 0, '0', '1'),
(13, 1, 5, 'qwerty3', '312321312', '', 13, 0, '0', '1'),
(14, 1, 5, 'adsadas', 'asdasda', '', 14, 0, '0', '1'),
(15, 1, 5, 'qqqqqqqqq', 'qq', '', 15, 0, '0', '1'),
(16, 1, 5, 'asd', '', '', 16, 0, '0', '1'),
(17, 1, 5, 'ff', '', '', 17, 0, '0', '1'),
(18, 1, 5, 'asdfg', 'sadsadsads', '', 18, 0, '0', '1'),
(19, 1, 5, 'eeeeee', 'eeeeee', '', 19, 0, '0', '1'),
(20, 1, 5, 'zzzzz', 'zzzzz', '', 20, 0, '0', '1'),
(21, 1, 5, 'xxxxx', 'xxxxx', '', 21, 0, '0', '1'),
(22, 7, 5, 'qqqqq', 'Array', '', 22, 0, '1', '0'),
(23, 7, 5, 'qwerty2', 'qwerty2', '', 23, 0, '1', '0'),
(24, 7, 5, 'qwerty3', 'qwerty3', '', 24, 0, '1', '0'),
(25, 7, 5, 'qwerty4', 'qwerty45', '', 25, 0, '1', '0'),
(26, 7, 5, 'wer', 'adas', '', 26, 0, '1', '0'),
(27, 1, 5, 'ййй', '', '', 27, 0, '0', '1'),
(28, 1, 5, '', '', '', 28, 0, '0', '1'),
(29, 1, 5, '', '', '', 29, 0, '0', '1'),
(30, 1, 5, '', '', '', 30, 0, '0', '1'),
(31, 1, 5, '', '', '', 31, 0, '0', '1'),
(32, 1, 5, 'вфывфы', '', '', 32, 0, '0', '1'),
(33, 1, 5, 'ф', '', '', 33, 0, '0', '1'),
(34, 8, 1, 'Создание сайтов', 'http://future-group.ru/create/', '', 34, 0, '0', '0'),
(35, 8, 1, 'Создание сайтов (1)', 'http://future-group.ru/create/', '', 35, 0, '0', '0'),
(36, 8, 1, 'Раскрутка сайтов', 'http://future-group.ru/seo/', '', 36, 0, '0', '0'),
(37, 1, 5, 'qqq', '', '', 37, 0, '0', '1'),
(38, 1, 5, 'qqq', '', '', 38, 0, '0', '1'),
(39, 1, 5, 'qqq', '', '', 39, 0, '0', '1'),
(40, 9, 6, 'Хостинг wlw', 'http://wlw.su/?page=tarif', '', 40, 0, '0', '0'),
(41, 1, 5, 'мой сайт', 'http://ya.ruq', '', 41, 0, '1', '0'),
(42, 6, 9, 'ва цй', 'пц ', '', 42, 0, '0', '0'),
(43, 1, 5, 'qqqq', 'q', '', 43, 0, '0', '0'),
(44, 1, 5, 'qq', 'qqqqqqqqqqqqq', '', 44, 0, '0', '0'),
(45, 1, 5, 'qqq', 'qqqqqqqqqqqqq', '', 45, 0, '0', '0'),
(46, 1, 5, 'qqqqqqqqqqqqqqqq', 'qqq', '', 46, 0, '0', '0'),
(47, 1, 5, 'abst', 'qq', '', 47, 0, '0', '0'),
(48, 12, 5, 'qqqqqqqqqq', 'rrrrrrrrrrrrrrrrrrrrrrrrrr', '', 48, 0, '0', '0'),
(49, 13, 5, 'главная', 'http://future-group.ru/', '', 49, 0, '0', '0'),
(50, 13, 5, 'портфолио', 'http://future-group.ru/portfolio/', '', 50, 0, '0', '0'),
(51, 14, 5, 'главная', 'http://oriflame-klass.ru/', '', 51, 0, '0', '0'),
(52, 14, 5, 'каталоги', 'http://oriflame-klass.ru/catalog-oriflame/', '', 52, 0, '0', '0'),
(53, 14, 5, 'консультанты', 'http://oriflame-klass.ru/nasha-komanda/', '', 53, 0, '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `page_filter`
--

CREATE TABLE IF NOT EXISTS `page_filter` (
  `id_filter` int(11) NOT NULL auto_increment COMMENT 'id фильтра',
  `id_page` int(11) NOT NULL default '0' COMMENT 'id страницы',
  `id_user` int(11) NOT NULL default '0' COMMENT 'id пользователя',
  `price_filter` int(11) NOT NULL default '0' COMMENT 'общая цена по фильтру',
  `price` int(11) NOT NULL default '0' COMMENT 'цена по фильтру на которую закупили',
  `status` int(11) NOT NULL default '0' COMMENT 'Статус фильтра',
  `date` int(11) NOT NULL default '0' COMMENT 'дата создания',
  `active` enum('1','0') NOT NULL default '1',
  `delete_page` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_filter`,`id_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `page_filter`
--

INSERT INTO `page_filter` (`id_filter`, `id_page`, `id_user`, `price_filter`, `price`, `status`, `date`, `active`, `delete_page`) VALUES
(1, 2, 6, 0, 0, 0, 1306135860, '1', '0'),
(2, 3, 1, 0, 0, 0, 1306864776, '1', '0'),
(3, 2, 6, 0, 0, 0, 1306905281, '1', '0'),
(4, 6, 6, 0, 0, 0, 1306906099, '1', '0'),
(6, 2, 6, 0, 0, 0, 1306906180, '1', '0'),
(16, 22, 5, 0, 0, 0, 1314956462, '1', '0'),
(10, 23, 5, 0, 0, 0, 1314956446, '1', '0'),
(12, 2, 6, 0, 0, 0, 1309777178, '1', '0'),
(11, 2, 6, 0, 0, 0, 1309777201, '1', '0'),
(5, 2, 6, 0, 0, 0, 1309777659, '1', '0'),
(4, 2, 6, 0, 0, 0, 1309777720, '1', '0'),
(17, 8, 5, 0, 0, 0, 1315951337, '1', '1'),
(13, 3, 1, 0, 0, 0, 1309801143, '1', '0'),
(14, 2, 6, 0, 0, 0, 1311137615, '1', '0'),
(8, 8, 5, 0, 0, 0, 1311193470, '1', '0'),
(9, 9, 5, 0, 0, 0, 1311193459, '1', '0'),
(18, 8, 5, 0, 0, 0, 1316016961, '1', '1'),
(19, 1, 5, 0, 0, 0, 1316017005, '1', '0'),
(20, 1, 5, 0, 0, 0, 1316075227, '1', '0'),
(21, 8, 5, 0, 0, 0, 1316075325, '1', '1'),
(22, 8, 5, 0, 0, 0, 1316077857, '1', '1'),
(23, 34, 1, 0, 0, 0, 1316099734, '1', '0'),
(24, 34, 1, 0, 0, 0, 1316099802, '1', '0'),
(25, 40, 6, 0, 0, 0, 1317723566, '1', '0'),
(26, 40, 6, 0, 0, 0, 1317723669, '1', '0'),
(27, 1, 5, 0, 0, 0, 1317725657, '1', '1'),
(28, 2, 6, 0, 0, 0, 1320935613, '1', '0'),
(29, 1, 5, 0, 0, 0, 1321097800, '1', '1'),
(30, 1, 5, 0, 0, 0, 1322215653, '1', '1'),
(31, 1, 5, 0, 0, 0, 1322215692, '1', '1'),
(32, 1, 5, 0, 0, 0, 1322215922, '1', '1'),
(33, 1, 5, 0, 0, 0, 1322215995, '1', '1'),
(34, 1, 5, 0, 0, 0, 1322216053, '1', '1'),
(8, 1, 5, 0, 0, 0, 1322230007, '1', '1'),
(9, 1, 5, 0, 0, 0, 1322230156, '1', '1'),
(10, 1, 5, 0, 0, 0, 1322230273, '1', '1'),
(15, 1, 5, 0, 0, 0, 1322230303, '1', '1'),
(16, 1, 5, 0, 0, 0, 1322230413, '1', '1'),
(18, 1, 5, 0, 0, 0, 1322241285, '1', '1'),
(17, 1, 5, 0, 0, 0, 1322241382, '1', '1'),
(37, 1, 5, 0, 0, 0, 1322569243, '1', '0'),
(38, 8, 5, 0, 0, 0, 1322569287, '1', '0'),
(26, 2, 6, 0, 0, 0, 1328068249, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `place`
--

CREATE TABLE IF NOT EXISTS `place` (
  `id_place` int(11) NOT NULL auto_increment COMMENT 'id Площадки',
  `id_type_placed` int(11) NOT NULL default '0' COMMENT 'id типа площадки',
  `id_user` int(11) NOT NULL default '0' COMMENT 'id пользователя',
  `status` int(11) NOT NULL default '0' COMMENT 'Статус площадки',
  `date` int(11) NOT NULL default '0' COMMENT 'дата создания',
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  `caption` varchar(155) default NULL,
  PRIMARY KEY  (`id_place`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Место размещения лайков' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `place`
--


-- --------------------------------------------------------

--
-- Структура таблицы `place_param`
--

CREATE TABLE IF NOT EXISTS `place_param` (
  `id_place` int(11) NOT NULL default '0',
  `id_type_placed` int(11) NOT NULL default '0',
  `id_user` int(11) NOT NULL default '0',
  `social_id` varchar(155) default NULL,
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_place`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Параметры площадки размещения';

--
-- Дамп данных таблицы `place_param`
--


-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` int(11) NOT NULL auto_increment COMMENT 'id Проекта',
  `id_user` int(11) NOT NULL default '0' COMMENT 'id пользователя',
  `caption` varchar(155) NOT NULL COMMENT 'Название проекта',
  `text` text NOT NULL,
  `position` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0' COMMENT 'Дата создания',
  `active` enum('1','0') NOT NULL default '1',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_project`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Проекты рекламодателей' AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id_project`, `id_user`, `caption`, `text`, `position`, `date`, `active`, `delete`) VALUES
(1, 5, 'первая компания', '', 1, 1306108617, '1', '0'),
(2, 6, 'mediamoveенре', '', 2, 1306135470, '1', '0'),
(3, 1, 'Новая компания', '', 3, 1306864692, '1', '0'),
(4, 6, 'Еще одна страница', '', 4, 1306905483, '1', '0'),
(5, 6, 'Новая кампания', '', 5, 1306905597, '1', '0'),
(6, 9, '***', '', 6, 1312744911, '1', '0'),
(7, 5, 'тестовая компания', '', 7, 1314882756, '1', '0'),
(8, 1, 'Future-Group.ru', '', 8, 1316098651, '1', '0'),
(9, 6, 'Кампания 04.10.2011', '', 9, 1317722235, '1', '0'),
(10, 13, 'Первая компания', '', 10, 1331115114, '1', '0'),
(11, 5, 'вторая тестовая компания', '', 11, 1331225365, '1', '0'),
(12, 5, 'aaaaaaaaaaaaaaaaaaa', '', 12, 1335280126, '1', '0'),
(13, 5, 'future-group', '', 13, 1338810031, '1', '0'),
(14, 5, 'oriflame', '', 14, 1338813476, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `proxy`
--

CREATE TABLE IF NOT EXISTS `proxy` (
  `id` int(11) NOT NULL auto_increment,
  `proxy` varchar(255) NOT NULL,
  `key` varchar(255) default NULL,
  `position` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '1000',
  `active` enum('1','0') NOT NULL default '1',
  `last_used` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `proxy`
--

INSERT INTO `proxy` (`id`, `proxy`, `key`, `position`, `count`, `active`, `last_used`) VALUES
(1, 'proxy_user117:Th8xLR06FG@46.243.181.17:3128', 'user=kusolofo9897&key=03.115793110:3747464f8fff3156341ee797b8c5783a', 1, 886, '1', 1340361451),
(2, 'proxy_user117:Th8xLR06FG@46.243.181.18:3128', 'user=covusyca2856&key=03.115793128:ef0af69e2e3001ded5a7aee93cdf4f4c', 2, 902, '1', 1340361216),
(3, 'proxy_user117:Th8xLR06FG@46.243.181.19:3128', 'user=poviwoho809&key=03.115793139:62d3967237c4277910ce77e69cc4a5ee', 3, 891, '1', 1340361218),
(4, 'proxy_user117:Th8xLR06FG@46.243.181.20:3128', 'user=goforyqo1446&key=03.115793150:9f719c89b2ca26e47b378425383fcd69', 4, 881, '1', 1340361220),
(5, 'proxy_user117:Th8xLR06FG@46.243.181.21:3128', 'user=kenuboba6473&key=03.115793168:687f2b6cdba82fba76126972abdbc433', 5, 893, '1', 1340361221),
(6, 'proxy_user117:Th8xLR06FG@46.243.181.22:3128', 'user=venaqofe7355&key=03.115793183:c6c4e76fd571375cee87e13e6c96facc', 6, 892, '1', 1340361221),
(7, 'proxy_user117:Th8xLR06FG@46.243.181.23:3128', 'user=puwexaxi4279&key=03.115793201:0d11ae745602e59ffaf0277206d1a0d7', 7, 887, '1', 1340361222),
(8, 'proxy_user117:Th8xLR06FG@46.243.181.24:3128', 'user=narawytu7045&key=03.115793226:57ec585dc0a636c760a186e2d4d71194', 8, 900, '1', 1340361448),
(9, 'proxy_user117:Th8xLR06FG@46.243.181.25:3128', 'user=wudegonu5518&key=03.115793245:62d2c19b39437cb82bb3d5c13eb45725', 9, 885, '1', 1340361449),
(10, 'proxy_user117:Th8xLR06FG@46.243.181.26:3128', 'user=zyzivobi2471&key=03.115793270:cf5d37b8378989f3e0c619cac9ac5930', 10, 885, '1', 1340361448),
(11, 'proxy_user117:Th8xLR06FG@46.243.181.27:3128', 'user=pewilile6245&key=03.115793279:56d7a9daf505304471e1815add81dce8', 11, 888, '1', 1340361451),
(12, 'proxy_user117:Th8xLR06FG@46.243.181.28:3128', 'user=kinagysy9770&key=03.115793290:ec8b3707a009268c43b7e8edcfe51c99', 12, 881, '1', 1340361449),
(13, 'proxy_user117:Th8xLR06FG@46.243.181.29:3128', 'user=dyverato7020&key=03.115793311:2edaaeb02adeba9cc73961a5a6cf0bfb', 13, 892, '1', 1340361451),
(14, 'proxy_user117:Th8xLR06FG@46.243.181.30:3128', 'user=vulotyle6629&key=03.115793323:7423c8891bd87daeb0d18bd3d4decf2b', 14, 895, '1', 1340361452),
(15, 'proxy_user117:Th8xLR06FG@46.243.181.31:3128', 'user=lagakovo4657&key=03.115793335:f7e85208576b402874091fe0cefc0995', 15, 885, '1', 1340361215),
(16, 'proxy_user117:Th8xLR06FG@46.243.181.32:3128', 'user=rujojaja7999&key=03.115793355:cc98083ba47c22ecf27ee532dbd715a8', 16, 886, '1', 1340361216),
(17, 'proxy_user117:Th8xLR06FG@46.243.181.33:3128', 'user=fulacequ8217&key=03.115793366:e02caf05162c12b48f8004e2729839e4', 17, 898, '1', 1340361216),
(18, 'proxy_user117:Th8xLR06FG@46.243.181.34:3128', 'user=kexafely1303&key=03.115793386:4cd80bace060f0aabf276149e55cfb85', 18, 887, '1', 1340361217),
(19, 'proxy_user117:Th8xLR06FG@46.243.181.35:3128', 'user=myrumuzo6075&key=03.115793400:bdd0b2115ac00246bd0b52d4bdbcd3d7', 19, 883, '1', 1340361219),
(20, 'proxy_user117:Th8xLR06FG@46.243.181.36:3128', 'user=qofesogo9654&key=03.115793412:989de9487880d18a940b3dd9a615fae2', 20, 883, '1', 1340361219),
(21, 'proxy_user117:Th8xLR06FG@46.243.181.37:3128', 'user=likywuqi1907&key=03.115793430:69c875af7b99d9c37592cddcdf18d5e1', 21, 907, '1', 1340361219),
(22, 'proxy_user117:Th8xLR06FG@46.243.181.38:3128', 'user=reqeqabu5665&key=03.115793448:b1512db931ce6900acc05e8137dc3ad1', 22, 907, '1', 1340361220),
(23, 'proxy_user117:Th8xLR06FG@46.243.181.39:3128', 'user=xezusume8391&key=03.115793463:9fb5a655f5b30e0ab3e27f1e4bd9ca39', 23, 901, '1', 1340361220),
(24, 'proxy_user117:Th8xLR06FG@46.243.181.40:3128', 'user=hasamulu499&key=03.115793491:fc611fba333cfb1d1c71671965405a35', 24, 893, '1', 1340361448),
(25, 'proxy_user117:Th8xLR06FG@46.243.181.41:3128', 'user=havawoka9598&key=03.115793496:fdf1baa73a228d191ee430549a5bfc95', 25, 887, '1', 1340361448),
(26, 'proxy_user117:Th8xLR06FG@46.243.181.42:3128', 'user=gylyxebi1796&key=03.115793516:5a54e9a943fdf6bdc2a1ac1dbfa099fb', 26, 868, '1', 1340361449),
(27, 'proxy_user117:Th8xLR06FG@46.243.181.43:3128', 'user=fyfybozi7807&key=03.115793533:213ac2cc0756ab573087325b4ce9f6f2', 27, 887, '1', 1340361217),
(28, 'proxy_user117:Th8xLR06FG@46.243.181.44:3128', 'user=gilucovy9538&key=03.115793552:84a948126be0282b47ca5e949dfc9d92', 28, 873, '1', 1340361217),
(29, 'proxy_user117:Th8xLR06FG@46.243.181.45:3128', 'user=pexolyri7890&key=03.115793566:9d4171b019ed6c15696968eee249eb17', 29, 1000, '', 1340361221),
(30, 'proxy_user117:Th8xLR06FG@46.243.181.46:3128', 'user=lolacasu12&key=03.115793580:dde9157b0988a0401ea316b9f0f1002b', 30, 1000, '', 1340361449),
(31, 'proxy_user117:Th8xLR06FG@46.243.181.51:3128', 'user=sukicoza8735&key=03.115793663:ff90985cb7f6fe8f6925692a599aafc3', 31, 1000, '0', 1340361449),
(32, 'proxy_user117:Th8xLR06FG@46.243.181.52:3128', 'user=midyhywi6041&key=03.115793674:b4212f9ad86ba4ff43c82fcdbb96ee6c', 32, 1000, '0', 1340361452),
(33, 'proxy_user117:Th8xLR06FG@46.243.181.53:3128', 'user=jifegipa7061&key=03.115793699:95748c9d43edf2b9f6f055cb5a92d442', 33, 1000, '0', 1340361216),
(34, 'proxy_user117:Th8xLR06FG@46.243.181.54:3128', 'user=nevicypy7841&key=03.115793721:15203f4754a8d2a86e2af81a94f22f62', 34, 1000, '0', 1340361218),
(35, 'proxy_user117:Th8xLR06FG@46.243.181.55:3128', 'user=rarufisi6149&key=03.115793739:0f4715265cb95a0197cf32e895d7c237', 35, 1000, '0', 1340361221),
(36, 'proxy_user117:Th8xLR06FG@46.243.181.57:3128', 'user=tavinejo4307&key=03.115793778:253f3b50a15cce5136fd7e5155f8913c', 36, 1000, '0', 1340361450),
(37, 'proxy_user117:Th8xLR06FG@46.243.181.58:3128', 'user=mizyqiqi2065&key=03.115793797:01f79f4f25a42e9b21577de23499867c', 37, 1000, '0', 1340361216),
(38, 'proxy_user117:Th8xLR06FG@46.243.181.59:3128', 'user=qibaledi8752&key=03.115793806:971259f1e2b5e23bf93d9cc989c2642d', 38, 1000, '0', 1340361221),
(39, 'proxy_user117:Th8xLR06FG@46.243.181.60:3128', 'user=qarygete9557&key=03.115793822:ad9d9cf48dada191fdba9a7183b72ebe', 39, 1000, '0', 1340361450),
(40, 'proxy_user117:Th8xLR06FG@46.243.181.61:3128', 'user=raseqyde8765&key=03.115793838:dc5156a34acc5c20f8d2a138c093d8a7', 40, 1000, '0', 1340361450),
(41, 'proxy_user117:Th8xLR06FG@178.170.149.111:3128', 'user=saw654bg&key=03.95515262:c397c99a66d43b9e1249239dea04c94f', 41, 1000, '0', 1340361451),
(42, 'proxy_user117:Th8xLR06FG@178.170.149.112:3128', 'user=bvg58bnh&key=03.95515326:04d0be03580dc912d972ac9fc6462bee', 42, 1000, '0', 1340361452),
(43, 'proxy_user117:Th8xLR06FG@178.170.149.113:3128', 'user=et67h84h&key=03.95515405:7962d5a2f3dea32a39943a276d2471ee', 43, 1000, '0', 1340361218),
(44, 'proxy_user117:Th8xLR06FG@178.170.149.114:3128', 'user=fhv6354b&key=03.95515446:d962eb06664df5da9f6e486a97c57879', 44, 1000, '0', 1340361219),
(45, 'proxy_user117:Th8xLR06FG@178.170.149.115:3128', 'user=bfh68thn&key=03.95515521:1187407febe63adbef59764d4db11261', 45, 1000, '0', 1340361219),
(46, 'proxy_user117:Th8xLR06FG@178.170.149.116:3128', 'user=bvg684bg&key=03.95515576:35f40e82786d8d5e3110ec51991ea618', 46, 1000, '0', 1340361451),
(47, 'proxy_user117:Th8xLR06FG@178.170.149.117:3128', 'user=mv635ch6&key=03.95515637:237081004e725afcd7a3ed2a898db57b', 47, 1000, '0', 1340361220),
(48, 'proxy_user117:Th8xLR06FG@178.170.149.118:3128', 'user=cnh08nh6&key=03.95515715:32c58a8be9bc5fc07893b2d2a1fcd524', 48, 1000, '0', 1340361450),
(49, 'proxy_user117:Th8xLR06FG@178.170.149.119:3128', 'user=nfhw546c&key=03.95515790:ac7c8c4675b89e2ff3e242464839c072', 49, 1000, '0', 1340361215),
(50, 'proxy_user117:Th8xLR06FG@178.170.149.120:3128', 'user=nfg27556g&key=03.95515844:389d82f4ed17e925c190d412e3e43d39', 50, 1000, '0', 1340361217);

-- --------------------------------------------------------

--
-- Структура таблицы `site_administrator`
--

CREATE TABLE IF NOT EXISTS `site_administrator` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `role` int(11) NOT NULL default '2',
  `login` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `active` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `site_administrator`
--

INSERT INTO `site_administrator` (`id`, `name`, `role`, `login`, `password`, `email`, `active`) VALUES
(1, 'Nikita Shevlyakov', 1, 'admin', 'db2e38e6ad4ec55eaf214db5aa1e65ff', 'shevlyakov.nikita@gmail.com', '1'),
(2, 'Manager', 2, 'manager', '8c755726c8143cd7d54e9ab542a37e74', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `site_administrator_role`
--

CREATE TABLE IF NOT EXISTS `site_administrator_role` (
  `id` int(11) NOT NULL auto_increment,
  `role` varchar(255) NOT NULL default '',
  `active` enum('1','0') NOT NULL default '1',
  `position` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `site_administrator_role`
--

INSERT INTO `site_administrator_role` (`id`, `role`, `active`, `position`) VALUES
(1, 'administartor', '1', 1),
(2, 'manager', '1', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `site_config`
--

CREATE TABLE IF NOT EXISTS `site_config` (
  `id` int(11) NOT NULL auto_increment,
  `param` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  `active` enum('1','0') NOT NULL default '1',
  `caption` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `site_config`
--

INSERT INTO `site_config` (`id`, `param`, `value`, `active`, `caption`) VALUES
(5, 'phone1', '(495)627-64-93', '1', 'Телефон первый'),
(6, 'phone2', '(926)825-99-54', '1', 'Телефон второй'),
(3, 'email', 'info@fspartak.ru', '1', 'Администраторские емайлы'),
(8, 'footer', '<div class="logo-black bg">&nbsp;</div>\r\n<div class="site-create"><a target="_blank" href="http://future-group.ru/">Изготовление сайтов</a> - Future-Group</div>', '1', 'Футер'),
(12, 'phone3', '(499)409-41-32', '1', 'Телефон 3'),
(9, 'losung', 'Сайт фанатов спартака', '1', 'Лозунг'),
(11, 'special', '<a href="/spetspredlozheniya/2-metra-za-poltora/">Перила от производителя два метра за полтора.</a>', '1', 'Спецпредложение');

-- --------------------------------------------------------

--
-- Структура таблицы `site_modul`
--

CREATE TABLE IF NOT EXISTS `site_modul` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `caption` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `keywords` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `redir` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `position` int(11) NOT NULL default '0',
  `index` enum('0','1') NOT NULL default '0',
  `inmenu` enum('1','0') NOT NULL default '1',
  `active` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Дамп данных таблицы `site_modul`
--

INSERT INTO `site_modul` (`id`, `parent`, `caption`, `title`, `keywords`, `description`, `text`, `redir`, `file`, `position`, `index`, `inmenu`, `active`) VALUES
(1, 0, 'Главная', 'Сайт фанатов Спартака', 'Сайт фанатов Спартака', 'Сайт фанатов Спартака', '', '', 'main', 1, '1', '1', '1'),
(50, 0, 'Новости', 'Новости', '', '', '', 'novosti', 'news', 10, '0', '1', '1'),
(51, 0, 'Турниры', 'Турниры', '', '', '', 'tyrniry', 'text', 11, '0', '1', '1'),
(52, 0, 'Отчеты', 'Отчеты', '', '', '', 'otcheti', 'text', 12, '0', '1', '1'),
(53, 0, 'Блог', 'Блог', '', '', '', 'blog', 'text', 13, '0', '1', '1'),
(54, 0, 'Фото', 'Фото', '', '', '', 'foto', 'text', 14, '0', '1', '1'),
(55, 0, 'Стадион', 'Стадион', '', '', '', 'stadion', 'text', 15, '0', '1', '1'),
(56, 0, 'Трансляции', 'Трансляции', '', '', '', 'translyacii', 'text', 16, '0', '1', '1'),
(57, 0, 'Контакты', 'Контакты', '', '', '', 'kontakti', 'text', 17, '0', '0', '1'),
(58, 0, 'Реклама', 'Реклама', '', '', '', 'reklama', 'text', 18, '0', '0', '1'),
(49, 48, 'Перила из нержавейки', 'Перила из нержавейки', '', '', '<h1>Перила из нержавейки (нержавеющей стали).</h1>\r\n<p align="justify">Лестничные перила просто необходимы для безопасного  перемещения, с помощью них человек избегает случайных падений. Перила  также  обеспечивают удобство в процессе спуска и подъема. Что же  касается эстетической роли перил во внешнем оформлении лестницы, то она  имеет огромное значение, поэтому перилам отводится едва ли не большее  внимание, чем самой лестнице.</p>\r\n<script type="text/javascript" src="/js/price.js"></script> <script type="text/javascript" src="/js/highslide.js"></script>\r\n<p>\r\n<link href="/styles/highslide.css" type="text/css" rel="stylesheet" /> <script type="text/javascript">\r\n	hs.graphicsDir = "/images/graphics/";\r\n</script></p>\r\n<table style="margin: auto;">\r\n    <tbody>\r\n        <tr>\r\n            <td>\r\n            <div class="item_price item_price_nm"><a onclick="return hs.expand(this)" id="bjpg" href="/images/price/7/foto_1.jpg">\r\n            <div style="text-align: left;" class="item_zoom">&nbsp;</div>\r\n            <img alt="" style="background-image: url(&quot;/images/price/7/small_foto_1.jpg&quot;);" class="big" src="/images/spacer.gif" /> 				</a> 				<i> 											<img width="70px" class="miniImage mini_active" adrb="/images/price/7/foto_1.jpg" adrm="/images/price/7/small_foto_1.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/7/small2_foto_1.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 											<img width="70px" class="miniImage " adrb="/images/price/7/foto_2.jpg" adrm="/images/price/7/small_foto_2.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/7/small2_foto_2.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 											<img width="70px" class="miniImage " adrb="/images/price/7/foto_3.jpg" adrm="/images/price/7/small_foto_3.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/7/small2_foto_3.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 										 				</i></div>\r\n            </td>\r\n            <td>\r\n            <div class="price_text">\r\n            <h2>Перила 2 ригеля</h2>\r\n            <div class="main_price">от  <span>3500</span>  руб за м/п под ключ</div>\r\n            <div class="price_caption">\r\n            <div class="price_caption_title">Описание:</div>\r\n            <p>поручень - труба 50,8 мм<br />\r\n            стойка - труба 38,1 мм<br />\r\n            ригель - труба 16 мм - 2 шт.<br />\r\n            комплектующие</p>\r\n            </div>\r\n            </div>\r\n            </td>\r\n            <td style="padding: 0pt 0pt 0pt 25px;">\r\n            <div class="item_price item_price_nm"><a onclick="return hs.expand(this)" id="bjpg" href="/images/price/3/foto_1.jpg">\r\n            <div class="item_zoom">&nbsp;</div>\r\n            <img alt="" style="background-image: url(&quot;/images/price/3/small_foto_1.jpg&quot;);" class="big" src="/images/spacer.gif" /> 				</a>  				<i> 											<img width="70px" class="miniImage mini_active" adrb="/images/price/3/foto_1.jpg" adrm="/images/price/3/small_foto_1.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/3/small2_foto_1.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 											<img width="70px" class="miniImage " adrb="/images/price/3/foto_2.jpg" adrm="/images/price/3/small_foto_2.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/3/small2_foto_2.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 											<img width="70px" class="miniImage " adrb="/images/price/3/foto_3.jpg" adrm="/images/price/3/small_foto_3.jpg" src="/images/spacer.gif" style="background: url(&quot;/images/price/3/small2_foto_3.jpg&quot;) repeat scroll 0% 0% transparent;" alt="" /> 										 				</i></div>\r\n            </td>\r\n            <td>\r\n            <div class="price_text">\r\n            <h2>Перила 3 ригеля</h2>\r\n            <div class="main_price">от  <span>4500</span>  руб за м/п под ключ</div>\r\n            <div class="price_caption">\r\n            <div class="price_caption_title">Описание:</div>\r\n            <p>поручень - труба 50,8 мм <br />\r\n            стойка - труба 38,1 мм <br />\r\n            ригель - труба 16 мм -&nbsp;3 шт.<br />\r\n            комплектующие</p>\r\n            </div>\r\n            </div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="4">\r\n            <p><span style="font-size: 16px; line-height: 30px;">Остальные работы наших мастеров и цены на них представлены в разделах <a href="/perila/foto/">галерея</a> и <a href="/money/">цены</a>. По всем возникающим вопросам звоните по телефонам <b>{configs.phone1}</b>, <b>{configs.phone3}</b></span><span style="font-size: 16px; line-height: 30px;">, <b>{configs.phone2}</b></span><span style="font-size: 16px; line-height: 30px;">.</span></p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p align="justify">Согласно нормам техники безопасности, перилами  оснащаются все марши, имеющие более 3 ступеней. Если лестница узкая, то  есть ее ширина не больше 125 см, то перила можно установить только с  одной стороны. На широких лестницах для обеспечения прохода людей вверх и  вниз одновременно перила устанавливаются с обеих сторон. Высота перил  должна быть не менее 90 см, а расстояние между стойками  - не более 15  см. Хотя все эти показатели могут варьироваться в зависимости  от того,  для кого предназначена лестница, на которую Вы собираетесь установить  перила. Например, оптимальное расстояние между стойками перил лестницы,  которой будут пользоваться и дети,  - 10-12 см. Если Вы хотите, чтобы  Ваша лестница была безопасна в эксплуатации, позвоните специалистам  &laquo;Mst-stroy&raquo;, они проконсультируют Вас по всем имеющимся вопросам и  установят перила согласно всем правилам.</p>\r\n<p align="justify">Перила для лестниц могут быть металлическими, из  нержавеющей стали, алюминия, дерева, бетона, а также из различного  сочетания этих материалов с высокопрочным стеклом. &laquo;Mst-story&raquo;  специализируется на ограждениях из различных видов металла: Ст-3, перила  из нержавеющей стали, алюминия, бронзы. Наша практика показала, что из  выбранного металла можно изготовить разнообразные перильные ограждения  на лестницы с любым основанием.</p>\r\n<h2>Крепление перил из нержавейки.</h2>\r\n<p>Перила из нержавейки от &laquo;Mst-stroy&raquo; подойдут к любым видам лестниц,  независимо от материала из которого они сделаны (металл, бетон или  дерево). Если лестница (ступени) деревянная, то ограждения крепятся с  помощью специальных фланцев на саморезы либо при помощи болтовых  соединений. К металлическим лестницам (ступеням)  - с помощью болтовых  соединений или сварки. В бетонных лестницах система крепления перил  следующая - либо в процессе заливки монтируются специальные закладные,  либо перила крепятся с помощью химических анкеров или же непосредственно  в основание лестничного марша при помощи специальных растворов или  клеев.</p>\r\n<div align="justify">&nbsp;</div>\r\n<center>\r\n<table>\r\n    <tbody>\r\n        <tr>\r\n            <td><img width="190" src="/images/gallery/13/perila-iz-nerjaveiki (6).jpg" alt="перила нержавейка" title="перила из нержавеющей стали" style="margin: 5px 18px; float: left;" />	 <img width="190" src="/images/gallery/20/perila-iz-nerjaveiki (14).jpg" alt="нержавеющие перила" title="нержавеющие перила" style="margin: 5px 18px; float: left;" />	 <img width="190" src="/images/gallery/43/perila-iz-nerjaveiki (41).jpg" alt="перила из нержавейки" title="Офис. Перила из нержавейки." style="margin: 5px 18px; float: left;" /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</center>\r\n<p align="justify">Для изготовления перил из нержавейки, алюминиевых  перил можно использовать трубы различного диаметра, листовые детали,  профили и т.д.  Ограждениям можно придать любую конфигурацию согласно  окружающему интерьеру и Вашим требованиям.</p>\r\n<p align="justify">Перила из нержавейки универсальны и подойдут к интерьеру любого современного помещения - от гаража до крупного торгового центра.</p>', '', '', 9, '0', '1', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `social_set`
--

CREATE TABLE IF NOT EXISTS `social_set` (
  `id_social_set` int(11) NOT NULL auto_increment COMMENT 'id соц. сети',
  `name` varchar(255) NOT NULL,
  `active` enum('1','0') NOT NULL default '1',
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id_social_set`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `social_set`
--

INSERT INTO `social_set` (`id_social_set`, `name`, `active`, `position`) VALUES
(1, 'Facebook', '0', 0),
(2, 'Вконтакте', '1', 0),
(3, 'Twiter', '1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `social_set_filter`
--

CREATE TABLE IF NOT EXISTS `social_set_filter` (
  `id_social_set` int(11) NOT NULL default '0' COMMENT 'id соц. сети',
  `id_filter` int(11) NOT NULL default '0' COMMENT 'id фильтра',
  PRIMARY KEY  (`id_social_set`,`id_filter`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `social_set_filter`
--

INSERT INTO `social_set_filter` (`id_social_set`, `id_filter`) VALUES
(1, 8),
(1, 11),
(1, 20),
(1, 21),
(1, 25),
(1, 31),
(1, 36),
(2, 2),
(2, 8),
(2, 11),
(2, 19),
(2, 20),
(2, 22),
(2, 25),
(2, 27),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 34),
(2, 36),
(2, 38),
(3, 8),
(3, 11),
(3, 18),
(3, 19),
(3, 20),
(3, 25),
(3, 31);

-- --------------------------------------------------------

--
-- Структура таблицы `social_set_text_like`
--

CREATE TABLE IF NOT EXISTS `social_set_text_like` (
  `id_social_set` int(11) NOT NULL default '0' COMMENT 'id соц. сети',
  `id_text_like` int(11) NOT NULL default '0' COMMENT 'id текста страницы',
  `count` int(11) NOT NULL,
  `active` enum('1','0') character set utf8 NOT NULL,
  PRIMARY KEY  (`id_social_set`,`id_text_like`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `social_set_text_like`
--

INSERT INTO `social_set_text_like` (`id_social_set`, `id_text_like`, `count`, `active`) VALUES
(2, 16, 0, '1'),
(2, 17, 0, '1'),
(2, 18, 0, '1'),
(2, 21, 0, '1'),
(2, 25, 0, '1'),
(2, 27, 0, '1'),
(2, 48, 0, '1'),
(2, 60, 0, '1'),
(2, 62, 0, '1'),
(2, 63, 0, '1'),
(2, 65, 0, '1'),
(3, 17, 0, '1'),
(3, 18, 0, '1'),
(3, 19, 0, '1'),
(3, 25, 0, '1'),
(3, 61, 0, '1'),
(3, 62, 0, '1'),
(3, 64, 0, '1'),
(2, 66, 5, '1'),
(3, 66, 5, '0'),
(2, 67, 5, '0'),
(2, 68, 5, '1'),
(2, 69, 5, '1'),
(3, 67, 2, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `text_like`
--

CREATE TABLE IF NOT EXISTS `text_like` (
  `id_text_like` int(11) NOT NULL auto_increment COMMENT 'id текст',
  `id_page` int(11) NOT NULL default '0' COMMENT 'id Страницы',
  `caption` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL COMMENT 'картинка текста',
  `text_like` varchar(255) NOT NULL COMMENT 'текст лайка',
  `date_placed` int(11) NOT NULL default '0' COMMENT 'дата создания',
  `count_max` int(11) NOT NULL default '0' COMMENT 'количество макс использования',
  `count` int(11) NOT NULL default '0' COMMENT 'количество использования',
  `active` enum('1','0') NOT NULL default '1',
  `publick_active` enum('0','1') NOT NULL,
  `delete_page` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_text_like`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Лайк' AUTO_INCREMENT=70 ;

--
-- Дамп данных таблицы `text_like`
--

INSERT INTO `text_like` (`id_text_like`, `id_page`, `caption`, `image`, `text_like`, `date_placed`, `count_max`, `count`, `active`, `publick_active`, `delete_page`) VALUES
(1, 17, 'wewqewq', 'e', 'text', 0, 0, 0, '1', '0', '1'),
(2, 7, 'wqewqewq', 'wqewqe', 'ewqewqewq', 0, 0, 0, '1', '0', '0'),
(3, 19, 'wqe', 'eee', 'eee', 0, 0, 0, '1', '0', '0'),
(4, 2, 'тестовый заголовок 1', 'i2.jpg', 'Продвижение сайта по лучшей цене!', 0, 0, 0, '1', '0', '1'),
(45, 2, 'Тестовый заголовок', 'i3.jpg', 'Тут описание', 0, 0, 0, '1', '0', '0'),
(5, 3, 'Мой первый лайк', 'http://yabs.yandex.ru/resource/08KPQKfokY6zUIMYJ8xtLg.png', 'это мой самый первый первый лайк', 0, 0, 0, '1', '0', '1'),
(6, 4, 'Тут типа заголовок', 'Адрес картинки', 'Бла бла бла', 0, 0, 0, '1', '0', '0'),
(7, 4, 'Тут второй заголовок', 'Адрес картины', 'Тут бла бла бла', 0, 0, 0, '1', '0', '0'),
(8, 5, 'впрьвпртьпть', 'сптоьаполангл', 'впорароаробаробарбнрвеарн', 0, 0, 0, '1', '0', '0'),
(9, 6, '35645г6н', 'о467океро', 'кенокеровпкнголпаролаполаплернотен55555555', 0, 0, 0, '1', '0', '0'),
(10, 7, 'sASa', 'A', 'AA', 0, 0, 0, '1', '0', '0'),
(11, 8, 'AAA', '', '', 0, 0, 0, '1', '0', '1'),
(12, 9, 'sdfgh', '', '', 0, 0, 0, '1', '0', '0'),
(13, 10, 'Новость 1 ', '', '', 0, 0, 0, '1', '0', '0'),
(14, 10, '', '', '', 0, 0, 0, '1', '0', '0'),
(15, 11, '', '', '', 0, 0, 0, '1', '0', '0'),
(16, 22, 'qqqq', '', 'qqqqqqqq wwwwwwwwwww', 0, 0, 0, '1', '0', '0'),
(17, 22, 'test1', '', 'документы, регулирующие отношения между .masterhost и клиентами.', 0, 0, 0, '1', '0', '0'),
(18, 23, 'test2', '', 'в этом разделе мы рекомендуем вам удобное и проверенное в работе программное обеспечение известных фирм, а также, собственные утилиты для облегчения вашей работы над проектами.', 0, 0, 0, '1', '0', '0'),
(19, 25, 'список 1', '', 'список клиентов, приглашенных вами по акции «Хостинг для настоящих друзей».', 0, 0, 0, '1', '0', '0'),
(20, 25, 'список 2', '', 'список клиентов, приглашенных вами по акции «Хостинг для настоящих друзей».', 0, 0, 0, '1', '0', '0'),
(21, 25, 'список 3', '', 'список клиентов, приглашенных вами по акции «Хостинг для настоящих друзей».', 0, 0, 0, '1', '0', '0'),
(22, 1, 'новый текст', 'q', 'Работа по подготовке к Олимпийским играм 2014 года в Сочи по всем направлениям идет по заранее спланированному графику, сообщил в среду на пресс-конференции по итогам визита координационной комиссии МОК вице-премьер РФ Дмитрий Козак.', 0, 0, 0, '1', '0', '1'),
(23, 1, 'Зенит', '', '"Зенит" проиграл первый матч в Лиге чемпионов', 0, 0, 0, '1', '0', '1'),
(24, 1, 'Президент России поздравил российскую сборную', '', 'Президент России поздравил российскую сборную по пляжному футболу', 0, 0, 0, '1', '0', '1'),
(25, 1, 'Рижское «Динамо»', 'Tulips.jpg', 'Рижское «Динамо» начало сезон КХЛ с поражения', 0, 0, 0, '0', '0', '0'),
(26, 8, 'Руководство', '', 'Руководство "Факела" не приняло отставку Байдачного и Сарсании', 0, 0, 0, '1', '0', '1'),
(27, 8, 'Прохоров не исключил ', '1319802166.jpg', 'Прохоров не исключил ухода с поста лидера партии', 0, 0, 0, '0', '0', '0'),
(28, 8, 'Минтранс исключает', 'Chrysanthemum.jpg', 'Минтранс исключает версию крушения Як-42 из-за не отключённого тормоза', 0, 0, 0, '1', '0', '0'),
(29, 8, 'Вратарь Габулов', 'Hydrangeas.jpg', 'Вратарь Габулов дебютирует за ЦСКА в матче Лиги чемпионов с "Лиллем"', 0, 0, 0, '1', '0', '0'),
(30, 8, 'Медведев в Twitter', '', 'Медведев в Twitter поблагодарил всех за поздравления с днем рождения', 0, 0, 0, '0', '0', '1'),
(31, 34, 'Сайт "под ключ" 15000 рублей', '', 'Качественный дизайн, CMS, хостинг и домен бесплатно, большое портфолио. ', 0, 0, 0, '1', '0', '0'),
(32, 34, 'Создание сайта за 3999 руб!', '', 'Акция: создание сайта за 1 день + подарок на 1500 руб! ', 0, 0, 0, '1', '0', '0'),
(33, 34, 'Создание сайтов со скидкой до 30%', '', 'Отличный сайт всего 7000 руб.! Дизайн. CMS. Домен, хостинг в подарок!', 0, 0, 0, '1', '0', '0'),
(34, 1, 'qwerty', 'Penguins.jpg', 'qqq', 0, 0, 0, '1', '0', '1'),
(35, 1, 'qwerty11', 'Tulips.jpg', 'aaaa', 0, 0, 0, '1', '0', '1'),
(36, 1, 'qwertyйцу', 'Koala.jpg', 'фывап', 0, 0, 0, '1', '0', '1'),
(37, 1, 'Валерий', 'Koala.jpg', 'Валерий Непомнящий покинул «Томь»', 0, 0, 0, '0', '0', '0'),
(38, 1, 'У Вячеслава Малафеева', 'Jellyfish.jpg', 'У Вячеслава Малафеева усилились боли после травмы', 0, 0, 0, '1', '0', '0'),
(39, 8, 'Фильм Михалкова', 'Desert.jpg', 'Фильм Михалкова "Цитадель" выдвинут на премию "Оскар" от России', 0, 0, 0, '0', '0', '0'),
(40, 8, 'К катастрофе Ту-134', 'Tulips.jpg', 'К катастрофе Ту-134 под Петрозаводском привела череда фатальных ошибок', 0, 0, 0, '0', '0', '0'),
(41, 1, 'qwerty', 'Chrysanthemum.jpg', 'ads', 0, 0, 0, '1', '0', '1'),
(42, 1, 'qwerty', 'Lighthouse.jpg', 'AASDSA', 0, 0, 0, '1', '0', '1'),
(43, 1, 'zzzzzz', 'Tulips.jpg', 'zzzzzzzzzzzzzzzzzzzz', 0, 0, 0, '1', '0', '1'),
(44, 1, 'mamay', 'Penguins.jpg', 'mamay1986mamay1986', 0, 0, 0, '1', '0', '1'),
(46, 40, 'Хостинг за рубль', 'i1.jpg', 'У нас самый пиздатый хостинг', 0, 0, 0, '1', '0', '0'),
(47, 40, 'Хостинг за рубль', 'i3.jpg', '', 0, 0, 0, '1', '0', '0'),
(48, 1, 'Суд санкционировал арест следователя Дмитриевой', 'i.jpg', 'Пресненский районный суд Москвы в среду санкционировал арест старшего следователя Главного следственного управления ГУ МВД РФ по Москве майора юстиции Нелли Дмитриевой. Под стражей она останется до 24 ноября 2011 года, передает РАПСИ.', 0, 0, 0, '0', '0', '0'),
(49, 1, 'Спартак', 'qq.jpg', 'Глава КДК Владимир Катков заявил, что при принятии данной санкции КДК \\"опирался на регламент, где прописано, что подобные нарушения караются четырехматчевой дисквалификацией\\". Однако он уточнил, что в случае если \\"красно-белые\\" подадут апелляцию с про', 0, 0, 0, '1', '0', '0'),
(52, 8, 'Владимир Катков', 'picture.jpg', 'Владимир Катков: Пареха дисквалифицирован на четыре матча', 0, 0, 0, '0', '0', '0'),
(50, 1, 'Владимир Катков: "Столкновения Веллитона с Акинфеевым', '', 'Владимир Катков: "Столкновения Веллитона с Акинфеевым и Ломбертса с Диканем - абсолютно разные ситуации"', 0, 0, 0, '0', '0', '1'),
(51, 1, 'РФС дисквалифицировал футболиста "Спартака"', '', 'В матче "Спартак" - "Зенит", состоявшемся 2 октября и закончившемся вничью (2:2), Пареха был удален с поля. Защитник ударил Кержакова на 42-й минуте встречи. На сайте YouTube выложена видеозапись этого инцидента. ', 0, 0, 0, '0', '0', '1'),
(53, 8, 'ЦБ снизил оценку оттока капитала в 2010 г. до $33,6 млрд', '1.jpg', 'Банк России скорректировал данные по оттоку капитала частным сектором из РФ в 2010 году: согласно новым данным, показатель составил 33,6 миллиарда долларов, в то время как ранее сообщалось об оттоке в размере 38,3 миллиарда долларов по итогам 2010 года.', 0, 0, 0, '0', '0', '0'),
(54, 8, 'Moody''s понизило кредитный рейтинг Италии на три ступени', '2.jpg', 'Международное агентство Moody’s понизило рейтинг гособлигаций Италии на три ступени — с уровня Aa2 до A2 с прогнозом "негативный". Это означает понижение суверенного кредитного рейтинга страны.', 0, 0, 0, '0', '0', '0'),
(55, 8, 'dddd', '', 'adasdas', 0, 0, 0, '1', '0', '1'),
(56, 8, 'qqqq', '', 'ddddd', 0, 0, 0, '1', '0', '1'),
(57, 1, 'test', '', 'test', 0, 0, 0, '0', '0', '1'),
(58, 41, 'тестовый текст сайта', 'Penguins.jpg', 'тестовый рекламный текст с картинкой тестовый рекламный текст с картинкой тестовый рекламный текст с картинкой', 0, 0, 0, '0', '0', '0'),
(59, 41, 'тестовый текст сайта 2', 'Penguins.jpg', 'тестовый рекламный текст тестовый рекламный текст тестовый рекламный текст тестовый рекламный текст тестовый рекламный текст тестовый рекламный текст', 0, 0, 0, '1', '0', '0'),
(60, 1, 'Рижское «Динамо»', '', 'Рижское «Динамо» начало сезон КХЛ с поражения', 0, 0, 0, '1', '0', '1'),
(61, 1, 'Рижское «Динамо»', '', 'Рижское «Динамо» начало сезон КХЛ с поражения', 0, 0, 0, '1', '0', '1'),
(62, 1, 'Рижское «Динамо»', '', 'Рижское «Динамо» начало сезон КХЛ', 0, 0, 0, '1', '0', '1'),
(63, 1, 'Выборы Президента РФ', '', 'К 10 часам по московскому времени обработано уже почти 100% всех бюллетеней, и судя по предварительным результатам, победитель определился в первом туре: с огромным отрывом лидирует Владимир Путин, которого поддержали почти 64% избирателей.', 0, 0, 0, '1', '0', '0'),
(64, 1, 'Владимир Чуров рассказал о своей вере в Деда Мороза', 'i.jpg', 'В сегодняшнем номере газеты \\"Коммерсантъ\\" опубликовано интервью с председателем Центризбиркома Владимиром Чуровым. Он рассказал о явке избирателей, своем отношении к интернет-голосованию и агитации, и наотрез отказался отвечать на вопросы, связанные, на', 0, 0, 0, '1', '0', '0'),
(65, 48, 'eqweqweqweqwew', 'Penguins.jpg', '\r\n	\r\nРеферат по гироскопии\r\nТема: «Динамический уход гироскопа — актуальная национальная задача»\r\n\r\nКурс даёт более простую систему дифференциальных уравнений, если исключить дифференциальный подшипник подвижного объекта, что обусловлено существованием ци', 0, 0, 0, '1', '0', '0'),
(66, 49, 'вебстудия', '', 'создание и продвижение сайтов', 0, 0, 0, '1', '0', '0'),
(67, 51, 'Орифлейм: бизнес вместе!', '', 'Скидки 23%! Акции! Заработок с Орифлейм здесь! Сделаем бизнес вместе!', 0, 0, 0, '1', '1', '0'),
(68, 51, 'Бизнес в "Орифлейм"!', '', 'Скидки 23%! Акции! Поможем зарабатывать с Орифлейм! Начни свой бизнес!', 0, 0, 0, '1', '0', '0'),
(69, 53, 'Как стать консультантом Oriflame?', '', 'Скидки 23%! Акции! Стань консультантом! Поможем зарабатывать с Oriflame!', 0, 0, 0, '1', '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `cookies` varchar(255) NOT NULL default '',
  `active` enum('1','0') NOT NULL default '0',
  `delete` enum('0','1') NOT NULL default '0',
  `autication` varchar(255) default '',
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Пользователи' AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `cookies`, `active`, `delete`, `autication`) VALUES
(1, '', 'nik1tos@yandex.ru', '41fa3925a7ec42ce029c43d6676e4b2c', '', '1', '0', '0562b57bfac8d93e7086773a6235c15b'),
(5, '', 'mamaev.aleksander@gmail.com', '698d51a19d8a121ce581499d7b701668', '', '1', '0', '1b303f1e0550ca4090c58f9d711f88c3'),
(7, '', 'nwurka18@yandex.ru', '61c7005145b5da765945d5aca5', '', '0', '0', '8743d224060fc3a08efc0a9d08fd34cd'),
(12, '', 'sheluto@gmail.com', '96e79218965eb72c92a549dd5a330112', '', '1', '0', '075bded70a015482816dca911d96d7ef'),
(9, '', 'shevlyakov.danil@gmail.com', '1c75d417945436e35acd4a206c98558c', '', '1', '0', 'e605cf7ee03aa0daff9ee82ec75e8a7f'),
(10, '', 'sawizky89sergei@yandex.com', 'cce20aebd3c9e30f5743b9c91e6b4ad6', '', '0', '0', 'b60f632aecfde1ea6148e5bceddd773d'),
(11, '', 'kontervil@mail.ru', '190d039b1af04d950167e1e2525443a1', '', '1', '0', '8afe097a11c7f94dee05966d454c1628'),
(13, '', 'mamay1986@mail.ru', 'ed12206d95d423353686cd01dd1dd60a', '', '1', '0', 'a190072c680b9eafdb62727f589b2f21'),
(14, '', 'pr_1feddf47574a0b7641914f209f9d6d21@promolike.ru', '1feddf47574a0b7641914f209f9d6d21', '', '0', '0', ''),
(15, '', 'pr_d99b75bd86e03ac2d7e9844d457b67f0@promolike.ru', 'd99b75bd86e03ac2d7e9844d457b67f0', '', '0', '0', ''),
(16, '', 'pr_d2c19cd55f6e2ffeda5ce1cbebbd71f1@promolike.ru', 'd2c19cd55f6e2ffeda5ce1cbebbd71f1', '', '0', '0', ''),
(17, '', 'pr_f8196530e152a4ee590affa94d924048@promolike.ru', 'f8196530e152a4ee590affa94d924048', '', '0', '0', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_social_set_params`
--

CREATE TABLE IF NOT EXISTS `user_social_set_params` (
  `id` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL,
  `id_social_set` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `tocken` varchar(255) NOT NULL default '',
  `secret_tocken` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `active` enum('1','0') NOT NULL default '0',
  `delete` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `user_social_set_params`
--

INSERT INTO `user_social_set_params` (`id`, `id_user`, `id_social_set`, `uid`, `tocken`, `secret_tocken`, `nickname`, `first_name`, `last_name`, `active`, `delete`) VALUES
(4, 5, 2, '1567460', '7b8aef567b9d05b27b9d05b2577bb5d6d877b9d7b92678c109735cd65cbc373', '', '', '', '', '1', '0'),
(2, 1, 2, '2392426', '7223f9357207785f7207785f4a722fab357720672081a612ba018a1c1df7d96', '', '', '', '', '0', '0'),
(5, 12, 2, '8499452', 'e1c47e93e145ce6fe145ce6fa0e16d1d05ee145e14aac5167fc59896ad4f8a6', '', '', '', '', '0', '0'),
(7, 5, 3, '', '382620177-AvME0e8yZCattjwI1VfJkdlVfPnKv5r5llbfIdIA', '6Tmx9NuUrArZ4aXPFvgdhu5dpW3913OnglngYTnG42k', 'a_mamaev', '', '', '1', '0'),
(10, 16, 2, '5578787', 'f741f28ef714d2adf714d2adc7f73c01c7ff714f71bb0934fa212df537306dd', '', '', '', '', '0', '0'),
(11, 17, 2, '31797282', '3b53a27f3ab6925d3ab6925dac3a9e413733ab63ab9f0632bac0286de1e8541', '', '', '', '', '1', '0');
