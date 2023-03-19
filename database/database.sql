-- Admin Users Table
CREATE TABLE `admin_users`(
    `Admin_id` int(11) NOT NULL AUTO_INCREMENT,
    `email_Add` varchar(50),
    `Logo` varchar(50),
    `Username` varchar(50),
    `Status` varchar(10),
    `PassWD` varchar(20),
    PRIMARY KEY (`Admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_users`( `Admin_id`, `email_Add`, `Logo`, `Username`, `Status`, `PassWD`) VALUES ('', 'james@akweer.mail', '', 'Akweter', 'admin',  'True12');

-- Customers User Table

CREATE TABLE `customers`(
    `C_id` int(11) NOT NULL AUTO_INCREMENT,
    `email_Add` varchar(50),
    `Username` varchar(50),
    `Telephone` varchar(10),
    `Status` varchar(10),
    `PassWD` varchar(20),
    PRIMARY KEY (`C_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customers`( `C_id`, `email_Add`, `Username`, `Telephone`, `Status`, `PassWD`) VALUES ('', 'james@akweer.mail', 'Akweter', '0540544760', 'customer',  'True1');

-- Products Database

CREATE TABLE `products`(
    `P_id` int(11) NOT NULL AUTO_INCREMENT,
    `P_qty` int(50),
    `P_name` varchar(50),
    `P_image` varchar(20),
    `P_category` varchar(50),
    `P_price` int(20),
    `P_upload_date` varchar(50),
    PRIMARY KEY (`P_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products`(`P_id`, `P_qty`, `P_name`, `P_image`, `P_category`, `P_price`, `P_upload_date`) VALUES ('','20','cement','','building','20','2022-12-15');

