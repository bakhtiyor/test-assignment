CREATE TABLE asset (
   id INT AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   type VARCHAR(50) NOT NULL,
   source_type VARCHAR(50) NOT NULL
);

CREATE TABLE vulnerability (
   id INT AUTO_INCREMENT PRIMARY KEY,
   asset_id INT,
   name VARCHAR(255) NOT NULL,
   severity VARCHAR(20) NOT NULL,
   discovered_at DATE NOT NULL,
   archived_at DATE,
   FOREIGN KEY (asset_id) REFERENCES asset(id)
);