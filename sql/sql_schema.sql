--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `author_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `author_id`, `post_id`, `approved`, `created_at`) VALUES
(3, 'test', 2, 13, 1, '2023-09-17 12:17:13'),
(9, 'Test de commentaire', 2, 13, 0, '2023-09-17 12:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `content` longtext NOT NULL,
  `chapo` longtext,
  `author_id` int DEFAULT NULL,
  `slug` longtext NOT NULL,
  `last_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `chapo`, `author_id`, `slug`, `last_modified`) VALUES
(16, 'Les secrets du Deep Learning', 'Le Deep Learning est une sous-discipline de l\'apprentissage automatique qui utilise des réseaux neuronaux avec de nombreuses couches. Il est à la base de nombreuses avancées en matière d\'IA.', 'Découvrez ce qui se cache derrière les réseaux neuronaux profonds.', 2, 'secrets-deep-learning', '2023-09-17 08:23:05'),
(15, 'Les frameworks front-end populaires en 2023', 'Les frameworks front-end facilitent la création d\'applications web réactives et performantes. Découvrez les tendances actuelles et les meilleurs outils du moment.', 'Un tour d\'horizon des frameworks front-end les plus populaires cette année.', 2, 'frameworks-front-end-2023', '2023-09-17 08:23:07'),
(14, 'Comprendre les promesses en JavaScript', 'Les promesses sont un moyen de gérer les opérations asynchrones en JavaScript. Elles représentent une valeur qui pourrait être disponible maintenant, dans le futur, ou jamais.', 'Plongez dans le monde asynchrone de JavaScript avec les promesses.', 2, 'comprendre-promesses-javascript', '2023-09-17 08:23:09'),
(13, 'Les avantages de TypeScript', '<p>TypeScript est une évolution typée de JavaScript, développée par Microsoft. À première vue, il peut ressembler à JavaScript avec quelques ajouts, mais en y regardant de plus près, on découvre une multitude d\'avantages. Voici une analyse approfondie des points forts de TypeScript:</p>\n\n<h4>1. Typage statique</h4>\n<p>Le typage statique est sans doute la caractéristique la plus marquante de TypeScript. En ajoutant des annotations de type à vos variables, fonctions et objets, vous pouvez obtenir des vérifications de type à la phase de compilation. Cela signifie que:</p>\n<ul>\n    <li>Les erreurs sont détectées avant l\'exécution du code.</li>\n    <li>Le risque d\'erreurs d\'exécution dues à des incompatibilités de type est réduit.</li>\n    <li>Les développeurs peuvent corriger les erreurs dès le stade de la rédaction du code.</li>\n</ul>\n\n<h4>2. Meilleure lisibilité et documentation</h4>\n<p>Le code typé est intrinsèquement plus descriptif. Les annotations de type agissent comme une documentation intégrée. Pour une grande base de code ou une équipe de développement, cela signifie:</p>\n<ul>\n    <li>Moins de temps passé à comprendre le code écrit par d\'autres.</li>\n    <li>Des fonctions et des structures de données auto-documentées.</li>\n    <li>Une meilleure collaboration entre les développeurs.</li>\n</ul>\n\n<h4>3. Outils de développement améliorés</h4>\n<p>Le typage statique permet aux éditeurs de code et aux IDEs d\'offrir des fonctionnalités avancées telles que:</p>\n<ul>\n    <li>Autocomplétion intelligente.</li>\n    <li>Navigation efficace dans le code (par exemple, \"aller à la définition\").</li>\n    <li>Refactoring plus sûr et plus précis.</li>\n</ul>\n<p>Cela se traduit par une augmentation de la productivité des développeurs et une réduction des erreurs introduites lors du refactoring ou de l\'ajout de nouvelles fonctionnalités.</p>\n\n<h4>4. Compilateur puissant</h4>\n<p>Le compilateur TypeScript ne se contente pas de vérifier les types. Il offre aussi:</p>\n<ul>\n    <li>La transpilation vers différentes versions de JavaScript, permettant d\'utiliser des fonctionnalités modernes tout en supportant d\'anciens navigateurs.</li>\n    <li>La possibilité d\'intégrer des transformations personnalisées, étendant les fonctionnalités du compilateur.</li>\n</ul>\n\n<h4>5. Interfaces et génériques</h4>\n<p>Les interfaces permettent de définir des contrats que les objets peuvent respecter, tandis que les génériques permettent de créer des composants réutilisables qui peuvent fonctionner avec différents types. Ces fonctionnalités:</p>\n<ul>\n    <li>Améliorent la modularité et la réutilisabilité du code.</li>\n    <li>Renforcent la sécurité du type sans sacrifier la flexibilité.</li>\n</ul>\n\n<h4>6. Intégration avec les frameworks populaires</h4>\n<p>De nombreux frameworks et bibliothèques populaires, tels qu\'Angular, Vue, et React, ont des définitions de type disponibles ou sont directement écrits en TypeScript. Cela facilite:</p>\n<ul>\n    <li>L\'intégration de TypeScript dans les projets existants.</li>\n    <li>La collaboration entre différentes bibliothèques et frameworks.</li>\n</ul>\n\n<h4>7. Améliorations progressives</h4>\n<p>Vous n\'avez pas besoin de convertir tout votre projet en TypeScript en une fois. TypeScript est conçu pour être adopté progressivement, ce qui signifie que vous pouvez l\'introduire à votre propre rythme.</p>\n\n<h4>Conclusion</h4>\n<p>TypeScript offre un équilibre entre la flexibilité de JavaScript et la robustesse d\'un système de type fort. Il améliore la qualité, la productivité et la collaboration des développeurs, tout en permettant une adoption progressive. Pour ceux qui cherchent à améliorer leur flux de travail JavaScript, TypeScript est un choix qui mérite sérieusement d\'être considéré.</p>', 'TypeScript est un sur-ensemble typé de JavaScript qui compile en JavaScript pur. Il offre des avantages tels que la détection d\'erreurs à la compilation, la meilleure autocomplétion et une meilleure lisibilité. ', 2, 'avantages-typescript', '2023-09-17 08:23:11'),
(12, 'Introduction à Python', 'Python est un langage de programmation de haut niveau, interprété et orienté objet. Il est connu pour sa simplicité et sa lisibilité, ce qui en fait un excellent choix pour les débutants.', 'Un aperçu de Python, un langage de programmation polyvalent et puissant.', 2, 'introduction-python', '2023-09-17 08:23:12'),
(11, 'Les bases de la programmation orientée objet', 'La programmation orientée objet (POO) est une approche de la programmation qui regroupe les données et les fonctions qui opèrent sur ces données en objets. Cela permet de créer des programmes plus modulaires et réutilisables.', 'Découvrez les principes fondamentaux de la POO et comment ils peuvent améliorer votre code.', 2, 'bases-programmation-orientee-objet', '2023-09-17 08:23:14'),
(17, 'L\'importance des tests unitaires', 'Les tests unitaires permettent de vérifier que chaque partie de votre code fonctionne comme prévu. Ils sont essentiels pour garantir la qualité et la fiabilité de vos applications.', 'Pourquoi les tests unitaires sont essentiels pour tout développeur sérieux.', 2, 'importance-tests-unitaires', '2023-09-17 08:23:15'),
(18, 'Découverte de Rust', 'Rust est un langage de programmation qui se concentre sur la performance et la sécurité, en particulier la sécurité de la mémoire. Il offre des outils puissants pour créer des applications fiables et efficaces.', 'Pourquoi Rust est-il considéré comme le langage de programmation le plus aimé ?', 2, 'decouverte-rust', '2023-09-17 08:23:16'),
(19, 'Les bases de la programmation fonctionnelle', 'La programmation fonctionnelle est un paradigme de programmation qui traite le calcul comme l\'évaluation de fonctions mathématiques. Elle évite de changer l\'état et les données mutables.', 'Découvrez comment la programmation fonctionnelle peut améliorer votre code.', 2, 'bases-programmation-fonctionnelle', '2023-09-17 08:23:18'),
(20, 'L\'avenir de la réalité virtuelle en programmation', 'La réalité virtuelle offre des expériences immersives qui changent la façon dont les utilisateurs interagissent avec les applications. Découvrez comment cela impacte le développement et les tendances à venir.', 'Comment la réalité virtuelle influence-t-elle le monde du développement ?', 2, 'avenir-realite-virtuelle-programmation', '2023-09-17 08:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` longtext NOT NULL,
  `password` longtext NOT NULL,
  `email` longtext NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;