CREATE DATABASE pokedex;

USE pokedex;

CREATE TABLE pokemon (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(150) NOT NULL,
    `img` varchar(250) NOT NULL,
    `content` text NOT NULL
);

INSERT INTO pokemon (`name`, `img`, `content`) VALUES
('Evoli', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pokepedia.fr%2F%25C3%2589voli&psig=AOvVaw2VijxdBysvHCxhFqzFHwzu&ust=1603382224811000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCNjfzrGGxuwCFQAAAAAdAAAAABAD', 'Évoli (anglais : Eevee  Eievui[1]) est un Pokémon de type Normal de la première génération, qui a la faculté dévoluer différemment selon les circonstances.'),
('Psykokwak', 'hhttps://www.pokepedia.fr/Fichier:Psykokwak-RFVF.png', 'Psykokwak (anglais : Psyduck ; japonais : コダック Koduck[1]), le Pokémon Canard, a notamment été rendu célèbre dans le dessin animé par les prestations du Psykokwak d Ondine.'),
('Mew', 'https://www.pokepedia.fr/images/thumb/e/e6/Mew-RFVF.png/500px-Mew-RFVF.png', 'Mew (anglais : Mew ; japonais : ミュウ Mew[1]) est un Pokémon fabuleux de type Psy apparu dans la première génération.');