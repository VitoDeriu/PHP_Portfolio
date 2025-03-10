TRUNCATE `competences`;
TRUNCATE `niveaux`;
TRUNCATE `projects`;
TRUNCATE `roles`;
TRUNCATE `users`;
TRUNCATE `users_competences`;



INSERT INTO roles (id, name)
VALUES  (1, 'admin'), (2, 'user');

INSERT INTO niveaux (id, name)
VALUES  (1, 'debutant'), (2, 'intermédiaire'), (3, 'confirmé'), (4, 'expert');

INSERT INTO competences (name)
VALUES  ('CSS'), ('JavaScript'), ('Python'), ('Java'), ('PHP ');

INSERT INTO users (id, firstname, lastname, pseudo, email, password, id_role)
VALUES  (1, 'Vito', 'Deriu', 'Weep', 'vito@portfolio.com', '$2y$10$icKnODwleaMwi006Ic.h5OEj2.vZ/a3tyuh2oR20nvj1fY8TMv0CW', 1),
        (2, 'Kantin', 'Fagniart', 'KAVTIV', 'kantin@portfolio.com', '$2y$10$icKnODwleaMwi006Ic.h5OEj2.vZ/a3tyuh2oR20nvj1fY8TMv0CW', 2),
        (3, 'Julien', 'Dante', 'jdnte', 'julien@portfolio.com', '$2y$10$icKnODwleaMwi006Ic.h5OEj2.vZ/a3tyuh2oR20nvj1fY8TMv0CW', 2),
        (4, 'Nath', 'Pivot', 'Epikdiamon', 'nath@portfolio.com', '$2y$10$icKnODwleaMwi006Ic.h5OEj2.vZ/a3tyuh2oR20nvj1fY8TMv0CW', 1);

