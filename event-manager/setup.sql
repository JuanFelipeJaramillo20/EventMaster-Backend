CREATE TABLE "usuario"
(
    id SERIAL PRIMARY KEY,
    firstName VARCHAR(150) NOT NULL,
    lastName VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(600) NOT NULL
);

CREATE TABLE evento (
                        id SERIAL PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        description TEXT,
                        type VARCHAR(100),
                        capacity INT
);

CREATE TABLE usuario_evento (
                                id SERIAL PRIMARY KEY,
                                eventId INT NOT NULL,
                                userId INT NOT NULL,
                                FOREIGN KEY (eventId) REFERENCES evento(id),
                                FOREIGN KEY (userId) REFERENCES usuario(id)
);