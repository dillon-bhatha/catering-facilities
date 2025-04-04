DROP DATABASE IF EXISTS catering_facilities;

CREATE DATABASE catering_facilities;

USE catering_facilities;

CREATE TABLE Location (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    country_code VARCHAR(10) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

CREATE TABLE Facility (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    creation_date DATE NOT NULL,
    location_id INT NOT NULL,
    FOREIGN KEY (location_id) REFERENCES Location(id) ON DELETE CASCADE
);

CREATE TABLE Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Facility_Tag (
    facility_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (facility_id, tag_id),
    FOREIGN KEY (facility_id) REFERENCES Facility(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE
);

CREATE INDEX idx_facility_name ON Facility(name);
CREATE INDEX idx_location_city ON Location(city);
CREATE INDEX idx_tag_name ON Tag(name);

INSERT INTO Location (city, address, zip_code, country_code, phone_number) VALUES
('Amsterdam', 'Dam Square 1', '1012 JS', 'NL', '0201234567'),
('Rotterdam', 'Coolsingel 50', '3011 AD', 'NL', '0107654321'),
('Utrecht', 'Neude 5', '3512 AD', 'NL', '0301239876'),
('The Hague', 'Spui 10', '2511 BM', 'NL', '0701236543'),
('Eindhoven', 'Stratumseind 15', '5611 EN', 'NL', '0401234567');

INSERT INTO Facility (name, creation_date, location_id) VALUES
('Gym A', '2025-01-01', 1),
('Swimming Pool B', '2025-01-02', 2),
('Conference Center C', '2025-01-03', 3),
('Sports Hall D', '2025-01-04', 4),
('Café E', '2025-01-05', 5);

INSERT INTO Tag (name) VALUES
('Sports'),
('Culture'),
('Education'),
('Leisure'),
('Entertainment');

INSERT INTO Facility_Tag (facility_id, tag_id) VALUES
(1, 1),
(2, 1),
(3, 3),
(4, 1),
(5, 4);