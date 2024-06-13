INSERT INTO departement (nom) 
VALUES 
('Informatique'), 
('Ressources Humaines');

INSERT INTO utilisateur (nom, prenom, nbureau, tel_mobile, tel_fixe, email, created_at)
VALUES 
('Dupont', 'Jean', 123, '0612345678', '0123456789', 'jean.dupont@email.com', '2024-06-13 06:04:00'),
('Martin', 'Marie', 234, '0623456789', '0134567890', 'marie.martin@email.com', '2024-06-12 06:04:00'),
('Dubois', 'Pierre', 345, '0634567890', '0145678901', 'pierre.dubois@email.com', '2024-06-11 06:04:00'),
('Thomas', 'Sophie', 456, '0645678901', '0156789012', 'sophie.thomas@email.com', '2024-06-10 06:04:00'),
('Robert', 'Paul', 567, '0656789012', '0167890123', 'paul.robert@email.com', '2024-06-09 06:04:00'),
('Richard', 'Julie', 678, '0667890123', '0178901234', 'julie.richard@email.com', '2024-06-08 06:04:00'),
('Petit', 'Emilie', 789, '0678901234', '0189012345', 'emilie.petit@email.com', '2024-06-07 06:04:00'),
('Durand', 'Lucas', 890, '0689012345', '0190123456', 'lucas.durand@email.com', '2024-06-06 06:04:00'),
('Moreau', 'Chloe', 901, '0690123456', '0201234567', 'chloe.moreau@email.com', '2024-06-05 06:04:00'),
('Laurent', 'Camille', 102, '0701234567', '0212345678', 'camille.laurent@email.com', '2024-06-04 06:04:00');

INSERT INTO utilisateur2departement (id_utilisateur, id_departement)
VALUES 
(1, 1),
(1, 2),
(2, 2),
(2, 1),
(3, 1),
(4, 2),
(5, 1),
(6, 2),
(7, 1),
(8, 2),
(9, 1),
(10, 2);
