
-- Create the EventHub database
CREATE DATABASE IF NOT EXISTS eventhub;
USE eventhub;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50)
);

-- EVENTS TABLE (Unified)
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    date DATE NOT NULL,
    time VARCHAR(50),
    location VARCHAR(255),
    venue VARCHAR(255),
    image VARCHAR(500),
    background VARCHAR(500),
    total_tickets INT DEFAULT 0,
    available_tickets INT DEFAULT 0
);

-- -- BOOKINGS TABLE
-- CREATE TABLE IF NOT EXISTS bookings (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     event_id INT NOT NULL,
--     event_title VARCHAR(255) NOT NULL,
--     name VARCHAR(100) NOT NULL,
--     email VARCHAR(100) NOT NULL,
--     quantity INT NOT NULL,
--     total_price DECIMAL(10,2) NOT NULL,
--     razorpay_payment_id VARCHAR(255),
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
-- );

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    event_title VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    razorpay_payment_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);


-- CONTACT MESSAGES TABLE
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE USERS
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@eventhub.com', 'admin123', 'admin'),
('Regular User', 'user@eventhub.com', 'user123', 'user');

-- SAMPLE EVENTS
INSERT INTO events (title, description, category, date, time, location, venue, image, background, total_tickets, available_tickets) VALUES
('Music Fiesta', 'Enjoy live performances by top artists in an electrifying atmosphere.', 'Music', '2025-04-20', '6:00 PM', 'Open Grounds, City Center', 'City Amphitheater', 'https://via.placeholder.com/600x300?text=Music+Fiesta', 'https://via.placeholder.com/400x200/0077cc/ffffff?text=Music', 120, 120),
('Tech Conference 2025', 'Dive into the future of technology with top industry leaders.', 'Technology', '2025-05-10', '9:00 AM', 'Tech Hub Auditorium', 'Tech Hub Convention Center', 'https://via.placeholder.com/600x300?text=Tech+Conference', 'https://via.placeholder.com/400x200/444/fff?text=Tech', 80, 80),
('Food Carnival', 'Taste delicious dishes from around the world.', 'Food', '2025-04-25', '12:00 PM', 'Central Park', 'Central Park Grounds', 'https://via.placeholder.com/600x300?text=Food+Carnival', 'https://via.placeholder.com/400x200/ff5722/fff?text=Food', 200, 200),
('Startup Pitch Fest', 'Watch budding entrepreneurs pitch their ideas to investors.', 'Business', '2025-05-15', '10:00 AM', 'Innovation Hall', 'Innovation Center', 'https://via.placeholder.com/600x300?text=Startup+Pitch+Fest', 'https://via.placeholder.com/400x200/333/fff?text=Business', 60, 60),
('Jazz Night', 'Experience the soothing tunes of live jazz music.', 'Music', '2025-04-30', '7:30 PM', 'City Jazz Club', 'Downtown Jazz Club', 'https://via.placeholder.com/600x300?text=Jazz+Night', 'https://via.placeholder.com/400x200/880e4f/fff?text=Jazz', 50, 50),
('IPL: CSK vs MI', 'Thrilling cricket action between CSK and MI.', 'Sports', '2025-04-22', '7:00 PM', 'Stadium A', 'Chennai Stadium', 'https://via.placeholder.com/600x300?text=CSK+vs+MI', 'https://via.placeholder.com/400x200/1a237e/fff?text=CSK+vs+MI', 500, 500),
('IPL: RCB vs KKR', 'Watch RCB face off against KKR in this high-voltage match.', 'Sports', '2025-04-23', '7:00 PM', 'Stadium B', 'Bangalore Stadium', 'https://via.placeholder.com/600x300?text=RCB+vs+KKR', 'https://via.placeholder.com/400x200/004d40/fff?text=RCB+vs+KKR', 500, 500),
('IPL: DC vs RR', 'Exciting clash between DC and RR under the floodlights.', 'Sports', '2025-04-24', '7:00 PM', 'Stadium C', 'Delhi Arena', 'https://via.placeholder.com/600x300?text=DC+vs+RR', 'https://via.placeholder.com/400x200/3f51b5/fff?text=DC+vs+RR', 500, 500),
('IPL: LSG vs GT', 'Catch LSG vs GT in a battle of tactics and power-hitting.', 'Sports', '2025-04-26', '7:00 PM', 'Stadium D', 'Lucknow Stadium', 'https://via.placeholder.com/600x300?text=LSG+vs+GT', 'https://via.placeholder.com/400x200/263238/fff?text=LSG+vs+GT', 500, 500),
('IPL: PBKS vs SRH', 'Witness PBKS take on SRH in a nail-biting encounter.', 'Sports', '2025-04-27', '7:00 PM', 'Stadium E', 'Punjab Stadium', 'https://via.placeholder.com/600x300?text=PBKS+vs+SRH', 'https://via.placeholder.com/400x200/b71c1c/fff?text=PBKS+vs+SRH', 500, 500);
