-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 13-Fev-2019 às 00:01
-- Versão do servidor: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomplus_addons`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `apps`
--

CREATE TABLE `apps` (
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `partner_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `short_description` varchar(140) COLLATE utf8_unicode_ci DEFAULT NULL,
  `json_body` text COLLATE utf8_unicode_ci,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `free_trial` int(11) DEFAULT NULL,
  `version` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1.0.0',
  `version_date` datetime DEFAULT NULL,
  `type` set('dashboard','storefront','module_package','external') COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `load_events` text COLLATE utf8_unicode_ci,
  `script_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `github_repository` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication` tinyint(4) NOT NULL DEFAULT '0',
  `auth_callback_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_scope` text COLLATE utf8_unicode_ci,
  `avg_stars` tinyint(3) UNSIGNED DEFAULT '0',
  `evaluations` smallint(5) UNSIGNED DEFAULT '0',
  `downloads` int(10) NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plans_json` text COLLATE utf8_unicode_ci,
  `value_plan_basic` mediumint(8) UNSIGNED DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `apps`
--

INSERT INTO `apps` (`app_id`, `partner_id`, `title`, `slug`, `category`, `icon`, `description`, `short_description`, `json_body`, `paid`, `free_trial`, `version`, `version_date`, `type`, `module`, `load_events`, `script_uri`, `github_repository`, `authentication`, `auth_callback_uri`, `redirect_uri`, `auth_scope`, `avg_stars`, `evaluations`, `downloads`, `website`, `link_video`, `plans_json`, `value_plan_basic`, `active`) VALUES
(1236, 152, 'Melhor Envio', 'melhor-envio', 'shipping', 'https://d26lpennugtm8s.cloudfront.net/apps/461-pt_BR-small-avatar%20app%20nuvempshop.png', '---\n__Advertisement :)__\n\n- __[pica](https://nodeca.github.io/pica/demo/)__ - high quality and fast image\n  resize in browser.\n- __[babelfish](https://github.com/nodeca/babelfish/)__ - developer friendly\n  i18n with plurals support and easy syntax.\n\nYou will like those projects!\n\n---\n\n# h1 Heading 8-)\n## h2 Heading\n### h3 Heading\n#### h4 Heading\n##### h5 Heading\n###### h6 Heading\n\n\n## Horizontal Rules\n\n___\n\n---\n\n***\n\n\n## Typographic replacements\n\nEnable typographer option to see result.\n\n(c) (C) (r) (R) (tm) (TM) (p) (P) +-\n\ntest.. test... test..... test?..... test!....\n\n!!!!!! ???? ,,  -- ---\n\n\"Smartypants, double quotes\" and \'single quotes\'\n\n\n## Emphasis\n\n**This is bold text**\n\n__This is bold text__\n\n*This is italic text*\n\n_This is italic text_\n\n~~Strikethrough~~\n\n\n## Blockquotes\n\n\n> Blockquotes can also be nested...\n>> ...by using additional greater-than signs right next to each other...\n> > > ...or with spaces between arrows.\n\n\n## Lists\n\nUnordered\n\n+ Create a list by starting a line with `+`, `-`, or `*`\n+ Sub-lists are made by indenting 2 spaces:\n  - Marker character change forces new list start:\n    * Ac tristique libero volutpat at\n    + Facilisis in pretium nisl aliquet\n    - Nulla volutpat aliquam velit\n+ Very easy!\n\nOrdered\n\n1. Lorem ipsum dolor sit amet\n2. Consectetur adipiscing elit\n3. Integer molestie lorem at massa\n\n\n1. You can use sequential numbers...\n1. ...or keep all the numbers as `1.`\n\nStart numbering with offset:\n\n57. foo\n1. bar\n\n\n## Code\n\nInline `code`\n\nIndented code\n\n    // Some comments\n    line 1 of code\n    line 2 of code\n    line 3 of code\n\n\nBlock code \"fences\"\n\n```\nSample text here...\n```\n\nSyntax highlighting\n\n``` js\nvar foo = function (bar) {\n  return bar++;\n};\n\nconsole.log(foo(5));\n```\n\n## Tables\n\n| Option | Description |\n| ------ | ----------- |\n| data   | path to data files to supply the data that will be passed into templates. |\n| engine | engine to be used for processing templates. Handlebars is the default. |\n| ext    | extension to be used for dest files. |\n\nRight aligned columns\n\n| Option | Description |\n| ------:| -----------:|\n| data   | path to data files to supply the data that will be passed into templates. |\n| engine | engine to be used for processing templates. Handlebars is the default. |\n| ext    | extension to be used for dest files. |\n\n\n## Links\n\n[link text](http://dev.nodeca.com)\n\n[link with title](http://nodeca.github.io/pica/demo/ \"title text!\")\n\nAutoconverted link https://github.com/nodeca/pica (enable linkify to see)\n\n\n## Images\n\n![Minion](https://octodex.github.com/images/minion.png)\n![Stormtroopocat](https://octodex.github.com/images/stormtroopocat.jpg \"The Stormtroopocat\")\n\nLike links, Images also have a footnote style syntax\n\n![Alt text][id]\n\nWith a reference later in the document defining the URL location:\n\n[id]: https://octodex.github.com/images/dojocat.jpg  \"The Dojocat\"\n\n\n## Plugins\n\nThe killer feature of `markdown-it` is very effective support of\n[syntax plugins](https://www.npmjs.org/browse/keyword/markdown-it-plugin).\n\n\n### [Emojies](https://github.com/markdown-it/markdown-it-emoji)\n\n> Classic markup: :wink: :crush: :cry: :tear: :laughing: :yum:\n>\n> Shortcuts (emoticons): :-) :-( 8-) ;)\n\nsee [how to change output](https://github.com/markdown-it/markdown-it-emoji#change-output) with twemoji.\n\n\n### [Subscript](https://github.com/markdown-it/markdown-it-sub) / [Superscript](https://github.com/markdown-it/markdown-it-sup)\n\n- 19^th^\n- H~2~O\n\n\n### [\\<ins>](https://github.com/markdown-it/markdown-it-ins)\n\n++Inserted text++\n\n\n### [\\<mark>](https://github.com/markdown-it/markdown-it-mark)\n\n==Marked text==\n\n\n### [Footnotes](https://github.com/markdown-it/markdown-it-footnote)\n\nFootnote 1 link[^first].\n\nFootnote 2 link[^second].\n\nInline footnote^[Text of inline footnote] definition.\n\nDuplicated footnote reference[^second].\n\n[^first]: Footnote **can have markup**\n\n    and multiple paragraphs.\n\n[^second]: Footnote text.\n\n\n### [Definition lists](https://github.com/markdown-it/markdown-it-deflist)\n\nTerm 1\n\n:   Definition 1\nwith lazy continuation.\n\nTerm 2 with *inline markup*\n\n:   Definition 2\n\n        { some code, part of Definition 2 }\n\n    Third paragraph of definition 2.\n\n_Compact style:_\n\nTerm 1\n  ~ Definition 1\n\nTerm 2\n  ~ Definition 2a\n  ~ Definition 2b\n\n\n### [Abbreviations](https://github.com/markdown-it/markdown-it-abbr)\n\nThis is HTML abbreviation example.\n\nIt converts \"HTML\", but keep intact partial entries like \"xxxHTMLyyy\" and so on.\n\n*[HTML]: Hyper Text Markup Language\n\n### [Custom containers](https://github.com/markdown-it/markdown-it-container)\n\n::: warning\n*here be dragons*\n:::\n', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', NULL, 1, NULL, '1.0.1', '2018-10-15 00:00:00', 'external', NULL, '', NULL, 'https://github.com/ecomclub/app-melhor-envio', 1, 'https://melhorenvio.ecomplus.biz/callback', 'https://melhorenvio.ecomplus.biz/redirect', '{\n  \"orders\": [\n    \"GET\",\n    \"PATCH\",\n    \"POST\"\n  ],\n  \"orders/hidden_metafields\": [\n    \"POST\",\n    \"GET\",\n    \"PATCH\",\n    \"DELETE\"\n  ],\n  \"orders/shipping_lines\": [\n    \"POST\",\n    \"GET\",\n    \"PATCH\",\n    \"DELETE\"\n  ],\n  \"orders/fulfillments\": [\n    \"POST\",\n    \"PATCH\"\n  ],\n  \"procedures\": [\n    \"POST\"\n  ]\n}', NULL, NULL, 9999999, 'https://github.com/ecomclub/app-melhor-envio', NULL, '[\n  {\n    \"id\": 0,\n    \"title\": \"Basic\",\n    \"value\": 10,\n    \"currency\": \"monthly\",\n    \"description\": \"<p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p>\"\n  },\n  {\n    \"id\": 1,\n    \"title\": \"Top\",\n    \"value\": 20,\n    \"currency\": \"monthly\",\n    \"description\": \"<p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p>\"\n  },\n  {\n    \"id\": 2,\n    \"title\": \"Premium\",\n    \"value\": 30,\n    \"currency\": \"monthly\",\n    \"description\": \"<p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p><p>Feature do Plano</p>\"\n  }\n]', 122, 1),
(1238, 152, 'Wirecard', 'wirecard', 'sales', 'https://lorempixel.com/output/technics-q-g-120-118-1.jpg', 'Integração Wirecard', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', NULL, 0, NULL, '1.0.1', '2018-11-05 00:00:00', 'external', NULL, NULL, NULL, 'https://github.com/ecomclub/app-wirecard', 1, 'https://wirecard.ecomplus.biz/callback', 'https://wirecard.ecomplus.biz/redirect', '{\"orders\":[\"GET\",\"POST\"], \"orders/payments_history\": [\"GET\",\"POST\",\"PATCH\"], \"procedures\":[\"POST\"]}', NULL, NULL, 9999999, 'https://github.com/ecomclub/app-wirecard', NULL, NULL, NULL, 1),
(1240, 152, 'Mailjet', 'mailjet', 'marketing', 'https://lorempixel.com/output/technics-q-g-120-118-1.jpg', 'Interação MailJet e E-com.plus', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', NULL, 0, NULL, '1.0.1', '2018-11-07 00:00:00', 'external', NULL, NULL, NULL, 'https://github.com/ecomclub/app-mailjet', 1, 'https://mailjet.ecomplus.biz/callback', NULL, '{\"carts\":[\"GET\"],\"customers\":[\"GET\"],\"orders\":[\"GET\"]}', NULL, NULL, 9999999, NULL, NULL, NULL, NULL, 1),
(1241, 152, 'CPM', 'cpm', 'tools', 'https://lorempixel.com/output/technics-q-g-120-118-1.jpg', 'Common Procedure Manager ', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', NULL, 0, NULL, '1.0.1', '2018-11-09 00:00:00', 'external', NULL, NULL, NULL, 'https://github.com/ecomclub/procedures', 1, 'https://cpm.ecomplus.biz/callback', NULL, '{\"brands\":[\"GET\",\"PATCH\"],\"carts\":[\"GET\",\"PATCH\"],\"categories\":[\"GET\",\"PATCH\"],\"collections\":[\"GET\",\"PATCH\"],\"customers\":[\"GET\",\"PATCH\"],\"grids\":[\"GET\",\"PATCH\"],\"orders\":[\"GET\",\"PATCH\"],\"procedures\":[\"POST\"],\"products\":[\"GET\",\"PATCH\"]}', NULL, NULL, 9999999, 'https://cpm.ecomplus.biz/', NULL, NULL, NULL, 1),
(1242, 152, 'maijet', 'maijet', 'customer-service', 'https://lorempixel.com/output/technics-q-g-120-118-1.jpg', 'Integração melhor envio e mailjet', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', NULL, 0, NULL, '1.0.1', '2018-11-16 00:00:00', 'external', NULL, NULL, NULL, 'https://github.com/ecomclub/app-mailjet', 1, 'https://mailjet.ecomplus.biz/callback', NULL, '{\"customers\":[\"GET\", \"POST\"],\"orders\":[\"GET\", \"POST\"],\"procedures\":[\"GET\",\"POST\",\"PUT\",\"PATCH\",\"DELETE\"]}', NULL, NULL, 9999999, 'https://github.com/ecomclub/app-mailjet', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `apps_evaluations`
--

CREATE TABLE `apps_evaluations` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `store_id` mediumint(9) NOT NULL,
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `apps_evaluations`
--

INSERT INTO `apps_evaluations` (`id`, `date_time`, `store_id`, `app_id`, `stars`) VALUES
(1, '2018-09-12 03:00:00', 1011, 1236, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `badges`
--

CREATE TABLE `badges` (
  `id` tinyint(4) NOT NULL DEFAULT '1',
  `partner_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `buy_apps`
--

CREATE TABLE `buy_apps` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `store_id` mediumint(8) UNSIGNED NOT NULL,
  `date_init` date NOT NULL,
  `date_end` date NOT NULL,
  `date_renovation` date NOT NULL,
  `type_plan` tinyint(4) NOT NULL DEFAULT '0',
  `app_value` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `plan_id` mediumint(9) DEFAULT NULL,
  `id_transaction` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `buy_apps`
--

INSERT INTO `buy_apps` (`id`, `app_id`, `store_id`, `date_init`, `date_end`, `date_renovation`, `type_plan`, `app_value`, `payment_status`, `plan_id`, `id_transaction`) VALUES
(1, 1002, 1, '2018-09-01', '2018-12-01', '2018-10-01', 0, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `buy_themes`
--

CREATE TABLE `buy_themes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `theme_id` mediumint(8) UNSIGNED NOT NULL,
  `store_id` mediumint(8) UNSIGNED NOT NULL,
  `theme_value` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `license_type` tinyint(4) NOT NULL DEFAULT '0',
  `id_transaction` mediumint(8) UNSIGNED DEFAULT NULL,
  `template_id` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_apps`
--

CREATE TABLE `category_apps` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `category_apps`
--

INSERT INTO `category_apps` (`id`, `name`) VALUES
(1, 'product_sourcing'),
(2, 'marketing'),
(3, 'sales'),
(4, 'social_media'),
(5, 'shipping'),
(6, 'inventory'),
(7, 'customer_service'),
(8, 'tools'),
(9, 'reporting'),
(10, 'sales_channels');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_themes`
--

CREATE TABLE `category_themes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `category_themes`
--

INSERT INTO `category_themes` (`id`, `name`) VALUES
(1, 'art_photography'),
(2, 'clothing_fashion'),
(3, 'jewelry_accessories'),
(4, 'electronics'),
(5, 'food_drinks'),
(6, 'home_garden'),
(7, 'furniture'),
(8, 'health_beauty'),
(9, 'sports_recreation'),
(10, 'toys_games'),
(11, 'games'),
(12, 'sexshop'),
(13, 'petshop'),
(14, 'service'),
(15, 'fitness'),
(16, 'other');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comment_apps`
--

CREATE TABLE `comment_apps` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `store_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_comment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `comment_apps`
--

INSERT INTO `comment_apps` (`id`, `name`, `store_id`, `app_id`, `date_time`, `comment`, `parent_comment_id`) VALUES
(1, 'Lojista Teste', 1011, 1236, '2017-09-12 03:00:00', 'App bom de mais.', NULL),
(2, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(3, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(4, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(5, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(6, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(7, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(8, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(9, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(10, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(11, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(12, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(13, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(14, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(15, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(16, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(17, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(18, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'App bom de mais.', NULL),
(19, 'Lojista Teste', 1, 1236, '2018-09-12 03:00:00', 'Obrigado! O App é bom mesmo.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comment_themes`
--

CREATE TABLE `comment_themes` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `theme_id` mediumint(8) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_comment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historic_transaction`
--

CREATE TABLE `historic_transaction` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `partner_id` smallint(5) UNSIGNED DEFAULT NULL,
  `store_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `app_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `theme_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `transaction_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_value` mediumint(9) NOT NULL DEFAULT '0',
  `date_transaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historic_withdrawal`
--

CREATE TABLE `historic_withdrawal` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `partner_id` smallint(5) UNSIGNED NOT NULL,
  `date_withdrawal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `value_withdrawal` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `transaction_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `image_apps`
--

CREATE TABLE `image_apps` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width_px` smallint(5) UNSIGNED NOT NULL DEFAULT '600',
  `height_px` smallint(5) UNSIGNED NOT NULL DEFAULT '600'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `image_apps`
--

INSERT INTO `image_apps` (`id`, `app_id`, `name`, `alt`, `path_image`, `width_px`, `height_px`) VALUES
(18, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(19, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(20, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(21, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(22, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(23, 1002, NULL, 'Cu', 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 300, 300),
(221, 1231, 'e_com_club_Eu7Jx9YtHdPq.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(222, 1231, 'e_com_club_z29VtgrRFNwH.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(223, 1232, 'e_com_club_zsUYxFvhE2cg.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(224, 1232, 'e_com_club_gZVWxYSAOwFt.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(225, 1232, 'e_com_club_btHOJ49a5feE.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(226, 1232, 'e_com_club_jMtIl5vPKZrW.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(227, 1233, 'e_com_club_Tm_KaJOg1LVD.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(228, 1233, 'e_com_club_5cpxnSUPWe_K.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(229, 1233, 'e_com_club_d58gn4Cyq21M.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(230, 1233, 'e_com_club_OP2mrQHDs9G7.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(231, 1234, '_9osbIuPxtOK.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(232, 1234, 'PiseRpob6dwG.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(233, 1234, 'H2FzUvpjTBkX.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(234, 1234, 'amlZJsE6XwhV.jpg', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(235, 1235, 'pm2onkuSzEIH.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(236, 1235, 'RP_b5voSfwUg.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(237, 1235, 'fH9TspdwibzS.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(238, 1236, 'wfUvkIqW5Vop.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(239, 1236, '5Bf2cKYg4Ok6.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(240, 1236, 'kyhpSqXgumct.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(241, 1238, 'E3dL8FmoQywa.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600),
(242, 1238, 'WVk7o3yUFjfn.png', NULL, 'https://cdn.melhorenvio.com.br/images/facebook.png?v=6ffd560aa0c2f6c1f91dbbc0', 600, 600);

-- --------------------------------------------------------

--
-- Estrutura da tabela `image_themes`
--

CREATE TABLE `image_themes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `theme_id` mediumint(8) UNSIGNED NOT NULL,
  `alt` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width_px` smallint(5) UNSIGNED NOT NULL DEFAULT '600',
  `height_px` smallint(5) UNSIGNED NOT NULL DEFAULT '600'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `image_themes`
--

INSERT INTO `image_themes` (`id`, `name`, `theme_id`, `alt`, `path_image`, `width_px`, `height_px`) VALUES
(1, 'e_com_club_69leygKB4AH_.png', 1030, NULL, 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 600, 600),
(2, 'e_com_club_y8g3Np1UC2AW.png', 1030, NULL, 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 600, 600),
(3, 'e_com_club_KCt867ewAqn9.png', 1031, NULL, 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 600, 600),
(4, 'e_com_club_JzTSt7wpNGa1.png', 1031, NULL, 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 600, 600);

-- --------------------------------------------------------

--
-- Estrutura da tabela `partners`
--

CREATE TABLE `partners` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `avg_stars` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `evaluations` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `path_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_json` text COLLATE utf8_unicode_ci,
  `credit` mediumint(9) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `partners`
--

INSERT INTO `partners` (`id`, `name`, `password_hash`, `member_since`, `avg_stars`, `evaluations`, `path_image`, `profile_json`, `credit`) VALUES
(1, 'Talisson Ferreira', 'senha123', '2018-09-30 02:54:21', 5, 11, 'https://cdn0.iconfinder.com/data/icons/user-pictures/100/matureman1-512.png', '{}', 111),
(152, 'Talisson Trindade', '$2y$10$8nZmPbWzVoePjJ4TZpo1hem2gHEiUFB7nkIbS3vaOqfpz3HKwEr.i', '2019-02-08 14:28:54', 0, 0, 'https://avatars3.githubusercontent.com/u/14341511?s=400&v=4', '{}', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `partners_evaluations`
--

CREATE TABLE `partners_evaluations` (
  `partner_id` smallint(5) UNSIGNED NOT NULL,
  `store_id` mediumint(8) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stars` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relationship_category_apps`
--

CREATE TABLE `relationship_category_apps` (
  `app_id` mediumint(8) UNSIGNED NOT NULL,
  `category_apps_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relationship_category_themes`
--

CREATE TABLE `relationship_category_themes` (
  `theme_id` mediumint(8) UNSIGNED NOT NULL,
  `category_themes_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `store`
--

CREATE TABLE `store` (
  `store_id` mediumint(8) UNSIGNED NOT NULL,
  `credits` mediumint(9) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `store`
--

INSERT INTO `store` (`store_id`, `credits`) VALUES
(1, 1000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `themes`
--

CREATE TABLE `themes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `partner_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `json_body` text COLLATE utf8_unicode_ci,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `version` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1.0.0',
  `version_date` date DEFAULT NULL,
  `avg_stars` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `evaluations` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `link_documentation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value_license_basic` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `value_license_extend` mediumint(8) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `themes`
--

INSERT INTO `themes` (`id`, `partner_id`, `title`, `slug`, `category`, `thumbnail`, `description`, `json_body`, `paid`, `version`, `version_date`, `avg_stars`, `evaluations`, `link_documentation`, `link_video`, `value_license_basic`, `value_license_extend`) VALUES
(1000, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\n     cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\n     surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', NULL, 0, '1.0.0', NULL, 0, 0, NULL, NULL, 0, 0),
(1001, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1002, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1003, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1004, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1005, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1006, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1007, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1008, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1009, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1010, 152, 'Meu Thema', 'meu-thema', 'sex', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1011, 152, 'Meu Thema BpVtlbuUVzGeRypFGDWU', 'meu-thema-uhnLPPzQE', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\n     cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\n     surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', NULL, 0, '1.0.0', NULL, 0, 0, NULL, NULL, 0, 0),
(1012, 152, 'Meu Thema FEVRBmjSIp', 'meu-thema-GnyfUkQDU', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1013, 152, 'Meu Thema qJfSmMDUlBPeFULRZfe', 'meu-thema-NpSvpZmRKL', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1014, 152, 'Meu Thema xMZKhHcMSeZLy', 'meu-thema-jxFyJcepKgp', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1015, 152, 'Meu Thema fvtfUbgsWAIgtG', 'meu-thema-uUtYTTPx', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1016, 152, 'Meu Thema LlmLjJnUXXzF', 'meu-thema-MbzEIgtxB', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1017, 152, 'Meu Thema jTZHFV', 'meu-thema-mrEKYKb', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1018, 152, 'Meu Thema uXrlii', 'meu-thema-SdMkLidZJZcOeyNEtmUW', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1019, 152, 'Meu Thema HvuEuVMVtZ', 'meu-thema-GwkeKDm', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1020, 152, 'Meu Thema DaeFUWHgcixNTPztW', 'meu-thema-batlgmSQQpOxeGmDbShX', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1021, 152, 'Meu Thema qneAlNLyJLRVWRHZLW', 'meu-thema-KlCmcgexjlOYFW', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1022, 152, 'Meu Thema BpVtlbuUVzGeRypFGDWU', 'meu-thema-uhnLPPzQE', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\n     cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\n     surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', NULL, 0, '1.0.0', NULL, 0, 0, NULL, NULL, 0, 0),
(1023, 152, 'Meu Thema BpVtlbuUVzGeRypFGDWU', 'meu-thema-uhnLPPzQE', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\n     cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\n     surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', NULL, 0, '1.0.0', NULL, 0, 0, NULL, NULL, 0, 0),
(1024, 152, 'Meu Thema FEVRBmjSIp', 'meu-thema-GnyfUkQDU', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1025, 152, 'Meu Thema qJfSmMDUlBPeFULRZfe', 'meu-thema-NpSv', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1026, 152, 'Meu Thema xMZKhHcMSeZLy', 'meu-thema-jxFyJcepKgp', 'art-photography', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', 'enough oldest rope ten vertical hurry youth include shore paint mysterious tall judge trap receive given buffalo chemical copy round environment angry start strike\r\n          cause twelve deal replied say bridge curious little layers classroom lying guess jet upward characteristic unless statement than you spider hair food said troublegift whistle done flag are percent classroom habit hot inside serious top sort broken chance underline teacher student becoming very shelf carefully detail glass\r\n          surface lovely lonely fresh capital with small while bark stock signal speech voyage bow been worried manner plain depth toy it high we althoughtroops prepare mind remain difference are hollow needed stock hot lead surprise attached beyond purple pig income thy tell enough off shake trip officer', 'NULL', 0, '1.0.0', '0000-00-00', 0, 0, 'NULL', 'NULL', 0, 0),
(1028, 152, 'fsdfd', 'eqweq', 'clothing-fashion', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', '', NULL, 0, '213', '0000-00-00', 0, 0, '', '', 213, 312),
(1029, 152, 'fsdfd', 'eqweq', 'clothing-fashion', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', '', NULL, 0, '213', '0000-00-00', 0, 0, '', '', 213, 312),
(1030, 152, 'fsdfd', 'eqweq', 'clothing-fashion', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', '', NULL, 0, '213', '0000-00-00', 0, 0, '', '', 213, 312),
(1031, 1, 'fsdfd', 'eqweq', 'clothing-fashion', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', '', NULL, 0, '213', '0000-00-00', 0, 0, '', '', 213, 312),
(1032, 152, 'fsdfd', 'eqweq', 'clothing-fashion', 'http://www.gazetafmdf.com/file/2015/03/800x600.gif', '', NULL, 0, '213', '2018-09-04', 0, 0, '', '', 213, 312);

-- --------------------------------------------------------

--
-- Estrutura da tabela `themes_evaluations`
--

CREATE TABLE `themes_evaluations` (
  `theme_id` mediumint(8) UNSIGNED NOT NULL,
  `store_id` mediumint(8) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stars` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `partner_id` (`partner_id`,`slug`);

--
-- Indexes for table `apps_evaluations`
--
ALTER TABLE `apps_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_id` (`app_id`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`,`partner_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `buy_apps`
--
ALTER TABLE `buy_apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_id` (`app_id`,`store_id`),
  ADD KEY `id_transaction` (`id_transaction`);

--
-- Indexes for table `buy_themes`
--
ALTER TABLE `buy_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`,`store_id`),
  ADD KEY `id_transaction` (`id_transaction`);

--
-- Indexes for table `category_apps`
--
ALTER TABLE `category_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_themes`
--
ALTER TABLE `category_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_apps`
--
ALTER TABLE `comment_apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_id` (`app_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indexes for table `comment_themes`
--
ALTER TABLE `comment_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indexes for table `historic_transaction`
--
ALTER TABLE `historic_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`,`store_id`,`app_id`,`theme_id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `app_id` (`app_id`);

--
-- Indexes for table `historic_withdrawal`
--
ALTER TABLE `historic_withdrawal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `image_apps`
--
ALTER TABLE `image_apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_id` (`app_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `image_themes`
--
ALTER TABLE `image_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `partners_evaluations`
--
ALTER TABLE `partners_evaluations`
  ADD PRIMARY KEY (`partner_id`,`store_id`);

--
-- Indexes for table `relationship_category_apps`
--
ALTER TABLE `relationship_category_apps`
  ADD PRIMARY KEY (`app_id`,`category_apps_id`),
  ADD KEY `category_apps_id` (`category_apps_id`);

--
-- Indexes for table `relationship_category_themes`
--
ALTER TABLE `relationship_category_themes`
  ADD PRIMARY KEY (`theme_id`,`category_themes_id`),
  ADD KEY `category_themes_id` (`category_themes_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`,`slug`);

--
-- Indexes for table `themes_evaluations`
--
ALTER TABLE `themes_evaluations`
  ADD PRIMARY KEY (`theme_id`,`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `app_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1243;
--
-- AUTO_INCREMENT for table `apps_evaluations`
--
ALTER TABLE `apps_evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `buy_apps`
--
ALTER TABLE `buy_apps`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `buy_themes`
--
ALTER TABLE `buy_themes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category_apps`
--
ALTER TABLE `category_apps`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `category_themes`
--
ALTER TABLE `category_themes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `comment_apps`
--
ALTER TABLE `comment_apps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `comment_themes`
--
ALTER TABLE `comment_themes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `historic_transaction`
--
ALTER TABLE `historic_transaction`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `historic_withdrawal`
--
ALTER TABLE `historic_withdrawal`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `image_apps`
--
ALTER TABLE `image_apps`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `image_themes`
--
ALTER TABLE `image_themes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1033;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `apps`
--
ALTER TABLE `apps`
  ADD CONSTRAINT `apps_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Limitadores para a tabela `apps_evaluations`
--
ALTER TABLE `apps_evaluations`
  ADD CONSTRAINT `apps_evaluations_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`);

--
-- Limitadores para a tabela `badges`
--
ALTER TABLE `badges`
  ADD CONSTRAINT `badges_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `buy_apps`
--
ALTER TABLE `buy_apps`
  ADD CONSTRAINT `buy_apps_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buy_apps_ibfk_2` FOREIGN KEY (`id_transaction`) REFERENCES `historic_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `buy_themes`
--
ALTER TABLE `buy_themes`
  ADD CONSTRAINT `buy_themes_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buy_themes_ibfk_2` FOREIGN KEY (`id_transaction`) REFERENCES `historic_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `comment_apps`
--
ALTER TABLE `comment_apps`
  ADD CONSTRAINT `comment_apps_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_apps_ibfk_2` FOREIGN KEY (`parent_comment_id`) REFERENCES `comment_apps` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limitadores para a tabela `comment_themes`
--
ALTER TABLE `comment_themes`
  ADD CONSTRAINT `comment_themes_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_themes_ibfk_2` FOREIGN KEY (`parent_comment_id`) REFERENCES `comment_themes` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limitadores para a tabela `historic_transaction`
--
ALTER TABLE `historic_transaction`
  ADD CONSTRAINT `historic_transaction_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `historic_transaction_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`),
  ADD CONSTRAINT `historic_transaction_ibfk_3` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`);

--
-- Limitadores para a tabela `historic_withdrawal`
--
ALTER TABLE `historic_withdrawal`
  ADD CONSTRAINT `historic_withdrawal_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Limitadores para a tabela `image_apps`
--
ALTER TABLE `image_apps`
  ADD CONSTRAINT `image_apps_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `image_themes`
--
ALTER TABLE `image_themes`
  ADD CONSTRAINT `image_themes_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`id`) REFERENCES `themes` (`partner_id`),
  ADD CONSTRAINT `partners_ibfk_2` FOREIGN KEY (`id`) REFERENCES `apps` (`partner_id`);

--
-- Limitadores para a tabela `partners_evaluations`
--
ALTER TABLE `partners_evaluations`
  ADD CONSTRAINT `partners_evaluations_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `relationship_category_apps`
--
ALTER TABLE `relationship_category_apps`
  ADD CONSTRAINT `relationship_category_apps_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relationship_category_apps_ibfk_2` FOREIGN KEY (`category_apps_id`) REFERENCES `category_apps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `relationship_category_themes`
--
ALTER TABLE `relationship_category_themes`
  ADD CONSTRAINT `relationship_category_themes_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relationship_category_themes_ibfk_2` FOREIGN KEY (`category_themes_id`) REFERENCES `category_themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `themes_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `themes_evaluations`
--
ALTER TABLE `themes_evaluations`
  ADD CONSTRAINT `themes_evaluations_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
