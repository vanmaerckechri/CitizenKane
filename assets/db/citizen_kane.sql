-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 20 déc. 2018 à 00:22
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `citizen_kane`
--

-- --------------------------------------------------------

--
-- Structure de la table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `imgSrc` varchar(250) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `date_open` datetime NOT NULL,
  `date_close` datetime NOT NULL,
  `summary` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agenda`
--

INSERT INTO `agenda` (`id`, `imgSrc`, `title`, `date_open`, `date_close`, `summary`) VALUES
(1, 'agenda_1.png', 'Soirée HAVANA', '2018-10-01 08:00:00', '2018-11-30 23:30:00', 'Tous les jeudis, c\'est SOIRÉE HAVANA au Citizen Kane ! Tous les cocktails Havana sont à 5€ ... Santé !'),
(2, 'agenda_2.jpg', 'Quiz culturel & multimédia #18', '2018-11-22 21:00:00', '2018-11-22 23:00:00', 'Testez votre culture générale lors de notre quiz mensuel. Au programme : cinéma, histoire, télévision, musique, … Le tout avec des extraits sur grand écran ! Inscrivez-vous gratuitement en équipe via cafecitizenkane@gmail.com. Attention, pour des raisons d’équité, nous n’acceptons que des équipes de maximum 5 joueurs. Les équipes plus nombreuses seront séparées en plusieurs groupes.'),
(3, 'agenda_3.jpg', 'Beer Discovery Project : Brasserie Jandrain-Jandrenouille', '2018-11-14 20:00:00', '2018-11-14 22:00:00', 'En ce mois de décembre, la Brasserie Jandrain-Jandrenouille sera à l’honneur au Citizen Kane dans le cadre du Beer Discovery Project. Rendez-vous ce 14 décembre dès 20h en présence de la brasserie pour découvrir la IV Saison, la V Cense et la VI Wheat. Plus d’infos sur la brasserie sur www.brasseriedejandrainjandrenouille.com'),
(5, 'agenda_5.jpg', 'Beer Discovery Project : Brasserie de Sillye', '2018-11-09 20:00:00', '2018-11-09 22:00:00', 'En ce mois d’octobre, la Brasserie de Silly sera à l’honneur au Citizen Kane dans le cadre du Beer Discovery Project. Rendez-vous ce 9 novembre dès 20h en présence de la brasserie pour découvrir la Triple Swaf, Green Killer et l\'Abbaye de Forest. Plus d’infos sur la brasserie sur www.silly-beer.com'),
(6, 'agenda_6.jpg', 'Quiz culturel & multimédia #17', '2018-11-08 21:00:00', '2018-11-08 23:00:00', 'Testez votre culture générale lors de notre quiz mensuel. Au programme : cinéma, histoire, télévision, musique, … Le tout avec des extraits sur grand écran ! Inscrivez-vous gratuitement en équipe via cafecitizenkane@gmail.com. Attention, pour des raisons d’équité, nous n’acceptons que des équipes de maximum 5 joueurs. Les équipes plus nombreuses seront séparées en plusieurs groupes.'),
(7, 'agenda_7.jpg', 'Brunch de la Toussaint', '2018-11-01 20:00:00', '2018-11-01 22:00:00', 'Ce 1er novembre de 10h à 15h, nous vous accueillons pour bruncher en famille ou entre amis ! Plus d\'infos sur notre brunch ici.'),
(8, 'agenda_8.jpg', 'Quiz culturel & multimédia #16', '2018-10-18 21:00:00', '2018-10-18 23:00:00', 'Testez votre culture générale lors de notre quiz mensuel. Au programme : cinéma, histoire, télévision, musique, … Le tout avec des extraits sur grand écran ! Inscrivez-vous gratuitement en équipe via cafecitizenkane@gmail.com. Attention, pour des raisons d’équité, nous n’acceptons que des équipes de maximum 5 joueurs. Les équipes plus nombreuses seront séparées en plusieurs groupes.'),
(9, 'agenda_9.jpg', 'Beer Discovery Project : Brasserie Leopold 7', '2018-10-12 20:00:00', '2018-10-12 22:00:00', 'En ce mois d\'octobre, la Brasserie Leopold 7 sera à l’honneur au Citizen Kane dans le cadre du Beer Discovery Project. Rendez-vous ce 12 octobre dès 20h en présence de la brasserie pour découvrir la Leopold 7 et la Timber ! Plus d’infos sur la brasserie sur www.leopold7.com'),
(10, 'agenda_10.png', 'Grand concours “Weekend du Client”', '2018-10-06 11:00:00', '2018-10-07 22:00:00', 'Le weekend des 6 et 7 octobre, mangez au Citizen Kane et tentez de gagner un safari pour 2 personnes au Kenya ou l’un des nombreux autres prix offerts à l’occasion du Weekend du client ! Pour chaque repas commandé, recevez un code unique pour participer au concours. Bonne chance !'),
(11, 'agenda_11.jpg', 'Quiz culturel & multimédia #15', '2018-09-27 21:00:00', '2018-09-27 23:00:00', 'Testez votre culture générale lors de notre quiz mensuel. Au programme : cinéma, histoire, télévision, musique, … Le tout avec des extraits sur grand écran ! Inscrivez-vous gratuitement en équipe via cafecitizenkane@gmail.com. Attention, pour des raisons d’équité, nous n’acceptons que des équipes de maximum 5 joueurs. Les équipes plus nombreuses seront séparées en plusieurs groupes.'),
(12, 'agenda_12.jpg', 'Beer Discovery Project : Brasserie En Stoemelingst', '2018-09-14 20:00:00', '2018-09-14 22:00:00', 'En ce mois de septembre, la Brasserie artisanale En Stoemelings sera à l’honneur au Citizen Kane dans le cadre du Beer Discovery Project. Rendez-vous ce 14 septembre dès 20h en présence de la brasserie pour découvrir la Curieuse Neus, la Tanteke & la Chike Madame. Plus d’infos sur la brasserie sur www.enstoemelings.be');

-- --------------------------------------------------------

--
-- Structure de la table `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail` varchar(250) NOT NULL,
  `mdp` binary(20) NOT NULL,
  `reset_code` binary(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `auth`
--

INSERT INTO `auth` (`id`, `mail`, `mdp`, `reset_code`) VALUES
(1, 'test', 0xa94a8fe5ccb19ba61c4c0873d391e987982fbbd3, 0x0000000000000000000000000000000000000000);

-- --------------------------------------------------------

--
-- Structure de la table `beerproject`
--

DROP TABLE IF EXISTS `beerproject`;
CREATE TABLE IF NOT EXISTS `beerproject` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `imgSrc` varchar(250) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `beers` varchar(250) NOT NULL,
  `link` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `beerproject`
--

INSERT INTO `beerproject` (`id`, `imgSrc`, `title`, `date`, `beers`, `link`) VALUES
(1, 'beerproject_1.jpg', 'Brasserie de Jandrain-Jandrenouille', '2018-12-14', 'IV Saison, V Cense, VI Wheat', 'http://www.brasseriedejandrainjandrenouille.com/'),
(2, 'beerproject_2.png', 'Brasserie Lion (Brasserie bio & éco-responsable / Ophain)', '2019-01-11', 'Lion Blonde, Lion White, Lion IPA', ''),
(28, 'beerproject_28.jpg', 'Brasserie Caracole (Brasserie artisanale & pittoresque / Dinant)', '2019-02-08', 'Caracole, Saxo, Nostradamus & Troublette', ''),
(29, 'beerproject_29.png', 'Brasserie de la Senne (Brasserie “à l’ancienne” / Bruxelles)', '2019-06-14', 'Jambe-de-bois, Zinnebir & Taras Boulba', ''),
(5, 'beerproject_5.jpg', 'Brasserie Leopold 7 (Brasserie de Marsinne)', '2018-10-12', 'Leopold 7 & Timber', ''),
(30, 'beerproject_30.png', 'Ginette (Brasserie bio / Loupoigne)', '2019-05-10', 'Ginette Triple, Ginette White, Ginette Blonde & Ginette Fruit', ''),
(31, 'beerproject_31.png', 'Tartaruga (Soignies)', '2019-04-12', 'Super Fresca, Sunny Baia & Sweet Alma', ''),
(32, 'beerproject_32.png', 'Surprise (??? / ???)', '2019-03-22', '???', ''),
(33, 'beerproject_33.png', 'Brasserie de Silly', '2018-11-09', 'Triple Swaf, Green Killer, Abbaye de Forest', ''),
(34, 'beerproject_34.png', 'Brasserie de l’Abbaye du Val-Dieu (Brasserie d’Abbaye/Aubel)', '2018-08-09', 'Triple, Grand-Cru & Cuvée 800', ''),
(35, 'beerproject_35.png', 'Brasserie en Stoemelings (Brasserie artisanale)', '2018-09-14', 'Curieuse Neus, Tanteke, & Chike Madame', ''),
(36, 'beerproject_36.jpg', 'Brasserie Brussels Beer Project (Brasserie collaborative/ Bruxelles)', '2018-07-13', 'Red My Lips, Delta IPA, Jungle Joy, Grosse Bertha, Summer Haze & Go Belgium', ''),
(37, 'beerproject_37.png', 'Brasserie Bertinchamps (Brasserie familiale / Gembloux)', '2018-06-15', 'Triple, Pamplemousse, Blanche', ''),
(38, 'beerproject_38.jpg', 'Brasserie Lupulus (Gouvy)', '2018-05-11', 'La Hopera, L’Organicus, La Blanche', ''),
(39, 'beerproject_39.png', 'Brasserie le Goupil (Micro-brasserie / Rosières)', '2018-04-20', 'La Renart, la Renart spéciale, l’Ysengrin', ''),
(40, 'beerproject_40.png', 'Brasserie Valduc (Brasserie durable / Thorembais-Saint-Trond)', '2018-03-16', 'La Valduc Rio, La petite soeur du Valduc, Valduc Thor', ''),
(41, 'beerproject_41.png', 'Brasserie [C] (Brasserie / Liège)', '2018-02-16', 'Curtius, Torpah (30, 60 & 90), Black C', ''),
(42, 'beerproject_42.jpg', 'Brasserie du Renard (Brasserie bio / Grez Doiceau)', '2017-12-15', 'L’Adorée, la Blondasse, la Roublarde', '');

-- --------------------------------------------------------

--
-- Structure de la table `cartes`
--

DROP TABLE IF EXISTS `cartes`;
CREATE TABLE IF NOT EXISTS `cartes` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `imgSrc` varchar(250) DEFAULT NULL,
  `style` char(4) NOT NULL DEFAULT 'fold',
  `link` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cartes`
--

INSERT INTO `cartes` (`id`, `title`, `imgSrc`, `style`, `link`) VALUES
(31, 'Salades', 'carte_31_small.jpg', 'fold', NULL),
(32, 'Plats', 'carte_32_small.jpg', 'fold', NULL),
(171, '', 'carte_171_small.jpg', 'fold', NULL),
(189, 'titre de la carte', NULL, 'fold', NULL),
(192, 'Softs', 'carte_192_small.jpg', 'link', 'boissons.pdf'),
(193, 'Entrées', 'carte_193_small.jpg', 'fold', NULL),
(194, 'Viandes', 'carte_194_small.jpg', 'fold', NULL),
(195, 'Spaghettis', 'carte_195_small.jpg', 'fold', NULL),
(196, 'Enfants', 'carte_196_small.jpg', 'fold', NULL),
(197, 'Burgers', 'carte_197_small.jpg', 'fold', NULL),
(198, 'Desserts', 'carte_198_small.jpg', 'fold', NULL),
(199, 'Brunch', 'carte_199_small.jpg', 'fold', NULL),
(200, 'P\'tits Déjs', 'carte_200_small.jpg', 'fold', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `family` varchar(250) NOT NULL,
  `id_carte` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pages`
--

INSERT INTO `pages` (`id`, `name`, `family`, `id_carte`) VALUES
(1, 'restaurant', 'La Carte Restauration', 193),
(28, 'restaurant', 'La Carte Restauration', 31),
(29, 'restaurant', 'La Carte Restauration', 32),
(30, 'cafe', 'Cartes des Boissons', 192),
(32, 'cafe', 'La Carte Complète des Bières', 171),
(180, 'restaurant', 'Carte des Boissons', 192),
(181, 'restaurant', 'La Carte Restauration', 194),
(182, 'restaurant', 'La Carte Restauration', 195),
(183, 'restaurant', 'La Carte Restauration', 196),
(184, 'restaurant', 'La Carte Restauration', 197),
(185, 'restaurant', 'La Carte Restauration', 198),
(186, 'restaurant', 'La Carte Restauration', 199),
(187, 'brunch', '', 200),
(188, 'brunch', '', 199);

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `compo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `name`, `price`, `compo`) VALUES
(44, 'La Volver', '8.00', 'Toast de chèvre gratiné – Poivrons – Aubergines – Courgettes grillées – Roquette – Crème balsamique – Vinaigrette du chef'),
(45, 'La Strada', '11.00', 'Poulet – Croûtons – Oeuf dur – Parmesan – Roquette – Tomates – Vinaigrette du chef'),
(46, 'La Avé César', '6.50', 'Salade – Tomates – Concombres – Pommes – Croûtons – Pignons – Noix – Chavignol gratiné au miel & thym – Vinaigrette du chef'),
(47, 'La Vita E Bella', '12.50', 'Saumon fumé – Avocat – Tomates – Concombres – Oignons rouges – Épinards – Germes de radis – Vinaigrette à l’aneth'),
(48, 'La Salade de penne à l’italienne', '12.50', 'Penne – Huile d’olive au basilic – Pignons – Tomates séchées – Parmesan – Jambon italien'),
(49, 'Les Fondus au parmesan (2 pièces)', '13.50', ''),
(50, 'Le Suprême de poulet à l’estragon', '15.00', ''),
(51, 'Le Vol-au-vent de poule traditionnelle', '15.50', ''),
(52, 'Le Pain de viande à l’ancienne & sa sauce miel-moutarde', '15.50', ''),
(53, 'Le Pavé de saumon cuit sur peau & sa sauce échalotes-vin blanc', '18.00', ''),
(54, 'L’Américain préparé du chef', '13.50', ''),
(56, 'Barbar', '3.80', ''),
(57, 'Bel Pils 25cl', '2.20', ''),
(58, 'Bel Pils 33cl', '2.80', ''),
(59, 'Bel Pils 50cl', '4.00', ''),
(60, 'Bertinchamps triple', '6.60', ''),
(61, 'Besos', '4.50', ''),
(62, 'Bisous m\'chou', '10.00', ''),
(63, 'Black [C]', '5.50', ''),
(64, 'Blanche du Hainaut bio', '3.00', ''),
(65, 'Carlsberg', '3.20', ''),
(66, 'Cherry Chouffe', '4.00', ''),
(67, 'Chimay bleue', '4.50', ''),
(68, 'Chouffe blonde', '3.80', ''),
(69, 'Chouffe soleil', '4.00', ''),
(70, 'Delta IPA', '4.20', ''),
(71, 'Duvel', '4.00', ''),
(72, 'Duvel Triple Hop', '5.00', ''),
(73, 'Gueuze Boon', '3.20', ''),
(74, 'Guldenberg', '3.80', ''),
(75, 'Hopera', '4.20', ''),
(76, 'Houppe', '4.50', ''),
(77, 'Jambe de bois', '4.20', ''),
(78, 'Jungle Joy', '4.20', ''),
(79, 'Liefmans Fruitesse', '3.40', ''),
(80, 'Lupulus', '9.50', ''),
(81, 'Maredsous blonde', '3.80', ''),
(82, 'Maredsous brune', '4.50', ''),
(83, 'Mc Chouffe', '4.00', ''),
(84, 'Mobius', '4.20', ''),
(85, 'Moinette bio', '3.80', ''),
(86, 'Montagnarde', '4.00', ''),
(87, 'Noir de Dottignies', '4.50', ''),
(88, 'Paix Dieu', '4.70', ''),
(89, 'Rochefort 8', '4.50', ''),
(90, 'Rulles estivale', '10.50', ''),
(91, 'Taras Boulba', '3.80', ''),
(92, 'Thor', '5.00', ''),
(93, 'Triple Karmeliet', '4.00', ''),
(94, 'Val-Dieu', '3.80', ''),
(95, 'Vedett blanche', '3.00', ''),
(96, 'Vedett Blonde', '3.00', ''),
(97, 'Vedett IPA', '3.80', ''),
(98, 'Westmalle triple', '4.50', ''),
(99, 'Zinnebir', '3.80', ''),
(100, 'Chouffe houblon', '4.40', ''),
(101, 'Le Fondu au parmesan (1 pièce)', '8.00', ''),
(112, 'Le Fondu au parmesan (1 pièce)', '8.00', ''),
(113, 'Les Fondus au parmesan (2 pièces)', '11.00', ''),
(114, 'Le Potage du jour & ses croûtons', '6.50', ''),
(115, 'Le Carpaccio de bœuf à l’italienne', '12.50', ''),
(116, 'Le Toast de chèvre sur salade croquante', '12.50', ''),
(117, 'La Cassolette de scampis aux petits légumes', '13.50', ''),
(118, 'L’Assiette de saumon fumé & son toast', '13.00', ''),
(119, 'Le Pavé de bœuf irlandais', '19.00', ''),
(120, 'L’Onglet de bœuf irlandais', '17.00', ''),
(121, 'L’Entrecôte de vachette Holstein (300 gr)', '20.50', ''),
(122, 'Le Bolo', '11.00', ''),
(123, 'Le Jambon-fromage', '11.00', ''),
(124, 'Le Crème de parmesan & pesto maison', '12.50', ''),
(125, 'Le Scampis & petits légumes', '14.00', ''),
(126, 'Le Spaghetti enfant (Bolo ou jambon-fromage)', '7.00', ''),
(127, 'Le p’tit Cheeseburger', '8.00', ''),
(128, 'Le Poulet compote', '8.50', ''),
(129, 'Le p’tit Citizen', '10.00', '120gr de boeuf – Salade – Tomate – Bacon – Oignons frits – Cheddar – Sauce bbq maison'),
(130, 'Le p’tit Rocky', '10.50', '120gr de boeuf – Salade – Tomate – Bacon – Oignons rouges – Sauce roquefort maison'),
(131, 'Le p’tit Brigitte', '9.50', 'Galette végé maison – Salade – Légumes grillés – Pesto maison – Mayonnaise maison'),
(132, 'Le Citizen', '14.00', '200gr de boeuf – Salade – Tomate – 2x Cheddar – Oignons frits – Sauce du chef'),
(133, 'Le Pêpêre', '14.50', '200gr de boeuf – Salade – Tomate – Cheddar – Oignons rouges – Sauce poivre maison'),
(134, 'Le Roosevelt', '15.50', '200gr de boeuf – Salade – Tomate – 2x Bacon – Oignons frits – 2x Cheddar – Sauce bbq maison'),
(135, 'Le Gringo', '16.50', '200gr de boeuf – Salade – Tomate – Cheddar – Oignons rouges – Avocat – Sauce cocktail maison'),
(136, 'Le Parrain', '15.50', '200gr de boeuf – Salade – Tomate – Parmesan – Roquette – Pesto maison – Mayonnaise maison'),
(137, 'Le Gaston', '16.50', '200gr de boeuf – Salade – Tomate – Fromage Brugge – Sirop de liège – Sauce bbq maison'),
(138, 'Le Rocky', '16.50', '200gr de boeuf – Salade – Tomate – 2x Bacon – Oignons rouges – Sauce roquefort maison'),
(139, 'Le Poulidor', '14.50', 'Poulet – Salade – Tomate – Emmenthal – Oignons frits – Sauce aïoli maison'),
(140, 'Le Moby-Dick', '15.00', 'Galette de poisson maison – Salade – Tomate – Cheddar – Oignons rouges – Sauce tartare maison'),
(141, 'Le Brigitte ', '15.00', 'Galette végé maison – Salade – Légumes grillés – Pesto maison – Mayonnaise maison'),
(142, 'La Crème brûlée', '6.50', ''),
(143, 'Le Moelleux au chocolat et sa crème anglaise', '8.00', ''),
(144, 'Le Duo de crêpes', '6.00', ''),
(145, 'La Mousse au chocolat', '7.00', ''),
(146, 'Le Duo de sorbets', '6.00', ''),
(147, 'La Boule de glace ou de sorbet enfant', '2.50', ''),
(148, 'La Crêpe mikado', '8.50', ''),
(149, 'La Dame blanche', '7.50', ''),
(150, 'La Dame noire', '7.50', ''),
(151, 'Les Profiteroles glacées au chocolat', '8.00', ''),
(152, 'Le Café gourmand', '9.00', ''),
(153, 'Le Belmondo', '16.00', 'Les Oeufs sur le plat & leur bacon croustillant + Le Pain perdu maison & sa cassonade + La Viennoiserie & le muffin au chocolat + Le Café'),
(154, 'Le Gabin', '17.00', 'Les Oeufs brouillés du chef + La Tranche de gouda & le chavignol de “La Casière” + Le Yahourt, son muesli & ses fruits frais + Le Thé'),
(155, 'Le Fernandel', '23.00', 'Le Saumon & son fromage frais + Les Oeufs brouillés à la Forestière + Le Pain perdu maison + La Viennoiserie & son muffin au chocolat + Le Verre de bulles'),
(156, 'Le Bourvil', '9.00', 'Pour les enfants jusqu’à 12 ans La Viennoiserie + Les Crêpes & leur cassonade + Les Fruits + Le Petit chocolat chaud '),
(157, 'La Formule express', '5.00', 'Le Café, la viennoiserie & le jus'),
(158, 'La Viennoiserie & le muffin au chocolat ', '5.00', ''),
(159, 'Le Pain perdu maison', '5.00', ''),
(160, 'Les Crêpes & leur cassonade', '5.00', ''),
(161, 'Le Yahourt, son muesli & ses fruits frais', '5.00', ''),
(162, 'Les Oeufs sur le plat & leur bacon croustillant', '5.00', ''),
(163, 'Les Oeufs brouillés du chef', '5.00', ''),
(164, 'Les Oeufs brouillés façon Tex-Mex', '5.00', 'Maïs, poivron & paprika'),
(165, 'Les Oeufs brouillés à la Forestière', '5.00', 'Aux champignons'),
(166, 'La Tranche de gouda & le jambon de “La Casière”', '5.00', ''),
(167, 'La Tranche de gouda & le chavignol de “La Casière”', '5.00', ''),
(168, 'Le Saumon & son fromage frais', '5.00', '');

-- --------------------------------------------------------

--
-- Structure de la table `rel_cartes_plats`
--

DROP TABLE IF EXISTS `rel_cartes_plats`;
CREATE TABLE IF NOT EXISTS `rel_cartes_plats` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_carte` smallint(4) NOT NULL,
  `id_plat` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rel_cartes_plats`
--

INSERT INTO `rel_cartes_plats` (`id`, `id_carte`, `id_plat`) VALUES
(43, 31, 44),
(44, 31, 45),
(45, 31, 46),
(46, 31, 47),
(47, 31, 48),
(48, 32, 49),
(49, 32, 50),
(50, 32, 51),
(51, 32, 52),
(52, 32, 53),
(53, 32, 54),
(55, 171, 56),
(56, 171, 57),
(57, 171, 58),
(58, 171, 59),
(59, 171, 60),
(60, 171, 61),
(61, 171, 62),
(62, 171, 63),
(63, 171, 64),
(64, 171, 65),
(65, 171, 66),
(66, 171, 67),
(67, 171, 68),
(68, 171, 100),
(69, 171, 69),
(70, 171, 70),
(71, 171, 71),
(72, 171, 72),
(73, 171, 73),
(74, 171, 74),
(75, 171, 75),
(76, 171, 76),
(77, 171, 77),
(78, 171, 78),
(79, 171, 79),
(80, 171, 80),
(81, 171, 81),
(82, 171, 82),
(83, 171, 83),
(84, 171, 84),
(85, 171, 85),
(86, 171, 86),
(87, 171, 87),
(88, 171, 88),
(89, 171, 89),
(90, 171, 90),
(91, 171, 91),
(92, 171, 92),
(93, 171, 93),
(94, 171, 94),
(95, 171, 95),
(96, 171, 96),
(97, 171, 97),
(98, 171, 98),
(99, 171, 99),
(100, 178, 101),
(107, 193, 112),
(108, 193, 113),
(109, 193, 114),
(110, 193, 115),
(111, 193, 116),
(112, 193, 117),
(113, 193, 118),
(114, 194, 119),
(115, 194, 120),
(116, 194, 121),
(117, 195, 122),
(118, 195, 123),
(119, 195, 124),
(120, 195, 125),
(121, 196, 126),
(122, 196, 127),
(123, 196, 128),
(124, 197, 129),
(125, 197, 130),
(126, 197, 131),
(127, 197, 132),
(128, 197, 133),
(129, 197, 134),
(130, 197, 135),
(131, 197, 136),
(132, 197, 137),
(133, 197, 138),
(134, 197, 139),
(135, 197, 140),
(136, 197, 141),
(137, 198, 142),
(138, 198, 143),
(139, 198, 144),
(140, 198, 145),
(141, 198, 146),
(142, 198, 147),
(143, 198, 148),
(144, 198, 149),
(145, 198, 150),
(146, 198, 151),
(147, 198, 152),
(148, 199, 153),
(149, 199, 154),
(150, 199, 155),
(151, 199, 156),
(152, 200, 157),
(153, 200, 158),
(154, 200, 159),
(155, 200, 160),
(156, 200, 161),
(157, 200, 162),
(158, 200, 163),
(159, 200, 164),
(160, 200, 165),
(161, 200, 166),
(162, 200, 167),
(163, 200, 168);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
