USE defaultdb;

CREATE TABLE user_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type_id INT NOT NULL,
    FOREIGN KEY (user_type_id) REFERENCES user_type(id)
);

INSERT INTO user_type (name) VALUES ('user'), ('provider'), ('admin');

use defaultdb;

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    link VARCHAR(100) NOT NULL
);

CREATE TABLE usertype_menu (
    user_type_id INT NOT NULL,
    menu_id INT NOT NULL,
    PRIMARY KEY (user_type_id, menu_id),
    FOREIGN KEY (user_type_id) REFERENCES user_type(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE
);

INSERT INTO menu (name, link) VALUES
('Browse Listings', 'listings.php'),
('My Orders', 'orders.php'),
('Provider Dashboard', 'provider_dashboard.php'),
('Manage Users', 'admin_users.php');


INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (1, 1), (1, 2);
INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (2, 3);
INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (3, 4);

CREATE TABLE listing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    is_premium BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (provider_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE attribute (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE listing_value (
	id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value VARCHAR(255) NOT NULL,
    FOREIGN KEY (listing_id) REFERENCES listing(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id) REFERENCES attribute(id) ON DELETE CASCADE
);

INSERT INTO menu (name, link) VALUES ('Add Listing', 'addListing.php');
INSERT INTO menu (name, link) VALUES ('My Listings', 'viewListings.php');


DELETE FROM usertype_menu WHERE user_type_id = 2;

INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (2, 5); 


INSERT INTO menu (name, link) VALUES ('View User Orders', 'viewOrders-P.php');
INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (2, 7);

INSERT INTO user (user_name, email, password, user_type_id) 
VALUES ('Anthony Edward', 'test@test.eg', '$2y$10$wOxsf1lDydrsQucby2/bke5CY7bBlhMclp.yfxXhdW1hewKVdUBam', 3);

INSERT INTO menu (name, link) VALUES ('Manage Orders', 'adminOrders.php');
INSERT INTO menu (name, link) VALUES ('Manage Listings', 'adminListings.php');

INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (3, 8);
INSERT INTO usertype_menu (user_type_id, menu_id) VALUES (3, 9);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    listing_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (listing_id) REFERENCES listing(id) ON DELETE CASCADE
);

ALTER TABLE orders ADD COLUMN order_notes VARCHAR(255) DEFAULT '';