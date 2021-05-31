-- // table user
create table users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- // table category
create table categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(100),
    icons VARCHAR(100),
    color_hex VARCHAR(9) DEFAULT '#0000FF',
    user_created INT UNSIGNED,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_created) REFERENCES users(id)
);

-- // table tasks
create table tasks (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	due_date TIMESTAMP,
	location VARCHAR(255),
	attachments VARCHAR(255),
	status Boolean DEFAULT FALSE,
	created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cat_id INT UNSIGNED,
	user_created INT UNSIGNED,
	FOREIGN KEY (cat_id) REFERENCES categories(id),
	FOREIGN KEY (user_created) REFERENCES users(id)
);

-- // dummy categories
INSERT INTO categories(name, description, icons, color_hex,user_created) VALUES ('school', 'daily tasks & assignment', 'school', '#d0efff', 1);
INSERT INTO categories(name, description, icons, color_hex,user_created) VALUES ('work', 'daily tasks to be done at office', 'work', '#2a9df4', 1);