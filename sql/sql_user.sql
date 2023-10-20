-- Create the user
CREATE USER 'user'@'%' IDENTIFIED BY 'password';
-- Grant access to xxx_database
GRANT ALL PRIVILEGES ON projet_3_oc.* TO 'user'@'%';
-- Reload privilege tables to apply changes
FLUSH PRIVILEGES;