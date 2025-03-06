CREATE DATABASE bbdd;
USE bbdd;

CREATE TABLE users_data (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion TEXT,
    sexo ENUM('Masculino', 'Femenino', 'Otro') NOT NULL
);

CREATE TABLE users_login (
    idLogin INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL UNIQUE,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
);
CREATE TABLE citas (
    idCita INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    fecha_cita DATE NOT NULL,
    motivo_cita TEXT,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
);

CREATE TABLE noticias (
    idNoticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL UNIQUE,
    imagen VARCHAR(255) NOT NULL,
    texto TEXT NOT NULL,
    fecha DATE NOT NULL,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
);

INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES
                                ('Eva', 'Gomez', 'evagomez@gmail.com', '123456789', '1990-01-01', 'Calle Mayor 1', 'Femenino');
INSERT INTO users_login (idUser, usuario, password, rol) VALUES
                                (1, 'eva', '$1$AH22UgGJ$x7XE0YJLUveOsjxxvV/sf0', 'admin');
INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES
                                                                ('Clínica Dental Gana Premio a la Excelencia', 'noticia2.png', 'Nos complace anunciar que nuestra clínica ha sido galardonada con el Premio a la Excelencia en Servicios Dentales 2025. Este reconocimiento es un testimonio de nuestro compromiso con la calidad y la satisfacción del paciente.', '2025-02-15', 1),
                                                                ('Ofertas Especiales en Marzo', 'noticia1.png', '¡Aprovecha nuestras ofertas especiales durante el mes de marzo! Descuentos en limpiezas dentales, blanqueamientos y más. No pierdas esta oportunidad de cuidar tu sonrisa a precios increíbles.', '2024-03-01', 1),
                                                                ('Nueva Tecnología en Implantes Dentales', 'noticia3.png', 'Hemos incorporado la última tecnología en implantes dentales para ofrecer tratamientos más rápidos, cómodos y duraderos. Ven y descubre cómo podemos mejorar tu sonrisa.', '2025-02-20', 1),
                                                                ('Horario Especial en Semana Santa', 'noticia4.png', 'Informamos a nuestros pacientes que durante la Semana Santa tendremos un horario especial. Consulta nuestra página web o llámanos para más detalles.', '2025-01-15', 1),
                                                                ('Consejos para una Sonrisa Saludable', 'noticia5.png', 'Mantén tu sonrisa radiante con estos consejos esenciales de nuestros expertos. Desde la higiene bucal adecuada hasta la alimentación, aprende a cuidar tu salud dental.', '2025-02-25', 1),
                                                                ('Atención a Pacientes Pediátricos', 'noticia6.png', 'Sabemos lo importante que es la salud dental de los más pequeños. Contamos con especialistas en odontopediatría para que tus hijos reciban el mejor cuidado.', '2025-01-05', 1);