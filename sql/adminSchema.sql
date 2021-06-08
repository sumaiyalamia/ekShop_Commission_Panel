
CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



INSERT INTO `admin` (`user_id`, `user_email`, `user_password`) VALUES
(1, 'admin', 'admin'),


ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;




