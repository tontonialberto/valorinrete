CREATE TABLE tab_col_controllo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    regione VARCHAR(100) NOT NULL
);

INSERT INTO tab_col_controllo (regione, email) VALUES
('Abruzzo', 'abruzzo.sgs@figc.it'),
('Basilicata', 'basilicata.sgs@figc.it'),
('Calabria', 'm.costa@figc.it'),
('Campania', 'ferdinando.manzi7@gmail.com'),
('Emilia-Romagna', 'info@figcparma.it'),
('Friuli-Venezia Giulia', 'friuliveneziagiulia.sgs@figc.it'),
('Friuli-Venezia Giulia', 'giovanni.messina@uniud.it'),
('Lazio', 'lazio.sgs@figc.it'),
('Liguria', 'scuola.liguriasgs@figc.it'),
('Lombardia', 'scuola.lombardiasgs@figc.it'),
('Marche', 'scuola.marchesgs@figc.it'),
('Molise', 'scuola.molisesgs@figc.it'),
('Piemonte', 'segretario.figc.piemontevdasgs@gmail.com'),
('Puglia', 'scuola.pugliasgs@figc.it'),
('Sardegna', 'sardegna.sgs@figc.it'),
('Sicilia', 'scuola.siciliasgs@figc.it'),
('Toscana', 'toscana.sgs@figc.it'),
('Umbria', 'scuola.umbriasgs@figc.it'),
('Veneto', 'veneto.sgs@figc.it'),
('Trentino-Alto Adige - Bolzano', 'bolzano.sgs@figc.it'),
('Trentino-Alto Adige - Trento', 'trento.sgs@figc.it');

INSERT INTO tab_col_controllo (regione, email) VALUES
('Abruzzo', 'scuola.abruzzosgs@figc.it'),
('Basilicata', 'scuola.basilicatasgs@figc.it'),
('Calabria', 'scuola.calabriasgs@figc.it'),
('Campania', 'scuola.campaniasgs@figc.it'),
('Emilia-Romagna', 'scuola.emiliaromagnasgs@figc.it'),
('Friuli-Venezia Giulia', 'scuola.friuliveneziagiuliasgs@figc.it'),
('Lazio', 'scuola.laziosgs@figc.it'),
("Piemonte - Valle d'Aosta", 'scuola.piemontevalledaostasgs@figc.it'),
('Sardegna', 'scuola.sardegnasgs@figc.it'),
('Toscana', 'scuola.toscanasgs@figc.it'),
('Veneto', 'scuola.venetosgs@figc.it'),
('Trentino-Alto Adige - Bolzano', 'scuola.bolzanosgs@figc.it'),
('Trentino-Alto Adige - Trento', 'scuola.trentosgs@figc.it');
