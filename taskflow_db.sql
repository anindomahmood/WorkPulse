CREATE DATABASE IF NOT EXISTS taskflow_db;
USE taskflow_db;

DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','manager','team_leader','employee') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) AUTO_INCREMENT=1;

CREATE TABLE tasks (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    assigned_by INT NOT NULL,
    assigned_to INT NOT NULL,
    parent_task_id INT DEFAULT NULL,
    status ENUM('pending','in_progress','completed') DEFAULT 'pending',
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_by) REFERENCES users(user_id),
    FOREIGN KEY (assigned_to) REFERENCES users(user_id),
    FOREIGN KEY (parent_task_id) REFERENCES tasks(task_id)
) AUTO_INCREMENT=50;

CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT NOT NULL,
    recipient_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipient_id) REFERENCES users(user_id)
) AUTO_INCREMENT=150;

INSERT INTO users VALUES
(1,'System Admin','admin','admin123','admin',CURRENT_TIMESTAMP),
(2,'Rahim Manager','manager','manager123','manager',CURRENT_TIMESTAMP),
(3,'Karim Team Leader','leader','leader123','team_leader',CURRENT_TIMESTAMP),
(4,'Hasan Employee','employee1','employee123','employee',CURRENT_TIMESTAMP),
(5,'Nabil Employee','employee2','employee123','employee',CURRENT_TIMESTAMP);

INSERT INTO tasks
(task_id,title,description,assigned_by,assigned_to,parent_task_id,status,due_date)
VALUES
(50,'Develop Company Website','Main project assigned by manager',2,3,NULL,'in_progress','2026-09-15'),
(51,'Frontend Development','Create frontend pages',3,4,50,'in_progress','2026-09-10'),
(52,'Database Design','Prepare database structure',3,5,50,'completed','2026-09-12'),
(53,'Testing Website','Test system features',3,4,50,'pending','2026-09-14'),
(54,'Prepare Monthly Report','Prepare performance report',2,3,NULL,'pending','2026-09-20');

INSERT INTO notifications
(notification_id,message,recipient_id,type,is_read)
VALUES
(150,'New task assigned: Develop Company Website',3,'New Task Assigned',0),
(151,'New task assigned: Frontend Development',4,'New Task Assigned',0),
(152,'New task assigned: Database Design',5,'New Task Assigned',1),
(153,'Task status updated',3,'Task Update',0);

ALTER TABLE users AUTO_INCREMENT=6;
ALTER TABLE tasks AUTO_INCREMENT=55;
ALTER TABLE notifications AUTO_INCREMENT=154;
